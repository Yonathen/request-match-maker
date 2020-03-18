<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPartner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
+-------------+-------------+------+-----+------------+----------------+
| Field       | Type        | Null | Key | Default    | Extra          |
+-------------+-------------+------+-----+------------+----------------+
| ID          | int(11)     | NO   | PRI | NULL       | auto_increment |
| RequestedBy | int(11)     | NO   |     | NULL       |                |
| ConfirmedBy | int(11)     | NO   |     | NULL       |                |
| Date        | date        | YES  |     | 0000-00-00 |                |
| Status      | varchar(20) | NO   |     | NULL       |                |
+-------------+-------------+------+-----+------------+----------------+

        */
        Schema::create('user_partner', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('date');
            $table->enum('status', ['Confirmed', 'Pending', 'Blocked']);
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('confirmed_by');
            
            $table->foreign('requested_by')->references('id')->on('user');
            $table->foreign('confirmed_by')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_partner');
    }
}
