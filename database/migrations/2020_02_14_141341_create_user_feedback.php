<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFeedback extends Migration
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
| Subject | varchar(200) | NO   |     | NULL    |                |
| Date    | varchar(20)  | NO   |     | NULL    |                |
| Content | text         | NO   |     | NULL    |                |
| UserID  | int(11)      | NO   |     | NULL    |                |
+---------+--------------+------+-----+---------+----------------+
*/
        Schema::create('user_feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('date');
            $table->string('subject', 250);
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
        Schema::dropIfExists('user_feadback');
    }
}
