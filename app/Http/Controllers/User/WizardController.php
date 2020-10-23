<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

/*******************************************************************************
 * The Wizard will present either a guided step-by-step configuration for
 * businesses owners, or business directory listing for new users acting as
 * customers. It will also send them to default views if they are regular users.
 ******************************************************************************/
class WizardController extends Controller
{
    public function getWizard()
    {
        // logger()->info(__METHOD__);

        if ($slug = session()->pull('guest.last-intended-business-home')) {
            // logger()->info('Resume Business visit to:'.$slug);

            return redirect()->to('/'.$slug);
        }

        if (auth()->user()->hasBusiness()) {
            // logger()->info('User has Business');

            return redirect()->route('manager.business.index');
        }

        if (auth()->user()->hasContacts()) {
            // logger()->info('User has Contacts');

            return redirect()->route('user.dashboard');
        }

        return redirect()->route('wizard.pricing');

        // return view('wizard');
    }

    public function getDashboard()
    {
        // logger()->info(__METHOD__);

        $appointments = auth()->user()->appointments()->orderBy('start_at')->unarchived()->get();

        $appointmentsCount = $appointments->count();

        $subscriptionsCount = auth()->user()->contacts->count();

        return view('user.dashboard', compact('appointments', 'appointmentsCount', 'subscriptionsCount'));
    }

    public function getWelcome()
    {
        // logger()->info(__METHOD__);

        return view('wizard');
    }

    public function getPricing()
    {
        // logger()->info(__METHOD__);

        return view('manager.pricing');
    }

    public function getTerms()
    {
        // logger()->info(__METHOD__);

        return view('manager.terms');
    }
}
