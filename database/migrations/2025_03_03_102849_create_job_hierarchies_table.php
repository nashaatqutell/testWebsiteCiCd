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
        Schema::create('job_hierarchies', function (Blueprint $table) {
            $table->id();
            $table->foreignId("parent_id")->nullable()->constrained("job_hierarchies")
                ->nullOnDelete();
            $this->addGeneralFields($table);
            $table->timestamps();
        });

        Schema::create('job_hierarchy_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('locale')->index();
            $table->unsignedBigInteger('job_hierarchy_id')->nullable();
            $table->foreign('job_hierarchy_id')->references('id')->on('job_hierarchies')->onDelete('cascade');
            $table->unique(['job_hierarchy_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_hierarchies');
    }
};
