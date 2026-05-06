<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\AgendaRegistration;
use Illuminate\Http\Request;

class AgendaRegistrationController extends Controller
{
    public function index(Agenda $agenda)
    {
        $status = request('status');
        $query  = AgendaRegistration::with('user')
                                    ->where('agenda_id', $agenda->id)
                                    ->latest();

        if ($status && in_array($status, ['confirmed', 'cancelled', 'pending'])) {
            $query->where('status', $status);
        }

        $registrations = $query->paginate(25)->withQueryString();

        return view('admin.agendas.registrations', compact('agenda', 'registrations'));
    }

    public function updateStatus(Request $request, AgendaRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $oldStatus = $registration->status;
        $registration->status = $request->status;
        $registration->save();

        // Kirim notifikasi jika status berubah ke confirmed atau cancelled
        if ($oldStatus !== $request->status && $registration->user) {
            $notifStatus = $request->status === 'confirmed' ? 'confirmed' : 'cancelled';
            $registration->user->notify(new \App\Notifications\EventRegistrationNotification(
                $registration->agenda,
                $notifStatus
            ));
        }

        return back()->with('success', 'Status pendaftaran peserta berhasil diperbarui.');
    }

    public function destroy(AgendaRegistration $registration)
    {
        $registration->delete();
        return back()->with('success', 'Pendaftaran peserta berhasil dihapus.');
    }
}
