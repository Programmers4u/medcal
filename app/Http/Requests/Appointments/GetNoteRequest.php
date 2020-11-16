<?php

namespace App\Http\Requests\Appointments;

use App\Http\Requests\Request;

class GetNoteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authorize = auth()->user();

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
            'appointmentId'    => 'nullable|integer',
            'businessId' => 'required|integer',
            'contactId' => 'required|integer'
        ];
    }
}
