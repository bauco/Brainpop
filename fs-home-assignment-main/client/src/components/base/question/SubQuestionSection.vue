<template>
    <div class="subquestions-container">
        <BaseQuestion v-for="(sub, subIndex) in subQuestions"
                      :key="subIndex"
                      :index="`${index}.${subIndex + 1}`"
                      :question="sub.question"
                      :type="sub.type"
                      :options="sub.options"
                      :multipleChoice="sub.multipleChoice"
                      v-model="localSubAnswers[subIndex]"
                      :submitted="submitted" />
    </div>
</template>

<script>

    import BaseQuestion from './BaseQuestion.vue';
    import { ref, watch } from 'vue';
    export default {
        name: 'SubQuestionSection',
        props: {
            subQuestions: { type: Array, required: true },
            index: { type: String, required: true },
            submitted: { type: Boolean, required: false, default: false },
        },
        setup(props) {
            const localSubAnswers = ref(props.subQuestions.map(() => ''));

            return { localSubAnswers };
        },
    };
</script>

<style scoped>
    .subquestions-container {
        margin-top: 20px;
        padding-left: 20px;
        border-left: 2px solid #ddd;
    }
</style>
