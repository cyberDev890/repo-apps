<?php

namespace App\Http\Controllers;

use App\Models\WorkUnit;
use Illuminate\Http\Request;

class WorkUnitController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkUnit::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
        }
        $workUnits = $query->paginate(10);
        return view('work-units.index', compact('workUnits'));
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('q');
        $results = WorkUnit::where('name', 'like', '%' . $search . '%')
                           ->take(10)
                           ->get(['id', 'name', 'type']);
        return response()->json($results);
    }

    public function create()
    {
        return view('work-units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:4',
            'name' => 'required|string|max:255',
            'type' => 'required|in:Kantor Cabang,Unit,Kantor Cabang Pembantu',
        ], [
            'code.digits' => 'Kode Uker harus berupa 4 angka.',
            'code.required' => 'Kode Uker wajib diisi.'
        ]);

        $data = $request->all();
        $data['name'] = ucwords($data['name']);

        WorkUnit::create($data);

        return redirect()->route('work-units.index')->with('success', 'Unit Kerja berhasil ditambahkan.');
    }

    public function show(WorkUnit $workUnit)
    {
        // For show, we might want to list devices in this work unit
        $devices = $workUnit->devices()->with('category')->get();
        return view('work-units.show', compact('workUnit', 'devices'));
    }

    public function edit(WorkUnit $workUnit)
    {
        return view('work-units.edit', compact('workUnit'));
    }

    public function update(Request $request, WorkUnit $workUnit)
    {
        $request->validate([
            'code' => 'required|digits:4',
            'name' => 'required|string|max:255',
            'type' => 'required|in:Kantor Cabang,Unit,Kantor Cabang Pembantu',
        ], [
            'code.digits' => 'Kode Uker harus berupa 4 angka.',
            'code.required' => 'Kode Uker wajib diisi.'
        ]);

        $data = $request->all();
        $data['name'] = ucwords($data['name']);

        $workUnit->update($data);

        return redirect()->route('work-units.index')->with('success', 'Unit Kerja berhasil diperbarui.');
    }

    public function destroy(WorkUnit $workUnit)
    {
        if ($workUnit->devices()->count() > 0) {
            return redirect()->route('work-units.index')->with('error', 'Unit Kerja tidak dapat dihapus karena masih memiliki perangkat yang tertaut.');
        }

        $workUnit->delete();

        return redirect()->route('work-units.index')->with('success', 'Unit Kerja berhasil dihapus.');
    }
}
