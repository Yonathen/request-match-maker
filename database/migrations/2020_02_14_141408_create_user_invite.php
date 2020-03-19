<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInvite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
+--------------+---------+------+-----+---------+----------------+
| Field        | Type    | Null | Key | Default | Extra          |
+--------------+---------+------+-----+---------+----------------+
| ID           | int(11) | NO   | PRI | NULL    | auto_increment |
| invited_by   | text    | NO   |     | NULL    |                |
| invited_to   | text    | NO   |     | NULL    |                |
| invited_date | date    | NO   |     | NULL    |                |
+--------------+---------+------+-----+---------+----------------+
        */
        Schema::create('user_invite', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('invited_date');
            $table->text('invited_to');
            $table->unsignedBigInteger('invited_by');
            
            $table->foreign('invited_by')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_invite');
    }
}
