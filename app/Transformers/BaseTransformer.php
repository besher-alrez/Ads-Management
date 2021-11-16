<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    protected bool $forShow;

    public function __construct(bool $forShow = false, $include=[])
    {
        $this->forShow = $forShow;
        $this->setDefaultIncludes($include);
    }
}
