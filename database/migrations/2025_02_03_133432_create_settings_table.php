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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("phone2")->nullable();
            $table->string("support_phone")->nullable();
            $table->string("location")->nullable();
            $table->string("facebook")->nullable();
            $table->string("x")->nullable();
            $table->string("instagram")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("youtube")->nullable();
            $table->string("tiktok")->nullable();
            $this->addGeneralFields($table);
            $table->timestamps();
        });

        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained('settings')->cascadeOnDelete();
            $table->string("name")->nullable();
            $table->longText("description")->nullable();
            $table->longText("notes_and_suggestions")->nullable();
            $table->longText("footer_description")->nullable();
            $table->longText("footer_description2")->nullable();
            $table->string('locale')->index();
            $table->unique(['setting_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_translations');
        Schema::dropIfExists('settings');
    }
};
