<?php

namespace App\Http\Requests\website;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebsiteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            "name" => ["nullable", "string", "max:225"],
            "url" => ["required", "unique:websites"],
            "date_check" => ["required", "date_format:h:i"]
        ];
    }
}
