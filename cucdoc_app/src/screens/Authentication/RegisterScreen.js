

import React, { useState, useEffect } from 'react';
import { Platform, View, Text, TextInput, TouchableOpacity, KeyboardAvoidingView, ScrollView, TouchableWithoutFeedback, Keyboard, ActivityIndicator, Alert, StatusBar } from 'react-native';
import { Image } from 'expo-image'; // Sử dụng bộ đệm của expo-image
import { User, Mail, Lock, UserPlus, Calendar, Activity } from 'lucide-react-native'; import { useDispatch, useSelector } from 'react-redux';
// import { ACTIVITY_LEVELS } from '../../constants/constants';
import { registerUser } from '../../store/slices/authSlice';
import styles from './style'; // Sử dụng chung file style với Login để đồng bộ thiết kế
import { useLanguage } from '../../i18n/LanguageContext';

// Một bức ảnh nền mang tính bùng nổ, động lực khác cho màn hình đăng ký
const BG_REGISTER = "https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=1000&auto=format&fit=crop";

export default function RegisterScreen({ navigation }) {
  const { t } = useLanguage();
  const dispatch = useDispatch();
  const { loading } = useSelector((state) => state.auth);
  const [form, setForm] = useState({
    email: '',
    password: '',
    username: '',
    birth_year: new Date().getFullYear() - 25,
    activity_level: null,
  });

  const handleRegister = async () => {
    if (!form.email || !form.password || !form.username) {
      Alert.alert(t('auth.required'), t('auth.registerMissing'));
      return;
    }

    const res = await dispatch(registerUser(form));
    
    // Chỉ chuyển hướng khi thành công 100%
    if (res.meta?.requestStatus === 'fulfilled' && res.payload?.status === true) {
      Alert.alert(t('auth.resetSuccess'), t('auth.registrationSuccess'));
      navigation.replace('Login'); // Chỉ gọi ở đây
    } else {
      // Khi thất bại, CHỈ HIỂN THỊ ALERT, KHÔNG ĐƯỢC GỌI NAVIGATION GÌ CẢ
      const errorMessage = res.payload?.message || 'Có lỗi xảy ra';
      Alert.alert(t('auth.registrationFailed'), errorMessage);
    }
  };
  // const handleRegister = async () => {
  //   if (!form.email || !form.password || !form.username) {
  //     Alert.alert('Lỗi', 'Vui lòng điền đầy đủ thông tin');
  //     return;
  //   }
  //   const res = await dispatch(registerUser(form));
  //   console.log('Register response:', res);
  //   if (res.payload?.status) {
  //     Alert.alert('Thành công', 'Tài khoản đã được tạo');
  //     // navigation.replace('Login');
  //   } else {
  //     Alert.alert('Đăng ký thất bại', res.payload?.message || 'Có lỗi xảy ra');
  //   }
  // };
  // useEffect(() => {
  //   const unsubscribe = navigation.addListener('blur', () => {
  //     console.log('RegisterScreen BLUR');
  //   });

  //   return unsubscribe;
  // }, [navigation]);
  // useEffect(() => {
  //   console.log('RegisterScreen mounted');

  //   return () => {
  //     console.log('RegisterScreen unmounted');
  //   };
  // }, []);

  return (
    <View style={{ flex: 1, backgroundColor: '#000' }}>
      <StatusBar barStyle="light-content" />

      {/* BACKGROUND IMAGE & OVERLAY */}
      <Image
        source={{ uri: BG_REGISTER }}
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
              <Text style={styles.brandTitle}>CUCDOC</Text>
              <Text style={styles.brandTagline}>CHẾ ĐỘ CHIẾN BINH</Text>
              {/* <Text style={styles.subTitle}>Tạo tài khoản để mở khóa toàn bộ giáo án tập luyện của bạn.</Text> */}
            </View>

            <View style={styles.formContainer}>

              {/* Tên người dùng */}
              <View style={styles.inputWrapper}>
                <User size={20} color="#94A3B8" style={styles.inputIcon} />
                <TextInput
                  style={styles.input}
                  placeholder={t('auth.username')}
                  placeholderTextColor="#64748B"
                  autoCapitalize="none"
                  value={form.username}
                  onChangeText={(text) => setForm({ ...form, username: text })}
                />
              </View>

              {/* Email */}
              <View style={styles.inputWrapper}>
                <Mail size={20} color="#94A3B8" style={styles.inputIcon} />
                <TextInput
                  style={styles.input}
                  placeholder={t('auth.email')}
                  keyboardType="email-address"
                  placeholderTextColor="#64748B"
                  autoCapitalize="none"
                  value={form.email}
                  onChangeText={(text) => setForm({ ...form, email: text })}
                />
              </View>

              {/* Mật khẩu */}
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
              {/* Ô chọn năm sinh */}
              {/* <TouchableOpacity style={styles.inputWrapper} onPress={showYearPicker}>
                <Calendar size={20} color="#94A3B8" style={styles.inputIcon} />
                <Text style={{ color: '#FFF', flex: 1 }}>Năm sinh: {form.birth_year}</Text>
              </TouchableOpacity> */}
              {/* Ô chọn mức độ vận động */}
              {/* <TouchableOpacity style={styles.inputWrapper} onPress={showActivityPicker}>
                <Activity size={20} color="#94A3B8" style={styles.inputIcon} />
                <Text
                  style={{
                    color: form.activity_level ? '#FFF' : '#94A3B8', // Màu xám khi là placeholder, trắng khi đã chọn
                    flex: 1
                  }}
                  numberOfLines={1}
                >
                  {ACTIVITY_LEVELS.find(i => i.value == form.activity_level)?.label || "Chọn mức độ vận động"}
                </Text>
              </TouchableOpacity> */}
              {/* <TouchableOpacity style={styles.inputWrapper} onPress={showActivityPicker}>
                <Activity size={20} color="#94A3B8" style={styles.inputIcon} />
                <Text style={{ color: '#FFF', flex: 1 }} numberOfLines={1}>
                  {ACTIVITY_LEVELS.find(i => i.value == form.activity_level)?.label}
                </Text>
              </TouchableOpacity> */}

              {/* Button Tạo tài khoản màu cam */}
              <TouchableOpacity
                style={[styles.mainButton, loading && { opacity: 0.8 }]}
                onPress={handleRegister}
                disabled={loading}
              >
                {loading ? (
                  <ActivityIndicator color="#000" />
                ) : (
                  <View style={styles.buttonInner}>
                    <Text style={styles.buttonText}>{t('auth.register')}</Text>
                    <UserPlus size={20} color="#000" />
                  </View>
                )}
              </TouchableOpacity>

              <View style={styles.footer}>
                <Text style={styles.footerText}>{t('auth.haveAccount')}</Text>
                <TouchableOpacity onPress={() => navigation.navigate('Login')}>
                  <Text style={styles.footerLink}>{t('auth.login')}</Text>
                </TouchableOpacity>
              </View>
            </View>
          </ScrollView>
        </TouchableWithoutFeedback>
      </KeyboardAvoidingView>
    </View>
  );
}
