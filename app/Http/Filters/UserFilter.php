<?php

namespace App\Http\Filters;

class UserFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        "phone",
        "role",
    ];

    protected function name($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('name'),
                    function ($query) use ($value) {
                        $query->where("name", "like", "%{$value}%");
                    }
                );
        }

        return $this->builder;
    }

    protected function phone($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('phone'),
                    function ($query) use ($value) {
                        $query->where("phone", "like", "%{$value}%");
                    }
                );
        }

        return $this->builder;
    }

    protected function role($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('role'),
                    function ($query) use ($value) {
                        $query->where("role", $value);
                    }
                );
        }
        return $this->builder;
    }


}
