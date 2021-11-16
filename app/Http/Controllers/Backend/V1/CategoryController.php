<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;

use Spatie\Fractal\Fractal;

class CategoryController extends BackendController
{

    /**
     * @var CategoryRepository
     */
    protected $categories;

    /**
     * Create a new controller instance.
     *
     * @param CategoryRepository $categories
     */
    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
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
        $query = $this->categories->query()->with([]);

        $requestSearchQuery = new RequestSearchQuery($request, $query,[]);

        return $requestSearchQuery->result(new CategoryTransformer());
    }

    /**
     * @param Category $category
     *
     * @return \Spatie\Fractalistic\Fractal
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Category $category)
    {
        // $this->authorize('view printers');

        return Fractal::create()->item($category, new CategoryTransformer());
    }

    /**
     * @param StoreCategoryRequest $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCategoryRequest $request)
    {
        // $this->authorize('create printers');

        $this->categories->store($request->all());

        return $this->redirectResponse($request, __('modules/printers.alerts.created'));
    }

    /**
     * @param Category $category
     * @param UpdateCategoryRequest $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        // $this->authorize('edit printers');

        $this->categories->update($category, $request->all());

        return $this->redirectResponse($request, __('modules/printers.alerts.updated'));
    }

    /**
     * @param Category $category
     * @param Request $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Category $category, Request $request)
    {
        // $this->authorize('delete printers');

        $this->categories->destroy($category);

        return $this->redirectResponse($request, __('modules/printers.alerts.deleted'));
    }
}
