<template>
    <div class="question-container">
        <div class="question-header">
            <h2>{{ index }}</h2>
            <p>{{ text }}</p>
        </div>
        <TextQuestion v-if="type === 'text'" :submitted="submitted" v-model="localAnswer" :placeholder="placeholder" :isCorrect ="isCorrect"/>
        <TextArea v-if="type === 'textarea'" :submitted="submitted" v-model="localAnswer" :placeholder="placeholder" :isCorrect ="isCorrect"/>

        <MultipleChoiceQuestion v-if="type === 'multiple-choice'"
                                :options="options"
                                v-model="localAnswer"
                                @update:modelValue="updateAnswer"
                                :submitted="submitted"
                                :isCorrect ="isCorrect"
                                />
        <SubQuestionSection :submitted="submitted" v-if="type === 'section'"
                            :subQuestions="subQuestions"
                            v-model="localSubAnswers" />
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
            localAnswer: { type: String, required: false },
            submitted: { type: Boolean, required: false, default: false },
            isCorrect: { type: Boolean, required: false},
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


            return {
                localAnswer,
                localSubAnswers,
                updateAnswer,
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