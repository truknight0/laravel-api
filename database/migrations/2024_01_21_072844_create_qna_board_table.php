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
        Schema::create('qna_board', function (Blueprint $table) {
            $table->id('idx');
            $table->string('title')->comment('제목');
            $table->text('contents')->comment('내용');
            $table->bigInteger('user_idx')->comment('작성자 idx');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qna_board');
    }
};
