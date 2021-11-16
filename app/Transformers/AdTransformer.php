<?php
namespace App\Transformers;

use App\Models\Ad;
use App\Models\Category;
use League\Fractal\TransformerAbstract;

class AdTransformer extends BaseTransformer
{



    public function transform(Ad $ad)
    {
            $tags = $ad->ad_tags->map(function ($tag){

                return ['id' => $tag->id, 'name' => $tag->name];
            });

           // dd($tags);
        return [
            'id' => $ad->id,
			'name' => $ad->name,
			'type' => $ad->type,
			'title' => $ad->title,
			'description' => $ad->description,
			'category' => ['id' => $ad->category->id,'name' => $ad->category->name],
			'advertiser' => $ad->advertiser,
			'tags' =>$tags->toArray(),
            'can_edit' => $ad->can_edit,
            'can_delete' => $ad->can_delete,
        ];
    }
}
