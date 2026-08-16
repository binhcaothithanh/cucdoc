import { StyleSheet, Platform } from 'react-native';

const styles = StyleSheet.create({
  // Lớp phủ nền kính mờ Glassmorphism
  blurViewOverlay: {
    ...StyleSheet.absoluteFill,
    backgroundColor: 'rgba(20, 20, 20, 0.65)', // Màu nền tối trong suốt đồng bộ với Login
    // borderWidth: 1,
    // borderColor: 'rgba(255, 255, 255, 0.08)', // Viền mỏng tinh tế tạo hiệu ứng nổi khối
    borderColor: 'rgba(20, 20, 20, 0.65)', // Tạm thời ẩn viền để tránh xung đột với viền Tab Bar
    
    // borderRadius: 50,
    // borderWidth: 10,
  },
  // Cấu hình thanh Tab Bar dạng nổi (Floating)
  tabBar: {
    position: 'absolute',
    bottom: Platform.OS === 'ios' ? 24 : 20, // Khoảng cách nổi so với đáy màn hình
    left: 24,
    right: 24,
    height: 65, // Tăng nhẹ chiều cao để bấm dễ hơn và cân đối hơn với icon cỡ lớn
    paddingBottom: 12,
    paddingTop: 12,
    borderRadius: 50,
    // borderColor: 'red',
    // borderWidth: 1,
    // backgroundColor: 'transparent', // Bắt buộc để lộ lớp BlurView phía sau
    borderTopWidth: 0,
    elevation: 0, // Xóa vệt đen trên Android
    // Đổ bóng phát quang nhẹ đặc trưng của Sport UI
    shadowColor: '#000000',
    shadowOffset: { width: 0, height: 8 },
    shadowOpacity: 0.4,
    shadowRadius: 12,
    // marginHorizontal: 30,
  },
  // Container bọc icon giúp căn giữa tuyệt đối
  iconWrapper: {
    alignItems: 'center',
    justifyContent: 'center',
    width: 44,
    height: 44,
    borderRadius: 22,
  },
  // Hiệu ứng highlight nhẹ dưới icon khi tab đó đang active (Tùy chọn)
  iconActiveBg: {
    // backgroundColor: 'rgba(255, 107, 0, 0.1)', // Đổ một lớp cam cực nhẹ quanh icon đang chọn
  }
});

export default styles;