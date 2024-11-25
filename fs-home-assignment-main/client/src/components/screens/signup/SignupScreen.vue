<template>
    <main class="signup_content">
        <logo />
        <SignupForm @submit="submit($event)"></SignupForm>
        <br />
        <BaseButton @click="login" type="submit" :theme="'SECONDARY'">Login</BaseButton>
        <p v-if="errorMessage" class="error_message">{{ errorMessage }}</p>

    </main>
</template>

<script>
// COMPONENTS

import BaseButton from '@/components/base/button/BaseButton.vue'
import { useUserStore } from '@/stores/user'

import Logo from '@/components/base/logo/Logo.vue'
import SignupForm from '@/components/compositions/forms/signup/SignupForm.vue'
import axios from 'axios'


export default {

  name: 'SignupScreen',
  emits: ['submit'],
  components: {
    Logo,
    SignupForm,
    BaseButton
  },
  data() {
    return {
        errorMessage: '', // Error message to display on the screen
    };
    
},
    methods: {
        login() {
        this.$router.push('login');
    },
    async submit(credentials) {
        const apiUrl = import.meta.env.VITE_API_URL;
        axios.defaults.baseURL = apiUrl;
        console.log('Signup:', apiUrl + '/api/signup');
        try {
            const response = await axios.post('/api/signup', credentials);
            if (response.data.message !== "User signup successfully") throw new Error('Signup failed');
            this.$emit('submit', credentials)
        } catch (error) {
         if (error.response) {
             this.errorMessage = error.response.data.message || 'An error occurred while logging in.';
         } else if (error.request) {
             this.errorMessage = 'No response from the server. Please try again later.';
         } else {
             this.errorMessage = error.message;
         }
     }
    }
}
}
</script>

<style lang="scss" scoped>
    .signup_content {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        max-width: 782px;
        background: #fff;
        box-shadow: 0px 4px 4px 3px rgba(185, 185, 185, 0.2509803922);
        flex-direction: column;
        padding: 35px 0;
        height: -webkit-fill-available;
    }
    .error_message {
        color: red;
        margin-top: 15px;
        font-weight: bold;
    }
</style>
