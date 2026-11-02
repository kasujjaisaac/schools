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
        Schema::create('education_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employer_name')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('location')->nullable();
            $table->text('description');
            $table->text('qualifications')->nullable();
            $table->text('application_instructions')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();
            $table->index(['status', 'deadline']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_jobs');
    }
};
