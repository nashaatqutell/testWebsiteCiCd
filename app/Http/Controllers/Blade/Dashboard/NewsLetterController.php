<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter\NewsLetter;

class NewsLetterController extends Controller
{
    public function index()
    {
        $newsLetters = NewsLetter::query()->latest()->get();
        return view("dashboard.newsLetter.index", get_defined_vars());
    }
}
