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
        Schema::create('income', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('finance_category')->onDelete('restrict');
            $table->string('customer', 25);
            $table->decimal('amount', 15);
            $table->decimal('gyro_cash', 15);
            $table->date('date_entry');
            $table->string('description', 255);
            $table->date('date_factur');
            $table->integer('no_factur',17);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income');
    }
};
