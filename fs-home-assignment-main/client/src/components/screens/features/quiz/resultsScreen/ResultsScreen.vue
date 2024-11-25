<template>
    <div class="results-screen">
        <h2>Quiz Results</h2>
        <div v-for="(question, index) in questions" :key="index" class="result-item">
            <BaseQuestion :key="index"
                          :index="index + 1"
                          :question="question.question"
                          :type="question.type"
                          :options="question.options"
                          :subQuestions="question.subQuestions"
                          :multipleChoice="question.multipleChoice"
                          v-model="answers[index]"
                          :totalQuestions="questions.length" />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ResultsScreen',
        props: {
            answers: {
                type: Array,
                required: true
            },
            questions: {
                type: Array,
                required: true
            }
        },
        computed: {
            totalQuestions() {
                return this.questions.length;
            },
            score() {
                return this.answers.filter((answer, index) => {
                    return this.isCorrect(index);
                }).length;
            }
        },
        methods: {
            isCorrect(index) {
                const question = this.questions[index];
                const correctAnswer = question.correctAnswer;
                const userAnswer = this.answers[index];

                if (Array.isArray(correctAnswer)) {
                    return correctAnswer.every(ans => userAnswer.includes(ans));
                }
                return userAnswer === correctAnswer;
            }
        }
    }
</script>

<style scoped>
    .results-screen {
        padding: 20px;
    }

    .result-item {
        margin-bottom: 10px;
    }

    .score {
        font-size: 1.2rem;
        font-weight: bold;
    }
</style>
