<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public function scopeSortable(Builder $builder)
    {
        $sort = request()->query('sort');

        if (! is_null($sort)) {
            foreach ($sort as $key => $value) {
                $builder->orderBy($key, $value);
            }
        }
    }
}
