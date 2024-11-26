<template>
  <div class="check_circle" v-html="Check"></div>
</template>

<script>
    import Check from '@/assets/check_circle.svg?raw'

export default {
        name: 'Check',
  data() {
    return {
        Check
    }
  },
  props: {
    color: {
      type: String,
      required: false,
          default: '#5ba167'
    },
    width: {
      type: String,
      required: false,
      default: 'initial'
    }
  }
}
</script>

<style lang="scss" scoped>
    .check_circle {
        fill: v-bind(color);
        color: v-bind(color);

        :deep(svg) {
            width: v-bind(width);
        }
    }
</style>
