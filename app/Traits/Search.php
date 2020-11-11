<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Search Trait
 * @created @hmadsk
 * @github https://github.com/iamsaeed
 * @email asklko2004@gmail.com
 * @package App\Traits
 * @remarks This trait is implementing the Laravel local query scope
 * @usage should be used in Laravel Models
 */

trait Search
{
    public function scopeSearchDateRange($query, $field, $start_date, $end_date)
    {
        if ($start_date && $end_date) {
            return $query->whereBetween($field, array($start_date, $end_date));
        }
    }

    public function scopeSearchDate($query, $field, $search)
    {
        if ($search !== '') {
            return $query->whereDate($field, $search);
        }
    }

    public function scopeSearchStrict($query, $field, $search)
    {
        if ($search !== '') {
            return $query->where($field, $search);
        }
    }

    public function scopeOrSearch($query, $field, $search)
    {
        if ($search !== '') {
            return $query->orWhere($field, 'like', "%$search%");
        }
    }

    public function scopeSearch($query, $field, $search)
    {
        if ($search !== '') {
            return $query->where($field, 'like', "%$search%");
        }
    }

    public function scopeSearchMany($query, $field, $search, $relation)
    {
        if ($search !== '') {
            return $query->whereHas($relation, function ($query) use ($field, $search) {
                $query->where($field, 'like', '%' . $search . '%');
            });
        }
    }

    public function scopeSearchManyStrict($query, $field, $search, $relation)
    {
        if ($search !== '') {
            return $query->whereHas($relation, function (Builder $query) use ($field, $search) {
                $query->where($field, 'like', $search);
            });
        }
    }

    public function scopeSearchManyMorph($query, $field, $model, $search, $relation)
    {
        if ($search !== '') {
            return $query->whereHasMorph($relation, $model, function ($query) use ($field, $search) {
                $query->where($field, 'like', $search);
            });
        }
    }
}
