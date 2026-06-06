<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AgendaRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaRegistrationController extends Controller
{
    public function create($slug)
    {
        $agenda = Agenda::where('slug', $slug)->firstOrFail();

        // Cek apakah registrasi diaktifkan
        if (!$agenda->registration_enabled) {
            return redirect()->route('events.show', $slug)->with('error', 'Pendaftaran untuk agenda ini tidak dibuka.');
        }

        // Cek apakah agenda sudah terlaksana atau tanggalnya sudah terlewati
        if ($agenda->status !== 'upcoming' || $agenda->event_date->isPast()) {
            return redirect()->route('events.show', $slug)->with('error', 'Pendaftaran tidak dapat dilakukan karena agenda ini telah selesai atau dibatalkan.');
        }

        // Cek apakah sudah terdaftar
        $isRegistered = AgendaRegistration::where('agenda_id', $agenda->id)
                                          ->where('user_id', Auth::id())
                                          ->exists();
        if ($isRegistered) {
            return redirect()->route('events.show', $slug)->with('info', 'Anda sudah terdaftar di agenda ini.');
        }

        // Cek kuota (hanya hitung yang confirmed)
        if ($agenda->quota > 0) {
            $confirmedCount = AgendaRegistration::where('agenda_id', $agenda->id)
                                                ->where('status', 'confirmed')
                                                ->count();
            if ($confirmedCount >= $agenda->quota) {
                return redirect()->route('events.show', $slug)->with('error', 'Mohon maaf, kuota pendaftaran untuk agenda ini sudah penuh.');
            }
        }

        return view('pages.event-register', compact('agenda'));
    }

    public function store(Request $request, $slug)
    {
        $agenda = Agenda::where('slug', $slug)->firstOrFail();

        // Cek apakah registrasi diaktifkan
        if (!$agenda->registration_enabled) {
            return redirect()->route('events.show', $slug)->with('error', 'Pendaftaran untuk agenda ini tidak dibuka.');
        }

        // Cek apakah agenda sudah terlaksana atau tanggalnya sudah terlewati
        if ($agenda->status !== 'upcoming' || $agenda->event_date->isPast()) {
            return redirect()->route('events.show', $slug)->with('error', 'Pendaftaran tidak dapat dilakukan karena agenda ini telah selesai atau dibatalkan.');
        }

        // Validasi duplikat
        $isRegistered = AgendaRegistration::where('agenda_id', $agenda->id)
                                          ->where('user_id', Auth::id())
                                          ->exists();
        if ($isRegistered) {
            return redirect()->route('events.show', $slug)->with('info', 'Anda sudah terdaftar di agenda ini.');
        }

        // Cek kuota (hanya hitung yang confirmed)
        if ($agenda->quota > 0) {
            $confirmedCount = AgendaRegistration::where('agenda_id', $agenda->id)
                                                ->where('status', 'confirmed')
                                                ->count();
            if ($confirmedCount >= $agenda->quota) {
                return redirect()->route('events.show', $slug)->with('error', 'Mohon maaf, kuota pendaftaran sudah penuh.');
            }
        }

        $request->validate([
            'information_source' => 'required|string',
            'other_source' => 'required_if:information_source,Lainnya|nullable|string|max:255',
        ]);

        $source = $request->information_source;
        if ($source === 'Lainnya') {
            $source = 'Lainnya: ' . $request->other_source;
        }

        AgendaRegistration::create([
            'agenda_id' => $agenda->id,
            'user_id'   => Auth::id(),
            'name'      => Auth::user()->name,
            'phone'     => Auth::user()->phone ?? '-',
            'information_source' => $source,
            'status'    => 'confirmed',
        ]);

        // Kirim notifikasi konfirmasi
        Auth::user()->notify(new \App\Notifications\EventRegistrationNotification($agenda, 'confirmed'));

        // Jika event besok, kirim pengingat sekarang
        if ($agenda->event_date->startOfDay()->equalTo(\Carbon\Carbon::tomorrow()->startOfDay())) {
            Auth::user()->notify(new \App\Notifications\EventReminderNotification($agenda));
        }

        return redirect()->route('events.show', $slug)->with('success', 'Pendaftaran Anda berhasil dikonfirmasi! Email konfirmasi telah dikirim.');
    }
}
