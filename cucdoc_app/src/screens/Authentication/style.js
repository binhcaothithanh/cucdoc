
import { StyleSheet, Dimensions } from 'react-native';

const { width, height } = Dimensions.get('window');

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  // backgroundImage: {
  //   position: 'absolute',
  //   width: width,
  //   height: height,
  //   top: 0,
  //   left: 0,
  // },
  darkOverlay: {
    position: 'absolute',
    width: width,
    height: height,
    top: 0,
    left: 0,
    backgroundColor: 'rgba(0, 0, 0, 0.65)', // Tạo lớp mờ phủ lên ảnh gốc giúp chữ sắc nét hơn
  },
  scrollContent: {
    flexGrow: 1,
    justifyContent: 'flex-end', // Đẩy form xuống dưới một chút nhìn nghệ thuật hơn
    paddingHorizontal: 28,
    paddingBottom: 50,
    // marginBottom: 200,
    // paddingTop: 40,
  },
  headerArea: {
    // marginBottom: 40,
    alignItems: 'flex-start', // Đổi sang căn trái nhìn gai góc hơn căn giữa
  },
  brandTitle: {
    fontSize: 42,
    fontWeight: '900',
    color: '#FF6B00', // Màu Cam Neon đậm chất Sport mạnh mẽ
    letterSpacing: -1.5,
    fontStyle: 'italic', // Nghiêng nhẹ tạo cảm giác chuyển động, tốc độ
  },
  brandTagline: {
    fontSize: 14,
    fontWeight: '700',
    color: '#FFFFFF',
    letterSpacing: 3,
    marginTop: -4,
    // marginBottom: 10,
    marginVertical: 20,
    marginLeft: 50,
  },
  subTitle: {
    fontSize: 14,
    color: '#e2e8f08d',
    textAlign: 'left',
    lineHeight: 22,
  },
  formContainer: {
    width: '100%',
    // marginBottom: 200,
    // flex: 1,
  },
  inputWrapper: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: 'rgba(255, 255, 255, 0.12)', // Nền input trong suốt mờ ảo trên ảnh nền
    borderWidth: 1,
    borderColor: 'rgba(255, 255, 255, 0.15)',
    borderRadius: 12,
    paddingHorizontal: 16,
    marginBottom: 16,
    height: 58,
  },
  inputIcon: {
    marginRight: 12
  },
  input: {
    flex: 1,
    fontSize: 16,
    color: '#FFFFFF', // Chữ trắng nổi bật trên nền tối
    fontWeight: '500',
  },
  forgotPass: {
    alignSelf: 'flex-end',
    marginBottom: 12,
  },
  forgotText: {
    color: '#94A3B8',
    fontSize: 14,
    fontWeight: '600',
  },
  mainButton: {
    backgroundColor: '#FF6B00', // Đổi nút bấm sang màu cam kích thích thị giác
    height: 58,
    borderRadius: 12,
    justifyContent: 'center',
    alignItems: 'center',
    // Hiệu ứng đổ bóng phát sáng màu cam cho nút
    shadowColor: '#FF6B00',
    shadowOffset: { width: 0, height: 6 },
    shadowOpacity: 0.4,
    shadowRadius: 10,
    elevation: 6,
  },
  buttonInner: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
  },
  buttonText: {
    color: '#000000', // Chữ đen tương phản sắc nét trên nền nút cam
    fontSize: 16,
    fontWeight: '800',
    letterSpacing: 0.5,
  },
  footer: {
    flexDirection: 'row',
    justifyContent: 'center',
    marginTop: 35,
  },
  footerText: {
    color: '#94A3B8',
    fontSize: 14,
  },
  footerLink: {
    color: '#FF6B00',
    fontSize: 14,
    fontWeight: '700',
  },

  modalContainer: { flex: 1, backgroundColor: '#000', padding: 20, justifyContent: 'center' },
  // Thêm/Kiểm tra trong style.js
  backgroundImage: {
    flex: 1,
    width: '100%',
    height: '100%',
    justifyContent: 'center',
  },
  darkOverlay: {
    ...StyleSheet.absoluteFillObject,
    backgroundColor: 'rgba(0,0,0,0.85)', // Độ tối của lớp phủ
  },
  // modalContainer: {
  //   flex: 1,
  //   justifyContent: 'center',
  //   padding: 20,
  // },
});

export default styles;