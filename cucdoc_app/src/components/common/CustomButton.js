import React from 'react';
import { TouchableOpacity, Text, StyleSheet, ActivityIndicator } from 'react-native';

export default function CustomButton({ title, onPress, isLoading, type = 'primary' }) {
    return (
        <TouchableOpacity 
            style={[styles.button, type === 'secondary' ? styles.secondaryBtn : styles.primaryBtn]} 
            onPress={onPress}
            disabled={isLoading}
        >
            {isLoading ? (
                <ActivityIndicator color="#fff" />
            ) : (
                <Text style={[styles.text, type === 'secondary' ? styles.secondaryText : styles.primaryText]}>
                    {title}
                </Text>
            )}
        </TouchableOpacity>
    );
}

const styles = StyleSheet.create({
    button: {
        height: 48,
        borderRadius: 8,
        justifyContent: 'center',
        alignItems: 'center',
        width: '100%',
        marginVertical: 8,
    },
    primaryBtn: {
        backgroundColor: '#007AFF',
    },
    secondaryBtn: {
        backgroundColor: 'transparent',
        borderWidth: 1,
        borderColor: '#007AFF',
    },
    primaryText: {
        color: '#fff',
        fontSize: 16,
        fontWeight: 'bold',
    },
    secondaryText: {
        color: '#007AFF',
        fontSize: 16,
        fontWeight: 'bold',
    },
});