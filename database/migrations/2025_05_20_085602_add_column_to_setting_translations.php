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
        Schema::table('setting_translations', function (Blueprint $table) {
            $table->string("address")->nullable()->after("footer_description2");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setting_translations', function (Blueprint $table) {
            $table->dropColumn("address");
        });
    }
};
