<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name');
            $table->string('email')->unique(); // Ensures the email is unique
            $table->string('phone')->unique(); // Phone number as unique
            $table->text('description')->nullable(); // Longer text, can be null
            $table->unsignedBigInteger('role_id'); // Role ID should be numeric and unsigned
            $table->string('profile_image')->nullable(); // Allow null for profile image
            $table->timestamps(); // Created_at and updated_at timestamps

            // Optional: Add foreign key constraint for role_id
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
