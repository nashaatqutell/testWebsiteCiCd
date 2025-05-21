<?php

namespace App\Exports;

use App\Models\User;
use App\Enums\User\RoleEnum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('id', 'name', 'email', 'phone', 'role')
            ->where('role', RoleEnum::Employee->value)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => RoleEnum::getValue($user->role) ?? 'Unknown',
                ];
            });
    }
    public function headings(): array
    {
        return ["ID", "Name", "Email", "Phone", "Role"];
    }
}
