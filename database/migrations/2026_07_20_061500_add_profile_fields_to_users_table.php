<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('location')->nullable()->after('phone');
            $table->string('national_id')->nullable()->after('location');
            $table->date('date_of_birth')->nullable()->after('national_id');
            $table->string('occupation')->nullable()->after('date_of_birth');
            $table->string('next_of_kin_name')->nullable()->after('occupation');
            $table->string('next_of_kin_phone')->nullable()->after('next_of_kin_name');
            $table->string('profile_photo_path')->nullable()->after('next_of_kin_phone');
            $table->text('bio')->nullable()->after('profile_photo_path');
        });
    }

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
                'profile_photo_path',
                'bio',
            ]);
        });
    }
};
