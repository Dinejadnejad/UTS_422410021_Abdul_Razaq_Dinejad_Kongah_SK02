<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObservationSessionRequest;
use App\Http\Requests\UpdateObservationSessionRequest;
use App\Models\Equipment;
use App\Models\ObservationSession;
use App\Models\TargetObject;
use App\Services\ObservationSessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ObservationSessionController extends Controller
{
    public function __construct(
        protected ObservationSessionService $service
    ) {}

    public function index(Request $request): View
    {
        $sessions = $this->service->getFilteredSessions(
            $request->only(['search', 'target_object_id', 'weather_condition'])
        );
        $targetObjects = TargetObject::orderBy('name')->get();

        return view('sessions.index', compact('sessions', 'targetObjects'));
    }

    public function create(): View
    {
        $targetObjects = TargetObject::orderBy('name')->get();
        $equipments = Equipment::orderBy('name')->get();

        return view('sessions.create', compact('targetObjects', 'equipments'));
    }

    public function store(StoreObservationSessionRequest $request): RedirectResponse
    {
        $this->service->createSession($request->validated());

        return redirect()
            ->route('observation-sessions.index')
            ->with('success', 'Sesi pengamatan astronomi berhasil ditambahkan.');
    }

    public function show(ObservationSession $observationSession): View
    {
        $observationSession->load(['targetObject', 'location', 'equipments']);

        return view('sessions.show', compact('observationSession'));
    }

    public function edit(ObservationSession $observationSession): View
    {
        $observationSession->load(['location', 'equipments']);
        $targetObjects = TargetObject::orderBy('name')->get();
        $equipments = Equipment::orderBy('name')->get();

        return view('sessions.edit', compact('observationSession', 'targetObjects', 'equipments'));
    }

    public function update(UpdateObservationSessionRequest $request, ObservationSession $observationSession): RedirectResponse
    {
        $this->service->updateSession($observationSession, $request->validated());

        return redirect()
            ->route('observation-sessions.index')
            ->with('success', 'Data sesi pengamatan berhasil diperbarui.');
    }

    public function destroy(ObservationSession $observationSession): RedirectResponse
    {
        $this->service->deleteSession($observationSession);

        return redirect()
            ->route('observation-sessions.index')
            ->with('success', 'Sesi pengamatan berhasil dihapus.');
    }
}