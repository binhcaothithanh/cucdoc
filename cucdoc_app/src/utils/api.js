
import axios from 'axios';
import { getToken } from './asyncStorageHelpers';
import Constants from 'expo-constants';
let store;

const BASE_URL = Constants.expoConfig?.extra?.API_URL || process.env.API_URL;
export const injectStore = (_store) => {
    store = _store;
}

export const instance = axios.create({
    baseURL: BASE_URL,
    timeout: 30000 // 30 seconds
});

export const authInstance = axios.create({
    baseURL: process.env.EXPO_PUBLIC_HOST
});

// Sửa thành async (config) để giải quyết Promise từ AsyncStorage
authInstance.interceptors.request.use(
    async (config) => {
        // 1. Ưu tiên lấy token từ Redux State trước để tối ưu tốc độ
        let token = store?.getState()?.auth?.token;

        // 2. Nếu Redux trống (Ví dụ user tắt app bật lại), lấy từ AsyncStorage ra
        if (!token) {
            token = await getToken();
        }

        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        console.log('Starting Request with Token attached');
        console.log(config);
        return config;
    },
    (error) => Promise.reject(error)
);

// Format dữ liệu đầu ra cho gọn gàng cho cả 2 instance
instance.interceptors.response.use(
    // response => response.data, 
    // error => Promise.reject(error.response?.data || error)
    response => {
        // === LOG DỮ LIỆU KHI API THÀNH CÔNG ===
        console.log('=== API GỌI THÀNH CÔNG ===');
        console.log('Mã trạng thái (Status):', response.status);
        console.log('Dữ liệu (Response Data):', response.data);
        // Bạn có thể dùng JSON.stringify để hiển thị object rõ ràng hơn trong môi trường React Native
        // console.log('Dữ liệu chi tiết:', JSON.stringify(response.data, null, 2));

        return response.data;
    },
    error => {
        console.log('=== CÓ LỖI XẢY RA KHI GỌI API ===');

        // 1. Kiểm tra xem Server có kịp phản hồi về bất kỳ dữ liệu nào không
        if (error.response) {
            // Server có phản hồi về (Ví dụ: mã lỗi 400, 401, 500...)
            console.log('Mã trạng thái HTTP (Status):', error.response.status);
            console.log('Dữ liệu lỗi từ Server trả về:', error.response.data);
            console.log('Headers của phản hồi:', error.response.headers);

            if (error.response.status >= 400) {
                console.log('Xử lý phân quyền hoặc lỗi dữ liệu ở đây...');
            }
        } else if (error.request) {
            // Request đã gửi đi nhưng hoàn toàn KHÔNG nhận được phản hồi nào từ Server
            // Đây chính là nơi đại diện cho lỗi "Network Error" thực sự
            console.log('Request đã phát đi nhưng Server im lặng:', error.request);
        } else {
            // Lỗi xảy ra trong quá trình thiết lập cấu hình request trước khi kịp gửi đi
            console.log('Lỗi cấu hình Axios:', error.message);
        }

        return Promise.reject(error);
    }
);


authInstance.interceptors.response.use(
    response => {
        // === LOG DỮ LIỆU KHI API THÀNH CÔNG ===
        console.log('=== API GỌI THÀNH CÔNG ===');
        console.log('Mã trạng thái (Status):', response.status);
        console.log('Dữ liệu (Response Data):', response.data);
        // Bạn có thể dùng JSON.stringify để hiển thị object rõ ràng hơn trong môi trường React Native
        // console.log('Dữ liệu chi tiết:', JSON.stringify(response.data, null, 2));

        return response.data;
    },
    error => {
        console.log('=== CÓ LỖI XẢY RA KHI GỌI API ===');

        // 1. Kiểm tra xem Server có kịp phản hồi về bất kỳ dữ liệu nào không
        if (error.response) {
            // Server có phản hồi về (Ví dụ: mã lỗi 400, 401, 500...)
            console.log('Mã trạng thái HTTP (Status):', error.response.status);
            console.log('Dữ liệu lỗi từ Server trả về:', error.response.data);
            console.log('Headers của phản hồi:', error.response.headers);

            if (error.response.status >= 400) {
                console.log('Xử lý phân quyền hoặc lỗi dữ liệu ở đây...');
            }
        } else if (error.request) {
            // Request đã gửi đi nhưng hoàn toàn KHÔNG nhận được phản hồi nào từ Server
            // Đây chính là nơi đại diện cho lỗi "Network Error" thực sự
            console.log('Request đã phát đi nhưng Server im lặng:', error.request);
        } else {
            // Lỗi xảy ra trong quá trình thiết lập cấu hình request trước khi kịp gửi đi
            console.log('Lỗi cấu hình Axios:', error.message);
        }

        return Promise.reject(error);
    }
);