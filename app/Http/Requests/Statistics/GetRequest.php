<?php

namespace App\Http\Requests\Statistics;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class GetRequest extends Request
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
            'businessId' => [
                'required',
                'integer',
                Rule::exists('businesses','id'),
            ],
        ];
    }
}
