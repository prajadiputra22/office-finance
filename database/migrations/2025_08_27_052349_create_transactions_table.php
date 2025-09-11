<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expenditure']);
            $table->foreignId('category_id')->constrained('category')->onDelete('restrict');
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->date('date_factur');
            $table->integer('no_factur');
            $table->string('description', 255)->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
