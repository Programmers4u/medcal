<?php

namespace App\Http\Requests\Statistics;

use App\Http\Requests\Request;

class PutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authorize = auth()->user();

        // logger()->info("Authorize:$authorize");

        return $authorize;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'businessId'  => 'required|integer',
        ];
    }
}
