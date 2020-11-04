<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\BusinessAlreadyRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessFormRequest;
use App\Models\MedicalHistory;
use App\TG\Business\Dashboard;
use App\TG\BusinessService;
use Carbon\Carbon;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\File;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Category;

class BusinessController extends Controller
{
    /**
     * Location data.
     *
     * @var array
     */
    protected $location = null;

    /**
     * Business service.
     *
     * @var App\TG\BusinessService
     */
    private $businessService;

    /**
     * Current localized time.
     *
     * @var Carbon\Carbon
     */
    private $time;

    /**
     * Create Controller.
     *
     * @param App\TG\BusinessService $businessService
     */
    public function __construct(BusinessService $businessService, Carbon $time)
    {
        $this->businessService = $businessService;

        $this->time = $time;

        parent::__construct();
    }

    /**
     * List all businesses.
     *
     * @return Response Rendered view for Businesses listing
     */
    public function index()
    {
        
        $businesses = auth()->user()->businesses;

        if ($businesses->count() == 1) {
            // logger()->info('Only one business to show');

            //flash()->success(trans('manager.businesses.msg.index.only_one_found'));
            $business = $businesses->first();
            session()->put('selected.business', $business);
            return redirect()->route('manager.business.agenda.calendar', $business );
            //return redirect()->route('manager.business.show', $businesses->first());
        }

        $user = auth()->user();

        return view('manager.businesses.index', compact('businesses', 'user'));
    }

    /**
     * create Business.
     *
     * @return Response Rendered view of Business creation form
     */
    public function create($plan = 'free')
    {

        $timezone = $this->guessTimezone(null);

        $countryCode = $this->getCountry();

        $locale = app()->getLocale();

        $categories = $this->listCategories();

        $business = new Business();

        return view('manager.businesses.create', compact(
            'business',
            'timezone',
            'categories',
            'plan',
            'countryCode',
            'locale'
        ));
    }

    /**
     * store Business.
     *
     * @param BusinessFormRequest $request Business form Request
     *
     * @return Response Redirect
     */
    public function store(BusinessFormRequest $request)
    {
        // logger()->info(__METHOD__);

        // BEGIN

        try {
            $business = $this->businessService->register(auth()->user(), $request->all(), $request->get('category'));
            // $this->businessService->setup($business);
        } catch (BusinessAlreadyRegistered $exception) {
            flash()->error(trans('manager.businesses.msg.store.business_already_exists'));

            return redirect()->back()->withInput(request()->all());
        }

        // Redirect success
        flash()->success(trans('manager.businesses.msg.store.success'));

        return redirect()->route('manager.business.service.create', $business);
    }

    /**
     * show Business.
     *
     * @param Business            $business Business to show
     * @param BusinessFormRequest $request  Business form Request
     *
     * @return Response Rendered view for Business show
     */
    public function show(Business $business)
    {
        $this->authorize('manage', $business);

        // BEGIN

        session()->put('selected.business', $business);

        $this->time->timezone($business->timezone);

        $dashboard = new Dashboard($business, $this->time);

        $boxes = $dashboard->getBoxes();

        $time = $this->time->toTimeString();

        return view('manager.businesses.show', compact(
            'business', 
            'boxes', 
            'time'
        ));
    }

