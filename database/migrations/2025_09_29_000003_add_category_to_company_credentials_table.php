<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('company_credentials', function (Blueprint $table) {
            $table->string('category')->nullable()->after('company_slug');
        });
    }

    public function down(): void
    {
        Schema::table('company_credentials', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
