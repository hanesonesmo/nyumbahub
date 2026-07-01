@extends('layouts.app')

@section('title', __('Inbox') . ' | NyumbaHub')

@push('styles')
<style>
.inbox-container {
    max-width: 800px;
    margin: 40px auto;
    background: var(--surface, #fff);
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
}

.inbox-header {
    padding: 24px;
    border-bottom: 1px solid var(--border, #ebebeb);
    background: var(--bg-soft, #f8f9fa);
}

.inbox-header h2 {
    margin: 0;
    font-family: 'Playfair Display', serif;
    color: var(--primary-dark, #0f2d1f);
}

.conversation-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.conversation-item {
    display: flex;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border, #ebebeb);
    text-decoration: none;
    color: inherit;
    transition: background 0.2s ease;
    align-items: center;
    gap: 16px;
}

.conversation-item:hover {
    background: var(--bg-soft, #f8f9fa);
}

.conversation-item:last-child {
    border-bottom: none;
}

.conversation-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--primary, #1b4332);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    flex-shrink: 0;
}

.conversation-details {
    flex: 1;
    min-width: 0;
}

.conversation-title {
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 4px;
    color: var(--text, #222);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.conversation-time {
    font-size: 12px;
    color: var(--text-muted, #888);
    font-weight: normal;
}

.conversation-property {
    font-size: 13px;
    color: var(--accent, #d4a853);
    margin-bottom: 6px;
    font-weight: 500;
}

.conversation-snippet {
    font-size: 14px;
    color: var(--text-light, #666);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.unread-badge {
    background: var(--accent, #d4a853);
    color: #fff;
    font-size: 11px;
    font-weight: bold;
    padding: 2px 8px;
    border-radius: 12px;
    margin-left: 8px;
}

.unread-message {
    font-weight: bold;
    color: var(--text, #222);
}

.empty-inbox {
    padding: 60px 20px;
    text-align: center;
    color: var(--text-muted, #888);
}

.empty-inbox i {
    font-size: 48px;
    color: var(--border, #ccc);
    margin-bottom: 16px;
}
</style>
@endpush

@section('content')
<div class="container-wide">
    <div class="inbox-container">
        <div class="inbox-header">
            <h2>{{ __('Inbox') }}</h2>
        </div>

        @if($conversations->isEmpty())
            <div class="empty-inbox">
                <i class="fa-regular fa-comments"></i>
                <h3>{{ __('No messages yet') }}</h3>
                <p>{{ __('When you contact agents or users, your conversations will appear here.') }}</p>
            </div>
        @else
            <ul class="conversation-list">
                @foreach($conversations as $conversation)
                    @php
                        $otherPerson = auth()->id() === $conversation->user_id ? $conversation->agent : $conversation->user;
                        $latestMessage = $conversation->messages->first();
                        
                        $isUnread = $latestMessage 
                            && $latestMessage->sender_id !== auth()->id() 
                            && is_null($latestMessage->read_at);
                    @endphp
                    
                    <a href="{{ route('messages.show', $conversation) }}" class="conversation-item">
                        <div class="conversation-avatar">
                            {{ strtoupper(substr($otherPerson->first_name, 0, 1)) }}
                        </div>
                        <div class="conversation-details">
                            <div class="conversation-title">
                                {{ $otherPerson->first_name }} {{ $otherPerson->last_name }}
                                @if($latestMessage)
                                    <span class="conversation-time">{{ $latestMessage->created_at->diffForHumans() }}</span>
                                @else
                                    <span class="conversation-time">{{ $conversation->created_at->diffForHumans() }}</span>
                                @endif
                            </div>
                            <div class="conversation-property">
                                <i class="fa-solid fa-house" style="font-size: 11px; margin-right: 4px;"></i> {{ $conversation->property->title }}
                            </div>
                            <div class="conversation-snippet {{ $isUnread ? 'unread-message' : '' }}">
                                @if($latestMessage)
                                    @if($latestMessage->sender_id === auth()->id())
                                        <i class="fa-solid fa-reply" style="font-size: 11px; margin-right: 4px; color: var(--text-muted);"></i>
                                    @endif
                                    {{ Str::limit($latestMessage->message, 80) }}
                                @else
                                    <em>{{ __('No messages yet. Say hello!') }}</em>
                                @endif

                                @if($isUnread)
                                    <span class="unread-badge">New</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
