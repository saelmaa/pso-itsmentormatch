<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('department');
            $table->text('expertise');
            $table->text('bio')->nullable();
            $table->integer('experience_years')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_sessions')->default(0);
            $table->integer('total_reviews')->default(0);
            $table->enum('availability_status', ['available', 'busy', 'offline'])->default('available');
            $table->json('skills')->nullable();
            $table->string('location')->nullable();
            $table->string('price')->default('Free');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mentors');
    }
};