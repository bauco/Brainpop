<template>
    <div class="input-container">
        <input v-model="localAnswer"
               :placeholder="placeholder || 'Your answer here'"
               type="text"
               class="question-field"
               @input="updateAnswer" />
    </div>
</template>

<script>
    export default {
        props: {
            modelValue: { type: String, required: false },
            placeholder: { type: String, required: false }
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
    .input-container {
        margin-top: 10px;
    }

    .question-field {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
