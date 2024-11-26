<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Quiz;
use App\Models\UserAnswer;

class UserQuiz extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quiz_id', 'score', 'started_at', 'finished_at'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(UserAnswer::class);
    }
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'user_quiz_id');
    }
}
