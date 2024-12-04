<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->string("id", 20)
                ->nullable(false)
                ->primary();
            $table->string("name", 50)
                ->nullable(true);
            $table->text("description")
                ->nullable(true);
            $table->timestamp("created_at")
                ->nullable(false)
                ->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
