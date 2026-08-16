import React, { useState } from 'react';
import { View, Text, StyleSheet, Alert, TouchableOpacity } from 'react-native';
import { useDispatch, useSelector } from 'react-redux';
import { registerUser } from '../../store/slices/authSlice';
import CustomInput from '../../components/common/CustomInput';
import CustomButton from '../../components/common/CustomButton';

export default function RegisterScreen({ navigation }) {
    const dispatch = useDispatch();
    const { isLoading } = useSelector((state) => state.auth);

    const [phone, setPhone] = useState('');
    const [password, setPassword] = useState('');
    const [fullName, setFullName] = useState('');
    const [role, setRole] = useState('customer'); // Mặc định là khách hàng

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
        <View style={styles.container}>
            <Text style={styles.headerTitle}>Đăng Ký Tài Khoản</Text>
            
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

            {/* Chọn role đơn giản */}
            <View style={styles.roleContainer}>
                <TouchableOpacity 
                    style={[styles.roleBtn, role === 'customer' && styles.roleActive]} 
                    onPress={() => setRole('customer')}
                >
                    <Text style={[styles.roleText, role === 'customer' && styles.roleTextActive]}>Khách hàng</Text>
                </TouchableOpacity>
                <TouchableOpacity 
                    style={[styles.roleBtn, role === 'provider' && styles.roleActive]} 
                    onPress={() => setRole('provider')}
                >
                    <Text style={[styles.roleText, role === 'provider' && styles.roleTextActive]}>Thợ / Dịch vụ</Text>
                </TouchableOpacity>
            </View>

            <CustomButton title="Đăng Ký" onPress={handleRegister} isLoading={isLoading} />

            <TouchableOpacity style={styles.switchLink} onPress={() => navigation.navigate('Login')}>
                <Text style={styles.switchText}>Đã có tài khoản? <Text style={styles.linkBold}>Đăng nhập ngay</Text></Text>
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
    roleContainer: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        marginBottom: 20,
    },
    roleBtn: {
        flex: 1,
        padding: 12,
        borderWidth: 1,
        borderColor: '#ddd',
        borderRadius: 8,
        alignItems: 'center',
        marginHorizontal: 5,
        backgroundColor: '#fff',
    },
    roleActive: {
        borderColor: '#007AFF',
        backgroundColor: '#e6f0ff',
    },
    roleText: {
        color: '#666',
        fontWeight: '600',
    },
    roleTextActive: {
        color: '#007AFF',
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