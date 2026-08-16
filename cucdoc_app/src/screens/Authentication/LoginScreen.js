
import React, { useEffect, useState } from 'react';
import { Platform, View, Text, TextInput, TouchableOpacity, KeyboardAvoidingView, ScrollView, TouchableWithoutFeedback, Keyboard, ActivityIndicator, Alert, StatusBar } from 'react-native';
import { Image } from 'expo-image'; // Sử dụng expo-image để cache ảnh nền tốt hơn
import { Mail, Lock, ArrowRight } from 'lucide-react-native';
import { loginUser } from '../../store/slices/authSlice';
import { useDispatch, useSelector } from 'react-redux';
import styles from './style';
import { useLanguage } from '../../i18n/LanguageContext';

// Bạn có thể thay link này bằng ảnh local (require('./background.jpg')) hoặc ảnh CDN chất lượng cao của bạn
const BG_MOTIVATION = "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1000&auto=format&fit=crop";

export default function LoginScreen({ route, navigation }) {
  const { t } = useLanguage();
  const loginEmail = route.params?.email;
  // const [email, setEmail] = useState(loginEmail || '');

  const dispatch = useDispatch();
  const { loading } = useSelector((state) => state.auth);
  const [form, setForm] = useState({ email: '', password: '' });
  const [submitting, setSubmitting] = useState(false); // State loading giả lập hoặc kết nối API sau này

  useEffect(() => {
    if (!loginEmail) {
      setForm({ email: 'trang020185@gmail.com', password: '123456' });
    } else {
      setForm({ email: loginEmail, password: '' });
    }
  }, []);

  const handleLogin = async () => {
    if (!form.email || !form.password) {
      Alert.alert(t('auth.loginFailed'), t('auth.missingCredentials'));
      return;
    }
    // console.log('Attempting login with:', form);

    // const res = await dispatch(loginUser(form));
    // if (!res.payload?.status) {
    //   Alert.alert('Đăng nhập thất bại', res.payload?.message || 'Có lỗi xảy ra');
    // }
    setSubmitting(true);
    const res = await dispatch(loginUser(form));
    setSubmitting(false);

    if (res.payload?.status) {
      console.log('Login successful, response payload data:', res.payload.data.is_temp_password);
      const isTempPassword = res.payload.data?.is_temp_password;

      if (isTempPassword == 1) {
        // TRƯỜNG HỢP 1: Đăng nhập bằng mật khẩu tạm -> Bắt buộc qua trang tạo mật khẩu mới
        Alert.alert('Thông báo', 'Bạn đang sử dụng mật khẩu tạm thời. Vui lòng đổi mật khẩu mới để bảo mật tài khoản.');
        navigation.replace('ChangePasswordTemp'); // Tên màn hình đặt lại mật khẩu mới
      } else {
        // console.log('thong tin tem pass', isTempPassword == 1);
        // TRƯỜNG HỢP 2: Đăng nhập bình thường -> Vào thẳng màn hình chính do redux tự lưu state user và navigation sẽ điều hướng tới Main Navigation 
        // navigation.replace('HomeMain'); // Hoặc 'Home' tùy cách bạn đặt tên
      }
    } else {
      console.log('Login failed, response payload:', res);
      Alert.alert(t('auth.loginFailed'), res.payload?.message || t('auth.loginFailed'));
    }
  };

  const handleForgotPassword = () => {
    navigation.navigate('ForgotPassword', { email: form.email });
  }

  return (
    <View style={{ flex: 1, backgroundColor: '#000' }}>
      <StatusBar barStyle="light-content" />

      {/* 1. BACKGROUND IMAGE & OVERLAY */}
      <Image
        source={{ uri: BG_MOTIVATION }}
        style={styles.backgroundImage}
        contentFit="cover"
        cachePolicy="disk"
      />
      <View style={styles.darkOverlay} />

      {/* 2. MAIN CONTENT */}
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
        style={styles.container}
      >
        <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
          <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>

            <View style={styles.headerArea}>
              <Text style={styles.brandTitle}>CUCDOC</Text>
              <Text style={styles.brandTagline}>FITNESS CHALLENGE</Text>
              {/* <Text style={styles.subTitle}>Sẵn sàng vượt qua giới hạn hôm nay?</Text> */}
            </View>

            <View style={styles.formContainer}>

              {/* Input Email */}
              <View style={styles.inputWrapper}>
                <Mail size={20} color="#94A3B8" style={styles.inputIcon} />
                <TextInput
                  style={styles.input}
                  placeholder={t('auth.email')}
                  keyboardType="email-address"
                  autoCapitalize="none"
                  placeholderTextColor="#64748B"
                  value={form.email}
                  onChangeText={(text) => setForm({ ...form, email: text })}
                />
              </View>

              {/* Input Password */}
              <View style={styles.inputWrapper}>
                <Lock size={20} color="#94A3B8" style={styles.inputIcon} />
                <TextInput
                  style={styles.input}
                  placeholder={t('auth.password')}
                  secureTextEntry
                  placeholderTextColor="#64748B"
                  value={form.password}
                  onChangeText={(text) => setForm({ ...form, password: text })}
                />
              </View>

              <TouchableOpacity style={styles.forgotPass} onPress={handleForgotPassword}>
                <Text style={styles.forgotText}>{t('auth.forgotPassword')}</Text>
              </TouchableOpacity>

              {/* Button Đăng nhập Thể Thao (Cam/Neon thịnh hành) */}
              <TouchableOpacity
                style={[styles.mainButton, loading && { opacity: 0.8 }]}
                onPress={handleLogin}
                disabled={loading}
              >
                {loading ? (
                  <ActivityIndicator color="#000" />
                ) : (
                  <View style={styles.buttonInner}>
                    <Text style={styles.buttonText}>{t('auth.startTraining')}</Text>
                    <ArrowRight size={20} color="#000" />
                  </View>
                )}
              </TouchableOpacity>

              <View style={styles.footer}>
                <Text style={styles.footerText}>{t('auth.noAccount')}</Text>
                <TouchableOpacity onPress={() => navigation.navigate('Register')}>
                  <Text style={styles.footerLink}>{t('auth.signUp')}</Text>
                </TouchableOpacity>
              </View>
            </View>

          </ScrollView>
        </TouchableWithoutFeedback>
      </KeyboardAvoidingView>
    </View>
  );
}
