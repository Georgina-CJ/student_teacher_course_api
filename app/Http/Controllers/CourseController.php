<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\CourseStudent;

class CourseController extends Controller
{
    /**
     * 查詢全部課程列表
     * limit 回傳資料是否分頁
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer'
        ]);

        //是否分頁
        $limit = isset($request->limit) ? $request->limit:null;
        if (empty($limit)) {
            $courses = Course::get();
        } else {
            $courses = Course::paginate($limit);
        };

        return response(['courses' => $courses], Response::HTTP_OK);
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
     * 課程建立
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'status' => 'required|in:preparation,started',
            'teacherId' => 'required|integer'
        ]);
        $request['teacher_id'] = $request['teacherId'];
        unset($request['teacherId']);
        $course = Course::create($request->all());
        return response($course, Response::HTTP_CREATED);
    }

    /**
     * 查詢單一課程資料
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return response($course, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $this->validate($request, [
            'name' => 'string',
            'status' => 'in:preparation,started',
            'teacherId' => 'integer'
        ]);

        $request['teacher_id'] = $request['teacherId'];
        unset($request['teacherId']);
        $course->update($request->all());
        return response($course, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //need to delete who is book this course
        CourseStudent::where('course_id', '=', $course->id)->delete();
        $course->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
