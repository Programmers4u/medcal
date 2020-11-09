<?php

namespace App\Http\Requests\MedicalTemplate;

use App\Http\Requests\Request;
use App\Models\MedicalTemplates;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class DeleteRequest extends Request
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
            'id' => [
                'required',
                Rule::exists(MedicalTemplates::TABLE, MedicalTemplates::ID),
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
