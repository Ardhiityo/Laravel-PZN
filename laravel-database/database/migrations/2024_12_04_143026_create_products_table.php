<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string("id", 20)
                ->nullable(false)
                ->primary();
            $table->string("name", 20)
                ->nullable(true);
            $table->text("description")
                ->nullable(true);
            $table->integer("price")
                ->nullable(true);
            $table->string("category_id", 20)
                ->nullable(true);
            $table->timestamp("created_at")
                ->nullable(false)
                ->useCurrent();

            $table->foreign("category_id")
                ->references("id")
                ->on("categories");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
