<template>
    <div class="question_container">
        <div class="question_header">
            <h2>{{ index }}</h2>
            <p>{{ question }}</p>
        </div>

        <!-- Text question -->
        <div v-if="type === 'text'" class="input_container">
            <input v-model="localAnswer"
                   :placeholder="placeholder || 'Your answer here'"
                   type="text"
                   class="question_field"
                   @input="updateAnswer" />
        </div>

        <!-- Multiple choice -->
        <div v-if="type === 'multiple'" class="input_container">
            <div v-for="(option, idx) in options" @click="selectOption(option)"
                 :key="idx"
                 :class="['multi_question_answer', { checked: isChecked(option) }]">
                <svg v-if="multipleChoice"
                     class="circle-svg"
                     :class="{ selected: isChecked(option) }"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" class="circle-background" />
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" class="circle-text">{{ String.fromCharCode(97 + idx).toUpperCase() }}</text>
                </svg>
                <input v-else
                       type="radio"
                       :value="option"
                       v-model="localAnswer"
                       @change="updateAnswer" />
                <p>{{ option }}</p>
            </div>
            <svg v-if="submitted" :class="{'correct': isCorrect(option), 'wrong': !isCorrect(option)}">
                <!-- SVG content here, e.g., a checkmark or a cross -->
            </svg>
        </div>

        <!-- Subquestions -->
        <div v-if="type === 'section' || subQuestions" class="subquestions_container">
            <div v-for="(sub, subIndex) in subQuestions" :key="subIndex">
                <BaseQuestion :index="index + '.' + (subIndex + 1)"
                              :question="sub.question"
                              :type="sub.type"
                              :options="sub.options"
                              :multipleChoice="sub.multipleChoice"
                              v-model="localSubAnswers[subIndex]"
                              :totalQuestions="totalQuestions"/>
            </div>
        </div>
    </div>
</template>

<script>
    import { ref, watch } from 'vue';

    export default {
        name: 'BaseQuestion',
        props: {
            modelValue: {
                type: [String, Array],
                required: false,
            },
            type: {
                type: String,
                required: true,
            },
            index: {
                type: [Number, String],
                required: true,
            },
            totalQuestions: {
                type: Number,
                required: true,
            },
            question: {
                type: String,
                required: true,
            },
            options: {
                type: Array,
                required: false,
            },
            subQuestions: {
                type: Array,
                required: false,
            },
            multipleChoice: {
                type: Boolean,
                required: false,
                default: false,
            },
            placeholder: {
                type: String,
                required: false,
            },
            isReadOnly: {
                type: Boolean,
                default: false,
            },
            submitted: {
                type: Boolean,
                default: false,
            },
            correctAnswer: {
                type: [String, Array],
                required: false,
            }
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

            const isChecked = (option) => {
                if (props.multipleChoice) {
                    return localAnswer.value.includes(option);
                }
                return localAnswer.value === option;
            };

            const selectOption = (option) => {
                if (props.multipleChoice) {
                    if (localAnswer.value.includes(option)) {
                        localAnswer.value = localAnswer.value.filter((item) => item !== option);
                    } else {
                        localAnswer.value.push(option);
                    }
                } else {
                    localAnswer.value = option;
                }
            };
            return {
                localAnswer,
                localSubAnswers,
                updateAnswer,
                isChecked,
                selectOption
            };
        },
    };
</script>

<style lang="scss" scoped>
    @import '@/utilities/css/vars/vars.scss';

    .question_header {
        display: flex;
        gap: 10px;
        p{
            margin:0;
        }
    }

    .question_container {
        margin-bottom: 20px;
    }

    .input_container {
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

        &.checked {
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

        &:focus-visible {
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
