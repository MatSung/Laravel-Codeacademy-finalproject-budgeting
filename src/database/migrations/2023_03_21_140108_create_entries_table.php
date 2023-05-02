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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->dateTime('transaction_date');
            $table->foreignId('category_id')->constrained('entry_categories')->restrictOnDelete();
            $table->foreignId('subcategory_id')->nullable()
                ->constrained('entry_subcategories')->nullOnDelete(); 
            $table->float('amount', 10, 2);
            $table->string('note', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
