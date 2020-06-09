<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'status',
        'teacher_id'
    ];

    //將課程資料附上教師資訊
    //courseId: 課程代號
    public static function showTeacher($courseId = null)
    {
        $courses = Course::select(
            'courses.*',
            'teachers.name as teacherName',
            'teachers.number as teacherNumber'
        )
        ->join('teachers', 'teachers.id', '=', 'courses.teacher_id');

        if (!empty($courseId)) {
            $courses->where('courses.id', '=', $courseId);
        };

        return $courses;
    }
}
