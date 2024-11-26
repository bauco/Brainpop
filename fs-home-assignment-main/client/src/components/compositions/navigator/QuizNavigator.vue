<template>
    <div class="quiz-navigation">
        <div class="navigation-buttons">
            <BaseButton @click="prevQuestion" v-if="currentQuestionIndex > 0 && currentQuestionIndex <= totalQuestions - 1" type="submit" :theme="'RTEAL'">Back</BaseButton>
            <BaseButton @click="nextQuestion" v-if="currentQuestionIndex < totalQuestions - 1" type="submit" :theme="'SECONDARY'">Next</BaseButton>
            <BaseButton @click="submit" v-if="currentQuestionIndex === totalQuestions - 1" type="submit" :theme="'SECONDARY'">Submit</BaseButton>
        </div>
    </div>
</template>

<script>
    import BaseButton from '@/components/base/button/BaseButton.vue';

    export default {
        name: 'QuizNavigator',
        components: {BaseButton},
        props: {
            currentQuestionIndex: {
                type: Number,
                required: true
            },
            totalQuestions: {
                type: Number,
                required: true
            },
            nextQuestion: {
                type: Function,
                required: true
            },
            prevQuestion: {
                type: Function,
                required: true
            },
            submit: {
                type: Function,
                required: true
            }
        }
    }
</script>

<style scoped>
    .quiz-navigation {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        border-top: 1px solid #ccc;
        padding: 10px 0;
        z-index: 10;
    }

    .navigation-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 0 20px;
    }
</style>
