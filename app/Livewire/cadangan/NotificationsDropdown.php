<?php

namespace App\Livewire;

use App\Models\LaporanKomentar;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsDropdown extends Component
{
    public $notifications;
    public $selectedNotif = null;
    public $showModal = false;
    public $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        // Ambil semua notifikasi status "diterima" untuk dropdown
        $this->notifications = LaporanKomentar::where('to_user_id', Auth::id())
            ->where('status', 'diterima')
            ->latest()
            ->get();

        // Hitung berapa yang belum dibaca
        $this->unreadCount = LaporanKomentar::where('to_user_id', Auth::id())
            ->where('status', 'diterima')
            ->where('is_read', false)
            ->count();
    }

    public function markAsRead($id)
    {
        $notif = LaporanKomentar::where('id', $id)
            ->where('to_user_id', Auth::id())
            ->first();

        if ($notif) {
            if (!$notif->is_read) {
                $notif->is_read = true;
                $notif->save();
            }

            // Tampilkan di modal
            $this->selectedNotif = $notif;
            $this->showModal = true;

            // Refresh data
            $this->loadNotifications(); // panggil fungsi yang sudah dibuat
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedNotif = null;
    }

    public function removeNotification($id)
    {
        $notif = LaporanKomentar::where('id', $id)
            ->where('to_user_id', Auth::id())
            ->firstOrFail();

        // Hapus hanya nilai kolom to_user_id, bukan barisnya
        $notif->to_user_id = null;
        $notif->save();

        $this->closeModal();
        $this->loadNotifications();
    }



    public function render()
    {
        return view('livewire.notifications-dropdown');
    }
}
