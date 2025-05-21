<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\NewsLetterRequest;
use App\Http\Resources\NewsLetterResource;
use App\Models\NewsLetter\NewsLetter;

class NewsLetterController extends Controller
{


    public function store(NewsLetterRequest $request)
    {
        $data = $request->validated() + ["added_by_id" => auth()->id()];
        $newsLetter = NewsLetter::query()->create($data);
        return $this->successResponse(data: NewsLetterResource::make($newsLetter), message: __("messages.success"));
    }
}
