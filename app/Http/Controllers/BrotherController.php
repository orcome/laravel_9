<?php

namespace App\Http\Controllers;

use App\Models\Brother;
use Illuminate\Http\Request;

class BrotherController extends Controller
{
    public function index(Request $request)
    {
        $brotherQuery = Brother::query();
        $brotherQuery->where('title', 'like', '%'.$request->get('q').'%');
        $brotherQuery->orderBy('title');
        $brothers = $brotherQuery->paginate(25);

        return view('brothers.index', compact('brothers'));
    }

    public function create()
    {
        $this->authorize('create', new Brother);

        return view('brothers.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Brother);

        $newBrother = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newBrother['creator_id'] = auth()->id();

        $brother = Brother::create($newBrother);

        return redirect()->route('brothers.show', $brother);
    }

    public function show(Brother $brother)
    {
        return view('brothers.show', compact('brother'));
    }

    public function edit(Brother $brother)
    {
        $this->authorize('update', $brother);

        return view('brothers.edit', compact('brother'));
    }

    public function update(Request $request, Brother $brother)
    {
        $this->authorize('update', $brother);

        $brotherData = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $brother->update($brotherData);

        return redirect()->route('brothers.show', $brother);
    }

    public function destroy(Request $request, Brother $brother)
    {
        $this->authorize('delete', $brother);

        $request->validate(['brother_id' => 'required']);

        if ($request->get('brother_id') == $brother->id && $brother->delete()) {
            return redirect()->route('brothers.index');
        }

        return back();
    }
}
