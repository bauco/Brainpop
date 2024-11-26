<template>
    <div class="answer-feedback">
        <Check v-if="isCorrect" color="#5ba167" width="20px" />
        <Times v-else color="#d95079" width="20px" />
</div>
</template>

<script>
    import { ref, watch } from 'vue';
    import Check from '@/components/base/logo/Check.vue'
    import Times from '@/components/base/logo/Times.vue'

    export default {
        name: 'AnswerFeedback',
        components: { Check, Times },
        props: {
            isCorrect: { type: Boolean, required: true },
        },
    };
</script>

<style scoped>
    .answer-feedback {
        position: absolute;
        left: 75%;
    }
</style>
