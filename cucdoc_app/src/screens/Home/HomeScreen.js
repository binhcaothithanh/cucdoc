import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { useDispatch, useSelector } from 'react-redux';
import { logoutUser } from '../../store/slices/authSlice';
import CustomButton from '../../components/common/CustomButton';

export default function HomeScreen() {
    const dispatch = useDispatch();
    const userInfo = useSelector((state) => state.auth.userInfo);

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Trang Chủ (Home Screen)</Text>
            <Text style={styles.welcome}>Xin chào, SĐT: {userInfo?.phone || 'User'}</Text>
            <Text style={styles.role}>Vai trò: {userInfo?.role === 'provider' ? 'Thợ / Dịch vụ' : 'Khách hàng'}</Text>
            <Text style={styles.debt}>Số tiền nợ phí: {userInfo?.debt_balance || 0} VNĐ</Text>

            <View style={styles.btnWrapper}>
                <CustomButton title="Đăng Xuất" type="secondary" onPress={() => dispatch(logoutUser())} />
            </View>
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        padding: 20,
        backgroundColor: '#fff',
    },
    title: {
        fontSize: 22,
        fontWeight: 'bold',
        marginBottom: 10,
    },
    welcome: {
        fontSize: 16,
        color: '#333',
        marginBottom: 5,
    },
    role: {
        fontSize: 16,
        color: '#007AFF',
        marginBottom: 5,
    },
    debt: {
        fontSize: 16,
        color: '#ff4d4f',
        marginBottom: 20,
    },
    btnWrapper: {
        width: '60%',
    }
});