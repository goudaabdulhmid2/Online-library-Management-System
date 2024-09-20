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
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('title',255)->nullable(false);
            $table->string('author',255)->nullable(false);
            $table->text('description');
            $table->unsignedBigInteger('genre_id');
            $table->integer('quantity')->default(0)->check('quantity >= 0');


            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');

             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
