<?php

namespace App\Http\Controllers;

use App\Models\Master;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $masterQuery = Master::query();
        $masterQuery->where('title', 'like', '%'.$request->get('q').'%');
        $masterQuery->orderBy('title');
        $masters = $masterQuery->paginate(25);

        return view('masters.index', compact('masters'));
    }

    public function create()
    {
        $this->authorize('create', new Master);

        return view('masters.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Master);

        $newMaster = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newMaster['creator_id'] = auth()->id();

        $master = Master::create($newMaster);

        return redirect()->route('masters.show', $master);
    }

    public function show(Master $master)
    {
        return view('masters.show', compact('master'));
    }

    public function edit(Master $master)
    {
        $this->authorize('update', $master);

        return view('masters.edit', compact('master'));
    }

    public function update(Request $request, Master $master)
    {
        $this->authorize('update', $master);

        $masterData = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $master->update($masterData);

        return redirect()->route('masters.show', $master);
    }

    public function destroy(Request $request, Master $master)
    {
        $this->authorize('delete', $master);

        $request->validate(['master_id' => 'required']);

        if ($request->get('master_id') == $master->id && $master->delete()) {
            return redirect()->route('masters.index');
        }

        return back();
    }
}
