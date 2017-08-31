<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BasicModel;
use Nicolaslopezj\Searchable\SearchableTrait;

class Model extends BasicModel
{
    use SearchableTrait;

    /**
     * Filtering by database enum columns
     *
     * @param  string       $orderByColumn
     * @param  array        $filterParameters
     * @param  integer      $itemsPerPage
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function filter(
        $orderByColumn,
        $filterParameters = null,
        $itemsPerPage = 10
    ) {
        return self::where($filterParameters)
            ->orderBy($orderByColumn)
            ->paginate($itemsPerPage);
    }

    /**
     * Keywords search and filtering
     *
     * @param  array        $filterParameters
     * @param  string       $keywords
     * @param  string       $orderByColumn
     * @param  array        $timeInterval
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function filterAndSearch(
        $filterParameters,
        $keywords,
        $orderByColumn,
        $timeInterval = null
    ) {
        if (is_null($timeInterval))
            return self::where($filterParameters)
                ->search($keywords)
                ->orderBy($orderByColumn)
                ->get();

        return self::where($filterParameters)
            ->whereBetween('issue_year', $timeInterval)
            ->search($keywords)
            ->orderBy($orderByColumn)
            ->get();
    }
}
