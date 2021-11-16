<?php

namespace App\Repositories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AdRepository extends BaseRepository
{
    public function __construct(Ad $ad)
    {
        parent::__construct($ad);
    }

    public function find(string $name): Model|Builder|null
    {
        return $this->query()->where('name', $name)->first();
    }

    public function store(array $input): Ad
    {
        $input['category_id'] = $input['category']['id'];
        /** @var Ad $ad */
        $ad = $this->make(Arr::except($input, []));


        DB::transaction(function () use ($ad, $input) {
            if (!$ad->save()) {
                abort(400,__('modules/printers.exceptions.create'));
            }
            if(isset($input['tags'])) $ad->ad_tags()->sync(Arr::pluck(($input['tags']), 'id'));


            return true;
        });

        return $ad;
    }

    public function update(Ad $ad, array $input): Ad
    {
        if (($existingPrinter = $this->find($input['name']))
          && $existingPrinter->id !== $ad->id
        ) {
            abort(400,__('modules/printers.exceptions.already_exist'));
        }

        DB::transaction(function () use ( $ad, $input) {
            $ad->fill(Arr::except($input, ['printer', '_method']));

            if (! $ad->save()) {
                abort(400,__('modules/printers.exceptions.update'));
            }

            return true;
        });

        return $ad;
    }

    public function destroy(Ad $ad): ?bool
    {
        if (! $ad->delete()) {
            abort(400,__('modules/printers.exceptions.delete'));
        }

        return true;
    }
}
