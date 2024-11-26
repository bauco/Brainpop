<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAnswer;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'text', 'type', 'options', 'correct_answer'];

    protected $table = 'questions';
    protected $primaryKey = 'id';
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'question_id');
    }
    public function getOptionsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }
}
