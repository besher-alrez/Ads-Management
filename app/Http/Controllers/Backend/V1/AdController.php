<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Mail\CertificateExpiryNotification;
use App\Models\Ad;
use App\Models\Category;
use App\Repositories\AdRepository;
use App\Repositories\CategoryRepository;
use App\Transformers\AdTransformer;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;

use Spatie\Fractal\Fractal;

class AdController extends BackendController
{

    /**
     * @var AdRepository
     */
    protected $ads;

    /**
     * Create a new controller instance.
     *
     * @param AdRepository $ads
     */
    public function __construct(AdRepository $ads)
    {
        $this->ads = $ads;
    }

    /**
     *
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     *
     */
    public function search(Request $request)
    {
        $query = $this->ads->query()->with([]);

        $requestSearchQuery = new RequestSearchQuery($request, $query,[]);

        return $requestSearchQuery->result(new AdTransformer());
    }

    /**
     * @param Ad $ads
     *
     * @return \Spatie\Fractalistic\Fractal
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Ad $ad)
    {
        // $this->authorize('view printers');
        $this->send_reminder();

        return Fractal::create()->item($ad, new AdTransformer());
    }

    /**
     * @param StoreAdRequest $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreAdRequest $request)
    {
        // $this->authorize('create printers');

        $this->ads->store($request->all());

        return $this->redirectResponse($request, __('modules/printers.alerts.created'));
    }

    /**
     * @param Ad $ad
     * @param UpdateAdRequest $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Ad $ad, UpdateAdRequest $request)
    {
        // $this->authorize('edit printers');

        $this->ads->update($ad, $request->all());

        return $this->redirectResponse($request, __('modules/printers.alerts.updated'));
    }

    /**
     * @param Ad $ad
     * @param Request $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Ad $ad, Request $request)
    {
        // $this->authorize('delete printers');

        $this->ads->destroy($ad);

        return $this->redirectResponse($request, __('modules/printers.alerts.deleted'));
    }


    public function send_reminder(){
        $ads= Ad::all()->toArray();
        $advertisers=[];
        foreach ($ads as $ad){
            $start_date =new Carbon($ad->start_date);
            $now = Carbon::now();
            if($start_date->diff($now)->days == 1){
                array_push($advertisers, $ad->advertiser);
            }
        }

        Mail::to($advertisers)
            ->send(new AdvertismentReminder($advertisers));
    }
}
