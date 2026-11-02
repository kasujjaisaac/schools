<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInstitutionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['sometimes', 'nullable', 'string', 'max:255', Rule::unique('institutions', 'slug')->ignore($this->route('institution'))],
            'short_name' => ['nullable', 'string', 'max:80'],
            'tagline' => ['nullable', 'string', 'max:160'],
            'institution_category_id' => ['sometimes', 'required', 'exists:institution_categories,id'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'education_level_ids' => ['array'],
            'education_level_ids.*' => ['integer', 'exists:education_levels,id'],
            'ownership' => ['nullable', Rule::in(['Government', 'Private', 'Community', 'Faith-based'])],
            'gender_type' => ['nullable', Rule::in(['Mixed', 'Girls', 'Boys'])],
            'boarding_type' => ['nullable', Rule::in(['Day', 'Boarding', 'Day and boarding'])],
            'established_year' => ['nullable', 'integer', 'between:1800,2100'],
            'description' => ['nullable', 'string', 'max:5000'],
            'mission' => ['nullable', 'string', 'max:2000'],
            'vision' => ['nullable', 'string', 'max:2000'],
            'logo_url' => ['nullable', 'url', 'max:2048'],
            'cover_image_url' => ['nullable', 'url', 'max:2048'],
            'primary_color' => ['sometimes', 'required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['sometimes', 'required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'accent_color' => ['sometimes', 'required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'telephone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:2048'],
            'whatsapp' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'is_verified' => [Rule::prohibitedIf(! $this->user()?->isAdministrator()), 'boolean'],
            'is_featured' => [Rule::prohibitedIf(! $this->user()?->isAdministrator()), 'boolean'],
            'status' => [Rule::prohibitedIf(! $this->user()?->isAdministrator()), 'sometimes', 'required', Rule::in(['draft', 'pending', 'published', 'archived'])],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
