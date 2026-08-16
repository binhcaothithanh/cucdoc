import React, { useState } from 'react';
import { Platform, View, Text, TextInput, TouchableOpacity, KeyboardAvoidingView, ScrollView, TouchableWithoutFeedback, Keyboard, ActivityIndicator, Alert, StatusBar } from 'react-native';
import { Image } from 'expo-image';
import { Lock, Eye, EyeOff, ArrowRight } from 'lucide-react-native';
import { useDispatch } from 'react-redux';

// Import action từ authSlice (Chúng ta sẽ định nghĩa action này ở bước tiếp theo)
import { updateNewPassword } from '../../store/slices/authSlice'; 

import styles from './style';
import { useLanguage } from '../../i18n/LanguageContext';

const BG_CHANGE_PASS = "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1000&auto=format&fit=crop";

export default function ChangePasswordTempScreen({ navigation }) {
    const { t } = useLanguage();
    const dispatch = useDispatch();

    const [password, setPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const [submitting, setSubmitting] = useState(false);

    // State ẩn/hiện mật khẩu
    const [securePassword, setSecurePassword] = useState(true);
    const [secureConfirmPassword, setSecureConfirmPassword] = useState(true);

    const handleChangePassword = async () => {
        // 1. Validate dữ liệu đầu vào cơ bản
        if (!password || !confirmPassword) {
            Alert.alert('Lỗi', 'Vui lòng nhập đầy đủ thông tin mật khẩu');
            return;
        }

        if (password.length < 6) {
            Alert.alert('Lỗi', 'Mật khẩu mới phải có ít nhất 6 ký tự');
            return;
        }

        if (password !== confirmPassword) {
            Alert.alert('Lỗi', 'Mật khẩu xác nhận không khớp');
            return;
        }

        try {
            setSubmitting(true);

            // 2. Gọi API thông qua Redux Thunk
            const res = await dispatch(updateNewPassword({ password }));

            // 3. Xử lý phản hồi từ phía Server
            if (!res.payload?.status) {
                Alert.alert('Thất bại', res.payload?.message || 'Không thể cập nhật mật khẩu lúc này');
            } else {
                Alert.alert(
                    'Thành công',
                    'Mật khẩu của bạn đã được cập nhật chính thức!',
                    [
                        {
                            text: 'Bắt đầu luyện tập',
                            onPress: () => {
                                // Chuyển hướng thẳng vào màn hình chính của App (ví dụ: MainTabs hoặc Home)
                                // Thay 'MainTabs' bằng tên Route màn hình chính trong Navigation của bạn
                                navigation.replace('MainTabs'); 
                            }
                        }
                    ]
                );
            }
        } catch (error) {
            console.log('Lỗi cập nhật mật khẩu:', error);
            Alert.alert('Lỗi', 'Có lỗi kết nối hệ thống xảy ra.');
        } finally {
            setSubmitting(false);
        }
    };

    return (
        <View style={{ flex: 1, backgroundColor: '#000' }}>
            <StatusBar barStyle="light-content" />

            {/* BACKGROUND IMAGE & OVERLAY (Giữ nguyên phong cách thiết kế mạnh mẽ) */}
            <Image
                source={{ uri: BG_CHANGE_PASS }}
                style={styles.backgroundImage}
                contentFit="cover"
                cachePolicy="disk"
            />
            <View style={styles.darkOverlay} />

            {/* MAIN CONTENT */}
            <KeyboardAvoidingView
                behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
                style={styles.container}
            >
                <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
                    <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>

                        <View style={styles.headerArea}>
                            <Text style={styles.brandTitle}>{t('auth.newPasswordTitle')}</Text>
                            <Text style={styles.brandTagline}>{t('auth.newPasswordTagline')}</Text>
                            <Text style={styles.subTitle}>{t('auth.newPasswordDescription')}</Text>
                        </View>

                        <View style={styles.formContainer}>

                            {/* Ô Nhập Mật khẩu mới */}
                            <View style={styles.inputWrapper}>
                                <Lock size={20} color="#94A3B8" style={styles.inputIcon} />
                                <TextInput
                                    style={styles.input}
                                    placeholder={t('auth.newPassword')}
                                    secureTextEntry={securePassword}
                                    autoCapitalize="none"
                                    placeholderTextColor="#64748B"
                                    value={password}
                                    onChangeText={(text) => setPassword(text)}
                                />
                                <TouchableOpacity 
                                    style={{ padding: 10 }} 
                                    onPress={() => setSecurePassword(!securePassword)}
                                >
                                    {securePassword ? <EyeOff size={18} color="#64748B" /> : <Eye size={18} color="#64748B" />}
                                </TouchableOpacity>
                            </View>

                            {/* Ô Nhập lại mật khẩu mới */}
                            <View style={styles.inputWrapper}>
                                <Lock size={20} color="#94A3B8" style={styles.inputIcon} />
                                <TextInput
                                    style={styles.input}
                                    placeholder={t('auth.confirmPassword')}
                                    secureTextEntry={secureConfirmPassword}
                                    autoCapitalize="none"
                                    placeholderTextColor="#64748B"
                                    value={confirmPassword}
                                    onChangeText={(text) => setConfirmPassword(text)}
                                />
                                <TouchableOpacity 
                                    style={{ padding: 10 }} 
                                    onPress={() => setSecureConfirmPassword(!secureConfirmPassword)}
                                >
                                    {secureConfirmPassword ? <EyeOff size={18} color="#64748B" /> : <Eye size={18} color="#64748B" />}
                                </TouchableOpacity>
                            </View>

                            {/* Nút bấm Gửi yêu cầu cập nhật */}
                            <TouchableOpacity
                                style={[styles.mainButton, submitting && { opacity: 0.8 }]}
                                onPress={handleChangePassword}
                                disabled={submitting}
                            >
                                {submitting ? (
                                    <ActivityIndicator color="#000" />
                                ) : (
                                    <View style={styles.buttonInner}>
                                        <Text style={styles.buttonText}>{t('auth.activateAccount')}</Text>
                                        <ArrowRight size={20} color="#000" />
                                    </View>
                                )}
                            </TouchableOpacity>

                            {/* <View style={styles.footer}>
                                <TouchableOpacity onPress={() => navigation.replace('Login')}>
                                    <Text style={styles.footerLink}>{t('auth.cancelAndLogin')}</Text>
                                </TouchableOpacity>
                            </View> */}
                        </View>
                    </ScrollView>
                </TouchableWithoutFeedback>
            </KeyboardAvoidingView>
        </View>
    );
}
