<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
/*
+--------+--------------+------+-----+---------+----------------+
| Field  | Type         | Null | Key | Default | Extra          |
+--------+--------------+------+-----+---------+----------------+
| ID     | int(11)      | NO   | PRI | NULL    | auto_increment |
| Image  | varchar(100) | NO   |     | NULL    |                |
| Link   | text         | NO   |     | NULL    |                |
| UserID | int(11)      | NO   |     | NULL    |                |
+--------+--------------+------+-----+---------+----------------+
*/
        Schema::create('user_ad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('image', 250);
            $table->text('link');
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
        Schema::dropIfExists('user_ad');
    }
}
