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
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $this->addGeneralFields($table);
            $table->string('slug')->unique();
            $table->timestamps();
        });
        Schema::create('static_page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('static_page_id')->constrained('static_pages')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->longText('description');
            $table->longText('meta_description')->nullable();
            $table->softDeletes();
            $table->unique(['static_page_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('static_page_translations');
        Schema::dropIfExists('static_pages');
    }
};
