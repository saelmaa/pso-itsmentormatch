<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('goals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->string('mentor_name')->nullable();
        $table->string('deadline')->nullable();
        $table->integer('sessions_completed')->default(0);
        $table->integer('target_sessions')->default(1);
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
