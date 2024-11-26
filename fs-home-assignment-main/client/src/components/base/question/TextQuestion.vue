<template>
    <div class="input-container">
        <input v-model="localAnswer"
               :placeholder="placeholder || 'Your answer here'"
               type="text"
               class="question-field"
               @input="updateAnswer"
               :disabled="submitted" />
        <AnswerFeedback v-if="submitted" :isCorrect="isCorrect" />

    </div>
</template>

<script>
    import AnswerFeedback from '@/components/base/question/AnswerFeedback.vue';

    import { ref, watch } from 'vue';

    export default {
        name: 'TextQuestion',
        components: { AnswerFeedback },
        props: {
            modelValue: { type: String, required: false },
            placeholder: { type: String, required: false },
            submitted: { type: Boolean, required: false, default: false },
            isCorrect: { type: Boolean, required: false },

        },
        emits: ['update:modelValue'],
        setup(props, { emit }) {
            const localAnswer = ref(props.modelValue || '');

            const updateAnswer = () => {
                emit('update:modelValue', localAnswer.value);
            };

            return { localAnswer, updateAnswer };
        }
    };
</script>

<style scoped>
    .question_header {
        display: flex;
        gap: 10px;
        p

    {
        margin: 0;
    }

    }

    .question_container {
        margin-bottom: 20px;
    }

    .input-container {
        width: 100%;
        margin-top: 10px;
    }

    .multi_question_answer {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        align-items: center;
        gap: 10px;
        border: solid 0.3px #dedddd;
        box-shadow: 1px 1px 1px #e7e7e7;
        border-radius: 3px;
        padding: 0 10px 0;
        margin: 15px;
        transition: background-color 0.3s, border 0.3s;
        &.checked

    {
        background-color: #f0fcfe;
    }

    }

    .label {
        font-family: $FONT_BOLD;
        font-size: large;
    }

    .question_field {
        width: 97%;
        border: $BORDER;
        border-radius: 6px;
        font-size: 18px;
        height: 34px;
        outline: none;
        padding-inline-start: 6px;
        &:focus-visible

    {
        box-shadow: 0 0 0 2px #fff, 0 0 0 4px #0067f4;
    }

    }

    .subquestions_container {
        margin-top: 20px;
        padding-left: 20px;
        border-left: 2px solid $LIGHT_GRAY;
    }

    input[type='checkbox']:checked + label,
    input[type='radio']:checked + label {
        font-weight: bold;
    }

    .circle-svg {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s, stroke 0.3s, fill 0.3s;
    }

    .circle-background {
        fill: transparent;
        stroke: #ccc;
        stroke-width: 2px;
    }

    .circle-text {
        font-size: 24px;
        fill: #333; /* Default text color */
        font-weight: bold;
    }

    .circle-svg:hover {
        background-color: #e6f7ff;
    }

    .circle-svg.selected .circle-background {
        fill: #d3f4f4;
        stroke: #35797a;
    }

    .circle-text {
        font-size: 50px;
    }
</style>