<?php

use App\Traits\MigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use MigrationTrait;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $this->addGeneralFields($table);
            $table->timestamps();
        });
        Schema::create('hero_section_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_section_id')->constrained('hero_sections')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->longText('sub_description')->nullable();
            $table->longText('description')->nullable();
            $table->softDeletes();
            $table->unique(['hero_section_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_section_translations');
        Schema::dropIfExists('hero_sections');
    }
};
