<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->text('duties')->nullable();
            $table->text('skills')->nullable();
            $table->text('recommended_subjects')->nullable();
            $table->text('education_pathway')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();
        });

        Schema::create('career_programme', function (Blueprint $table) {
            $table->foreignId('career_id')->constrained()->cascadeOnDelete();
            $table->foreignId('programme_id')->constrained()->cascadeOnDelete();
            $table->primary(['career_id', 'programme_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_programme');
        Schema::dropIfExists('careers');
    }
};
