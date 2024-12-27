<?php

namespace App\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearchable(Builder $builder, ?Closure $callback = null)
    {
        $filter = request()->query('filter');

        if ($callback instanceof Closure) {
            $callback($builder, $filter);
        }

        if (! is_null($filter)) {
            $builder->where(function ($query) use ($filter) {
                foreach ($filter as $key => $value) {
                    $query->where($key, 'LIKE', '%'.$value.'%');
                }
            });
        }
    }
}
