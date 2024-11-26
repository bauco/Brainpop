<template>
  <div class="signup_container">
    <SignupScreen @submit="submit($event)"></SignupScreen>
  </div>
</template>

<script>
// SCREEN
    import SignupScreen from '@/components/screens/signup/SignupScreen.vue'
//STORE
import { useUserStore } from '@/stores/user'
export default {
        name: 'Signup',
  components: {
      SignupScreen
  },
  methods: {
    submit(credentials) {
      console.log('credentials', credentials)
    }
  }
}
</script>

<style lang="scss" scoped>
    .signup_container {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f5f5f5;
        height: 100vh;
    }
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
</style>
