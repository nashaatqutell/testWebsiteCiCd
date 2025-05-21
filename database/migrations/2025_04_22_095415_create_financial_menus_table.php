<?php

use App\Traits\MigrationTrait;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    use MigrationTrait;
    public function up(): void
    {
        Schema::create('financial_menus', function (Blueprint $table) {
            $table->id();
            $table->string('year')->nullable();
            $this->addGeneralFields($table);
            $table->timestamps();
        });

        Schema::create('financial_menus_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('locale')->index();
            $table->unsignedBigInteger('financial_menu_id');
            $table->foreign('financial_menu_id')->references('id')->on('financial_menus')->onDelete('cascade');
            $table->unique(['financial_menu_id', 'locale']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_menus');
    }
};
