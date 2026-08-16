import React, { useState } from 'react';
import { Modal, View, Text, Alert, TouchableOpacity, TouchableWithoutFeedback, Keyboard, ImageBackground } from 'react-native';
import { Ruler, Calendar, Activity, UserPlus } from 'lucide-react-native';

import { ACTIVITY_LEVELS } from '../../../constants/constants';
// import MyButton from '../../../components/common/MyButton';
import styles from '../../Authentication/style'; // Sử dụng chung file style với Register để đồng bộ thiết kế
const BG_IMAGE = "https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=1000&auto=format&fit=crop";
const ProfileSetupModal = ({ visible, onSave }) => {
    const [form, setForm] = useState({
        height: '',
        birth_year: null,
        activity_level: null
    });


    const handleSave = () => {
        if (!form.height || !form.birth_year || !form.activity_level) {
            Alert.alert("Lỗi", "Vui lòng điền đầy đủ thông tin");
            return;
        }
        onSave(form);
    };
    const showActivityPicker = () => {
        Alert.alert("Chọn mức độ vận động", "Lựa chọn mức độ của bạn:", [
            ...ACTIVITY_LEVELS.map(item => ({
                text: item.label,
                onPress: () => setForm({ ...form, activity_level: item.value })
            })),
            { text: "Hủy", style: "cancel" }
        ]);
    };

    const showYearPicker = () => {
        const currentYear = new Date().getFullYear();
        const years = Array.from({ length: 60 }, (_, i) => currentYear - 15 - i); // Từ 15 đến 78 tuổi

        Alert.alert("Chọn năm sinh", "Chọn năm sinh của bạn:", [
            ...years.map(y => ({
                text: y.toString(),
                onPress: () => setForm({ ...form, birth_year: y })
            })),
            { text: "Hủy", style: "cancel" }
        ]);
    };
    const showHeightPicker = () => {
        // Tạo mảng từ 50 đến 250
        const heights = Array.from({ length: 201 }, (_, i) => 50 + i);

        Alert.alert("Chọn chiều cao (cm)", "Chọn chiều cao của bạn:", [
            ...heights.map(h => ({
                text: h.toString(),
                onPress: () => setForm({ ...form, height: h.toString() })
            })),
            { text: "Hủy", style: "cancel" }
        ]);
    };
    // console.log('form.birth_year', form.birth_year);
    // console.log('form.height', form.height);
    return (
        <Modal visible={visible} animationType="slide">
            <ImageBackground source={{ uri: BG_IMAGE }} style={styles.backgroundImage}></ImageBackground>
            <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
                {/* Sử dụng container có nền tối đồng bộ với app */}
                <View style={styles.modalContainer}>
                    <View style={styles.headerArea}>
                        <Text style={styles.brandTitle}>CUCDOC</Text>
                        <Text style={styles.subTitle}>Thiết lập thông tin cá nhân</Text>
                    </View>

                    <View style={styles.formContainer}>
                        {/* Chiều cao */}
                        <TouchableOpacity style={styles.inputWrapper} onPress={showHeightPicker}>
                            <Ruler size={20} color="#94A3B8" style={styles.inputIcon} />
                            <Text style={form.height ? styles.input : [styles.input, { color: '#64748B' }]}>
                                {form.height ? `${form.height} cm` : "Chiều cao (cm)"}
                            </Text>
                        </TouchableOpacity>

                        {/* Năm sinh */}
                        <TouchableOpacity style={styles.inputWrapper} onPress={showYearPicker}>
                            <Calendar size={20} color="#94A3B8" style={styles.inputIcon} />
                            <Text style={form.birth_year ? styles.input : [styles.input, { color: '#64748B' }]}>
                                {form.birth_year ? String(form.birth_year) : "Năm sinh"}
                            </Text>
                        </TouchableOpacity>

                        {/* Mức vận động */}
                        <TouchableOpacity style={styles.inputWrapper} onPress={showActivityPicker}>
                            <Activity size={20} color="#94A3B8" style={styles.inputIcon} />
                            <Text style={form.activity_level ? styles.input : [styles.input, { color: '#64748B' }]}>
                                {ACTIVITY_LEVELS.find(i => i.value == form.activity_level)?.label || "Chọn mức độ vận động"}
                            </Text>
                        </TouchableOpacity>

                        {/* Button Cam đồng bộ */}
                        <TouchableOpacity style={styles.mainButton} onPress={handleSave}>
                            <View style={styles.buttonInner}>
                                <Text style={styles.buttonText}>BẮT ĐẦU HÀNH TRÌNH</Text>
                                <UserPlus size={20} color="#000" />
                            </View>
                        </TouchableOpacity>
                    </View>
                </View>
            </TouchableWithoutFeedback>
        </Modal>
    );
};

export default ProfileSetupModal;