    /**
     * edit Business.
     *
     * @param Business $business Business to edit
     *
     * @return Response Rendered view of Business edit form
     */
    public function edit(Business $business)
    {
        $this->authorize('update', $business);

        // BEGIN

        $timezone = $this->guessTimezone($business->timezone);

        $categories = $this->listCategories();

        $category = $business->category_id;

        $command = "du -h --max-depth=0 ".base_path().'/'.env('STORAGE_PATH','');
        $storageSize = exec($command,$res);
        //$command="df -H --output=size,used";
        $command="df -H . | sed 's/ \+/ /g' | cut -d\" \" -f2";
        $res = exec($command,$diskSize);
        $storageSize.= ' All: '.$diskSize[1]; 

        $command="df -H . | sed 's/ \+/ /g' | cut -d\" \" -f4";
        $res = exec($command,$diskAvail);
        $storageSize.= ' Avail: '.$diskAvail[1]; 
        
        /**
         * Finansowe info 
         */

        $medicalHistory = MedicalHistory::query()
            // ->where(MedicalHistory::C)
            ;
        $finance = [
            'sum' => 0,
            'avg' => 0,
        ];
        $proces = [];
        foreach($medicalHistory as $index => $oneSet){
            // dd($oneSet);
            $mh = json_decode($oneSet->json_data);
            if(isset($mh->price) && !empty($mh->price))  {
                $filter = array_filter($proces,function($item) use($oneSet) {
                    // dd($item);
                    if($item['label'] === substr($oneSet->{MedicalHistory::CREATED_AT},0,10))
                        return $item;
                });
                // dd($filter);
                if(!$filter) {
                    array_push($proces, [ 
                        'data' => $mh->price, 
                        'label' => substr($oneSet->{MedicalHistory::CREATED_AT},0,10),
                    ]);    
                } else {
                    // dd($filter, $proces);
                    // $proces[0]['data'] += $mh->price;
                }
            }
        }
        // dd($proces);
        // if(count($proces)>0) {
        //     $finance['sum'] = array_sum($proces);
        //     $finance['avg'] = $finance['sum']/count($proces);
        // }

        // logger()->info(sprintf('businessId:%s timezone:%s category:%s', $business->id, $timezone, $category));

        return view('manager.businesses.edit', compact('finance' ,'business', 'category', 'categories', 'timezone', 'storageSize'));
    }

    /**
     * update Business.
     *
     * @param Business            $business Business to update
     * @param BusinessFormRequest $request  Business form Request
     *
     * @return Response Redirect
     */
    public function update(Business $business, BusinessFormRequest $request)
    {
        // logger()->info(__METHOD__);
        // logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('update', $business);

        // BEGIN
        $category = $request->get('category');

        $data = $request->only([
                'name',
                'description',
                'timezone',
                'postal_address',
                'phone',
                'social_facebook',
        ]);

        $this->businessService->update($business, $data);

        $this->businessService->setCategory($business, $category);

        flash()->success(trans('manager.businesses.msg.update.success'));

        return redirect()->route('manager.business.show', compact('business'));
    }

    /**
     * destroy Business.
     *
     * @param Business $business Business to destroy
     *
     * @return Response Redirect to Businesses index
     */
    public function destroy(Business $business)
    {
        // logger()->info(__METHOD__);

        $this->authorize('destroy', $business);

        // logger()->info(sprintf('Deactivating: businessId:%s', $business->id));
        // BEGIN

        $this->businessService->deactivate($business);

        flash()->success(trans('manager.businesses.msg.destroy.success'));

        return redirect()->route('manager.business.index');
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * get business category list.
     *
     * TODO: SHOULD BE USED WITH VIEW COMPOSER
     *
     * @return array list of categories for combo
     */
    protected function listCategories()
    {
        return Category::pluck('slug', 'id')->transform(
            function ($item) {
                return trans("app.business.category.{$item}");
            }
        );
    }

    /**
     * guess user (client) timezone.
     *
     * @param string $timezone Default or fallback timezone
     *
     * @return string Guessed or fallbacked timezone
     */
    protected function guessTimezone($timezone = null)
    {
        if (!empty($timezone)) {
            return $timezone;
        }

        $this->getLocation();

        // logger()->info(sprintf('TIMEZONE FALLBACK="%s" GUESSED="%s"', $timezone, $this->location['timezone']));

        $identifiers = timezone_identifiers_list();

        return in_array($this->location['timezone'], $identifiers) ? $this->location['timezone'] : $timezone;
    }

    protected function getCountry()
    {
        $this->getLocation();

        return array_get($this->location, 'isoCode', null);
    }

    protected function getLocation()
    {
        if ($this->location === null) {
            // logger()->info('Getting location');

            $geoip = app('geoip');

            $this->location = $geoip->getLocation();

            // logger()->info(serialize($this->location));
        }

        return $this->location;
    }
}
