<template>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=visibility,visibility_off" />
    <form class="login_form" @submit.prevent="submit">
        <BaseInput v-model="email" label="email" />
        <BaseInput class="password-input" v-model="password" label="Password" :type="visibility ? 'text' : 'password'" />
        <span @click="toggleVisibility" class="material-symbols-outlined  visibility-icon">
            {{ visibility ? 'visibility' : 'visibility_off' }}
        </span>
        <BaseButton type="submit" fullWidth>Log in</BaseButton>
    </form>
</template>

<script>
// COMPONENTS
import BaseInput from '@/components/base/input/BaseInput.vue'
import BaseButton from '@/components/base/button/BaseButton.vue'

export default {
  name: 'LoginForm',
  emits: ['submit'],
  components: {
    BaseInput,
    BaseButton
  },
  data() {
    return {
        email: '',
        password: '',
        visibility: false
    }
  },
        methods: {
            toggleVisibility() {
                this.visibility = !this.visibility;
            },
    submit() {
      console.log('submit', {
        email: this.email,
        password: this.password
      })
      this.$emit('submit', {
        email: this.email,
        password: this.password
      })
    }
  }
}
</script>

<style lang="scss" scoped>
    @import '@/utilities/css/vars/vars.scss';

    .login_form {
        width: 60%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        color: $ESSENTIALS_BLUE2;
        margin-block-start: 50px;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
    }
    .input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .visibility-icon {
        position: relative;
        top: -53px;
        right: -45%;
        color: #888;
    }

    .visibility-icon:hover {
        color: #000;
    }
</style>
