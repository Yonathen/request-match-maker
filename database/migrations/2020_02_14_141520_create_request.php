<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
+-------------+-------------+------+-----+---------+----------------+
| Field       | Type        | Null | Key | Default | Extra          |
+-------------+-------------+------+-----+---------+----------------+
| ID          | int(11)     | NO   | PRI | NULL    | auto_increment |
| Title       | text        | YES  |     | NULL    |                |
| Image       | text        | YES  |     | NULL    |                |
| What        | text        | YES  |     | NULL    |                |
| Where       | text        | YES  |     | NULL    |                |
| When        | text        | YES  |     | NULL    |                |
| Who         | text        | YES  |     | NULL    |                |
| PubDateTime | varchar(20) | YES  |     | NULL    |                |
| Status      | varchar(15) | YES  |     | NULL    |                |
| Views       | int(6)      | YES  |     | NULL    |                |
| UserID      | int(11)     | YES  |     | NULL    |                |
+-------------+-------------+------+-----+---------+----------------+

        */
        Schema::create('request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->dateTime('date_time', 0);
            $table->string('subject', 250);
            $table->enum('status', ['OPEN', 'CLOSED', 'NEW_OFFER']);
            $table->text('title');
            $table->text('image');
            $table->json('what');
            $table->text('where');
            $table->text('when');
            $table->text('who');
            $table->unsignedBigInteger('views');
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
        Schema::dropIfExists('request');
    }
}
