<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reference' => 'string|required',
            'amountInCents' => 'integer|required',
            'currency' => 'string|required|max:2|in:' . implode(',', config('unpay.supported_currencies')),
            'country' => 'string|required|max:2|in:' . implode(',', config('unpay.supported_countries_alpha_2')),
            'returnUrl' => 'active_url|required'
        ];
    }
}
