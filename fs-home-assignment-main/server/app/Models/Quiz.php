<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'correct_answer', 'options', 'parent_id'];

    public function subQuestions()
    {
        return $this->hasMany(Quiz::class, 'parent_id');
    }
}
