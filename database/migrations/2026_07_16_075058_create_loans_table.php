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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')->constrained()->cascadeOnDelete();

            $table->decimal('amount', 12, 2);
            $table->decimal('interest_rate', 5, 2)->default(10); // %
            $table->integer('duration_months');

            $table->decimal('total_payable', 12, 2)->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'active',
                'completed',
                'defaulted'
            ])->default('pending');

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('disbursed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
