import React from 'react';
import { View, TouchableOpacity, Text } from 'react-native';
import { authStyles } from '../authStyles';

export default function RoleSelector({ selectedRole, onSelectRole }) {
    return (
        <View style={authStyles.roleContainer}>
            <TouchableOpacity 
                style={[authStyles.roleBtn, selectedRole === 'customer' && authStyles.roleActive]} 
                onPress={() => onSelectRole('customer')}
            >
                <Text style={[authStyles.roleText, selectedRole === 'customer' && authStyles.roleTextActive]}>
                    Khách hàng
                </Text>
            </TouchableOpacity>
            
            <TouchableOpacity 
                style={[authStyles.roleBtn, selectedRole === 'provider' && authStyles.roleActive]} 
                onPress={() => onSelectRole('provider')}
            >
                <Text style={[authStyles.roleText, selectedRole === 'provider' && authStyles.roleTextActive]}>
                    Thợ / Dịch vụ
                </Text>
            </TouchableOpacity>
        </View>
    );
}