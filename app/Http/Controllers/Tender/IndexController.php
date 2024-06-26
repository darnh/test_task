<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use App\Models\Tender;

class IndexController extends Controller
{
    public function __invoke(): \Illuminate\Contracts\View\View
    {
        return view('tenders.index', ['tenders' => Tender::all()]);
    }
}
