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
        Schema::create('saisierjes', function (Blueprint $table) {
            $table->id();
            $table->date('daterje');
            $table->foreignId('engin_id')->constrained('engins');
            $table->foreignId('site_id')->constrained('sites');
            $table->foreignId('panne_id')->constrained('pannes');
            $table->double('hrm')->min(0);
            $table->double('him')->min(0);
            $table->double('nho')->min(0)->max(24)->default(24);
            $table->integer('ni')->min(0);
            $table->timestamps();

            $table->unique(['daterje', 'engin_id', 'panne_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(function (Blueprint $table) {
            $table->dropConstrainedForeignId('engin_id');
        });
        Schema::table(function (Blueprint $table) {
            $table->dropConstrainedForeignId('site_id');
        });
        Schema::table(function (Blueprint $table) {
            $table->dropConstrainedForeignId('panne_id');
        });

        Schema::dropIfExists('saisierjes');
    }
};