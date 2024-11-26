<template>
  <div class="topic_avatar" v-html="Topic"></div>
</template>

<script>
    import Topic from '@/assets/topic_avatar.svg?raw'

export default {
        name: 'Topic',
  data() {
    return {
        Topic
    }
  },
  props: {
    color: {
      type: String,
      required: false,
      default: 'black'
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
    .topic_avatar {
        fill: v-bind(color);

        :deep(svg) {
            width: v-bind(width);
            height: v-bind(width);
        }
    }
</style>
