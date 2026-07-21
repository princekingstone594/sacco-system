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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullabele();
            $table->string('location')->nullable();
            $table->string('national_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('occupation')->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->text('bio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'location',
                'national_id',
                'date_of_birth',
                'occupation',
                'next_of_kin_name',
                'next_of_kin_phone',
                'bio'
            ]);
        });
    }
};
