<?php

namespace App\Http\Controllers;

use App\Models\LaporanKomentar;
use Illuminate\Http\Request;

class AdminReportCommentController extends Controller
{
    public function index()
    {
        $AdminReport = LaporanKomentar::with(['user', 'comment'])->latest()->paginate(10);
        return view('halaman.admin_report_komentar', compact('AdminReport'));
    }

    public function updateStatus(Request $request, $id)
    {
        $report = LaporanKomentar::findOrFail($id);
        $status = $request->input('status');

        if (!in_array($status, ['pending', 'diterima', 'ditolak'])) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        if ($status === 'diterima') {
            // Hapus komentar terkait
            if ($report->comment) {
                $report->comment->delete();
            } else {
                $message = 'Komentar sudah tidak tersedia, namun status laporan tetap diperbarui';
            }
            // Opsional: hapus laporan juga
            // $report->delete();
            $report->status = $status;
            $report->save();

            return redirect()->back()->with('success', 'Komentar berhasil dihapus karena laporan diterima');
        }

        // Kalau statusnya 'pending' atau 'ditolak', cukup update status
        $report->status = $status;
        $report->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diubah');
    }
}
