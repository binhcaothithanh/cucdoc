
import LoginScreen from '../screens/Authentication/LoginScreen';
import RegisterScreen from '../screens/Authentication/RegisterScreen';
import ForgotPasswordScreen from '../screens/Authentication/ForgotPasswordScreen';
import ChangePasswordTempScreen from '../screens/Authentication/ChangePasswordTempScreen';
import { createStackNavigator } from '@react-navigation/stack';


const Stack = createStackNavigator();
const RootStack = createStackNavigator();

export default function AuthNavigator() {

  return (
    <Stack.Navigator
      // initialRouteName="Login"
      screenOptions={{ headerShown: false }}>
      <Stack.Screen name="Login" component={LoginScreen} />
      <Stack.Screen name="ForgotPassword" component={ForgotPasswordScreen} />
      <Stack.Screen name="Register" component={RegisterScreen} />
      <Stack.Screen name="ChangePasswordTemp" component={ChangePasswordTempScreen} />

    </Stack.Navigator>
  );
}
