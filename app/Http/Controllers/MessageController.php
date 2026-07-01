<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Listing;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MessageController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of conversations (Inbox).
     */
    public function index()
    {
        $user = Auth::user();

        // Get conversations where user is either the seeker or the agent
        $conversations = Conversation::with(['user', 'agent', 'property', 'messages' => function ($query) {
                $query->latest();
            }])
            ->where('user_id', $user->id)
            ->orWhere('agent_id', $user->id)
            ->get()
            ->sortByDesc(function ($conversation) {
                return $conversation->messages->first() ? $conversation->messages->first()->created_at : $conversation->created_at;
            });

        return view('messages.index', compact('conversations'));
    }

    /**
     * Display the specific conversation chat view.
     */
    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        // Mark unread messages sent by the OTHER person as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $conversation->load(['messages.sender', 'property', 'user', 'agent']);

        return view('messages.show', compact('conversation'));
    }

    /**
     * Start a new conversation from a property listing.
     */
    public function start(Request $request, Listing $listing)
    {
        $user = Auth::user();
        $agent_id = $listing->user_id;

        // Cannot message yourself
        if ($user->id === $agent_id) {
            return redirect()->back()->with('error', 'You cannot message yourself about your own property.');
        }

        // Check if conversation already exists
        $conversation = Conversation::firstOrCreate(
            [
                'user_id' => $user->id,
                'agent_id' => $agent_id,
                'property_id' => $listing->id,
            ]
        );

        return redirect()->route('messages.show', $conversation);
    }

    /**
     * Store a new message in the conversation.
     */
    public function store(Request $request, Conversation $conversation)
    {
        $this->authorize('update', $conversation);

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Touch conversation to update its updated_at timestamp
        $conversation->touch();

        return redirect()->route('messages.show', $conversation);
    }
}
