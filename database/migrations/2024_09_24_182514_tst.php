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
        Schema::create('tst', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('track_id')->default(null)->nullable();
            $table->string('isrc', 20)->default(null)->nullable();
            $table->unsignedBigInteger('track_external_id')->default(null)->nullable();
            $table->unsignedBigInteger('album_id')->default(null)->nullable();
            $table->unsignedBigInteger('album_external_id')->default(null)->nullable();
            $table->text('title')->default(null)->nullable();
            $table->text('version')->default(null)->nullable();
            $table->text('artist')->default(null)->nullable();
            $table->text('album')->default(null)->nullable();
            $table->string('file', 200)->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tst');
    }
};
