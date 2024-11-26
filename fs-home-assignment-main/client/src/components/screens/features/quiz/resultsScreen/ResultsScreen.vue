<template>
    <div class="start-container">
        <Navigator :items="[
        { text: name, to: `/feature/quiz` ,topic: true},
        { text: 'Quiz', to: '' }
      ]" />
        <main class="start-content">
            <div class="results-screen">
                <div class="pad">

                </div>
                <div class="result-summary">
                    <h2>
                        Scored {{score}} / {{totalQuestions}}
                    </h2>
                </div>
                <div v-for="(question, index) in questions" :key="index">
                    <div class="result-item">
                        <BaseQuestion :key="index"
                                      :index="index + 1"
                                      :text="question.text"
                                      :type="question.type"
                                      :options="question.options"
                                      :subQuestions="question.subQuestions"
                                      :multipleChoice="question.multipleChoice"
                                      v-model="answers[index]"
                                      :submitted="true"
                                      :isCorrect="results[index]" />
                    </div>
                    <hr />
                </div>
            </div>
        </main>
    </div>
</template>
<script>
    import BaseQuestion from '@/components/base/question/BaseQuestion.vue';
    import Navigator from '@/components/compositions/navigator/Navigator.vue'
    export default {
        name: 'ResultsScreen',
        components: {
            Navigator,
            BaseQuestion,
        },
        data() {
            return {
                name: 'Accelration',
            }
        },
        props: {
            answers: {
                type: Array,
                required: true
            },
            questions: {
                type: Array,
                required: true
            },
            results: {
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
    .pad {
        width: 100%;
        height: 40px;
        background: #f3f3f3;
        border: solid 0.01rem #c0bdbd;
        box-shadow: 0 1px 2px 0 rgba(255, 255, 255, 0.15);
    }
    .results-screen {
        margin-block: 60px auto;
    }
    .result-item {
        margin: 0 25%;
    }
    .result-summary {
        padding: 10px;
        width: 100%;
        display: flex;
        width: 100%;
        background: #f0f7f7;
        justify-content: center;
    }
    .score {
        font-size: 1.2rem;
        font-weight: bold;
    }
    .start-container {
        width:100%;
    }
    .start_content {
        margin-block: 100px auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        gap: 1.2rem;
    }
    .quiz-container {
        padding: 20px;
        border-radius: 8px;
        margin: 20px auto;
    }
</style>
