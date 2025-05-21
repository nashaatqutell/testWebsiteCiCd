<?php


use App\Models\HeroSection\HeroSection;
use App\Models\Setting\Setting;
use Carbon\Carbon;

function convertCreatedAt($createdAt = null): ?string
{
    return $createdAt ? Carbon::parse($createdAt)->format('Y-m-d') : null;
}

if (!function_exists('generate_unique_code')) {
    function generate_unique_code($model, $col = 'code', $length = 4, $letter_type = null): string
    {
        $characters = '';
        switch ($letter_type) {
            case 'lower':
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                break;
            case 'upper':
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'numbers':
                $characters = '0123456789';
                break;

            default:
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
        }
        $generate_random_code = '';
        $charactersLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $generate_random_code .= $characters[rand(0, $charactersLength - 1)];
        }
        if ($model::where($col, $generate_random_code)->exists()) {
            generate_unique_code($model, $col, $length, $letter_type);
        }
        return $generate_random_code;
    }
}


function convertToArray($data): array
{
    return is_array($data) && !empty($data) ? $data : [$data] ?? [];
}

function getFirstSettingId(): int
{
    return Setting::query()->first()->id;
}

function getSiteName()
{
    return Setting::query()->first()->name;
}

function getFirstHeroSectionId(): int
{
    return HeroSection::query()->first()->id;
}
