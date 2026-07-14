<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // 0 - kitap belgilew, 1 - testke tayin, 2 - test baslangan, 3 - test juwmaqlangan
            $table->enum('status', ['0', '1', '2', '3', '4'])->default('0');
            $table->timestamp('finished_at')->nullable();
            $table->double('score')->default(0);
            $table->integer('downloads')->default(1);
            $table->integer('checks')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
