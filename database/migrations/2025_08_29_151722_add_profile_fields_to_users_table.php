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
            $table->text('bio')->nullable()->after('avatar');
            $table->string('location')->nullable()->after('bio');
            $table->string('website')->nullable()->after('location');
            $table->string('phone')->nullable()->after('website');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->integer('profile_views')->default(0)->after('date_of_birth');
            $table->boolean('is_private')->default(false)->after('profile_views');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'location',
                'website',
                'phone',
                'date_of_birth',
                'profile_views',
                'is_private'
            ]);
        });
    }
};
