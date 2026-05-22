<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\AgendaRegistration;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    public function export(Agenda $agenda)
    {
        $status = request('status');
        $query  = AgendaRegistration::with('user')
                                    ->where('agenda_id', $agenda->id)
                                    ->latest();

        if ($status && in_array($status, ['confirmed', 'cancelled', 'pending'])) {
            $query->where('status', $status);
        }

        $registrations = $query->get();

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setTitle('Peserta Agenda');

        // Header agenda
        $activeWorksheet->setCellValue('A1', 'Daftar Peserta Agenda: ' . $agenda->title);
        $activeWorksheet->mergeCells('A1:I1');
        $activeWorksheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Header tabel
        $headers = ['No', 'Nama Lengkap', 'Email', 'No. WhatsApp', 'Kabupaten', 'Status', 'Sumber Informasi', 'Catatan', 'Tanggal Daftar'];
        $activeWorksheet->fromArray($headers, NULL, 'A3');

        // Style header row
        $headerRange = 'A3:I3';
        $activeWorksheet->getStyle($headerRange)->getFont()->setBold(true);
        $activeWorksheet->getStyle($headerRange)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD7A15C'); // Gold/Amber matching the admin theme
        $activeWorksheet->getStyle($headerRange)->getFont()->getColor()->setARGB('FFFFFFFF'); // White text

        // Data
        $row = 4;
        $no = 1;
        foreach ($registrations as $reg) {
            $activeWorksheet->setCellValue('A' . $row, $no++);
            $activeWorksheet->setCellValue('B' . $row, $reg->name);
            $activeWorksheet->setCellValue('C' . $row, $reg->user->email ?? '-');
            $activeWorksheet->setCellValue('D' . $row, $reg->phone ?? '-');
            $activeWorksheet->setCellValue('E' . $row, $reg->user->kabupaten ?? '-');
            $activeWorksheet->setCellValue('F' . $row, ucfirst($reg->status));
            $activeWorksheet->setCellValue('G' . $row, $reg->information_source ?? '-');
            $activeWorksheet->setCellValue('H' . $row, $reg->notes ?? '-');
            $activeWorksheet->setCellValue('I' . $row, $reg->created_at->format('Y-m-d H:i:s'));
            $row++;
        }

        // Auto fit column widths
        foreach (range('A', 'I') as $columnID) {
            $activeWorksheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Border styling
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FFCCCCCC'],
                ],
            ],
        ];
        $activeWorksheet->getStyle('A3:I' . ($row - 1))->applyFromArray($styleArray);

        $safeAgendaTitle = \Illuminate\Support\Str::slug($agenda->title, '_');
        $fileName = 'peserta_agenda_' . $safeAgendaTitle . '_' . date('Y-m-d') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
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
