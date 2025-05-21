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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $this->addGeneralFields($table);
            $table->timestamps();
        });
        Schema::create('slider_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_id')->constrained('sliders')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->longText('description');
            $table->softDeletes();
            $table->unique(['slider_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_translations');
        Schema::dropIfExists('sliders');
    }
};
