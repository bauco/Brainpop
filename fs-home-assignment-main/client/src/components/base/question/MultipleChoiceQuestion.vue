<template>
    <div class="input-container">
        <div v-for="(option, idx) in options"
             :key="idx" :class="['multi-option', { checked: isChecked(option) } , { true: isTrue(option) } , { false: isFalse(option) }]"
             @click="selectOption(option)">
            <svg class="circle-svg"
                 :class="{ selected: isChecked(option) }"
                 xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" class="circle-background" />
                <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" class="circle-text">{{ String.fromCharCode(97 + idx).toUpperCase() }}</text>
            </svg>
            <p>{{ option }}</p>
            <AnswerFeedback v-if="submitted && localAnswer === option" :isCorrect="isCorrect" />
        </div>

    </div>
</template>

<script>
    import AnswerFeedback from '@/components/base/question/AnswerFeedback.vue';

    import { ref, watch } from 'vue';
    export default {
        components: { AnswerFeedback },
        name:'MultipleChoiceQuestion',
        props: {
            modelValue: { type: [String, Array], required: false },
            options: { type: Array, required: true },
            multipleChoice: { type: Boolean, required: false, default: false },
            submitted: { type: Boolean, required: false, default: false },
            isCorrect: { type: Boolean, required: false },
        },
        emits: ['update:modelValue'],
        setup(props, { emit }) {
            const localAnswer = ref(props.modelValue || (props.multipleChoice ? [] : ''));

            const updateAnswer = () => {
                emit('update:modelValue', localAnswer.value);
            };

            const isChecked = (option) => {
                return props.multipleChoice ? localAnswer.value.includes(option) : localAnswer.value === option;
            };
            const isTrue = (option) => {
                if (!props.submitted || !isChecked(option)) {
                    return false;
                }
                return props.isCorrect;
            };
            const isFalse = (option) => {
                if (!props.submitted || !isChecked(option)) {
                    return false;
                }
                console.log(option)
                console.log(props.submitted)
                console.log(isChecked(option))
                console.log(props.isCorrect)
                return !props.isCorrect;
            };
            const selectOption = (option) => {
                if (props.submitted) {
                    return;
                }
                if (props.multipleChoice) {
                    const idx = localAnswer.value.indexOf(option);
                    if (idx > -1) {
                        localAnswer.value.splice(idx, 1);
                    } else {
                        localAnswer.value.push(option);
                    }
                } else {
                    localAnswer.value = option;
                }
                updateAnswer();
            };

            return { localAnswer, isChecked,isTrue,isFalse, selectOption, updateAnswer };
        },
    };
</script>

<style lang="scss" scoped>
    @import '@/utilities/css/vars/vars.scss';

    .input-container {
        width: 100%;
        margin-top: 10px;
    }

    .multi-option {
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

        &.checked {
            background-color: #f0fcfe;
        }

        &.true {
            background-color: #f3fff1;
            border: solid #589e63 1px;
        }

        &.false {
            background-color: #fcf7f7;
            border: solid #de678b 1px;
        }
    }


    .question-field {
        width: 97%;
        border: $BORDER;
        border-radius: 6px;
        font-size: 18px;
        height: 34px;
        outline: none;
        padding-inline-start: 6px;

        &:focus-visible {
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px #0067f4;
        }
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
