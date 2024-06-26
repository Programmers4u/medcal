<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Humanresource;

class HumanresourceController extends Controller
{
    public function index(Business $business)
    {
        $this->authorize('manageHumanresources', $business);

        $humanresources = $business->humanresources;

        return view('manager.businesses.humanresources.index', compact('business', 'humanresources'));
    }

    public function create(Business $business)
    {
        if ($business->humanresources()->count() > plan('limits.specialists', $business->plan)) {
            flash()->warning(trans('app.saas.plan_limit_reached'));

            return redirect()->back();
        }

        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        $humanresource = new Humanresource(); // For Form Model Binding
        return view('manager.businesses.humanresources.create', compact('business', 'humanresource'));
    }

    public function store(Business $business, Request $request)
    {
        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        $humanresource = new Humanresource($request->all());

        $humanresource->color = $request->input('color');

        $humanresource->business()->associate($business->id);

        $iCalPath = url("/business/{$business->id}/ical/calendar-{$humanresource->slug}.ics");
        
        $humanresource->calendar_link = $iCalPath;

        $humanresource->save();

        flash()->success(trans('manager.humanresources.msg.store.success'));

        return redirect()->route('manager.business.humanresource.show', [$business, $humanresource]);
    }

    public function show(Business $business, Humanresource $humanresource)
    {
        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        return view('manager.businesses.humanresources.show', compact('business', 'humanresource'));
    }

    public function edit(Business $business, Humanresource $humanresource)
    {
        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        return view('manager.businesses.humanresources.edit', compact('business', 'humanresource'));
    }

    public function update(Business $business, Humanresource $humanresource, Request $request)
    {
        $this->authorize('manageHumanresources', $business);

        // BEGIN //
        $humanresource->fill($request->all());
        $humanresource->color = $request->input('color');
        $humanresource->save();

        flash()->success(trans('manager.humanresources.msg.update.success'));

        return redirect()->route('manager.business.humanresource.show', [$business, $humanresource]);
    }

    public function destroy(Business $business, Humanresource $humanresource)
    {
        $this->authorize('manageHumanresources', $business);

        $humanresource = $humanresource->delete();

        flash()->success(trans('manager.humanresources.msg.destroy.success'));

        return redirect()->route('manager.business.humanresource.index', $business);
    }
}
