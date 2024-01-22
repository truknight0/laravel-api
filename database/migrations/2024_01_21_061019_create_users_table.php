<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('idx');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('user_type')->comment('품종');
            $table->integer('age')->comment('나이');
            $table->integer('user_level')->default(1)->comment('1=멘티, 2=멘토');
            $table->string('join_sns_type')->nullable()->comment('kakao, google, facebook, etc...');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
