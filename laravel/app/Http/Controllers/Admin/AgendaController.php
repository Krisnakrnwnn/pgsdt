<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::withCount(['registrations', 'registrations as confirmed_registrations_count' => function ($q) {
                        $q->where('status', 'confirmed');
                    }])
                    ->latest('event_date')
                    ->paginate(15);
        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agendas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'itinerary' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'location_map' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:upcoming,completed,cancelled',
            'quota' => 'required_if:registration_enabled,1|nullable|integer|min:0',
        ]);

        $agenda = new Agenda();
        $agenda->title = $request->title;
        $agenda->slug = Str::slug($request->title) . '-' . time();
        $agenda->description = $request->description;
        $agenda->itinerary = $request->itinerary;
        $agenda->event_date = $request->event_date;
        $agenda->location = $request->location;
        $agenda->location_map = $request->location_map;
        $agenda->status = $request->status;
        $agenda->registration_enabled = $request->has('registration_enabled');
        
        if ($request->has('is_featured')) {
            Agenda::where('is_featured', true)->update(['is_featured' => false]);
            $agenda->is_featured = true;
        } else {
            $agenda->is_featured = false;
        }

        $agenda->quota = $agenda->registration_enabled ? ($request->quota ?? 0) : 0;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('agendas', 'public');
            $agenda->image_path = $imagePath;
        }

        $agenda->save();

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'itinerary' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'location_map' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:upcoming,completed,cancelled',
            'quota' => 'nullable|integer|min:0',
        ]);

        $agenda->title = $request->title;
        if ($agenda->getOriginal('title') !== $request->title) {
            $agenda->slug = Str::slug($request->title) . '-' . time();
        }
        $agenda->description = $request->description;
        $agenda->itinerary = $request->itinerary;
        $agenda->event_date = $request->event_date;
        $agenda->location = $request->location;
        $agenda->location_map = $request->location_map;
        $agenda->status = $request->status;
        $agenda->registration_enabled = $request->has('registration_enabled');

        if ($request->has('is_featured')) {
            Agenda::where('id', '!=', $agenda->id)->where('is_featured', true)->update(['is_featured' => false]);
            $agenda->is_featured = true;
        } else {
            $agenda->is_featured = false;
        }

        $agenda->quota = $agenda->registration_enabled ? ($request->quota ?? 0) : 0;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($agenda->image_path && Storage::disk('public')->exists($agenda->image_path)) {
                Storage::disk('public')->delete($agenda->image_path);
            }
            $imagePath = $request->file('image')->store('agendas', 'public');
            $agenda->image_path = $imagePath;
        }

        $agenda->save();

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function setFeatured(Agenda $agenda)
    {
        // Un-feature all others
        Agenda::where('is_featured', true)->update(['is_featured' => false]);
        
        // Feature this one
        $agenda->update(['is_featured' => true]);

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda "' . $agenda->title . '" berhasil dijadikan Agenda Utama.');
    }

    public function destroy(Agenda $agenda)
    {
        if ($agenda->image_path && Storage::disk('public')->exists($agenda->image_path)) {
            Storage::disk('public')->delete($agenda->image_path);
        }
        $agenda->delete();

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
