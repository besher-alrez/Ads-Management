<?php

namespace App\Repositories;

use App\Models\Category;
use Exception;
use App\Models\Printer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function find(string $name): Model|Builder|null
    {
        return $this->query()->where('name', $name)->first();
    }

    public function store(array $input): Category
    {
        /** @var Category $category */
        $category = $this->make(Arr::except($input, []));

        if ($this->find($category->name)) {
            abort(400,__('modules/printers.exceptions.already_exist'));
        }

        DB::transaction(function () use ($category, $input) {
            if (!$category->save()) {
                abort(400,__('modules/printers.exceptions.create'));
            }

            return true;
        });

        return $category;
    }

    public function update(Category $category, array $input): Category
    {
        if (($existingPrinter = $this->find($input['name']))
          && $existingPrinter->id !== $category->id
        ) {
            abort(400,__('modules/printers.exceptions.already_exist'));
        }

        DB::transaction(function () use ( $category, $input) {
            $category->fill(Arr::except($input, ['printer', '_method']));

            if (! $category->save()) {
                abort(400,__('modules/printers.exceptions.update'));
            }

            return true;
        });

        return $category;
    }

    public function destroy(Category $category): ?bool
    {
        if (! $category->delete()) {
            abort(400,__('modules/printers.exceptions.delete'));
        }

        return true;
    }
}
