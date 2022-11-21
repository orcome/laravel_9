<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use Illuminate\Http\Request;

class MotherController extends Controller
{
    public function index(Request $request)
    {
        $editableMother = null;
        $motherQuery = Mother::query();
        $motherQuery->where('title', 'like', '%'.$request->get('q').'%');
        $motherQuery->orderBy('title');
        $mothers = $motherQuery->paginate(25);

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editableMother = Mother::find(request('id'));
        }

        return view('mothers.index', compact('mothers', 'editableMother'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Mother);

        $newMother = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newMother['creator_id'] = auth()->id();

        Mother::create($newMother);

        return redirect()->route('mothers.index');
    }

    public function update(Request $request, Mother $mother)
    {
        $this->authorize('update', $mother);

        $motherData = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $mother->update($motherData);

        $routeParam = request()->only('page', 'q');

        return redirect()->route('mothers.index', $routeParam);
    }

    public function destroy(Request $request, Mother $mother)
    {
        $this->authorize('delete', $mother);

        $request->validate(['mother_id' => 'required']);

        if ($request->get('mother_id') == $mother->id && $mother->delete()) {
            $routeParam = request()->only('page', 'q');

            return redirect()->route('mothers.index', $routeParam);
        }

        return back();
    }
}
