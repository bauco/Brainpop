<template>
        <Navigator :items="[
        { text: name, to: `/feature/quiz`, topic: true },
        { text: 'Quiz', to: '' }
      ]" />
        <main class="start_content">
            <div class="pad">

            </div>
            <div class="start_container">
                <div class="quiz-container">
                    <!-- Display current question only -->
                    <BaseQuestion :key="currentQuestionIndex"
                                  :index="currentQuestionIndex + 1"
                                  :text="questions[currentQuestionIndex].text"
                                  :type="questions[currentQuestionIndex].type"
                                  :options="questions[currentQuestionIndex].options"
                                  :subQuestions="questions[currentQuestionIndex].subQuestions"
                                  :multipleChoice="questions[currentQuestionIndex].multipleChoice"
                                  v-model="answers[currentQuestionIndex]"
                                  :submitted="false" />
                    <QuizNavigator :currentQuestionIndex="currentQuestionIndex"
                                   :totalQuestions="questions.length"
                                   :nextQuestion="nextQuestion"
                                   :prevQuestion="prevQuestion"
                                   :submit="submit" />
                </div>
            </div>
        </main>
</template>


<script>
    import BaseQuestion from '@/components/base/question/BaseQuestion.vue';
    import Navigator from '@/components/compositions/navigator/Navigator.vue'
    import QuizNavigator from '@/components/compositions/navigator/QuizNavigator.vue'

    export default {
        name: 'QuizQuestionsScreen',
        components: {
            BaseQuestion,
            Navigator,
            QuizNavigator
        },
        props: {
            questions: {
                type: Array,
                required: true
            }
        },
        methods: {
            nextQuestion() {
                if (this.currentQuestionIndex < this.questions.length - 1) {
                    this.currentQuestionIndex++;
                }
            },
            prevQuestion() {
                if (this.currentQuestionIndex > 0) {
                    this.currentQuestionIndex--;
                }
            },
            submit() {
                this.$emit('submit', this.answers);
            }
        },
        data() {
            return {
                currentQuestionIndex: 0,
                allowBack: true,
                name: 'Accelration',
                answers: ['', '', [], '', ''], // Store answers (array for multiple choices)
                currentQuestionIndex: 0,
            }
        }
    }
</script>

<style lang="scss" scoped>
    .pad {
        width: 100%;
        height: 40px;
        background: #f3f3f3;
        border: solid 0.01rem #c0bdbd;
        box-shadow: 0 1px 2px 0 rgba(255, 255, 255, 0.15);
    }
    .start_container {
        display: flex;
        justify-content: center;
        align-items: center;
        color: #343a41;
    }

    .start_content {
        margin-block: 60px auto;
        width:100%;
    }

    .quiz-container {
        padding: 20px;
        border-radius: 8px;
        margin: 20px auto;
    }

</style>
