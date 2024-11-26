<template>
  <div class="times" v-html="Times"></div>
</template>

<script>
    import Times from '@/assets/times_circle.svg?raw'

export default {
        name: 'Times',
  data() {
    return {
        Times
    }
  },
  props: {
    color: {
      type: String,
      required: false,
        default: '#d95079'
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
    .times {
        fill: v-bind(color);
        color: v-bind(color);

        :deep(svg) {
            width: v-bind(width);
        }
    }
</style>
