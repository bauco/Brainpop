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
        'text' => 'What is 2 + 2?',
        'type' => 'text',
        'options' => [],
    ],
    [
        'text' => 'What is the capital of France?',
        'type' => 'text',
        'options' => [],
    ],
    [
        'text' => 'Which of the following are programming languages?',
        'type' => 'multiple',
        'options' => ['JavaScript', 'HTML', 'CSS', 'Python', 'Excel'],
    ],
    [
        'text' => 'Who wrote "Hamlet"?',
        'type' => 'textarea',
        'options' => [],
    ],
    [
        'text' => 'What is the tallest mountain in the world?',
        'type' => 'text',
        'options' => [],
    ]
];
        return response()->json([
            'message' => 'Quiz submitted successfully',
            'questions' => $questions,
        ]);
    }

    public function submit(ValidateRequest $request)
    {
        error_log("124");
        $validated = $request->validated();
        $results = $this->checkQuestions( $request->input('answers'),$request->input('questions'));
        $score = count(array_filter($results, fn($result) => $result));

        return response()->json([
            'message' => 'Quiz submitted successfully',
            'score' => $score,
            'results' => $results,
        ]);
    }
    private function checkQuestions($answers, $questions)
    {
        $results = [];
        foreach ($questions as $index => $question) {
            error_log($index);
            if(is_array($answers[$index])){
                $this->checkQuestions($question,$answers[$index]);
            }else{
                $matchedQuestion = Question::where('text', $question['text'])
                    ->where('type', $question['type'])
                    ->first();
                error_log( $matchedQuestion);
                if (!$matchedQuestion) {
                    return response()->json([
                        'error' => 'Invalid question submitted.',
                        'question' => $question,
                    ], 422);
                }
                error_log( $answers[$index]);
                $isCorrect = $this->validateAnswer($answers[$index], $matchedQuestion);
                error_log(  $isCorrect);
                array_push($results,  $isCorrect);

            }
        }
        return $results;
    }
    private function validateAnswer($submitted, $matched)
    {
       return strtolower(trim($submitted)) === strtolower(trim($matched->correct_answer));
    }
}
