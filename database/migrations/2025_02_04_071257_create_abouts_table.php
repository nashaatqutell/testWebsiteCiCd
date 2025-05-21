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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $this->addGeneralFields($table);
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('about_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('about_id');
            $table->string('locale');
            $table->string('name');
            $table->text('description');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->timestamps();

            $table->foreign('about_id')->references('id')->on('abouts')->onDelete('cascade');
            $table->unique(['about_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_translations');
        Schema::dropIfExists('abouts');
    }
};
