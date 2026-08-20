import { StyleSheet } from 'react-native';

export const authStyles = StyleSheet.create({
    container: {
        flex: 1,
        padding: 24,
        justifyContent: 'center',
        backgroundColor: '#f9f9f9',
    },
    headerTitle: {
        fontSize: 26,
        fontWeight: 'bold',
        marginBottom: 8,
        textAlign: 'center',
        color: '#1a1a1a',
    },
    subtitle: {
        fontSize: 14,
        color: '#666',
        textAlign: 'center',
        marginBottom: 24,
    },
    switchLink: {
        marginTop: 20,
        alignItems: 'center',
    },
    switchText: {
        color: '#666',
        fontSize: 14,
    },
    linkBold: {
        color: '#007AFF',
        fontWeight: 'bold',
    },
    // Style dành riêng cho component nhỏ bên trong nhóm Auth (ví dụ: bộ chọn Role)
    roleContainer: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        marginBottom: 15,
    },
    roleBtn: {
        flex: 1,
        padding: 12,
        borderWidth: 1,
        borderColor: '#ddd',
        borderRadius: 8,
        alignItems: 'center',
        marginHorizontal: 4,
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
});