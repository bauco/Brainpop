import { defineStore } from 'pinia'
import axios from 'axios'
import { Exception } from 'sass';

export const useUserStore = defineStore('user', {
    state: () => ({
        loggedIn: false,
        token: null,
    }),
    getters: {
        isLoggedIn: (state) => {
            const token = window.localStorage.getItem('token');
            return token || state.loggedIn;
        }
    },
    actions: {
        async signup(credentials) {
            const apiUrl = import.meta.env.VITE_API_URL;
            axios.defaults.baseURL = apiUrl;
            axios.defaults.withCredentials = true;
            const response = await axios.post('/api/signup', credentials);
            if (!response.data || response.data.message !== "User signup successfully") {
                throw new Exception('Signup failed', response.data);
            } else {
                axios.interceptors.request.use(function (config) {
                    config.headers.Authorization = 'Bearer ' + response.data.access_token;
                    return config;
                });
                this.login(credentials);
            }

        },
        async login(credentials) {
            const apiUrl = import.meta.env.VITE_API_URL;
            axios.defaults.baseURL = apiUrl;
            axios.defaults.withCredentials = true;
            const response = await axios.post('/api/login', credentials)
            if (response.data.access_token && response.data.user) {
                axios.interceptors.request.use(function (config) {
                    config.headers.Authorization = 'Bearer ' + response.data.access_token;
                    return config;
                });
                this.token = response.data.access_token;
                this.loggedIn = true;
                window.localStorage.setItem('loggedIn', 'true');
                window.localStorage.setItem('token', this.token);
            }
        },
        async getQuestions() {
            try {
                return await axios.get('/api/questions?quiz_id=1', { withCredentials: true });
            } catch (error) {
                console.error('Error in start quiz:', error);
            }
        },
        setUser(state, user) {
            state.user = user;
            state.isAuthenticated = !!user;
        },
        logout() {
            this.loggedIn = false;
            this.token = null;
            window.localStorage.removeItem('loggedIn');
            window.localStorage.removeItem('token');
        }
    }
}
);
