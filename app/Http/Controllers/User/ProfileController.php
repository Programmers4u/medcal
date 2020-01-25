<?php

namespace App\Http\Controllers\User;

use App\Events\NewContactWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlterContactRequest;
use App\Models\User;
use Notifynder;
use Request;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;
use App\Http\Requests\AlterProfileRequest;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{


    /**
     * edit Profile User.
     *
     * @param Business            $business Business holding the Contact
     * @param Contact             $contact  Contact for edit
     * @param AlterContactRequest $request  Alter Contact Request
     *
     * @return Response Rendered view of Contact edit form
     */
    public function edit(Business $business)
    {
        logger()->info(__METHOD__);
        //logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        //$this->authorize('manage', $contact);

        // BEGIN
        $user = auth()->user();

        $contact = Contact::query()->where('user_id','=',$user->id)->first();
        if(!$contact) {
            $contact = Contact::create(['firstname'=>$user->name,'email'=>$user->email]);
            if($contact) {
                DB::table('contacts')
                    ->where('id','=',$contact->id)
                    ->update(['user_id'=>$user->id]);
            }
        }
        //dd($contact);
        return view('user.profile.edit', compact('business', 'contact'));
    }


    /**
     * update Contact.
     *
     * @param Business            $business Business holding the Contact
     * @param Contact             $contact  Contact to update
     * @param AlterContactRequest $request  Alter Contact Request
     *
     * @return Response Redirect back to edited Contact
     */
    public function update(Business $business, Contact $contact, AlterContactRequest $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manage', $contact);

        // BEGIN

        $data = $request->only([
            'firstname',
            'lastname',
            'email',
            'nin',
            'gender',
            'birthdate',
            'mobile',
            'mobile_country',
        ]);

        $contact = $business->addressbook()->update($contact, $data, $request->get('notes'));

        flash()->success(trans('user.contacts.msg.update.success'));

        return redirect()->route('user.business.contact.show', [$business, $contact]);
    }

}
