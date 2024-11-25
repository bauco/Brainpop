<template>
  <form class="signup_form" @submit.prevent="submit">
    <BaseInput v-model="name" label="Name" />
    <BaseInput v-model="email" label="Email" />
    <BaseInput v-model="password" label="Password" type="password" />
    <BaseInput v-model="password_confirmation"  type="password" label="Password Confirmation" />
    <BaseButton type="submit" fullWidth>Sign Up</BaseButton>
  </form>
</template>

<script>
// COMPONENTS
import BaseInput from '@/components/base/input/BaseInput.vue'
import BaseButton from '@/components/base/button/BaseButton.vue'

export default {
  name: 'SignupForm',
  emits: ['submit'],
  components: {
    BaseInput,
    BaseButton
  },
  data() {
    return {
        name:'',
        email: '',
        password: '',
        password_confirmation: ''
    }
  },
  methods: {
    submit() {
      console.log('submit', {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
      })
      this.$emit('submit', {
        name: this.name,
        email: this.email,
        password: this.password,
        //password_confirmation: this.password_confirmation,
      })
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';
.signup_form {
  width: 60%;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  color: $ESSENTIALS_BLUE2;
  margin-block-start: 50px;
}
</style>
