<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestMatchMaker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    /*
+----------+--------------+------+-----+---------+----------------+
| Field    | Type         | Null | Key | Default | Extra          |
+----------+--------------+------+-----+---------+----------------+
| ID       | int(11)      | NO   | PRI | NULL    | auto_increment |
| Title    | varchar(250) | NO   |     | NULL    |                |
| Keywords | text         | YES  |     | NULL    |                |
| Location | text         | NO   |     | NULL    |                |
| UserID   | int(11)      | YES  |     | NULL    |                |
+----------+--------------+------+-----+---------+----------------+

    */
        Schema::create('request_match_maker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title', 250);
            $table->json('keywords');
            $table->json('location');
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
        Schema::dropIfExists('request_match_maker');
    }
}
