<?php

use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('contracts', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('monthly_costs', 8, 2)->default(0);
            $table->boolean('flatrate')->default(false);
            $table->timestamps();
        });

        Schema::create('contract_customer', function(Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Contract::class)->constrained()->cascadeOnDelete();
            $table->date('create_date');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        // Setze den Startwert der Auto-Inkrement-Spalte auf 123456
        DB::statement("ALTER TABLE contract_customer AUTO_INCREMENT = 98765432;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('contract_customer');
    }
};
