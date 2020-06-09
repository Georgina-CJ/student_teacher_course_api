<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    protected $table = 'courses_students';
    protected $fillable = [
        'course_id',
        'student_id'
    ];
}
