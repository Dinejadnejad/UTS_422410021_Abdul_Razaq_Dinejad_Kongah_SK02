<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(Request $request): View
    {
        $equipments = Equipment::withCount('observationSessions')
            ->when($request->search, function ($query, $search) {
                $query->where('code', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%");
            })
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view('equipments.index', compact('equipments'));
    }

    public function create(): View
    {
        return view('equipments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code'           => ['required', 'string', 'max:20', 'unique:equipment,code'],
            'name'           => ['required', 'string', 'max:100'],
            'type'           => ['required', 'string', 'max:50'],
            'specifications' => ['nullable', 'string', 'max:255'],
        ]);

        Equipment::create($validated);

        return redirect()
            ->route('equipments.index')
            ->with('success', 'Perlengkapan observatorium berhasil ditambahkan.');
    }

    public function edit(Equipment $equipment): View
    {
        return view('equipments.edit', compact('equipment'));
    }

    public function update(Request $request, Equipment $equipment): RedirectResponse
    {
        $validated = $request->validate([
            'code'           => ['required', 'string', 'max:20', Rule::unique('equipment', 'code')->ignore($equipment->id)],
            'name'           => ['required', 'string', 'max:100'],
            'type'           => ['required', 'string', 'max:50'],
            'specifications' => ['nullable', 'string', 'max:255'],
        ]);

        $equipment->update($validated);

        return redirect()
            ->route('equipments.index')
            ->with('success', 'Data perlengkapan berhasil diperbarui.');
    }

    public function destroy(Equipment $equipment): RedirectResponse
    {
        $equipment->observationSessions()->detach();
        $equipment->delete();

        return redirect()
            ->route('equipments.index')
            ->with('success', 'Perlengkapan berhasil dihapus.');
    }
}