<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
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
            // 'product_id' => 'required|integer',
            // 'quantity' => 'required|integer|min:1',
            // 'extra_option_id' => 'sometimes|integer|min:1',
            // 'note'     => 'sometimes|nullable',
        ];
    }
}
