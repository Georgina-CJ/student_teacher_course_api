<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('課程名稱');
            $table->enum('status', ['preparation', 'started']);
            $table->unsignedInteger('teacher_id')->comment('授課老師');
            $table->foreign('teacher_id')->references('id')->on('teachers');
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
        Schema::dropIfExists('courses', function (Blueprint $table) {
            $table->dropForeign('courses_teacher_id_foreign');
            $table->dropColumn('teacher_id');
        });
    }
}
