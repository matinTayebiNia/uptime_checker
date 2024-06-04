<?php

namespace App\Http\Requests\website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWebsiteRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ["nullable", "string", "max:225"],
            "url" => ["required", Rule::unique("websites")->ignore($this->route("website"))]
        ];
    }
}
