import React, { useState } from 'react';
import { View, Text, Alert, TouchableOpacity } from 'react-native';
import { useDispatch, useSelector } from 'react-redux';
import { loginUser } from '../../store/slices/authSlice';
import CustomInput from '../../components/common/CustomInput';
import CustomButton from '../../components/common/CustomButton';
import { authStyles } from './authStyles';

export default function LoginScreen({ navigation }) {
    const dispatch = useDispatch();
    const { isLoading } = useSelector((state) => state.auth);

    const [phone, setPhone] = useState('');
    const [password, setPassword] = useState('');

    const handleLogin = async () => {
        if (!phone || !password) {
            Alert.alert('Lỗi', 'Vui lòng nhập số điện thoại và mật khẩu.');
            return;
        }

        const resultAction = await dispatch(loginUser({ phone, password }));

        if (!loginUser.fulfilled.match(resultAction)) {
            Alert.alert('Đăng nhập thất bại', resultAction.payload || 'Sai thông tin đăng nhập.');
        }
    };

    return (
        <View style={authStyles.container}>
            <Text style={authStyles.headerTitle}>Đăng Nhập</Text>
            <Text style={authStyles.subtitle}>Chào mừng bạn quay trở lại hệ thống</Text>

            <CustomInput
                label="Số điện thoại"
                placeholder="Nhập số điện thoại"
                value={phone}
                onChangeText={setPhone}
                keyboardType="phone-pad"
            />

            <CustomInput
                label="Mật khẩu"
                placeholder="Nhập mật khẩu"
                value={password}
                onChangeText={setPassword}
                secureTextEntry
            />

            <CustomButton title="Đăng Nhập" onPress={handleLogin} isLoading={isLoading} />

            <TouchableOpacity style={authStyles.switchLink} onPress={() => navigation.navigate('Register')}>
                <Text style={authStyles.switchText}>
                    Chưa có tài khoản? <Text style={authStyles.linkBold}>Đăng ký ngay</Text>
                </Text>
            </TouchableOpacity>
        </View>
    );
}