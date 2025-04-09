<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('material_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_resources');
    }
};
