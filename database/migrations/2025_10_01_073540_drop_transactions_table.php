<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop table transactions kalau ada
        Schema::dropIfExists('transactions');
    }

    public function down(): void
    {
        // Kosong saja, karena rollback tidak akan mengembalikan tabel
        // Bisa juga dibuat ulang kalau memang diperlukan
    }
};

