// import { instance, authInstance } from '../utils/api'; // Thay bằng đường dẫn chính xác tới file chứa axios instance của bạn


// export const UserApi = {
//   getUser: (userId) => authInstance.get(`user/profile?id=${userId}`),
//   updateUser: (payload) => authInstance.post('user/update', payload),
// };


import { instance, authInstance } from '../utils/api';

export const UserApi = {
  // Lấy thông tin user theo ID
  getUser: (userId) => authInstance.get(`user/profile?id=${userId}`),
getStatsHistory: () => authInstance.get(`user/stats-history`), // Lấy lịch sử StatsHistory
  // Cập nhật thông tin user (Đã sửa từ 'api' thành 'authInstance' để đính kèm Token)
  updateUser: (payload) => authInstance.post('user/update', payload),
  updateBodyStats: (formData) => authInstance.post('/user/update-stats', formData, {
    headers: { 'Content-Type': 'multipart/form-data' }
  }),
};