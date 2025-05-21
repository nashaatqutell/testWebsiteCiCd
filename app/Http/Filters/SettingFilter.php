<?php

namespace App\Http\Filters;

class SettingFilter extends BaseFilters
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
                        $query->whereTranslationLike("name", "%{$value}%")
                            ->orWhereTranslationLike("description", "%{$value}%");
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
