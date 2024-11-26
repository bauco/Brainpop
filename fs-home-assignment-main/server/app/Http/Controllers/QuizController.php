<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateRequest;
use App\Http\Requests\GetQuestionsRequest;

class QuizController extends Controller
{
    public function questions(GetQuestionsRequest $request){
        return [
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
            ];
    }
    public function submit(ValidateRequest $request)
    {
        $submittedQuestions = $request->input('questions');

        $results = [];
        foreach ($submittedQuestions as $submittedQuestion) {
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

            // Validate subquestions
            foreach ($submittedQuestion['subQuestions'] as $subQuestion) {
                $results[] = $this->validateAnswer($subQuestion, $matchedQuestion->subQuestions->find($subQuestion['id']));
            }

            $results[] = [
                'question' => $submittedQuestion['question'],
                'is_correct' => $isCorrect,
            ];
        }
        return response()->json([
            'message' => 'Quiz submitted successfully',
            'results' => $results,
        ]);
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
