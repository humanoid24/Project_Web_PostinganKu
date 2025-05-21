<?php

namespace App\Livewire;

use App\Models\LaporanBlogger;
use App\Models\LaporanKomentar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsDropdown extends Component
{
    public Collection $notifications;
    public $selectedNotif = null;
    public bool $showModal = false;
    public int $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $userId = Auth::id();

        $komentar = LaporanKomentar::where('to_user_id', $userId)
            ->where('status', 'diterima')
            ->latest()
            ->get();

        $blogger = LaporanBlogger::where('to_user_id', $userId)
            ->where('status', 'diterima')
            ->latest()
            ->get();

        $merged = $komentar->concat($blogger)
            ->sortByDesc('updated_at')
            ->values();

        $this->notifications = $merged;
        $this->unreadCount = $this->notifications->where('is_read', false)->count();
    }

    public function markAsRead($id, $type)
    {
        $notif = $this->findNotifByTypeAndId($type, $id);

        if ($notif && !$notif->is_read) {
            $notif->is_read = true;
            $notif->save();
        }

        $this->selectedNotif = $notif;
        $this->showModal = true;
        $this->loadNotifications();
    }

    public function removeNotification($id)
    {
        if (!$this->selectedNotif) return;

        $notif = $this->findNotifByTypeAndId(
            $this->getNotifType($this->selectedNotif),
            $id
        );

        if ($notif) {
            $notif->to_user_id = null; // "Menghapus" notifikasi untuk user
            $notif->save();
        }

        $this->closeModal();
        $this->loadNotifications();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedNotif = null;
    }

    protected function findNotifByTypeAndId(string $type, int $id): ?object
    {
        if ($type === 'komentar') {
            return LaporanKomentar::where('id', $id)
                ->where('to_user_id', Auth::id())
                ->first();
        }

        return LaporanBlogger::where('id', $id)
            ->where('to_user_id', Auth::id())
            ->first();
    }

    protected function getNotifType($notif): string
    {
        return $notif instanceof LaporanKomentar ? 'komentar' : 'blogger';
    }

    public function render()
    {
        return view('livewire.notifications-dropdown');
    }
}
