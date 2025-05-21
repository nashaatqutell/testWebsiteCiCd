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
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            $table->string("slug")->nullable();
            $table->string("page_name")->nullable();
            $this->addGeneralFields($table);
            $table->timestamps();
        });
        Schema::create("seo_translations", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("seo_id");
            $table->foreign("seo_id")->references("id")->on("seos")->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("locale");
            $table->string("meta_name")->nullable();
            $table->longText("meta_description")->nullable();
            $table->longText("meta_keywords")->nullable();
            $table->unique(["seo_id", "locale"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_translations');
        Schema::dropIfExists('seos');
    }
};
