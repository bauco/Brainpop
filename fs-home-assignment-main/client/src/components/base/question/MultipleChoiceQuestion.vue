<template>
    <div class="input-container">
        <div v-for="(option, idx) in options" :key="idx" class="multi-option" @click="selectOption(option)">
            <input v-if="!multipleChoice" type="radio" :value="option" v-model="localAnswer" />
            <div v-if="multipleChoice" :class="['checkbox', { checked: isChecked(option) }]">
                <svg class="circle-svg" :class="{ selected: isChecked(option) }" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" class="circle-background" />
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" class="circle-text">{{ String.fromCharCode(97 + idx).toUpperCase() }}</text>
                </svg>
                <p>{{ option }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            modelValue: { type: [String, Array], required: false },
            options: { type: Array, required: true },
            multipleChoice: { type: Boolean, required: false, default: false },
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

            const selectOption = (option) => {
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

            return { localAnswer, isChecked, selectOption, updateAnswer };
        },
    };
</script>

<style scoped>
    .multi-option {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .circle-svg {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid #ddd;
        transition: background-color 0.3s;
    }

    .circle-background {
        fill: transparent;
        stroke: #ccc;
        stroke-width: 2px;
    }

    .circle-text {
        font-size: 16px;
        font-weight: bold;
    }

    .checkbox.selected {
        background-color: #d3f4f4;
        border-color: #35797a;
    }
</style>
