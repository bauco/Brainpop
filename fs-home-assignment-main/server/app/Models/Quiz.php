<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];


    public function subQuestions()
    {
        return $this->hasMany(Question::class);
    }
}
