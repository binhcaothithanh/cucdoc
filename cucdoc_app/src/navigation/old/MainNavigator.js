

import React from 'react';
import { View } from 'react-native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { createStackNavigator } from '@react-navigation/stack';
import { BlurView } from 'expo-blur';
import Ionicons from '@expo/vector-icons/Ionicons';

// Import màn hình
import HomeScreen from '../screens/Home/HomeScreen';
import ExercisesScreen from '../screens/Exercises/ExercisesScreen';
import AccountScreen from '../screens/Account/AccountScreen';
import ProgramListScreen from '../screens/Home/components/ProgramListScreen';
import ToolScreen from '../screens/Tools/ToolScreen';
// Import file style đồng bộ cấu trúc mới
import styles from './style';

const Tab = createBottomTabNavigator();
const Stack = createStackNavigator();

function HomeStack() {
  return (
    <Stack.Navigator screenOptions={{ headerShown: false }}>
      <Stack.Screen name="HomeMain" component={HomeScreen} />
      <Stack.Screen name="ProgramList" component={ProgramListScreen} />
    </Stack.Navigator>
  );
}

export default function MainNavigator() {
  return (
    <Tab.Navigator 
      screenOptions={({ route }) => ({
        headerShown: false,
        tabBarShowLabel: false,
        
        // Đồng bộ màu sắc cốt lõi từ màn hình Login
        tabBarActiveTintColor: '#FF6B00',   // Cam Neon mạnh mẽ khi kích hoạt
        tabBarInactiveTintColor: '#94A3B8', // Xám Slate thanh lịch khi ở trạng thái chờ
        
        // 1. TẦNG NỀN KÍNH MỜ (DARK GLASSMORPHISM)
        tabBarBackground: () => (
          <BlurView 
            tint="dark"            // Chuyển sang tối để đồng bộ với theme chìm của App
            intensity={35}         // Tăng cường độ làm mờ một chút để đọc nội dung phía dưới tốt hơn
            style={styles.blurViewOverlay} 
          />
        ),

        // 2. GÁN STYLE TỪ FILE RIÊNG CHO TAB BAR
        tabBarStyle: styles.tabBar,

        // 3. XỬ LÝ ICON HIỂN THỊ
        tabBarIcon: ({ color, focused }) => {
          let iconName;
          if (route.name === 'Home') iconName = focused ? 'home' : 'home-outline';
          else if (route.name === 'Exercises') iconName = focused ? 'barbell' : 'barbell-outline';
          else if (route.name === 'Account') iconName = focused ? 'person' : 'person-outline';
          else if (route.name === 'Tool') iconName = focused ? 'construct' : 'construct-outline';
          return (
            <View style={[
              styles.iconWrapper, 
              focused && styles.iconActiveBg
            ]}>
              <Ionicons 
                name={iconName} 
                size={focused ? 26 : 22} 
                color={color} // Sử dụng trực tiếp mảng màu Active/Inactive cấu hình ở trên
              />
            </View>
          );
        },
      })}
    >
      <Tab.Screen name="Home" component={HomeStack} />
      <Tab.Screen name="Exercises" component={ExercisesScreen} />
      <Tab.Screen name="Tool" component={ToolScreen} />
      <Tab.Screen name="Account" component={AccountScreen} />    
    </Tab.Navigator>
  );
}