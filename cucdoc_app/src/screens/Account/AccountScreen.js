import React, { useEffect, useState, useCallback } from 'react';
import { TouchableWithoutFeedback, View, Text, TouchableOpacity, ScrollView, Alert, Platform, StatusBar } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useDispatch, useSelector } from 'react-redux';
import { useFocusEffect } from '@react-navigation/native';
import { Pencil, Trash2, User, BookOpen, LogOut, Activity, ChevronRight, PlusCircle, Camera, X } from 'lucide-react-native';
import { Image } from 'expo-image';
// import * as ImagePicker from 'expo-image-picker';
import { IMAGE_MUSCLE_URL } from '@env';

// import { KeyboardAvoidingView, Keyboard } from 'react-native';
// import { ACTIVITY_LEVELS } from '../../constants/constants';
// import MyButton from '../../components/common/MyButton';
import { fetchUserProfile, fetchStatsHistory, clearUser, updateUserProfile } from '../../store/slices/userSlice';
import { logout } from '../../store/slices/authSlice';
import styles from './style';
import { DetailsTab, ProgramsTab, ProgressTab } from './components/AccountTabs';
import ProfileSetupModal from './components/ProfileSetupModal';
import { useLanguage } from '../../i18n/LanguageContext';

// const TABS = { DETAILS: 'details', PROGRAMS: 'programs' };
const TABS = { DETAILS: 'details', PROGRAMS: 'programs', PROGRESS: 'progress' };
const AccountScreen = ({ navigation }) => {
  const { language, selectLanguage, t } = useLanguage();
  const dispatch = useDispatch();
  const { profile, loading: userLoading } = useSelector((state) => state.user);
  const [activeTab, setActiveTab] = useState(TABS.DETAILS);
  const [isModalVisible, setModalVisible] = useState(false);
  useEffect(() => {
    if (profile) {
      const isMissingInfo =
        !profile.height ||
        !profile.birth_year ||
        !profile.activity_level;

      if (isMissingInfo) {
        setModalVisible(true);
      } else {
        setModalVisible(false);
      }
    }
  }, [profile]);

  useFocusEffect(
    useCallback(() => {
      dispatch(fetchUserProfile()).unwrap();
      dispatch(fetchStatsHistory());
    }, [dispatch])
  );






  // KHÔI PHỤC POPUP CHỌN GENDER




  const handleLogout = () => {
    Alert.alert("Đăng xuất", "Bạn có chắc chắn muốn thoát?", [
      { text: "Hủy", style: "cancel" },
      { text: "Thoát", onPress: () => { dispatch(logout()); dispatch(clearUser()); } }
    ]);
  };

  const handleLanguageChange = () => {
    Alert.alert(t('language.changeTitle'), '', [
      { text: t('language.english'), onPress: () => selectLanguage('en') },
      { text: t('language.vietnamese'), onPress: () => selectLanguage('vi') },
      { text: t('language.cancel'), style: 'cancel' },
    ]);
  };



  return (
    <SafeAreaView style={styles.container} edges={['top']}>
      <StatusBar barStyle="light-content" />
      <ScrollView showsVerticalScrollIndicator={false}>
        <View style={styles.profileHeader}>
          <View style={styles.avatarCircle}>

            {/* <Image source={{ uri: `https://api.dicebear.com/7.x/bottts/svg?seed=${form.email}` }} style={{ width: 80, height: 80, borderRadius: 40 }} /> */}
            <Image
              source={{
                uri: (profile?.gender) === 'male'
                  ? `${IMAGE_MUSCLE_URL}male.png`
                  : `${IMAGE_MUSCLE_URL}female.png`
              }}
              style={styles.profileAvatar}
              contentFit="contain"
            />
          </View>
          <Text style={styles.profileName}>{profile?.user_name || 'Vận động viên'}</Text>
          <Text style={styles.profileEmail}>{profile?.email}</Text>
          <TouchableOpacity onPress={handleLanguageChange} style={{ marginTop: 8 }}>
            <Text style={{ color: '#FF6B00', fontWeight: '700', fontSize: 13 }}>
              {t('language.change')} · {language === 'vi' ? t('language.vietnamese') : t('language.english')}
            </Text>
          </TouchableOpacity>
          <TouchableOpacity style={styles.logoutIconBtn} onPress={handleLogout}>
            <LogOut size={22} color="#EF4444" />
          </TouchableOpacity>
        </View>

        <ProfileSetupModal
          visible={isModalVisible}
          onSave={async (data) => {
            // Cập nhật lên server/redux
            await dispatch(updateUserProfile(data)).unwrap();
            // Sau khi lưu xong, modal sẽ tự đóng vì useEffect sẽ chạy lại 
            // và thấy profile đã có đủ thông tin 
            setModalVisible(false);
            Alert.alert("Thành công", "Đã cập nhật hồ sơ!");
          }}
        /> 
        {/* TABS CONTROLLER */}
        <View style={styles.accountTabBar}>
          <TouchableOpacity style={[styles.tabItem, activeTab === TABS.DETAILS && styles.activeTabItem]} onPress={() => setActiveTab(TABS.DETAILS)}>
            <User size={16} color={activeTab === TABS.DETAILS ? '#000' : '#EF4444'} />
            <Text style={[styles.tabText, activeTab === TABS.DETAILS && styles.activeTabText]}>{t('account.profileDetails')}</Text>
          </TouchableOpacity>
          <TouchableOpacity style={[styles.tabItem, activeTab === TABS.PROGRESS && styles.activeTabItem]} onPress={() => setActiveTab(TABS.PROGRESS)}>
            <Activity size={16} color={activeTab === TABS.PROGRESS ? '#000' : '#EF4444'} />
            <Text style={[styles.tabText, activeTab === TABS.PROGRESS && styles.activeTabText]}>{t('account.bodyProgress')}</Text>
          </TouchableOpacity>
          <TouchableOpacity style={[styles.tabItem, activeTab === TABS.PROGRAMS && styles.activeTabItem]} onPress={() => setActiveTab(TABS.PROGRAMS)}>
            <BookOpen size={16} color={activeTab === TABS.PROGRAMS ? '#000' : '#EF4444'} />
            <Text style={[styles.tabText, activeTab === TABS.PROGRAMS && styles.activeTabText]}>{t('account.myPrograms')} ({profile?.created_programs?.length || 0})</Text>
          </TouchableOpacity>
        </View>

        {activeTab === TABS.DETAILS ? (
          <DetailsTab />
        ) : activeTab === TABS.PROGRAMS ? (
          <ProgramsTab />
        ) : (
          <ProgressTab />
        )}
      </ScrollView>
    </SafeAreaView>
  );
};

export default AccountScreen;
