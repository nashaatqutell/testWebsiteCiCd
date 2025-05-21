<?php

use App\Traits\MigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    use MigrationTrait;
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string("price")->nullable();
            $table->integer("discount_percent")->default(0);
            $this->addGeneralFields($table);
            $table->timestamps();
        });
        Schema::create('offer_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->string("description")->nullable();
            $table->unique(['offer_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_translations');
        Schema::dropIfExists('offers');
    }
};
