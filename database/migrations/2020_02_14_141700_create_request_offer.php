<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    /*
+-----------------+-------------+------+-----+---------+----------------+
| Field           | Type        | Null | Key | Default | Extra          |
+-----------------+-------------+------+-----+---------+----------------+
| ID              | int(11)     | NO   | PRI | NULL    | auto_increment |
| Date            | varchar(60) | YES  |     | NULL    |                |
| OfferNo         | int(5)      | YES  |     | NULL    |                |
| Price           | varchar(9)  | YES  |     | NULL    |                |
| Currency        | varchar(5)  | YES  |     | NULL    |                |
| MessageExchange | text        | YES  |     | NULL    |                |
| Status          | varchar(20) | YES  |     | NULL    |                |
| RequestID       | int(11)     | YES  |     | NULL    |                |
| UserID          | int(11)     | YES  |     | NULL    |                |
+-----------------+-------------+------+-----+---------+----------------+
    */
        Schema::create('request_offer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->dateTime('date_time', 0);
            $table->unsignedBigInteger('offer_no');
            $table->string('price', 9);
            $table->string('currency', 5);
            $table->json('message_exchange');
            $table->enum('status', ['New', 'Viewed', 'Selected', 'Rejected', 'Awarded']);
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('user_id');

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
        Schema::dropIfExists('request_offer');
    }
}
