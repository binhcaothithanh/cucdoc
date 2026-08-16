import { StyleSheet, Platform } from 'react-native';

export default StyleSheet.create({
  container: { flex: 1, backgroundColor: '#121212' },
  profileHeader: {
    alignItems: 'center',
    paddingVertical: 10,
    backgroundColor: '#1E1E1E',
    borderBottomLeftRadius: 30,
    borderBottomRightRadius: 30,
    borderBottomWidth: 1,
    marginHorizontal: 10,
    borderColor: 'rgba(255, 255, 255, 0.05)',
  },
  avatarCircle: {
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 5,
  },
  profileName: { fontSize: 22, fontWeight: '800', color: '#FFFFFF' },
  profileEmail: { fontSize: 14, color: '#64748B', marginTop: 4 },
  logoutIconBtn: { position: 'absolute', top: 20, right: 20, padding: 10 },
  profileAvatar: { width: 80, height: 80, borderRadius: 40, backgroundColor: '#FFFF', borderWidth: 2, borderColor: '#FF6B00' },
  accountTabBar: {
    flexDirection: 'row',
    marginHorizontal: 10,
    marginTop: 10,
    backgroundColor: '#1E1E1E',
    borderRadius: 15,
    padding: 5,
    borderWidth: 1,
    borderColor: 'rgba(255, 255, 255, 0.05)',
  },
  tabItem: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    paddingVertical: 10,
    borderRadius: 12,
  },
  activeTabItem: {
    backgroundColor: '#FF6B00',
  },
  tabText: { fontSize: 14, fontWeight: '700', color: '#64748B', marginLeft: 6 },
  activeTabText: { color: '#000000', },

  formContainer: {
    // padding: 20,
    paddingHorizontal: 10,
    marginTop: 0,
    marginBottom: 50
  },
  inputLabel: { fontSize: 12, fontWeight: '800', color: '#94A3B8', marginBottom: 8, textTransform: 'uppercase', marginTop: 15, marginLeft: 4 },

  // Khung Input tối cao cấp giống màn Login
  modernInput: {
    backgroundColor: '#1E1E1E',
    borderRadius: 12,
    padding: 14,
    fontSize: 15,
    color: '#FFFFFF',
    marginBottom: 5,
    borderWidth: 1,
    borderColor: 'rgba(255, 255, 255, 0.08)',
  },
  clickableInput: {
    justifyContent: 'center',
  },
  rowInput: { flexDirection: 'row', gap: 10 },

  programsContainer: { padding: 0, marginBottom: 10 },
  sectionHeaderRow: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginBottom: 0 },
  sectionTitleMain: {
    // fontSize: 18, fontWeight: '900', color: '#FFFFFF', textTransform: 'uppercase', letterSpacing: 0.5 

    fontSize: 17,
    fontWeight: '700',
    color: '#FFFFFF',
    letterSpacing: 1,
    // marginTop: -4,
    // marginBottom: 10,
    marginVertical: 20,
    marginLeft: 10,
  },

  programListCard: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#1E1E1E',
    padding: 16,
    borderRadius: 15,
    marginBottom: 10,
    borderWidth: 1,
    borderColor: 'rgba(255, 255, 255, 0.05)',
    marginHorizontal: 10,
  },
  programListTitle: { fontSize: 16, maxWidth: 270, fontWeight: '800', color: '#FFFFFF' },
  programListSub: { fontSize: 11, color: '#FF6B00', fontWeight: '900', marginTop: 2, backgroundColor: 'rgba(255,107,0,0.1)', paddingHorizontal: 6, paddingVertical: 2, borderRadius: 4, alignSelf: 'flex-start' },
  miniBtn: { minHeight: 38, minWidth: 38, paddingHorizontal: 0, paddingVertical: 0, borderRadius: 10 },
  row: { flexDirection: 'row', alignItems: 'center' },
  box: { backgroundColor: '#fff', margin: 20, padding: 20, borderRadius: 10 },
  photoBtn: { alignItems: 'center', marginVertical: 10, padding: 10, borderWidth: 1, borderStyle: 'dashed' },

  // configHeaderRow: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginBottom: 15 },

  darkOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0, 0, 0, 0.7)',
    justifyContent: 'center',
    padding: 20,
  },
  configCardBody: {
    flexDirection: 'column',
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#1E1E1E',
    borderRadius: 20,
    padding: 20,
    overflow: 'hidden',
    width: '100%',
    height: '70%',
  },
  configHeaderRow: {
    flex: 1,
    width: '100%',
    alignItems: 'center',
    // height: 520,
    flexDirection: 'column',
    alignItems: 'center',
    borderWidth: 1,
  },
  cardThumbContainerPicker: {
    flex: 1,
    width: '100%',
    // height: '100%',
    // height: 500,

    justifyContent: 'center',
    borderRadius: 15,
    overflow: 'hidden',
    backgroundColor: '#2D2D2D',
  },
  cardThumbImage: {
    width: '100%',
    height: '100%'
  },
  configTitle: {

    color: '#FFF',
    fontSize: 18,
    fontWeight: 'bold',
  },
  configSubTitle: {
    color: '#64748B',
    fontSize: 12,
    marginTop: 3,
  },
  inputGroupRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 15,
    paddingHorizontal: 20,
    gap: 30,
  },
  inputWrap: {
    flex: 1,
  },
  configLabelText: {
    color: '#94A3B8',
    fontSize: 11,
    fontWeight: '600',
    marginBottom: 8,
    letterSpacing: 0.5,
  },
  configNumericInput: {
    backgroundColor: '#2D2D2D',
    borderRadius: 12,
    color: '#FFF',
    padding: 12,
    fontSize: 16,
    textAlign: 'center',
  },
  statsSummaryCard: {
    backgroundColor: '#1E1E1E',
    padding: 16,
    borderRadius: 16,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginTop: 10,
    // marginHorizontal: 10,
    borderWidth: 1,
    borderColor: '#333'
  },
  statsSummaryTitle: { color: '#FFF', fontSize: 16, fontWeight: 'bold' },
  statsSummarySub: { color: '#64748B', fontSize: 12, marginTop: 4 },
  miniEditBtn: {
    backgroundColor: 'rgba(255, 107, 0, 0.1)',
    padding: 10,
    borderRadius: 12,

  },

  progressTabContainer: {
    flex: 1,
    marginVertical: 10,
    marginHorizontal: 10,

    // padding: 16,
    marginBottom: 100,
  },
  mainImageArea: {
    height: 450,
    width: '100%',
    // borderWidth: 4,
    // borderColor: 'red',
    alignSelf: 'center',
    // justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#1E1E1E',
    borderRadius: 16,
    marginBottom: 20,
    marginTop: 10,
    // marginHorizontal: 10,
    overflow: 'hidden',
    paddingTop: 0,
  },
  mainImage: {
    width: '100%',
    height: '100%',
    maxHeight: 300,

    // height: '70%',
    resizeMode: 'cover',
    // marginTop: 0,
  },
  dateLabel: {
    color: '#FFF',
    fontSize: 16,
    fontWeight: 'bold',
    marginTop: 10,
  },
  rulerContainer: {
    flexDirection: 'row',
    alignItems: 'flex-end',
    // paddingVertical: 10,
    marginVertical: 20,
    borderTopWidth: 2,
    borderTopColor: '#333',
  },
  rulerMarker: {
    alignItems: 'center',
    marginHorizontal: 8,
    width: 40,
  },
  line: {
    width: 2,
    height: 30, // Chiều cao mặc định
    backgroundColor: '#475569',
    borderRadius: 1,
  },
  activeLine: {
    height: 50, // Vạch đang chọn sẽ cao hơn
    backgroundColor: '#FF6B00',
    width: 4,
  },
  textDate: {
    color: '#94A3B8',
    fontSize: 10,
    marginTop: 8,
  },
  metricsContainer: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    // marginBottom: 20,
    backgroundColor: '#1E1E1E',
    padding: 15,
    borderRadius: 12,
    borderColor: 'rgba(255, 255, 255, 0.05)',
    borderWidth: 1,
  },
  metricBox: {

    alignItems: 'center',
  },
  metricLabel: {
    color: '#94A3B8',
    fontSize: 12,
    textTransform: 'uppercase',
  },
  metricValue: {
    color: '#FF6B00',
    fontSize: 20,
    fontWeight: 'bold',
    marginTop: 5,
  },
  cameraOverlay: {
    position: 'absolute',
    bottom: 20,
    right: 20,
    backgroundColor: 'rgba(0,0,0,0.5)',
    padding: 10,
    borderRadius: 20,
  },
  emptyStateContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 20
  },
  // Thêm vào file style.js
  modalContainer: {
    flex: 1,
    backgroundColor: '#0F172A',
    padding: 25,
    justifyContent: 'center',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#FFF',
    marginBottom: 10,
    textAlign: 'center',
  },
  input: {
    flex: 1,
    fontSize: 16,
    color: '#FFFFFF', // Chữ trắng nổi bật trên nền tối
    fontWeight: '500',
  },
  inputIcon: {
    marginRight: 12
  },
  inputWrapper: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '1E1E1E', // Nền input trong suốt mờ ảo trên ảnh nền
    borderWidth: 1,
    borderColor: 'rgba(255, 255, 255, 0.15)',
    borderRadius: 12,
    paddingHorizontal: 16,
    marginBottom: 16,
    height: 58,
  },
});