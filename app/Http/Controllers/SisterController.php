<?php

namespace App\Http\Controllers;

use App\Models\Sister;
use Illuminate\Http\Request;

class SisterController extends Controller
{
    public function index(Request $request)
    {
        $editableSister = null;
        $sisterQuery = Sister::query();
        $sisterQuery->where('title', 'like', '%'.$request->get('q').'%');
        $sisterQuery->orderBy('title');
        $sisters = $sisterQuery->paginate(25);

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editableSister = Sister::find(request('id'));
        }

        return view('sisters.index', compact('sisters', 'editableSister'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Sister);

        $newSister = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newSister['creator_id'] = auth()->id();

        Sister::create($newSister);

        return redirect()->route('sisters.index');
    }

    public function update(Request $request, Sister $sister)
    {
        $this->authorize('update', $sister);

        $sisterData = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $sister->update($sisterData);

        $routeParam = request()->only('page', 'q');

        return redirect()->route('sisters.index', $routeParam);
    }

    public function destroy(Request $request, Sister $sister)
    {
        $this->authorize('delete', $sister);

        $request->validate(['sister_id' => 'required']);

        if ($request->get('sister_id') == $sister->id && $sister->delete()) {
            $routeParam = request()->only('page', 'q');

            return redirect()->route('sisters.index', $routeParam);
        }

        return back();
    }
}
