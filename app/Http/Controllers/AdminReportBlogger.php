<?php

namespace App\Http\Controllers;

use App\Models\LaporanBlogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

            Session::flash('message', 'Postingan berhasil dihapus karena laporan diterima');
            return redirect()->back();
        }

        $report->status = $status;
        $report->save();

        Session::flash('message', 'Status laporan berhasil diubah');
        return redirect()->back();
    }
}
