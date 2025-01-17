<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function search($query)
    {
        return $this->orWhere('email', 'LIKE', '%' . $query . '%')
            ->orWhere('id', 'LIKE', '%' . $query . '%')
            ->orWhere('name', 'LIKE', '%' . $query . '%')
            //->orWhere('lastname', 'LIKE', '%' . $query . '%')
            //->orWhere('mobile', 'LIKE', '%' . $query . '%')
            //->orWhere('note', 'LIKE', '%' . $query . '%')
            //->orWhere('username', 'LIKE', '%' . $query . '%')
            ;
    }
}
