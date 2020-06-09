<?php

namespace App\Http\Controllers;

use App\CourseStudent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CourseStudentController extends Controller
{
    /**
     * 取得單一課程學生清單
     *
     * @param  \Illuminate\Http\Request  $request
     * courseId: 課程代號
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'courseId' => 'required|integer'
        ]);

        $c_id = isset($request->courseId) ? $request->courseId:null;

        if (!empty($c_id)) {
            $student_list = CourseStudent::select(
                'courses.id as courseId',
                'courses.name as courseName',
                'courses.status as courseStatus',
                'teachers.name as teacherName',
                'students.name as studentName',
                'students.number as studentNnmber'
            )
            ->join('courses', 'courses.id', '=', 'courses_students.course_id')
            ->join('students', 'students.id', '=', 'courses_students.student_id')
            ->join('teachers', 'teachers.id', '=', 'courses.teacher_id')
            ->where('courses_students.course_id', '=', $c_id)
            ->get();
        };

        $data = [];
        $data['studentList'] = $student_list;

        return response()->json(
            ['data' => $data],
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 學生選課
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courseStudent = CourseStudent::create($request->all());
        return response()->json(
            ['data' => $courseStudent],
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseStudent  $courseStudent
     * @return \Illuminate\Http\Response
     */
    public function show(CourseStudent $courseStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseStudent  $courseStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseStudent $courseStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseStudent  $courseStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseStudent $courseStudent)
    {
        //
    }

    /**
     * 學生刪除選課
     *
     * @param  \App\CourseStudent  $courseStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseStudent $courseStudent)
    {
        $courseStudent->delete();
        return response()->json([], 204);
    }

    // 抓單一學生學生選課數量
    // student_id: 學生代號
    // 回傳選課數量
    public static function courseListByStudent($student_id)
    {
        $c_list = CourseStudent::where('student_id', '=', $student_id);
        return [
            'count' => $c_list->count()
        ];
    }
}
