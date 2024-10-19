<?php

use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('contracts', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('hours')->nullable();
            $table->decimal('monthly_costs', 8, 2)->nullable();
            $table->boolean('flatrate')->default(false);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        Schema::create('contract_customer', function(Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Contract::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('contract_customer');
    }
};
