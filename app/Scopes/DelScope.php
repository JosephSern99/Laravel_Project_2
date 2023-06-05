<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DelScope implements Scope
{
    protected $delField;

    public function __construct($delField) {
        $this->delField = $delField;
    }

    public function apply(Builder $builder, Model $model)
    {
	$builder->whereNull($this->delField);
    }
}
