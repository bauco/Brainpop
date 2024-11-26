<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateRequest;
use App\Http\Requests\GetQuestionsRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Quiz;
use App\Models\Question;

class QuizController extends Controller
{
    public function questions(GetQuestionsRequest $request)
    {
        error_log( "ddsf");

        //$quizId = $request->input('quizId');

    $questions = [
    [
        'question' => 'What is 2 + 2?',
        'type' => 'text',
        'options' => [],
        'multipleChoice' => false
    ],
    [
        'question' => 'What is the capital of France?',
        'type' => 'text',
        'options' => [],
        'multipleChoice' => false
    ],
    [
        'question' => 'Which of the following are programming languages?',
        'type' => 'multiple',
        'options' => ['JavaScript', 'HTML', 'CSS', 'Python', 'Excel'],
        'multipleChoice' => true
    ],
    [
        'question' => 'Who wrote "Hamlet"?',
        'type' => 'textarea',
        'options' => [],
        'multipleChoice' => false
    ],
    [
        'question' => 'What is the tallest mountain in the world?',
        'type' => 'text',
        'options' => [],
        'multipleChoice' => false
    ]
];
        return response()->json([
            'message' => 'Quiz submitted successfully',
            'questions' => $questions,
        ]);
    }

    public function submit(ValidateRequest $request)
    {
        error_log( "dsf");

        $submittedQuestions = $request->input('answers');
        $this->checkQuestions($submittedQuestions);

        $results = [];
        return response()->json([
            'message' => 'Quiz submitted successfully',
            'results' => $results,
        ]);
    }
    private function checkQuestions($submittedQuestions){

        foreach ($submittedQuestions as $submittedQuestion) {
            if(is_array($submittedQuestion)){
                $this->checkQuestions($submittedQuestion);
            }else{
                error_log( $submittedQuestion);
                $matchedQuestion = Quiz::where('text', $submittedQuestion['question'])
                    ->where('type', $submittedQuestion['type'])
                    ->first();

                if (!$matchedQuestion) {
                    return response()->json([
                        'error' => 'Invalid question submitted.',
                        'submittedQuestion' => $submittedQuestion,
                    ], 422);
                }
                $isCorrect = $this->validateAnswer($submittedQuestion, $matchedQuestion);
            }
        }
    }
    private function validateAnswer($submitted, $matched)
    {
        if ($matched->type === 'text') {
            return strtolower(trim($submitted['answer'])) === strtolower(trim($matched->correct_answer));
        } elseif ($matched->type === 'multiple') {
            return empty(array_diff($submitted['answer'], $matched->options));
        }

        return false;
    }
}
