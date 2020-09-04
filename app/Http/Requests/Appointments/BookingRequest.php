<?php

namespace App\Http\Requests\Appointments;

use App\Http\Requests\Request;

class BookingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $businessId = $this->get('businessId');

        $authorize = (auth()->user()->isOwnerOf($businessId));

        logger()->info("Authorize:$authorize");

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
            'service_id'  => 'required|integer',
            'contact_id'  => 'required|integer',
            'contact'     => 'required|integer',
            'hr'          => 'required|integer',
            '_date'       => 'required|date',
            '_finish_date'=> 'required|date',
            'comments'    => 'nullable|string',
        ];
    }
}
