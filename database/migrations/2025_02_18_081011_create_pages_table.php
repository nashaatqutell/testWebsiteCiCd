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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $this->addGeneralFields($table);
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('pages_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->longText('meta_description');
            $table->string('locale')->index();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->unique(['page_id', 'locale']);
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('pages_translations');
        Schema::dropIfExists('pages');
    }
};
