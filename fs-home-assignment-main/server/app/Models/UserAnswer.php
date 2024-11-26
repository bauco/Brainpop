<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'user_answers';
    protected $fillable = [
        'user_id', 
        'user_quiz_id',
        'question_id', 
        'answer', 
        'is_correct'
    ];

}

