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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $this->addGeneralFields($table);
            $table->timestamps();
        });
        Schema::create('work_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->longText('description');
            $table->longText('meta_description')->nullable();
            $table->text('classification')->nullable();
            $table->softDeletes();
            $table->unique(['work_id', 'locale']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_translations');
        Schema::dropIfExists('works');
    }
};
