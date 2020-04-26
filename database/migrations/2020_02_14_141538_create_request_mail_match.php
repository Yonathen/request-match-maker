<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestMailMatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
+-----------+-------------+------+-----+------------+----------------+
| Field     | Type        | Null | Key | Default    | Extra          |
+-----------+-------------+------+-----+------------+----------------+
| ID        | int(11)     | NO   | PRI | NULL       | auto_increment |
| Date      | date        | YES  |     | 0000-00-00 |                |
| Status    | varchar(50) | YES  |     | NULL       |                |
| Type      | varchar(10) | YES  |     | NULL       |                |
| RequestID | int(11)     | YES  |     | NULL       |                |
| UserID    | int(11)     | YES  |     | NULL       |                |
| ExtID     | int(11)     | YES  |     | NULL       |                |
+-----------+-------------+------+-----+------------+----------------+

        */
        Schema::create('request_mail_match', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->enum('status', ['New', 'Viewed', 'Archived']);
            $table->enum('type', ['Match', 'Shared', 'Imported']);
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shared_by')->nullable();

            $table->foreign('request_id')->references('id')->on('request');
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
        Schema::dropIfExists('request_mail_match');
    }
}
