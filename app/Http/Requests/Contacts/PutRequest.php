<?php

namespace App\Http\Requests\Contacts;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class PutRequest extends Request
{
    public $error;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $authorize = auth()->user();
        // return $authorize;
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
            0  => 'required',
            'businessId' => [
                'required',
                Rule::exists('businesses','id'),
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            $this->errors = $validator->errors();
        }
    }

}
