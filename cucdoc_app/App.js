import { useEffect } from 'react';
import { Provider, useDispatch } from 'react-redux';
import store from './src/store';
import { setTokenFromStorage } from './src/store/slices/authSlice';
import { getToken } from './src/utils/asyncStorageHelpers';
// Import navigation của bạn ở đây...
import AppNavigation from './src/navigation/AppNavigation';
function MainApp() {
  const dispatch = useDispatch();

  useEffect(() => {
    const bootstrapAsync = async () => {
      try {
        const token = await getToken();
        if (token) {
          dispatch(setTokenFromStorage(token));
        }
      } catch (e) {
        console.error('Failed to load token from storage', e);
      }
    };

    bootstrapAsync();
  }, [dispatch]);

  return (
    // Đặt Navigation container của bạn ở đây
    <AppNavigation />
  );
}

export default function App() {
  return (
    <Provider store={store}>
      <MainApp />
    </Provider>
  );
}