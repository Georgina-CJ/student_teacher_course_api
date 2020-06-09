<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->comment('課程id');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->unsignedInteger('student_id')->comment('學生id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_students', function (Blueprint $table) {
            $table->dropForeign('courses_students_course_id_foreign');
            $table->dropColumn('course_id');
            $table->dropForeign('courses_students_student_id_foreign');
            $table->dropColumn('student_id');
        });
    }
}
