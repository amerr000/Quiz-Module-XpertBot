<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExamQuestion;
use App\Models\User;


class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id',
        'user_id',
        'answer',
        'is_correct',
    ];

    public function examQuestion()
    {
        return $this->belongsTo(ExamQuestion::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class);
            
    }
}
