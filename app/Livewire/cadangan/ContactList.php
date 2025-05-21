<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactList extends Component
{
    public $users;
    public $unreadMessagesCount = [];

    protected $listeners = [
        'messageSent' => 'refreshContactList',
    ];

    public function mount()
    {
        $this->users = User::where('id', '!=', Auth::id())->get();

        foreach ($this->users as $user) {
            $this->unreadMessagesCount[$user->id] = $this->getUnreadMessagesCount($user->id);
        }
    }

    public function getUnreadMessagesCount($userId)
    {
        return Message::where('to_user_id', Auth::id())
            ->where('from_user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function refreshContactList()
    {
        foreach ($this->users as $user) {
            $this->unreadMessagesCount[$user->id] = $this->getUnreadMessagesCount($user->id);
        }
    }

    public function selectContact($userId)
    {
        $this->dispatch('contactSelected', userId: $userId);

        // Tambahkan refresh setelah buka chat
        $this->refreshContactList();
    }

    public function render()
    {
        return view('livewire.contact-list', [
            'users' => $this->users,
            'unreadMessagesCount' => $this->unreadMessagesCount
        ]);
    }
}
