<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('receipt_categories')->nullOnDelete();
            $table->foreignId('scanned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('receipt_number', 100);
            $table->timestamp('date');
            $table->timestamp('scan_time')->nullable();
            $table->string('place')->nullable();
            $table->string('shop')->nullable();
            $table->string('bank')->nullable();
            $table->decimal('change', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('payment_type', 50)->nullable();
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('tax_pct', 5, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_enhanced_scan')->default(false);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
