import React, { useState } from 'react';
import { View, Text, StyleSheet, Alert, TouchableOpacity } from 'react-native';
import { useDispatch, useSelector } from 'react-redux';
import { loginUser } from '../../store/slices/authSlice';
import CustomInput from '../../components/common/CustomInput';
import CustomButton from '../../components/common/CustomButton';

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
        // console.log('Login resultAction:', resultAction); // Debugging line 
        if (loginUser.fulfilled.match(resultAction)) {
            // Đăng nhập thành công, Redux state 'token' có giá trị, 
            // Navigation container sẽ tự động chuyển sang luồng Home Screen.
        } else {
            Alert.alert('Đăng nhập thất bại', resultAction.payload || 'Sai thông tin đăng nhập.');
        }
    };

    return (
        <View style={styles.container}>
            <Text style={styles.headerTitle}>Đăng Nhập Hệ Thống</Text>

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

            <TouchableOpacity style={styles.switchLink} onPress={() => navigation.navigate('Register')}>
                <Text style={styles.switchText}>Chưa có tài khoản? <Text style={styles.linkBold}>Đăng ký ngay</Text></Text>
            </TouchableOpacity>
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        padding: 20,
        justifyContent: 'center',
        backgroundColor: '#f9f9f9',
    },
    headerTitle: {
        fontSize: 24,
        fontWeight: 'bold',
        marginBottom: 24,
        textAlign: 'center',
        color: '#222',
    },
    switchLink: {
        marginTop: 15,
        alignItems: 'center',
    },
    switchText: {
        color: '#666',
    },
    linkBold: {
        color: '#007AFF',
        fontWeight: 'bold',
    }
});