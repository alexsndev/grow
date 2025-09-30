<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('company_slug');
            $table->string('label'); // ex: Painel Financeiro
            $table->string('username');
            $table->text('password_encrypted');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('company_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_credentials');
    }
};
