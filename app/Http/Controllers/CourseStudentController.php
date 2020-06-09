<?php

namespace App\Http\Controllers;

use App\CourseStudent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseStudentController extends Controller
{
    /**
     * 取得單一課程學生清單
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'courseId' => 'required|integer'
        ]);

        $c_id = isset($request->courseId) ? $request->courseId:null;
        if (!empty($c_id)) {
            $student_list = CourseStudent::select('students.id', 'students.name', 'students.number')
            ->join('students', 'students.id', '=', 'courses_students.student_id')
            ->where('courses_students.course_id', '=', $c_id)
            ->get();
        };

        return response([
            'courseId' => $c_id,
            'studentList' => $student_list
        ], Response::HTTP_OK);
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
        return response($courseStudent, Response::HTTP_CREATED);
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
        return response(null, Response::HTTP_NO_CONTENT);
    }

    // 抓單一學生學生選課 to list courses by one student(not api)
    public static function courseListByStudent($student_id)
    {
        $c_list = CourseStudent::where('student_id', '=', $student_id);
        return [
            'list' => $c_list->get(),
            'count' => $c_list->count()
        ];
    }
}
