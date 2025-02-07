<?php

namespace App\Http\Controllers;

use App\Models\Homeowner;

class HomeownerController extends Controller
{
    public function index()
    {
        return inertia('Homeowners/Index', [
            'homeowners' => Homeowner::query()
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->simplePaginate(),
        ]);
    }
}
