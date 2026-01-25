<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('metal_type', ['Gold', 'Silver', 'Platinum']);
            $table->string('purity')->nullable(); // 18K, 22K
            $table->decimal('weight', 10, 3); // grams
            $table->decimal('making_charges', 10, 2)->default(0);
            $table->decimal('gst_percentage', 5, 2)->default(3); // 3% typical
            $table->decimal('price', 12, 2);
            $table->integer('stock_quantity')->default(0);
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('image')->nullable();
            $table->timestamps();
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
