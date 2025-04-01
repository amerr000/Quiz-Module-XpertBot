<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\ExamQuestion;

class Track extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    public function examQuestions(){
        return $this->hasMany(ExamQuestion::class);
    }
}
