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
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        // Łączymy komentarz z użytkownikiem, który go napisał
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Łączymy komentarz z postem, którego dotyczy
        $table->foreignId('post_id')->constrained()->onDelete('cascade');
        // Treść komentarza
        $table->text('content');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
