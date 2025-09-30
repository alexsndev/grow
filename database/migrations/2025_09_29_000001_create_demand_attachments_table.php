<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demand_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demand_id')->constrained('demands')->cascadeOnDelete();
            $table->string('path'); // relative path in public disk
            $table->string('original_name');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size')->nullable(); // bytes
            $table->timestamps();
            $table->index('demand_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demand_attachments');
    }
};
