<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
/* 
+---------+--------------+------+-----+---------+----------------+
| Field   | Type         | Null | Key | Default | Extra          |
+---------+--------------+------+-----+---------+----------------+
| ID      | int(11)      | NO   | PRI | NULL    | auto_increment |
| Date    | datetime     | NO   |     | NULL    |                |
| Page    | varchar(250) | NO   |     | NULL    |                |
| Content | text         | NO   |     | NULL    |                |
| Status  | varchar(10)  | NO   |     | NULL    |                |
| UserID  | int(11)      | NO   |     | NULL    |                |
+---------+--------------+------+-----+---------+----------------+
*/
        Schema::create('user_activity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('date');
            $table->string('page', 250);
            $table->text('content');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_activity');
    }
}
