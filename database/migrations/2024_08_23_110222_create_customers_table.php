<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('customers', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('managing_director');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
        });

        // Setze den Startwert der Auto-Inkrement-Spalte auf 123456
        DB::statement("ALTER TABLE customers AUTO_INCREMENT = 654321;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('customers');
    }
};
