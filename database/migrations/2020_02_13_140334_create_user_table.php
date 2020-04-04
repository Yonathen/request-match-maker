<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Role;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user');
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name', 200);
            $table->string('account_created_by', 200)->nullable();
            $table->timestamp('account_created_on')->nullable();
            $table->string('logo', 200)->nullable();
            $table->string('established_by', 20)->nullable();
            $table->enum('role', [Role::USER, Role::ADMIN])->default(Role::USER);
            $table->timestamp('established_on')->nullable();
            $table->json('representative')->nullable();
            $table->json('service')->nullable();
            $table->json('address')->nullable();
            $table->json('slides')->nullable();
            $table->json('contacts')->nullable();
            $table->json('notifications')->nullable();
            $table->string('email')->unique();
            $table->unsignedBigInteger('email_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verification_token');
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->string('website', 254)->nullable();
            $table->string('language', 30)->nullable();
            $table->enum('account_status', ['Active', 'Blocked', 'Suspended', 'PendingConfirmation'])->default('PendingConfirmation');
            $table->json('blocked_accounts')->nullable();
            $table->enum('gender', ['Male', 'Female'])->default('Male');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
