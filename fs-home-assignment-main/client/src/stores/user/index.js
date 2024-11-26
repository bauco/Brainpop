import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
    state: () => ({
        loggedIn: false,
        token: null, // Add token to store
    }),
    getters: {
        isLoggedIn: (state) => {
            const token = window.localStorage.getItem('token');
            return token || state.loggedIn;
        }
    },
    actions: {
        login(token) {
            window.localStorage.setItem('loggedIn', 'true');
            window.localStorage.setItem('token', token);
            this.token = token;
            this.loggedIn = true;
        },
        logout() {
            this.loggedIn = false;
            this.token = null;
            window.localStorage.removeItem('loggedIn');
            window.localStorage.removeItem('token');
        }
    }
});
