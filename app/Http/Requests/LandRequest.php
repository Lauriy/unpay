<?php

namespace App\Http\Requests;

class LandRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // http://localhost:8000/?reference=a1&amountInCents=9999&currency=USD&country=SV&callbackUrl=http://localhost:8000/return
        return [
            'reference' => 'string|required',
            'amountInCents' => 'integer|required',
            'currency' => 'string|required|max:3|in:' . implode(',', config('unpay.supported_currencies')),
            'country' => 'string|required|max:2|in:' . implode(',', config('unpay.supported_countries_alpha_2')),
            # TODO: Consider using active_url
            'callbackUrl' => 'url|required'
        ];
    }
}
