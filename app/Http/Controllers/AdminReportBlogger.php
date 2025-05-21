<?php

namespace App\Http\Controllers;

use App\Models\LaporanBlogger;
use Illuminate\Http\Request;

class AdminReportBlogger extends Controller
{
    public function index()
    {
        $reportsblogger = LaporanBlogger::with(['user', 'blogger'])->latest()->paginate(10);
        return view('halaman.admin_report_blogger', compact('reportsblogger'));
    }

    public function updateStatus(Request $request, $id)
    {
        $report = LaporanBlogger::with('blogger')->findOrFail($id);
        $status = $request->input('status');

        if (!in_array($status, ['pending', 'diterima', 'ditolak'])) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        if ($status === 'diterima') {
            if ($report->blogger) {
                $report->blogger->delete();
            }

            $report->status = $status;
            $report->save();

            return redirect()->back()->with('success', 'Postingan berhasil dihapus karena laporan diterima');
        }

        $report->status = $status;
        $report->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diubah');
    }
}
