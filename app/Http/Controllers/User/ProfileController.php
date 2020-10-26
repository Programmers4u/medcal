<?php

namespace App\Http\Controllers\User;

use App\Events\NewContactWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlterContactRequest;
use App\Models\User;
use Request;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;
use App\Http\Requests\AlterProfileRequest;
use Bootstrapper\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        //$this->authorize('manage', $contact);

        // BEGIN
        $user = auth()->user();
        if(!$user) {
            $alert = new Alert;
            $alert->warning('Nie mona rozpoznać uzytkownika!');
            return redirect()->back();    
        }

        $contact = Contact::query()->where('user_id','=',$user->id)->first();
        if(!$contact) {
            $contact = Contact::create(['firstname'=>$user->name,'email'=>$user->email]);
            if($contact) {
                DB::table('contacts')
                    ->where('id','=',$contact->id)
                    ->update(['user_id'=>$user->id]);
            }
        }

        return view('user.profile.edit', compact('business', 'contact'));
    }


    /**
     * update Profile User.
     *
     * @param Business            $business Business holding the Contact
     * @param Contact             $contact  Contact to update
     * @param AlterContactRequest $request  Alter Contact Request
     *
     * @return Response Redirect back to edited Contact
     */
    public function update(Business $business, Contact $contact, AlterProfileRequest $request)
    {
        $this->authorize('manage', $contact);

        // BEGIN

        $data = $request->only([
            'firstname',
            'lastname',
            'email',
            //'nin',
            //'gender',
            //'birthdate',
            'mobile',
            'mobile_country',
        ]);
        $contact->update($data);

        $uploadedFile = $request->file('avatar');
        if($uploadedFile) {
            $filename = 'avatar_'.auth()->user()->id.'.'.$uploadedFile->extension();
        
            $dir_avatar = env('STORAGE_PATH').DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'avatar';
            checkDir($dir_avatar);
                    
            $command = 'cp '.$uploadedFile.' '.base_path().DIRECTORY_SEPARATOR.$dir_avatar.DIRECTORY_SEPARATOR.$filename;
            system($command);    
        }

        flash()->success(trans('user.contacts.msg.update.success'));

        return redirect()->route('user.business.profile.edit', [$business]);
    }

    public function passwordReset(){
        auth()->logout();
        return redirect(url('password/reset'));
    }

}
