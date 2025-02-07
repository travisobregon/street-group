<?php

namespace App\Http\Controllers;

use App\Actions\SplitName;
use App\Models\Homeowner;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

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

    public function store(Request $request)
    {
        $request->validate(['file' => ['required', 'file', 'mimes:csv,txt']]);

        SimpleExcelReader::create($request->file('file')->getPathname(), 'csv')
            ->useHeaders(['homeowner'])
            ->getRows()
            ->flatMap(fn (array $row) => with(new SplitName())->handle($row['homeowner']))
            ->each(fn (array $attributes) => Homeowner::query()->create($attributes));

        return back();
    }
}
