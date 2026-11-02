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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('provider');
            $table->text('description');
            $table->string('eligible_level')->nullable();
            $table->text('eligibility')->nullable();
            $table->string('funding_type')->nullable();
            $table->date('opening_date')->nullable();
            $table->date('deadline')->nullable();
            $table->string('application_url')->nullable();
            $table->string('status')->default('published');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->index(['status', 'deadline']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
