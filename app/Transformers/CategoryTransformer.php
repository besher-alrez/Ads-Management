<?php
namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
			'name' => $category->name,
            'can_edit' => $category->can_edit,
            'can_delete' => $category->can_delete,
        ];
    }
}
