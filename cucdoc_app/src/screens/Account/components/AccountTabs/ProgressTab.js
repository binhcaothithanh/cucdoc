


import React, { useState, useRef, useEffect } from 'react';
import { Keyboard, KeyboardAvoidingView, Platform, Alert, TouchableWithoutFeedback, Modal, View, Text, FlatList, TouchableOpacity, TextInput } from 'react-native';
import { useDispatch, useSelector } from 'react-redux';
import { Image } from 'expo-image';
import { Camera, Plus } from 'lucide-react-native';
import { LinearGradient } from 'expo-linear-gradient';
import { IMAGE_PROCESS_URL } from '@env';
import * as ImagePicker from 'expo-image-picker';

import { updateBodyStats } from '../../../../store/slices/userSlice';
import MyButton from '../../../../components/common/MyButton';
import styles from '../../style';
import { useLanguage } from '../../../../i18n/LanguageContext';

const ProgressTab = () => {
    const { t } = useLanguage();
    const dispatch = useDispatch();
    const { profile } = useSelector((state) => state.user);
    const { statsHistory } = useSelector((state) => state.user);
    const [selectedIndex, setSelectedIndex] = useState(statsHistory.length > 0 ? statsHistory.length - 1 : 0);
    const [statsForm, setStatsForm] = useState({ weight: '', photo: null });
    const [modalVisible, setModalVisible] = useState(false);
    const flatListRef = useRef(null);
    
    useEffect(() => {
        if (statsHistory.length > 0) {
            let index = 0;

            const scrollInterval = setInterval(() => {
                if (index < statsHistory.length) {
                    // Cuộn tới từng item theo index
                    flatListRef.current?.scrollToIndex({
                        index: index,
                        animated: true,
                        viewPosition: 0.5, // Giữ item ở giữa màn hình
                    });
                    setSelectedIndex(index); // Cập nhật trạng thái hiển thị
                    index++;
                } else {
                    clearInterval(scrollInterval); // Dừng lại khi hết danh sách
                }
            }, 1000); // 1000ms = 1 giây mỗi hình ảnh

            return () => clearInterval(scrollInterval); // Dọn dẹp khi component unmount
        }
    }, [statsHistory.length]);

    // Tìm ảnh gần nhất (Backfill)
    const getEffectivePhoto = (index) => {
        for (let i = index; i >= 0; i--) {
            if (statsHistory[i]?.photo) return statsHistory[i].photo;
        }
        return null;
    };

    const pickImage = async () => {
        const { status } = await ImagePicker.requestMediaLibraryPermissionsAsync();
        if (status !== 'granted') {
            Alert.alert('Lỗi', 'Cần quyền truy cập thư viện ảnh!');
            return;
        }
        const result = await ImagePicker.launchImageLibraryAsync({
            mediaTypes: ['images'],
            allowsEditing: true,
            aspect: [4, 4],
            quality: 0.8,
        });
        if (!result.canceled) {
            setStatsForm(prev => ({ ...prev, photo: result.assets[0].uri }));
        }
    };

    const handleUpdateStats = () => {
        // Validation
        if (!statsForm.weight || statsForm.weight.trim() === "") {
            Alert.alert("Lỗi", "Vui lòng nhập cân nặng!");
            return;
        }
        if (!statsForm.photo) {
            Alert.alert("Lỗi", "Vui lòng chụp hoặc chọn ảnh vóc dáng!");
            return;
        }
        const formData = new FormData();
        formData.append('user_id', profile.id);
        formData.append('weight', statsForm.weight || profile?.stats?.weight?.toString() || "0");

        if (statsForm.photo) {
            const isPng = statsForm.photo.toLowerCase().endsWith('.png');
            formData.append('photo', {
                uri: statsForm.photo,
                name: `user_${profile.id}_${Date.now()}.${isPng ? 'png' : 'jpg'}`,
                type: isPng ? 'image/png' : 'image/jpeg',
            });
        }
        dispatch(updateBodyStats(formData)).then((res) => {
            setModalVisible(false);
            // Alert.alert("Thành công", "Đã cập nhật chỉ số!");
            if (res.meta.requestStatus === 'fulfilled') {
                setModalVisible(false);
                // Sau khi lưu xong, ruler sẽ tự cuộn vì statsHistory trong store thay đổi
                setSelectedIndex(statsHistory.length);
            }
        });
    };

    const calculateHealthMetrics = (weight, height, activityLevel, gender = 'male', age = 25) => {
        // Ép kiểu an toàn
        const w = parseFloat(weight);
        const h = parseFloat(height);
        const al = parseFloat(activityLevel || 1.2);
        const a = parseFloat(age);

        // Kiểm tra nếu các thông số cơ bản không hợp lệ
        if (!w || w <= 0 || !h || h <= 0) return { bmi: "0", tdee: 0 };

        // Tính toán BMI
        const bmi = (w / Math.pow(h / 100, 2)).toFixed(1);

        // Tính BMR và TDEE
        let bmr = (10 * w) + (6.25 * h) - (5 * a);
        bmr = (gender === 'male') ? (bmr + 5) : (bmr - 161);
        const tdee = Math.round(bmr * al);

        return { bmi, tdee };
    };

    const getBMIMeaning = (bmi) => {
        const value = parseFloat(bmi);
        if (value < 18.5) return { label: t('account.underWeight'), color: "#3B82F6" };
        if (value < 24.9) return { label: t('account.normal'), color: "#10B981" };
        if (value < 29.9) return { label: t('account.overWeight'), color: "#F59E0B" };
        return { label: t('account.obese'), color: "#EF4444" };
    };


    const getWeightTrend = (current, history) => {
        if (!history || history.length <= 1) return { label: t('account.start'), color: "#94A3B8" };

        const firstWeight = parseFloat(history[0].weight);
        const diff = parseFloat(current) - firstWeight;

        if (diff < 0) return { label: `${diff.toFixed(1)} kg`, color: "#10B981" }; // Giảm (Xanh lá)
        if (diff > 0) return { label: `+${diff.toFixed(1)} kg`, color: "#EF4444" }; // Tăng (Đỏ)
        return { label: t('account.normal'), color: "#94A3B8" }; // Giữ nguyên
    };

    const currentWeight = statsHistory[selectedIndex]?.weight;
    // Tính tuổi từ birth_year
    const currentYear = new Date().getFullYear();
    const age = profile?.birth_year ? (currentYear - profile.birth_year) : 25;

    const weightTrend = getWeightTrend(currentWeight, statsHistory);

    const height = profile?.height;
    const metrics = (currentWeight && height)
        ? calculateHealthMetrics(currentWeight, height, profile?.activity_level, profile?.gender || 'male', age)
        : { bmi: "0", tdee: 0 };
    // console.log({
    //     selectedIndex,
    //     currentWeight,
    //     height: profile?.height,
    //     activity: profile?.activity_level,
    //     gender: profile?.gender,
    //     age,
    // });
    const { bmi, tdee } = metrics;
    const bmiInfo = getBMIMeaning(bmi);
    const ITEM_WIDTH = 56;
    // if (!statsHistory || statsHistory.length === 0) {
    //     return (
    //         <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
    //             <Text style={{ color: 'white' }}>Hãy ghi nhận chỉ số đầu tiên để bắt đầu!</Text>
    //             <MyButton title="Ghi nhận ngay" onPress={() => setModalVisible(true)} />
    //         </View>
    //     );
    // }
    return (
        <View style={styles.progressTabContainer}>
            {/* MODAL CẬP NHẬT (Giữ nguyên logic của bạn) */}
            <Modal visible={modalVisible} transparent animationType="slide">
                <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
                    <View style={styles.darkOverlay}>
                        <KeyboardAvoidingView behavior={Platform.OS === 'ios' ? 'padding' : 'height'} style={{ width: '100%', alignItems: 'center' }}>

                            <View style={[styles.configCardBody, { paddingHorizontal: 0, paddingTop: 0 }]}>
                                {/* HEADER: Thay ảnh bài tập bằng ảnh vóc dáng */}
                                <View style={styles.configHeaderRow}>
                                    <TouchableOpacity style={[styles.cardThumbContainerPicker, { marginBottom: 0 }]} onPress={pickImage}>
                                        {statsForm.photo ? (
                                            <Image source={{ uri: statsForm.photo }} style={styles.cardThumbImage} contentFit="cover" />
                                        ) : (
                                            <View style={[styles.cardThumbImage, { justifyContent: 'center', alignItems: 'center', backgroundColor: '#333' }]}>
                                                {/* <Camera color="#FFF" /> */}
                                            </View>
                                        )}
                                        <View style={styles.cameraOverlay}>
                                            <Camera size={24} color="#FFF" />
                                        </View>
                                        <LinearGradient
                                            colors={['transparent', 'rgba(18, 18, 18, 0.8)', '#1E1E1E']}
                                            style={{ position: 'absolute', left: 0, right: 0, bottom: 0, height: 40 }}
                                        />
                                    </TouchableOpacity>

                                </View>

                                {/* INPUT GROUP: Thay Sets/Reps/Rest bằng Weight/BirthYear/Activity */}
                                <View style={{ marginVertical: 10 }}>
                                    <Text style={styles.configTitle}>{t('account.bodyProgress')}</Text>
                                    <Text style={styles.configSubTitle}>{t('account.updateStats')}</Text>
                                </View>
                                <View style={styles.inputGroupRow}>
                                    <View style={styles.inputWrap}>
                                        <Text style={styles.configLabelText}>{t('account.weight')}</Text>
                                        <TextInput
                                            style={styles.configNumericInput}
                                            keyboardType="numeric"
                                            placeholder={profile?.stats.weight?.toString() || "66"}
                                            placeholderTextColor="#64748B"
                                            value={statsForm.weight}
                                            onChangeText={(t) => setStatsForm({ ...statsForm, weight: t })}
                                        />
                                    </View>
                                    {/* Nếu muốn thêm Activity Level, bạn có thể biến nó thành một Picker hoặc Input đơn giản ở đây */}
                                </View>

                                {/* BUTTONS */}
                                <View style={{ flexDirection: 'row', gap: 10, paddingHorizontal: 20 }}>
                                    <View style={{ flex: 1.5 }}>
                                        <MyButton type="orange" title={t('account.saveChanges')} onPress={handleUpdateStats} />
                                    </View>
                                    <View style={{ flex: 1 }}>
                                        <MyButton type="orange" title={t('common.cancel')} onPress={() => setModalVisible(false)} />
                                    </View>
                                </View>
                            </View>

                        </KeyboardAvoidingView>
                    </View>
                </TouchableWithoutFeedback >
            </Modal >


            {/* 1. Kiểm tra trạng thái trống để hiển thị thông báo */}
            {(!statsHistory || statsHistory.length === 0) ? (
                <View style={styles.emptyStateContainer}>
                    <Text style={{ color: 'white', marginBottom: 20 }}>{t('account.recordFirst')}</Text>
                    {/* <MyButton title="Ghi nhận ngay" onPress={() => setModalVisible(true)} /> */}
                    <TouchableOpacity
                        style={[styles.miniEditBtn, { flexDirection: 'row', alignItems: 'center', gap: 5 }]}
                        onPress={() => setModalVisible(true)}
                    >
                        <Plus size={18} color="#FF6B00" />
                        <Text style={{ color: '#FF6B00', fontWeight: 'bold', fontSize: 14 }}>{t('account.newRecord')}</Text>
                    </TouchableOpacity>
                </View>
            ) : (
                /* 2. Hiển thị giao diện chính khi đã có dữ liệu */
                <>
                    {/* PHẦN CHỈ SỐ SỨC KHỎE */}
                    <View style={styles.metricsContainer}>
                        <View style={styles.metricBox}>
                            <Text style={styles.metricLabel}>BMI</Text>
                            <Text style={[styles.metricValue, { color: bmiInfo.color }]}>{bmi}</Text>
                            <Text style={{ color: bmiInfo.color, fontSize: 10, fontWeight: 'bold' }}>{bmiInfo.label}</Text>
                        </View>
                        <View style={styles.metricBox}>
                            <Text style={styles.metricLabel}>{t('account.dailyCalorie')}</Text>
                            <Text style={[styles.metricValue, { color: '#FF6B00' }]}>{tdee}</Text>
                            <Text style={{ color: '#94A3B8', fontSize: 10 }}>Kcal/ngày</Text>
                        </View>
                        <View style={styles.metricBox}>
                            <Text style={styles.metricLabel}>{t('account.weight')}</Text>
                            <Text style={[styles.metricValue, { color: '#FFFFFF' }]}>{currentWeight} kg</Text>
                            <Text style={{ color: weightTrend.color, fontSize: 10, fontWeight: 'bold' }}>
                                {weightTrend.label}
                            </Text>
                        </View>
                    </View>



                    {/* ẢNH HIỂN THỊ */}
                    <View style={styles.mainImageArea}>
                        {getEffectivePhoto(selectedIndex) ? (
                            <Image source={{ uri: `${IMAGE_PROCESS_URL}${getEffectivePhoto(selectedIndex)}` }} style={styles.mainImage} />
                        ) : (
                            <View style={[styles.mainImage, { justifyContent: 'center', alignItems: 'center' }]}>
                                <Camera size={50} color="#64748B" />
                            </View>
                        )}
                        <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between', width: '100%', paddingHorizontal: 10, marginTop: 10 }}>
                            <Text style={styles.dateLabel}>{statsHistory[selectedIndex]?.recorded_at}</Text>

                            <TouchableOpacity
                                style={[styles.miniEditBtn, { flexDirection: 'row', alignItems: 'center', gap: 5 }]}
                                onPress={() => setModalVisible(true)}
                            >
                                <Plus size={18} color="#FF6B00" />
                                <Text style={{ color: '#FF6B00', fontWeight: 'bold', fontSize: 14 }}>Ghi nhận mới</Text>
                            </TouchableOpacity>
                        </View>

                        <FlatList
                            horizontal
                            ref={flatListRef}
                            data={statsHistory}
                            getItemLayout={(data, index) => ({
                                length: ITEM_WIDTH,
                                offset: ITEM_WIDTH * index,
                                index,
                            })}
                            keyExtractor={(item, index) => item?.id?.toString() || index.toString()}
                            renderItem={({ item, index }) => (
                                <TouchableOpacity onPress={() => setSelectedIndex(index)} style={styles.rulerMarker}>
                                    <View style={[styles.line, index === selectedIndex && styles.activeLine]} />
                                    <Text style={styles.textDate}>
                                        {new Date(item.recorded_at).getDate()}/{new Date(item.recorded_at).getMonth() + 1}
                                    </Text>
                                </TouchableOpacity>
                            )}
                            contentContainerStyle={styles.rulerContainer}
                        />
                    </View>
                </>
            )}

        </View >
    );
};
export default ProgressTab;
