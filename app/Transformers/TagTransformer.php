<?php
namespace App\Transformers;

use App\Models\Category;
use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{

    public function transform(Tag $tag)
    {
        return [
            'id' => $tag->id,
			'name' => $tag->name,
            'can_edit' => $tag->can_edit,
            'can_delete' => $tag->can_delete,
        ];
    }
}
