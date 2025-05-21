<?php

namespace App\Http\Filters;

class AboutFilter extends BaseFilters
{

    protected $filters = [
        'type',
    ];


    protected function type($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('type'),
                    function ($query) use ($value) {
                        $query->whereLike('type', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }
}
