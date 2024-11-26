<template>
    <div class="answer-feedback">
        <p v-if="isCorrect">
            Correct!
        </p>
        <p v-else>
            Incorrect. Try again.
        </p>
    </div>
</template>

<script>
    import { ref, watch } from 'vue';
    export default {
        name: 'AnswerFeedback',
        props: {
            answer: { type: [String, Array], required: true },
            isCorrect: { type: Boolean, required: true },
        },
    };
</script>

<style scoped>
    .answer-feedback {
        margin-top: 10px;
        font-weight: bold;
    }
</style>
