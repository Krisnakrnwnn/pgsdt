<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AgendaRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaPopupController extends Controller
{
    /**
     * Handle agenda registration from popup after user registration
     */
    public function registerFromPopup(Request $request)
    {
        $agendaId = $request->input('agenda_id');
        $agenda = Agenda::findOrFail($agendaId);

        // Validasi apakah registrasi masih dibuka
        if (!$agenda->registration_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran untuk agenda ini tidak dibuka.'
            ], 400);
        }

        // Cek apakah sudah terdaftar
        $isRegistered = AgendaRegistration::where('agenda_id', $agenda->id)
                                          ->where('user_id', Auth::id())
                                          ->exists();
        if ($isRegistered) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar di agenda ini.'
            ], 400);
        }

        // Cek kuota
        if ($agenda->quota > 0) {
            $confirmedCount = AgendaRegistration::where('agenda_id', $agenda->id)
                                                ->where('status', 'confirmed')
                                                ->count();
            if ($confirmedCount >= $agenda->quota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mohon maaf, kuota pendaftaran sudah penuh.'
                ], 400);
            }
        }

        // Daftarkan user ke agenda
        AgendaRegistration::create([
            'agenda_id' => $agenda->id,
            'user_id'   => Auth::id(),
            'name'      => Auth::user()->name,
            'phone'     => Auth::user()->phone ?? '-',
            'information_source' => 'Pendaftaran Otomatis',
            'status'    => 'confirmed',
        ]);

        // Kirim notifikasi konfirmasi
        Auth::user()->notify(new \App\Notifications\EventRegistrationNotification($agenda, 'confirmed'));

        // Jika event besok, kirim pengingat sekarang
        if ($agenda->event_date->startOfDay()->equalTo(\Carbon\Carbon::tomorrow()->startOfDay())) {
            Auth::user()->notify(new \App\Notifications\EventReminderNotification($agenda));
        }

        // Clear session so popup doesn't show again
        $request->session()->forget(['show_agenda_popup', 'agenda_for_popup']);

        return response()->json([
            'success' => true,
            'message' => 'Anda berhasil terdaftar di agenda ' . $agenda->title
        ]);
    }

    /**
     * Dismiss the agenda popup for the current session
     */
    public function dismissPopup(Request $request)
    {
        $request->session()->forget(['show_agenda_popup', 'agenda_for_popup']);
        $request->session()->put('agenda_popup_dismissed', true);
        
        return response()->json([
            'success' => true,
            'message' => 'Popup dismissed'
        ]);
    }
}
