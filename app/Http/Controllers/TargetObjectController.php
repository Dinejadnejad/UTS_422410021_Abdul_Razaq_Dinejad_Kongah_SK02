<?php

namespace App\Http\Controllers;

use App\Models\TargetObject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TargetObjectController extends Controller
{
    public function index(Request $request): View
    {
        $targetObjects = TargetObject::withCount('observationSessions')
            ->when($request->search, function ($query, $search) {
                $query->where('code', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('catalog_number', 'like', "%{$search}%");
            })
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view('target-objects.index', compact('targetObjects'));
    }

    public function create(): View
    {
        return view('target-objects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code'           => ['required', 'string', 'max:20', 'unique:target_objects,code'],
            'name'           => ['required', 'string', 'max:100'],
            'catalog_number' => ['required', 'string', 'max:50'],
            'category'       => ['required', 'string', 'max:50'],
            'description'    => ['nullable', 'string'],
        ]);

        TargetObject::create($validated);

        return redirect()
            ->route('target-objects.index')
            ->with('success', 'Objek sasaran baru berhasil ditambahkan.');
    }

    public function edit(TargetObject $targetObject): View
    {
        return view('target-objects.edit', compact('targetObject'));
    }

    public function update(Request $request, TargetObject $targetObject): RedirectResponse
    {
        $validated = $request->validate([
            'code'           => ['required', 'string', 'max:20', Rule::unique('target_objects', 'code')->ignore($targetObject->id)],
            'name'           => ['required', 'string', 'max:100'],
            'catalog_number' => ['required', 'string', 'max:50'],
            'category'       => ['required', 'string', 'max:50'],
            'description'    => ['nullable', 'string'],
        ]);

        $targetObject->update($validated);

        return redirect()
            ->route('target-objects.index')
            ->with('success', 'Data objek sasaran berhasil diperbarui.');
    }

    public function destroy(TargetObject $targetObject): RedirectResponse
    {
        if ($targetObject->observationSessions()->exists()) {
            return back()->with('error', 'Objek sasaran tidak dapat dihapus karena masih digunakan pada sesi pengamatan.');
        }

        $targetObject->delete();

        return redirect()
            ->route('target-objects.index')
            ->with('success', 'Objek sasaran berhasil dihapus.');
    }
}