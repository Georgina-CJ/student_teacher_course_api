<?php

namespace App\Http\Controllers;

use App\Teacher;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeacherController extends Controller
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
     * 老師建立
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
        $teacher = Teacher::create($request->all());
        return response()->json(
            ['data' => $teacher],
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * 判別老師是否還有授課，如零授課可刪除
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //need to search which crouse he teach
        $c_count = Course::where('teacher_id', '=', $teacher->id)->count();
        if ($c_count > 0) {
            return response()->json(
                ['error' => '此老師還授課，無法刪除'],
                422
            );
        }
        $teacher->delete();
        return response()->json([], 204);
    }
}
