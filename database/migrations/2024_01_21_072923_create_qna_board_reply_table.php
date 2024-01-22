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
        Schema::create('qna_board_reply', function (Blueprint $table) {
            $table->id('idx');
            $table->text('contents')->comment('내용');
            $table->integer('choice_status')->default(1)->comment('1=미채택, 2=채택');
            $table->bigInteger('rel_board_idx')->comment('원글 idx');
            $table->bigInteger('user_idx')->comment('답변자 idx');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qna_board_reply');
    }
};
