import React, { useState, useEffect } from 'react';
import { Alert, View, Text, TextInput, TouchableOpacity } from 'react-native';
import { useSelector, useDispatch } from 'react-redux';
import { ACTIVITY_LEVELS } from '../../../../constants/constants';
import MyButton from '../../../../components/common/MyButton';
import styles from '../../style';
import { updateUserProfile } from '../../../../store/slices/userSlice';
import { useLanguage } from '../../../../i18n/LanguageContext';

const DetailsTab = () => {
    const { t } = useLanguage();
    const { profile } = useSelector((state) => state.user);
    const [form, setForm] = useState({
        email: '', birth_year: '', height: '', weight: '', goal: '', calorie: '', avatar_type: '', gender: 'other', note: '', activity_level: 1.2
    });
    const dispatch = useDispatch();

    useEffect(() => {
        if (profile) {
            setForm({
                email: profile.email || '',
                full_name: profile.full_name || profile.user_name || '',
                birth_year: profile.birth_year ? String(profile.birth_year) : '',
                height: profile.height ? String(profile.height) : '',
                // weight: profile.weight ? String(profile.weight) : '',
                goal: profile.goal || '',
                // calorie: profile.calorie ? String(profile.calorie) : '',
                avatar_type: profile.avatar_type || '',
                gender: profile.gender || 'other',
                note: profile.note || '',
                activity_level: profile.activity_level ? parseFloat(profile.activity_level) : 1.2,
            });

            // if (profile.stats) {
            //   // Nếu weight là 0, tức là chưa cập nhật thông tin lần đầu
            //   if (parseFloat(profile.stats.weight) === 0) {
            //     setModalVisible(true); // Hiển thị Modal "Chào mừng"
            //   }
            // }


        }
    }, [profile]);

    const showGenderPicker = () => {
        Alert.alert(
            "Chọn Giới Tính",
            "Vui lòng chọn giới tính của bạn:",
            [
                { text: "Nam (Male)", onPress: () => setForm({ ...form, gender: 'male' }) },
                { text: "Nữ (Female)", onPress: () => setForm({ ...form, gender: 'female' }) },
                { text: "Khác", onPress: () => setForm({ ...form, gender: 'other' }) },
                { text: "Hủy", style: "cancel" }
            ]
        );
    };

    // KHÔI PHỤC POPUP CHỌN GOAL (TARGET MENU)
    const showGoalPicker = () => {
        Alert.alert(
            "Mục Tiêu Tập Luyện",
            "Chọn mục tiêu thể hình hiện tại:",
            [
                { text: t('goal.Muscle Gain'), onPress: () => setForm({ ...form, goal: 'Muscle Gain' }) },
                { text: t('goal.Fat Loss'), onPress: () => setForm({ ...form, goal: 'Fat Loss' }) },
                { text: t('goal.Maintenance'), onPress: () => setForm({ ...form, goal: 'Maintenance' }) },
                { text: "Hủy", style: "cancel" }
            ]
        );
    };

    const handleSaveProfile = () => {
        // 1. Validate các trường bắt buộc để tính BMI/TDEE
        if (!form.height || parseInt(form.height) < 50 || parseInt(form.height) > 250) {
            Alert.alert("Lỗi", "Vui lòng nhập chiều cao hợp lệ (50-250cm).");
            return;
        }
        if (!form.birth_year || parseInt(form.birth_year) < 1900) {
            Alert.alert("Lỗi", "Vui lòng nhập năm sinh hợp lệ.");
            return;
        }
        if (!form.activity_level) {
            Alert.alert("Lỗi", "Vui lòng chọn mức độ vận động.");
            return;
        }
        const payload = {
            ...form,
            birth_year: form.birth_year ? parseInt(form.birth_year, 10) : null,
            height: form.height ? parseInt(form.height, 10) : null,
            activity_level: form.activity_level ? parseFloat(form.activity_level) : 1.2,
            // calorie: form.calorie ? parseInt(form.calorie, 10) : null,
        };
        console.log("Payload cập nhật hồ sơ:", payload);
        dispatch(updateUserProfile(payload)).then(() => {
            Alert.alert("Thành công", "Đã cập nhật thông tin cá nhân!");
        });
    };
    return (
        <View style={styles.programsContainer}>
            {/* Logic hiển thị ruler và hình ảnh ở đây */}
            {/* <Text>Tab Chi Tiết</Text> */}
            <View style={styles.formContainer}>
                <View style={styles.rowInput}>
                    <View style={{ flex: 1 }}>
                        <Text style={styles.inputLabel}>Năm Sinh</Text>
                        <TextInput style={styles.modernInput} value={form.birth_year}
                            onChangeText={(t) => setForm({ ...form, birth_year: t })}
                            keyboardType="numeric" placeholder="-- " placeholderTextColor="#64748B" />
                    </View>
                    <View style={{ flex: 1 }}>
                        <Text style={styles.inputLabel}>{t('account.gender')}</Text>
                        {/* KHÔI PHỤC CLICKABLE CHỌN GENDER */}
                        <TouchableOpacity style={[styles.modernInput, styles.clickableInput]} onPress={showGenderPicker}>
                            <Text style={{ color: '#FFF' }}>{form.gender === 'male' ? 'Nam' : form.gender === 'female' ? 'Nữ' : 'Khác'}</Text>
                        </TouchableOpacity>
                    </View>
                </View>

                <View style={styles.rowInput}>
                    <View style={{ flex: 1 }}>
                        <Text style={styles.inputLabel}>{t('account.height')}</Text>
                        <TextInput style={styles.modernInput} value={form.height} onChangeText={(t) => setForm({ ...form, height: t })} keyboardType="numeric" placeholder="170... ?" placeholderTextColor="#64748B" />
                    </View>
                    <View style={{ flex: 1 }}>
                        <Text style={styles.inputLabel}>{t('account.fitnessGoal')}</Text>
                        {/* KHÔI PHỤC CLICKABLE CHỌN TARGET MENU */}
                        <TouchableOpacity style={[styles.modernInput, styles.clickableInput, { height: 50 }]} onPress={showGoalPicker}>
                            <Text style={{ color: '#FFF' }}>{t('goal.' + form.goal || 'Bấm để lựa chọn...')}</Text>
                        </TouchableOpacity>
                    </View>
                </View>

                <Text style={styles.inputLabel}>{t('account.activityLevel')}</Text>
                <TouchableOpacity
                    style={[styles.modernInput, styles.clickableInput]}
                    onPress={() => {
                        // Hiện Alert chọn Activity Level giống như Gender Picker
                        Alert.alert("Chọn Mức Độ Vận Động", "Lựa chọn mức độ của bạn:", [
                            ...ACTIVITY_LEVELS.map(item => ({
                                text: t('activity.' + item.label),
                                onPress: () => setForm({ ...form, activity_level: item.value })
                            })),
                            { text: "Hủy", style: "cancel" }
                        ]);
                        // console.log("Activity Level hiện tại:", form.activity_level);
                    }}
                >
                    <Text style={{ color: '#FFF' }}>
                        {/* {ACTIVITY_LEVELS.find(i => i.value == form.activity_level)?.label || 'Chọn...'} */}
                        {t('activity.' + ACTIVITY_LEVELS.find(i =>
                            parseFloat(i.value).toFixed(1) === parseFloat(form.activity_level || 1.2).toFixed(1)
                        )?.label) || 'Chọn mức độ vận động'}
                    </Text>
                </TouchableOpacity>

                {/* <Text style={styles.inputLabel}>Mục tiêu Calorie / ngày</Text>
                <TextInput style={styles.modernInput} value={form.calorie} onChangeText={(t) => setForm({ ...form, calorie: t })} keyboardType="numeric" placeholder="2000" placeholderTextColor="#64748B" /> */}

                <Text style={styles.inputLabel}>{t('account.personalNotes')}</Text>
                <TextInput style={[styles.modernInput, { height: 80, textAlignVertical: 'top' }]} value={form.note} onChangeText={(t) => setForm({ ...form, note: t })} multiline placeholder="Ghi chú thể trạng..." placeholderTextColor="#64748B" />

                <View style={{ marginTop: 20, marginBottom: 40 }}>
                    <MyButton type="orange" title={t('account.updateProfile')} onPress={handleSaveProfile} />
                </View>
            </View>
        </View>
    );
};
export default DetailsTab;
