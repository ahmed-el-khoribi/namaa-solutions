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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('approver_id')->nullable(); // Admin user
            $table->string('title');
            $table->text('content');
            $table->enum('status', ['PENDING_APPROVAL', 'PUBLISHED'])->default('PENDING_APPROVAL');
            $table->date('published_at')->nullable();
            $table->timestamps();

            // Relations
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('approver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
