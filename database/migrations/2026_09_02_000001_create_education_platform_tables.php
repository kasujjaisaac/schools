<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('institution_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('district');
            $table->timestamps();
            $table->index(['parent_id', 'type']);
        });

        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_name')->nullable();
            $table->string('tagline')->nullable();
            $table->foreignId('institution_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ownership')->nullable();
            $table->string('gender_type')->nullable();
            $table->string('boarding_type')->nullable();
            $table->unsignedSmallInteger('established_year')->nullable();
            $table->text('description')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->string('primary_color')->default('#176b5b');
            $table->string('secondary_color')->default('#f2b84b');
            $table->string('accent_color')->default('#e96d4c');
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('published');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'is_featured']);
            $table->index(['institution_category_id', 'location_id']);
        });

        Schema::create('institution_education_level', function (Blueprint $table) {
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->foreignId('education_level_id')->constrained()->cascadeOnDelete();
            $table->primary(['institution_id', 'education_level_id']);
        });

        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('field')->nullable();
            $table->string('qualification')->nullable();
            $table->string('duration')->nullable();
            $table->text('description')->nullable();
            $table->text('career_prospects')->nullable();
            $table->timestamps();
            $table->index(['field', 'qualification']);
        });

        Schema::create('institution_programme', function (Blueprint $table) {
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->foreignId('programme_id')->constrained()->cascadeOnDelete();
            $table->string('requirements')->nullable();
            $table->string('study_mode')->nullable();
            $table->boolean('is_active')->default(true);
            $table->primary(['institution_id', 'programme_id']);
        });

        Schema::create('admission_intakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('academic_year')->nullable();
            $table->date('opening_date')->nullable();
            $table->date('closing_date')->nullable();
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->string('application_url')->nullable();
            $table->string('status')->default('open');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->index(['status', 'closing_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_intakes');
        Schema::dropIfExists('institution_programme');
        Schema::dropIfExists('programmes');
        Schema::dropIfExists('institution_education_level');
        Schema::dropIfExists('institutions');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('institution_categories');
        Schema::dropIfExists('education_levels');
    }
};
