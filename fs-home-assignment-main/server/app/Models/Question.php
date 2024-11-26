<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 
        'text',
        'options',
        'multipleChoice',
        'correct_answer'
    ];
    protected $table = 'questions';
    protected $primaryKey = 'id';
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
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
