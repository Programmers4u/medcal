<?php

namespace App\Http\Requests\Datasets;

use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CreateRequest extends Request
{
    public $error;
    
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

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            $this->errors = $validator->errors();
        }
    }

}
