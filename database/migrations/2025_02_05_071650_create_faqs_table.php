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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $this->addGeneralFields($table);
            $table->timestamps();
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('answer');
            $table->string('locale');
            $table->unsignedBigInteger('faq_id');
            $table->foreign('faq_id')->references('id')->on('faqs')->onDelete('cascade');
            $table->unique(['faq_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faqs');
    }
};
