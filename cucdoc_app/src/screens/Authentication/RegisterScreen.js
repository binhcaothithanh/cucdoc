import React, { useState } from 'react';
import { View, Text, Alert, TouchableOpacity } from 'react-native';
import { useDispatch, useSelector } from 'react-redux';
import { registerUser } from '../../store/slices/authSlice';
import CustomInput from '../../components/common/CustomInput';
import CustomButton from '../../components/common/CustomButton';
import RoleSelector from './components/RoleSelector'; // Component nhỏ dùng chung trong Auth
import { authStyles } from './authStyles';

export default function RegisterScreen({ navigation }) {
    const dispatch = useDispatch();
    const { isLoading } = useSelector((state) => state.auth);

    const [phone, setPhone] = useState('');
    const [password, setPassword] = useState('');
    const [fullName, setFullName] = useState('');
    const [role, setRole] = useState('customer');

    const handleRegister = async () => {
        if (!phone || !password) {
            Alert.alert('Lỗi', 'Vui lòng nhập đầy đủ số điện thoại và mật khẩu.');
            return;
        }

        const resultAction = await dispatch(registerUser({
            phone,
            password,
            full_name: fullName,
            role
        }));

        if (registerUser.fulfilled.match(resultAction)) {
            Alert.alert('Thành công', 'Đăng ký tài khoản thành công! Hãy đăng nhập.', [
                { text: 'OK', onPress: () => navigation.navigate('Login') }
            ]);
        } else {
            Alert.alert('Đăng ký thất bại', resultAction.payload || 'Có lỗi xảy ra.');
        }
    };

    return (
        <View style={authStyles.container}>
            <Text style={authStyles.headerTitle}>Tạo Tài Khoản</Text>
            <Text style={authStyles.subtitle}>Đăng ký để bắt đầu trải nghiệm dịch vụ</Text>
            
            <CustomInput
                label="Họ và tên"
                placeholder="Nhập họ tên của bạn"
                value={fullName}
                onChangeText={setFullName}
            />

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

            {/* Gọi component nhỏ dùng chung cho phần chọn role */}
            <RoleSelector selectedRole={role} onSelectRole={setRole} />

            <CustomButton title="Đăng Ký" onPress={handleRegister} isLoading={isLoading} />

            <TouchableOpacity style={authStyles.switchLink} onPress={() => navigation.navigate('Login')}>
                <Text style={authStyles.switchText}>
                    Đã có tài khoản? <Text style={authStyles.linkBold}>Đăng nhập ngay</Text>
                </Text>
            </TouchableOpacity>
        </View>
    );
}