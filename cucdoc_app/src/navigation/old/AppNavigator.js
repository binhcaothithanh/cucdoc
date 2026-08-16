
// import { useSelector } from 'react-redux';
// import { NavigationContainer } from '@react-navigation/native';
// import { createStackNavigator } from '@react-navigation/stack';
// import { SafeAreaView } from 'react-native-safe-area-context';

// import AuthNavigator from './AuthNavigator';
// import MainNavigator from './MainNavigator';
// import ProgramDetailScreen from '../screens/programDetailScreen/ProgramDetailScreen';
// import ProgramDayDetailScreen from '../screens/programDayDetailScreen/ProgramDayDetailScreen';
// import CreateProgramScreen from '../screens/CreateProgram/CreateProgramScreen';
// import EditProgramScreen from '../screens/editProgram/EditProgramScreen';
// import ExerciseDetailScreen from '../screens/Exercises/ExerciseDetailScreen';
// import ChangePasswordTempScreen from '../screens/Authentication/ChangePasswordTempScreen';

// export default function AppNavigator() {
//   const { user, loading } = useSelector(state => state.auth);
//   const RootStack = createStackNavigator();

//   if (loading) {
//     return null; // hoặc SplashScreen
//   }

//   return (
//     // <SafeAreaView style={{ flex: 1 }} edges={['left', 'right', 'bottom']}>
//     <NavigationContainer>
//       {user ? (
//         <RootStack.Navigator screenOptions={{ headerShown: false }}>
//           <RootStack.Screen name="MainTabs" component={MainNavigator} />
//           <RootStack.Screen
//             name="ProgramDetail"
//             component={ProgramDetailScreen}
//             options={{ headerShown: false, title: 'Program Detail' }}
//           />
//           <RootStack.Screen name="ProgramDayDetail" component={ProgramDayDetailScreen} />
//           <RootStack.Screen name="CreateProgramScreen" component={CreateProgramScreen} />
//           <RootStack.Screen name="EditProgram" component={EditProgramScreen} />
//           <RootStack.Screen name="ExerciseDetail" component={ExerciseDetailScreen} />
//           <RootStack.Screen name="ChangePasswordTemp" component={ChangePasswordTempScreen} />

//         </RootStack.Navigator>
//       ) : (
//         <AuthNavigator />
//       )}
//     </NavigationContainer>
//     // </SafeAreaView>
//   );
// }


import React from 'react';
import { useSelector } from 'react-redux';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';

import AuthNavigator from './AuthNavigator';
import MainNavigator from './MainNavigator';
import ProgramDetailScreen from '../screens/programDetailScreen/ProgramDetailScreen';
import ProgramDayDetailScreen from '../screens/programDayDetailScreen/ProgramDayDetailScreen';
import CreateProgramScreen from '../screens/CreateProgram/CreateProgramScreen';
import EditProgramScreen from '../screens/editProgram/EditProgramScreen';
import ExerciseDetailScreen from '../screens/Exercises/ExerciseDetailScreen';

// 1. IMPORT MÀN HÌNH ĐỔI MẬT KHẨU TẠM VÀO ĐÂY
import ChangePasswordTempScreen from '../screens/Authentication/ChangePasswordTempScreen';

export default function AppNavigator() {
  const { user, loading } = useSelector(state => state.auth);
  console.log("APP NAV USER:", user);

  const RootStack = createStackNavigator();

  // if (loading) {
  //    return null;  // this code cause a problem Register fail => back to Login
  // }

  return (
  <NavigationContainer>
    {user ? (
      <RootStack.Navigator screenOptions={{ headerShown: false }}>
        {user.is_temp_password == 1 ? (
          <RootStack.Screen
            name="ChangePasswordTemp"
            component={ChangePasswordTempScreen}
          />
        ) : (
          <>
            <RootStack.Screen name="MainTabs" component={MainNavigator} />
            <RootStack.Screen name="ProgramDetail" component={ProgramDetailScreen} />
            <RootStack.Screen name="ProgramDayDetail" component={ProgramDayDetailScreen} />
            <RootStack.Screen name="CreateProgramScreen" component={CreateProgramScreen} />
            <RootStack.Screen name="EditProgram" component={EditProgramScreen} />
            <RootStack.Screen name="ExerciseDetail" component={ExerciseDetailScreen} />
          </>
        )}
      </RootStack.Navigator>
    ) : (
      <AuthNavigator />
    )}
  </NavigationContainer>
)
}
