import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
import { instance } from '../../utils/api';
import { saveToken, removeToken } from '../../utils/asyncStorageHelpers';

// Thunk Đăng ký (Dùng instance từ api.js, vì interceptors đã tự động trả về response.data)
export const registerUser = createAsyncThunk(
    'auth/registerUser',
    async (userData, { rejectWithValue }) => {
        try {
            const response = await instance.post('/api/auth/register', userData);
            if (response.status) {
                return response;
            } else {
                return rejectWithValue(response.message);
            }
        } catch (error) {
            return rejectWithValue(error.response?.data?.message || error.message || 'Lỗi kết nối server');
        }
    }
);

// Thunk Đăng nhập
export const loginUser = createAsyncThunk(
    'auth/loginUser',
    async (credentials, { rejectWithValue }) => {
        try {
            const response = await instance.post('/api/auth/login', credentials);
            if (response.status) {
                const { access_token } = response.data;
                // Lưu token vào AsyncStorage
                await saveToken(access_token);
                return response.data; // Trả về thông tin user & token
            } else {
                return rejectWithValue(response.message);
            }
        } catch (error) {
            return rejectWithValue(error.response?.data?.message || error.message || 'Lỗi kết nối server');
        }
    }
);

// Thunk Đăng xuất
export const logoutUser = createAsyncThunk(
    'auth/logoutUser',
    async () => {
        await removeToken();
        return null;
    }
);

const initialState = {
    token: null,
    userInfo: null,
    isLoading: false,
    error: null,
};

const authSlice = createSlice({
    name: 'auth',
    initialState,
    reducers: {
        setTokenFromStorage: (state, action) => {
            state.token = action.payload;
        },
        clearError: (state) => {
            state.error = null;
        }
    },
    extraReducers: (builder) => {
        builder
            // Login
            .addCase(loginUser.pending, (state) => {
                state.isLoading = true;
                state.error = null;
            })
            .addCase(loginUser.fulfilled, (state, action) => {
                state.isLoading = false;
                state.token = action.payload.access_token;
                state.userInfo = action.payload;
            })
            .addCase(loginUser.rejected, (state, action) => {
                state.isLoading = false;
                state.error = action.payload;
            })
            // Register
            .addCase(registerUser.pending, (state) => {
                state.isLoading = true;
                state.error = null;
            })
            .addCase(registerUser.fulfilled, (state) => {
                state.isLoading = false;
            })
            .addCase(registerUser.rejected, (state, action) => {
                state.isLoading = false;
                state.error = action.payload;
            })
            // Logout
            .addCase(logoutUser.fulfilled, (state) => {
                state.token = null;
                state.userInfo = null;
            });
    },
});

export const { setTokenFromStorage, clearError } = authSlice.actions;
export default authSlice.reducer;