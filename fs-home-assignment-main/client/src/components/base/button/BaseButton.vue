<template>
  <button :class="{ fullWidth: fullWidth }" :disabled="disabled" @click="onClick">
    <slot></slot>
  </button>
</template>

<script>
import { THEMES } from './config.js'
export default {
  name: 'BaseButton',
  emits: ['click'],
  props: {
    value: {
      type: String,
      default: ''
    },
    fullWidth: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    theme: {
      type: String,
      default: THEMES.PRIMARY
    }
  },
  methods: {
    onClick() {
      this.$emit('click')
    }
  },
  computed: {
    themeObj() {
      const theme = {
        [THEMES.PRIMARY]: {
          bg: '#137996',
          hover: '#0c576c',
          color: '#fff'
        },
        [THEMES.SECONDARY]: {
          bg: '#008080',
          hover: '#006666',
          color: '#fff'
        },
        [THEMES.RTEAL]: {
            bg: 'transperent',
            hover: '#165252',
            color: '#008080',
        }
      }
      const type = this.theme.toUpperCase() || THEMES.PRIMARY
      return theme[type]
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';
    button {
        background-color: v-bind('themeObj.bg');
        color: v-bind('themeObj.color');
        border: solid 1px v-bind('themeObj.color');
        font-size: large;
        font-family: $FONT_BOLD;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;

        &.fullWidth {
            width: 100%;
        }

        &:hover {
            background-color: v-bind('themeObj.hover');
        }

        &:disabled {
            opacity: 0.5;
            cursor: not-allowed;

            &:hover,
            &:active {
                background: v-bind('themeObj.bg');
            }
        }
    }
</style>
