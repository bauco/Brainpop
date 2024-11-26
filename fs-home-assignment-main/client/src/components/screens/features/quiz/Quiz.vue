<template>
  <div class="quiz_container">
      <div v-if="data">
          <QuizStartScreen v-if="quizState === QUIZ_STATES.START" :name="data.name" :questionsLength="data.questions.length" @start="start"></QuizStartScreen>
          <QuizQuestionsScreen v-if="quizState === QUIZ_STATES.QUESTIONS"></QuizQuestionsScreen>
          <ResultsScreen v-if="quizState === QUIZ_STATES.RESULT"></ResultsScreen>

      </div>
    <div v-else>Loading...</div>
  </div>
</template>

<script>
import QuizStartScreen from './startScreen/QuizStartScreen.vue'
import ResultsScreen from './resultsScreen/ResultsScreen.vue'
import QuizQuestionsScreen from './questionsScreen/QuizQuestionsScreen.vue'

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
      quizState: QUIZ_STATES.START
    }
  },
  methods: {
    start() {
      this.quizState = QUIZ_STATES.QUESTIONS
    }
  }
}
</script>

<style lang="scss" scoped></style>
