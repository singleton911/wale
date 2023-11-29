<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'public_name' => ['required', 'string', 'min:3', 'max:20', 'unique:users,public_name',  'not_in:whale,whales,test,osint,mod,admin,automod'],
            'private_name' => 'required|string|min:3|max:20|unique:users,private_name|not_in:whale,whales,test,osint,mod,admin,automod',
            'login_passphrase' => 'required|string|min:3|max:20',
            'pin_code' => 'required|integer|min:6',
            'referral_link' => ['sometimes', 'string',
            Rule::exists('users', 'public_name')->where(function ($query) {
                $query->orWhereExists(function ($subQuery) {
                    $subQuery->select('store_name')
                        ->from('stores');
                });
            }), 'nullable'],
            'password' => 'required|min:8|max:128|regex:/^(?=.*[a-zA-Z\d])(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
        ];
    }
}
