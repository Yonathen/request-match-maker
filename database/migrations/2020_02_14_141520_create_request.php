<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\RequestStatus;

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
            $table->string('title', 250);
            $table->json('images')->nullable();
            $table->text('what');
            $table->json('where');
            $table->dateTimeTz('when', 0);
            $table->string('who', 250);
            $table->enum('status', [
                RequestStatus::OPEN, 
                RequestStatus::CLOSED
            ])->default(RequestStatus::OPEN);
            $table->boolean('edited')->default(false);
            $table->unsignedBigInteger('views')->default(0);
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
