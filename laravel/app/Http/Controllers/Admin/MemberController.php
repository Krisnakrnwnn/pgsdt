<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'member');

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['pending', 'active', 'rejected'])) {
            $query->where('member_status', $request->status);
        }

        // Search functionality - gunakan filled() agar tidak filter saat kosong
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('register_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort      = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['name', 'created_at', 'member_status', 'kabupaten', 'register_number'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        $query->orderBy($sort, $direction === 'asc' ? 'asc' : 'desc');

        $members = $query->paginate(25)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function show(User $member)
    {
        return view('admin.members.show', compact('member'));
    }

    public function edit(User $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:users,nik,' . $member->id],
            'phone' => 'nullable|string|max:20',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
        ]);

        $oldStatus = $member->member_status;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($member->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($member->image_path);
            }
            $member->image_path = $request->file('image')->store('members', 'public');
        }

        $member->name = $request->name;
        $member->nik = $request->nik;
        $member->phone = $request->phone;
        $member->kabupaten = $request->kabupaten;
        $member->kecamatan = $request->kecamatan;
        $member->desa = $request->desa;
        $member->save();

        // Send notification if status changed to active
        if ($oldStatus !== 'active' && $request->member_status === 'active') {
            $member->notify(new \App\Notifications\MemberVerifiedNotification('approved'));
        }

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function verify(User $member)
    {
        $oldStatus = $member->member_status;
        $member->member_status = 'active';
        $member->save();

        // Send notification to member
        if ($oldStatus !== 'active') {
            $member->notify(new \App\Notifications\MemberVerifiedNotification('approved'));
        }

        return back()->with('success', 'Anggota berhasil diverifikasi dan sekarang berstatus Aktif.');
    }

    public function destroy(User $member)
    {
        $member->delete();
        return back()->with('success', 'Anggota berhasil dihapus dari sistem.');
    }

    public function export()
    {
        $members = User::where('role', 'member')
                       ->select('register_number','name','nik','email','phone','kabupaten','kecamatan','desa','member_status','created_at')
                       ->orderBy('created_at', 'desc')
                       ->cursor(); // cursor() untuk hemat memori saat data banyak

        $fileName = 'data_krama_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = ['No. Register', 'Nama Lengkap', 'NIK', 'Email', 'No. WhatsApp', 'Kabupaten', 'Kecamatan', 'Desa', 'Tanggal Daftar'];

        $callback = function () use ($members, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM agar Excel baca dengan benar
            fputcsv($file, $columns);

            foreach ($members as $member) {
                fputcsv($file, [
                    $member->register_number,
                    $member->name,
                    $member->nik,
                    $member->email,
                    $member->phone ?? '-',
                    $member->kabupaten ?? '-',
                    $member->kecamatan ?? '-',
                    $member->desa ?? '-',
                    $member->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
