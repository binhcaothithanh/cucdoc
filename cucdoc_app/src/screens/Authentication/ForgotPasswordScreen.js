import React, { useState } from 'react';
import { Platform, View, Text, TextInput, TouchableOpacity, KeyboardAvoidingView, ScrollView, TouchableWithoutFeedback, Keyboard, ActivityIndicator, Alert, StatusBar } from 'react-native';
import { Image } from 'expo-image';
import { Mail, ArrowRight } from 'lucide-react-native';
import { useDispatch, useSelector } from 'react-redux';

import { resetPassword } from '../../store/slices/authSlice';

import styles from './style'; // Vẫn dùng chung file style hệ thống
import { useLanguage } from '../../i18n/LanguageContext';

const BG_FORGOT = "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1000&auto=format&fit=crop";

export default function ForgotPasswordScreen({ route, navigation }) {
    const { t } = useLanguage();
    const dispatch = useDispatch();
    const userEmail = route.params?.email;
    const [email, setEmail] = useState(userEmail || ''); // Nếu có email từ Login thì tự động điền vào ô input
    const [submitting, setSubmitting] = useState(false); // State loading giả lập hoặc kết nối API sau này


    // const handleResetPassword = async () => {
    //     console.log('Reset password for email:', email);

    //     if (!email) {
    //         Alert.alert('Lỗi', 'Vui lòng nhập email của bạn');
    //         return;
    //     }

    //     try {
    //         // 1. Bật trạng thái loading để hiển thị ActivityIndicator và khóa nút bấm
    //         setSubmitting(true);

    //         // 2. Gửi request lên server
    //         const res = await dispatch(resetPassword({ email }));

    //         // 3. Xử lý kết quả trả về
    //         if (!res.payload?.status) {
    //             Alert.alert('Reset password Fail', res.payload?.message || 'Có lỗi xảy ra');
    //         } else {
    //             Alert.alert(
    //                 'Thành công', 
    //                 'Thông tin đã được gửi về email của bạn',
    //                 [
    //                     { 
    //                         text: 'OK', 
    //                         onPress: () => {
    //                             // Điều hướng về Login và truyền kèm email vừa khôi phục sang
    //                             navigation.replace('Login', { email: email });
    //                         } 
    //                     }
    //                 ]
    //             );
    //         }
    //     } catch (error) {
    //         console.log('Lỗi client/redux:', error);
    //         Alert.alert('Lỗi', 'Không thể kết nối đến máy chủ.');
    //     } finally {
    //         // 4. Tắt loading dù thành công hay thất bại
    //         setSubmitting(false);
    //     }
    // };

    const handleResetPassword = async () => {
        console.log('Reset password for email:', email);
        if (!email) {
            Alert.alert(t('auth.required'), t('auth.email'));
            return;
        }

        try {
            setSubmitting(true);
            const res = await dispatch(resetPassword({ email }));

            // KIỂM TRA TRẠNG THÁI REJECTED CỦA REDUX ACTION
            if (resetPassword.rejected.match(res)) {
                // Lấy thông báo lỗi do Thunk đẩy về qua rejectWithValue
                const errorMsg = res.payload?.message || 'Email này không tồn tại trên hệ thống';
                Alert.alert(t('auth.resetError'), errorMsg);
                return;
            }

            // XỬ LÝ KHI THÀNH CÔNG (Trường hợp HTTP Status là 200 OK)
            if (res.payload?.status) {
                Alert.alert(
                    t('auth.resetSuccess'),
                    t('auth.resetSent'),
                    [
                        {
                            text: 'OK',
                            onPress: () => navigation.replace('Login', { email: email })
                        }
                    ]
                );
            } else {
                Alert.alert(t('auth.resetError'), res.payload?.message || t('auth.resetError'));
            }

        } catch (error) {
            console.log('Lỗi client execution:', error);
            Alert.alert(t('auth.resetError'), t('auth.resetError'));
        } finally {
            setSubmitting(false);
        }
    };

    return (
        <View style={{ flex: 1, backgroundColor: '#000' }}>
            <StatusBar barStyle="light-content" />

            {/* BACKGROUND IMAGE & OVERLAY */}
            <Image
                source={{ uri: BG_FORGOT }}
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
                            <Text style={styles.brandTitle}>{t('auth.forgotTitle')}</Text>
                            <Text style={styles.brandTagline}>{t('auth.forgotTagline')}</Text>
                            <Text style={styles.subTitle}>{t('auth.forgotDescription')}</Text>
                        </View>

                        <View style={styles.formContainer}>

                            {/* Ô Nhập Email */}
                            <View style={styles.inputWrapper}>
                                <Mail size={20} color="#94A3B8" style={styles.inputIcon} />
                                <TextInput
                                    style={styles.input}
                                    placeholder={t('auth.email')}
                                    keyboardType="email-address"
                                    autoCapitalize="none"
                                    placeholderTextColor="#64748B"
                                    value={email}
                                    onChangeText={(text) => setEmail(text)}
                                />
                            </View>

                            {/* Nút bấm Gửi yêu cầu */}
                            <TouchableOpacity
                                style={[styles.mainButton, submitting && { opacity: 0.8 }]}
                                onPress={handleResetPassword}
                                disabled={submitting}
                            >
                                {submitting ? (
                                    <ActivityIndicator color="#000" />
                                ) : (
                                    <View style={styles.buttonInner}>
                                        <Text style={styles.buttonText}>{t('auth.sendNewPassword')}</Text>
                                        <ArrowRight size={20} color="#000" />
                                    </View>
                                )}
                            </TouchableOpacity>

                            <View style={styles.footer}>
                                <TouchableOpacity onPress={() => navigation.navigate('Login')}>
                                    <Text style={styles.footerLink}>{t('auth.backToLogin')}</Text>
                                </TouchableOpacity>
                            </View>
                        </View>
                    </ScrollView>
                </TouchableWithoutFeedback>
            </KeyboardAvoidingView>
        </View>
    );
}
