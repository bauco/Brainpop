<template>
    <main class="login_content">
        <logo />
        <LoginForm @submit="submit($event)"></LoginForm>
        <br />
        <BaseButton @click="signup" type="submit" :theme="'SECONDARY'">Sign Up</BaseButton>
        <!-- Error message -->
        <p v-if="errorMessage" class="error_message">{{ errorMessage }}</p>
    </main>
</template>

<script>
    // COMPONENTS
    import BaseButton from '@/components/base/button/BaseButton.vue'
    import Logo from '@/components/base/logo/Logo.vue'
    import LoginForm from '@/components/compositions/forms/login/LoginForm.vue'
    import axios from 'axios'


    export default {

        name: 'LoginScreen',
        emits: ['submit'],
        components: {
            Logo,
            LoginForm,
            BaseButton
        },
        data() {
            return {
                errorMessage: '', // Error message to display on the screen
            };
        },
        methods: {
            signup() {
                this.$router.push('signup');
            },
            async submit(credentials) {
                const apiUrl = import.meta.env.VITE_API_URL;
                axios.defaults.baseURL = apiUrl;

                console.log('Login:', apiUrl + '/api/login');
                try {
                    const response = await axios.post('/api/login', credentials)
                    if (!response.ok) throw new Error('Login failed');

                    const data = await response.json();
                    console.log('Login successful:', data);
                    const store = useUserStore();
                    store.login(data.token);
                    this.$emit('submit', credentials)
                    this.$router.push('/feature/quiz');

                } catch (error) {
                    if (error.response) {
                        console.error("Error response data:", error.response.data);
                        console.error("Error response status:", error.response.status);
                        this.errorMessage = error.response.data.message || 'An error occurred while logging in.';
                    } else if (error.request) {
                        console.error("No response received:", error.request);
                        this.errorMessage = 'No response from the server. Please try again later.';
                    } else {
                        console.error("Error setting up request:", error.message);
                        this.errorMessage = error.message;
                    }
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .login_content {
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

