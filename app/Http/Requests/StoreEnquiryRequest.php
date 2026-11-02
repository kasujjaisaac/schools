<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'programme_id' => ['nullable', 'exists:programmes,id'],
            'admission_intake_id' => ['nullable', 'exists:admission_intakes,id'],
            'name' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
            'preferred_contact_method' => ['required', 'in:phone,email,whatsapp'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
