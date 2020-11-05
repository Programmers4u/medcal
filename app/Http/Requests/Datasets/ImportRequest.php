<?php

namespace App\Http\Requests\Datasets;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
class ImportRequest extends Request
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
            0  => 'required',
        ];

    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            $this->errors = $validator->errors();

        }
    }
}
