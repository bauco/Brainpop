<template>
    <div class="question-container">
        <div class="question-header">
            <h2>{{ index }}</h2>
            <p>{{ text }}</p>
        </div>
        <TextQuestion v-if="type === 'text'" v-model="localAnswer" :placeholder="placeholder" />
        <TextArea v-if="type === 'textarea'" v-model="localAnswer" :placeholder="placeholder" />

        <MultipleChoiceQuestion v-if="type === 'multiple'"
                                :options="options"
                                v-model="localAnswer"
                                @update:modelValue="updateAnswer" />
        <SubQuestionSection v-if="type === 'section'"
                            :subQuestions="subQuestions"
                            v-model="localSubAnswers" />
        <AnswerFeedback v-if="submitted" :answer="localAnswer" :isCorrect="isCorrectAnswer" />
    </div>
</template>

<script>
    import { ref, watch } from 'vue';
    import TextQuestion from '@/components/base/question/TextQuestion.vue';
    import TextArea from '@/components/base/question/TextArea.vue';
    import MultipleChoiceQuestion from '@/components/base/question/MultipleChoiceQuestion.vue';
    import SubQuestionSection from '@/components/base/question/SubQuestionSection.vue';
    import AnswerFeedback from '@/components/base/question/AnswerFeedback.vue';

    export default {
        components: {
            TextQuestion,
            TextArea,
            MultipleChoiceQuestion,
            SubQuestionSection,
            AnswerFeedback
        },
        name: 'BaseQuestion',
        props: {
            modelValue: { type: [String, Array], required: false },
            type: { type: String, required: true },
            index: { type: [Number, String], required: true },
            text: { type: String, required: true },
            options: { type: Array, required: false },
            subQuestions: { type: Array, required: false },
            multipleChoice: { type: Boolean, required: false, default: false },
            placeholder: { type: String, required: false },
            totalQuestions: { type: Number, required: true },
            localAnswer: { type: String, required: false },
            submitted: { type: Boolean, required: false, default: false },
        },
        emits: ['update:modelValue'],
        setup(props, { emit }) {
            const localAnswer = ref(props.modelValue || (props.multipleChoice ? [] : ''));
            const localSubAnswers = ref(props.subQuestions?.map(() => '') || []);

            watch(localAnswer, (newVal) => {
                emit('update:modelValue', newVal);
            });
            watch(localSubAnswers, (newSubAnswers) => {
                emit('update:modelValue', newSubAnswers);
            });

            const updateAnswer = () => {
                emit('update:modelValue', localAnswer.value);
            };

            const isCorrectAnswer = () => {
                // Add your logic for correctness here
                return true; // Mock for simplicity
            };

            return {
                localAnswer,
                localSubAnswers,
                updateAnswer,
                isCorrectAnswer
            };
        },
    };
</script>

<style lang="scss" scoped>
    .question-header {
        display: flex;
        gap: 10px;

        p {
            margin: 0;
        }
    }

    .question-container {
        margin-bottom: 20px;
    }
</style>