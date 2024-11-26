<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateRequest;
use App\Http\Requests\GetQuestionsRequest;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\UserQuiz;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function questions(GetQuestionsRequest $request)
    {
        // Retrieve quiz ID from query parameter
        $quizId = (int) $request->query('quiz_id');
        
        // Get questions related to the quiz
        $questions = Question::where('quiz_id', $quizId)
            ->select('id', 'text', 'type', 'options', 'quiz_id')
            ->get();

        return response()->json([
            'message' => 'Quiz questions retrieved successfully',
            'questions' => $questions,
        ]);
    }

    public function submit(ValidateRequest $request)
    {
        $userId = Auth::id();
        $validated = $request->validated();
        try{
            $userQuiz = UserQuiz::where('user_id', $userId)->exists();

            if ($userQuiz) {
                return response()->json([
                    'message' => 'You have already submitted answers for this quiz.',
                ], 400);
            }
            if (!$userQuiz) {
                $userQuiz = UserQuiz::create([
                    'user_id' => $userId,
                    'quiz_id' => $request->input('quiz_id'),
                    'started_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
                error_log("Error creating UserAnswer: " . $e->getMessage());
        }


        $results = $this->checkQuestions(
            $request->input('answers'),
            $request->input('questions'),
            $userId,
            $request->input('quiz_id')
        );
        
        $score = count(array_filter($results, fn($result) => $result));

        return response()->json([
            'message' => 'Quiz submitted successfully',
            'score' => $score,
            'results' => $results,
        ]);
    }

    private function checkQuestions($answers, $questions, $userId, $quizId)
    {
        $results = [];
        foreach ($questions as $index => $question) {
            // Recursively check nested questions if necessary
            if (is_array($answers[$index])) {
                $this->checkQuestions($answers[$index], $question, $userId, $quizId);
            } else {
                $matchedQuestion = Question::where('id', $question['id'])->first();

                if (!$matchedQuestion) {
                    return response()->json([
                        'error' => 'Invalid question submitted.',
                        'question' => $question,
                    ], 422);
                }
                $isCorrect = $this->validateAnswer($answers[$index], $matchedQuestion);
                try {
                    UserAnswer::create([
                        'user_id' => $userId,
                        'user_quiz_id' => $quizId, // Ensure this is passed correctly
                        'question_id' => $matchedQuestion->id,
                        'answer' => $answers[$index],
                        'is_correct' => $isCorrect,
                    ]);
                } catch (\Exception $e) {
                    error_log("Error creating UserAnswer: " . $e->getMessage());
                }
                array_push($results, $isCorrect);
            }
        }
        return $results;
    }

    private function validateAnswer($submitted, $matched)
    {
        return strtolower(trim($submitted)) === strtolower(trim($matched->correct_answer));
    }
}

