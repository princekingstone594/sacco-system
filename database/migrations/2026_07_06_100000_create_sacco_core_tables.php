<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_no')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('national_id')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('employer')->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->date('joined_at');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('account_no')->unique();
            $table->string('type');
            $table->decimal('balance', 14, 2)->default(0);
            $table->date('opened_at');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type');
            $table->decimal('amount', 14, 2);
            $table->string('reference')->nullable();
            $table->date('transacted_at');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('loan_products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('interest_rate', 5, 2);
            $table->unsignedInteger('term_months');
            $table->decimal('minimum_amount', 14, 2)->default(0);
            $table->decimal('maximum_amount', 14, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('loan_product_id')->constrained()->restrictOnDelete();
            $table->string('loan_no')->unique();
            $table->decimal('principal', 14, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->unsignedInteger('term_months');
            $table->decimal('total_payable', 14, 2);
            $table->decimal('balance', 14, 2);
            $table->date('issued_on');
            $table->date('due_on');
            $table->string('status')->default('active');
            $table->text('purpose')->nullable();
            $table->timestamps();
        });

        Schema::create('loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('amount', 14, 2);
            $table->string('reference')->nullable();
            $table->date('paid_on');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_repayments');
        Schema::dropIfExists('loans');
        Schema::dropIfExists('loan_products');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('members');
    }
};
