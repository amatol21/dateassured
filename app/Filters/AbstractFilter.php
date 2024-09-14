<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class AbstractFilter
{
    public abstract static function createQuery(Request $request): Model|Builder;
}
