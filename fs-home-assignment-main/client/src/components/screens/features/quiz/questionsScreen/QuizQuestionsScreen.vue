<template>
    <div class="start_container">
        <Navigator :items="[
        { text: name, to: `/feature/quiz` },
        { text: 'Quiz', to: '' }
      ]" />
        <main class="start_content">
            <div class="quiz-container">
                <!-- Display current question only -->
                <BaseQuestion :key="currentQuestionIndex"
                              :index="currentQuestionIndex + 1"
                              :question="questions[currentQuestionIndex].question"
                              :type="questions[currentQuestionIndex].type"
                              :options="questions[currentQuestionIndex].options"
                              :subQuestions="questions[currentQuestionIndex].subQuestions"
                              :multipleChoice="questions[currentQuestionIndex].multipleChoice"
                              v-model="answers[currentQuestionIndex]"
                              :totalQuestions="questions.length" />
                <QuizNavigator :currentQuestionIndex="currentQuestionIndex"
                                :totalQuestions="questions.length"
                                :nextQuestion="nextQuestion"
                                :prevQuestion="prevQuestion"
                                :submit="submit" />
            </div>
        </main>
    </div>
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
        emits: ['submit'],
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
                // Handle submission logic
                console.log('Answers submitted:', this.answers);
                this.$emit('submit', this.answers);
            }
        },
        data() {
            return {
                currentQuestionIndex: 0,
                allowBack: true,
                name: 'Accelration',
                questions: [
                    {
                        question: 'What is 2 + 2?',
                        type: 'text',
                        options: [],
                        multipleChoice: false
                    },
                    {
                        question: 'What is the capital of France?',
                        type: 'text',
                        options: [],
                        multipleChoice: false
                    },
                    {
                        question: 'Which of the following are programming languages?',
                        type: 'multiple',
                        options: ['JavaScript', 'HTML', 'CSS', 'Python', 'Excel'],
                        multipleChoice: true
                    },
                    {
                        question: 'Who wrote "Hamlet"?',
                        type: 'textarea',
                        options: [],
                        multipleChoice: false
                    },
                    {
                        question: 'What is the tallest mountain in the world?',
                        type: 'text',
                        options: [],
                        multipleChoice: false
                    },
                ],
                answers: ['', '', [], '', ''], // Store answers (array for multiple choices)
                currentQuestionIndex: 0,
            }
        }
    }
</script>

<style lang="scss" scoped>
    .start_container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #343a41;
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
