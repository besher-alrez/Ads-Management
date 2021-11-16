<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Repositories\TagRepository;
use App\Transformers\TagTransformer;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;

use Spatie\Fractal\Fractal;

class TagController extends BackendController
{

    /**
     * @var TagRepository
     */
    protected $tags;

    /**
     * Create a new controller instance.
     *
     * @param TagRepository $tags
     */
    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
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
        $query = $this->tags->query()->with([]);

        $requestSearchQuery = new RequestSearchQuery($request, $query,[]);

        return $requestSearchQuery->result(new TagTransformer());
    }

    /**
     * @param Tag $tag
     *
     * @return \Spatie\Fractalistic\Fractal
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Tag $tag)
    {
        // $this->authorize('view printers');

        return Fractal::create()->item($tag, new TagTransformer());
    }

    /**
     * @param StoreTagRequest $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTagRequest $request)
    {
        // $this->authorize('create printers');

        $this->tags->store($request->all());

        return $this->redirectResponse($request, __('modules/tags.alerts.created'));
    }

    /**
     * @param Tag $tag
     * @param UpdateTagRequest $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Tag $tag, UpdateTagRequest $request)
    {
        // $this->authorize('edit printers');

        $this->tags->update($tag, $request->all());

        return $this->redirectResponse($request, __('modules/tags.alerts.updated'));
    }

    /**
     * @param Tag $tag
     * @param Request $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Tag $tag, Request $request)
    {
        // $this->authorize('delete printers');

        $this->tags->destroy($tag);

        return $this->redirectResponse($request, __('modules/tags.alerts.deleted'));
    }
}
