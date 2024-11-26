<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateRequest;
class QuizController extends Controller
{
    public function validate(ValidateRequest $request)
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
