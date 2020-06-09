<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * 學生建立
     *
     * @param  \Illuminate\Http\Request  $request
     * number: 編號
     * name: 名稱
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'number' => 'required|string',
            'name' => 'required|string'
        ]);
        $student = Student::create($request->all());
        return response()->json(
            ['data' => $student],
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * 判斷學生是否已選課，未選課可以刪除
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //need to search which crouse is book
        $c_list = CourseStudentController::courseListByStudent($student->id);
        if ($c_list['count'] > 0) {
            return response()->json(
                ['error' => '此學生有參與課程，無法刪除'],
                422
            );
        }
        $student->delete();
        return response()->json([], 204);
    }
}
