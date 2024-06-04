<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UptimeSettingRequest extends FormRequest
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
            "app_name" => ["string", "nullable"],
            "check_per_minute" => ["required", "numeric"],
            "notification_type" => ["required", Rule::in(["email", "sms"])]
        ];
    }
}
