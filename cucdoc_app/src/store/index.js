import { configureStore } from '@reduxjs/toolkit';
import authReducer from './slices/authSlice';
import { injectStore } from '../utils/api';

export const store = configureStore({
    reducer: {
        auth: authReducer,
        // Các slice khác sẽ thêm ở các step sau...
    },
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware({
            serializableCheck: false,
        }),
});

// Inject store vào file api.js để interceptor đọc được state
injectStore(store);

export default store;