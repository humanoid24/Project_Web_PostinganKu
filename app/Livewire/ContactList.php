<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ContactList extends Component
{
    use WithPagination;

    public $unreadMessagesCount = [];

    protected $listeners = [
        'messageSent' => 'refreshContactList',
    ];

    public function getUnreadMessagesCount($userId)
    {
        return Message::where('to_user_id', Auth::id())
            ->where('from_user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function refreshContactList()
    {
        // Cukup reset pagination agar refresh
        $this->resetPage();
    }

    public function selectContact($userId)
    {
        $this->dispatch('contactSelected', userId: $userId);
        $this->refreshContactList();
    }

    public function render()
    {
        $users = User::where('id', '!=', Auth::id())->paginate(10);

        // Hitung pesan tidak terbaca
        foreach ($users as $user) {
            $this->unreadMessagesCount[$user->id] = $this->getUnreadMessagesCount($user->id);
        }

        return view('livewire.contact-list', [
            'users' => $users,
            'unreadMessagesCount' => $this->unreadMessagesCount
        ]);
    }
}
