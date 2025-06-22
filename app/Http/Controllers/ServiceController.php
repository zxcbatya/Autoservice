<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::all();

        return view('admin.service.index', ['services' => $services]);
    }

    public function create(): View
    {
        return view('admin.service.create');
    }

    public function edit(int $id): View
    {
        $service = Service::query()->where(['id' => $id])->first();
        return view('admin.service.edit', ['service' => $service]);
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $image = $validated['image'];
        $path = $image->store('images', 'public');

        $validated['image'] = $path;

        Service::query()->create($validated);

        return \redirect()->route('admin.service.index')->with('success', 'Сервис добавлен');
    }

    public function update(UpdateServiceRequest $request, int $id): RedirectResponse
    {
        $path = null;
        $service = Service::query()->where(['id' => $id])->first();
        $validated = $request->validated();
        $image = $validated['image'] ?? null;
        if ($image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
            $path = $image->store('images', 'public');
        }
        $validated['image'] = $path ?? $service->image;
        $service->update($validated);

        return redirect()->route('admin.service.index');
    }

    public function delete(int $id): RedirectResponse
    {
        $service = Service::query()->where(['id' => $id])->first();
        if (Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();

        return redirect()->route('admin.service.index');
    }
}
