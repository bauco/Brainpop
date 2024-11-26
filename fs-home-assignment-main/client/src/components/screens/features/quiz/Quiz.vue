<template>
  <div class="quiz_container">
      <div v-if="data">
          <QuizStartScreen v-if="quizState === QUIZ_STATES.START" :name="data.name" :questionsLength="data.questions.length" @start="start"></QuizStartScreen>
          <QuizQuestionsScreen v-if="quizState === QUIZ_STATES.QUESTIONS"  :questions="questions" @submit="submit"></QuizQuestionsScreen>
          <ResultsScreen v-if="quizState === QUIZ_STATES.RESULT"></ResultsScreen>

      </div>
    <div v-else>Loading...</div>
  </div>
</template>

<script>
import QuizStartScreen from './startScreen/QuizStartScreen.vue'
import ResultsScreen from './resultsScreen/ResultsScreen.vue'
import QuizQuestionsScreen from './questionsScreen/QuizQuestionsScreen.vue'
import axios from 'axios';

const QUIZ_STATES = {
  START: 'start',
  QUESTIONS: 'questions',
  RESULT: 'result'
}

export default {
  name: 'Quiz',
  components: {
      QuizStartScreen,
      QuizQuestionsScreen,
      ResultsScreen
  },
  props: {
    data: {
      type: Object,
      required: false
    }
  },
  data() {
    return {
        QUIZ_STATES,
        quizState: QUIZ_STATES.START,
        questions: [],
    }
  },
  methods: {
      async start() {
          try {
              const apiUrl = import.meta.env.VITE_API_URL;
              axios.defaults.baseURL = apiUrl;
              const response = await axios.get('/api/questions');
              this.questions = response.data.questions;  
              this.quizState = QUIZ_STATES.QUESTIONS
          } catch (error) {
              console.error('Error in start quiz:', error);
          }
      },
      async submit(answers) {
          try {
              const response = await axios.post('/api/validate', {
                  answers: answers,
                  questions: this.questions
              });
              this.results = response.data;
              this.quizState = this.QUIZ_STATES.RESULTS;
          } catch (error) {
              console.error('Error submitting answers:', error);
          }
      }
  }
}
</script>

<style lang="scss" scoped></style>
