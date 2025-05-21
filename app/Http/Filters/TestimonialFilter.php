<?php

namespace App\Http\Filters;

class TestimonialFilter extends BaseFilters
{

    protected $filters = [
        'name',
    ];


    protected function name($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('name'),
                    function ($query) use ($value) {
                        $query->whereLike('name', '%'.$value.'%')
                            ->orWhereTranslationLike('description', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }
}
