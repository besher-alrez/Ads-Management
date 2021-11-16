<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TagRepository extends BaseRepository
{
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }

    public function find(string $name): Model|Builder|null
    {
        return $this->query()->where('name', $name)->first();
    }

    public function store(array $input): Tag
    {
        /** @var Tag $tag */
        $tag = $this->make(Arr::except($input, []));

        if ($this->find($tag->name)) {
            abort(400,__('modules/printers.exceptions.already_exist'));
        }

        DB::transaction(function () use ($tag, $input) {
            if (!$tag->save()) {
                abort(400,__('modules/printers.exceptions.create'));
            }

            return true;
        });

        return $tag;
    }

    public function update(Tag $tag, array $input): Tag
    {
        if (($existingPrinter = $this->find($input['name']))
          && $existingPrinter->id !== $tag->id
        ) {
            abort(400,__('modules/printers.exceptions.already_exist'));
        }

        DB::transaction(function () use ( $tag, $input) {
            $tag->fill(Arr::except($input, ['tag', '_method']));

            if (! $tag->save()) {
                abort(400,__('modules/printers.exceptions.update'));
            }

            return true;
        });

        return $tag;
    }

    public function destroy(Tag $tag): ?bool
    {
        if (! $tag->delete()) {
            abort(400,__('modules/printers.exceptions.delete'));
        }

        return true;
    }
}
