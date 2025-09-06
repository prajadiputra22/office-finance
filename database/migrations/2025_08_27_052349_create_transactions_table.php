<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // contoh: 'giro' / 'cash'
            $table->string('customer')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('gyro_cash')->nullable();
            $table->date('date_entry')->nullable();
            $table->text('description')->nullable();
            $table->date('date_factur')->nullable();
            $table->string('no_factur')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
