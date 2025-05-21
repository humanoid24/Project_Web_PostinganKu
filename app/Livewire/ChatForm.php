<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatForm extends Component
{
    public $user = null;
    public $message = '';
    public $messages = [];

    protected $listeners = ['contactSelected'];

    public function contactSelected($userId)
    {
        $this->user = User::find($userId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->user) {
            $this->messages = [];
            return;
        }

        $messagesCollection = Message::where(function ($query) {
            $query->where('from_user_id', Auth::id())
                ->where('to_user_id', $this->user->id);
        })
            ->orWhere(function ($query) {
                $query->where('from_user_id', $this->user->id)
                    ->where('to_user_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Update pesan yang belum dibaca
        $messagesCollection->filter(function ($message) {
            return $message->from_user_id !== Auth::id() && $message->is_read == false;
        })->each(function ($message) {
            $message->update(['is_read' => true]);
        });

        $this->messages = $messagesCollection->toArray();
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string',
        ]);

        if (!$this->user) {
            return;
        }

        Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $this->user->id,
            'message' => $this->message,
        ]);

        $this->dispatch('messageSent'); // Lebih simpel, kirim event saja

        $this->reset('message');

        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat-form');
    }
}
