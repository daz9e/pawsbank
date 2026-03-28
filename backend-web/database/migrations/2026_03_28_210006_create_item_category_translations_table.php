<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_category_id')->constrained()->cascadeOnDelete();
            $table->char('locale', 5);
            $table->string('name', 100);

            $table->unique(['item_category_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_category_translations');
    }
};
