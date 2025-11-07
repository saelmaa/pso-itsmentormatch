<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained()->onDelete('cascade');
            $table->string('topic');
            $table->text('description')->nullable();
            $table->date('session_date');
            $table->time('session_time');
            $table->integer('duration')->default(60); // in minutes
            $table->enum('type', ['video_call', 'in_person', 'phone'])->default('video_call');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};