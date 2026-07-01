@extends('layouts.app')

@section('title', __('Chat') . ' | NyumbaHub')

@push('styles')
<style>
.chat-wrapper {
    max-width: 800px;
    margin: 20px auto;
    background: var(--surface, #fff);
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    height: 75vh;
    min-height: 500px;
    overflow: hidden;
    border: 1px solid var(--border, #ebebeb);
}

.chat-header {
    padding: 16px 24px;
    border-bottom: 1px solid var(--border, #ebebeb);
    background: var(--bg-soft, #f8f9fa);
    display: flex;
    align-items: center;
    gap: 16px;
}

.chat-back-btn {
    color: var(--text-light, #666);
    font-size: 18px;
    text-decoration: none;
    transition: color 0.2s;
}

.chat-back-btn:hover {
    color: var(--primary, #1b4332);
}

.chat-user-info {
    flex: 1;
}

.chat-user-name {
    font-weight: 700;
    font-size: 16px;
    color: var(--text, #222);
    margin-bottom: 2px;
}

.chat-property-link {
    font-size: 12px;
    color: var(--accent, #d4a853);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.chat-property-link:hover {
    text-decoration: underline;
}

.chat-messages {
    flex: 1;
    padding: 24px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
    background: var(--bg, #fff);
}

.message-row {
    display: flex;
    flex-direction: column;
    max-width: 75%;
}

.message-row.sent {
    align-self: flex-end;
}

.message-row.received {
    align-self: flex-start;
}

.message-bubble {
    padding: 12px 16px;
    border-radius: 16px;
    font-size: 14px;
    line-height: 1.5;
    position: relative;
    word-break: break-word;
}

.message-row.sent .message-bubble {
    background: var(--primary, #1b4332);
    color: #fff;
    border-bottom-right-radius: 4px;
}

.message-row.received .message-bubble {
    background: var(--bg-soft, #f1f5f9);
    color: var(--text, #222);
    border-bottom-left-radius: 4px;
}

.message-time {
    font-size: 11px;
    color: var(--text-muted, #888);
    margin-top: 4px;
}

.message-row.sent .message-time {
    text-align: right;
}

.chat-input-area {
    padding: 16px 24px;
    border-top: 1px solid var(--border, #ebebeb);
    background: var(--surface, #fff);
}

.chat-form {
    display: flex;
    gap: 12px;
}

.chat-input {
    flex: 1;
    padding: 14px 16px;
    border: 1px solid var(--border, #cbd5e1);
    border-radius: 24px;
    outline: none;
    font-family: inherit;
    font-size: 14px;
    resize: none;
    background: var(--bg, #fff);
    color: var(--text, #222);
    transition: border-color 0.2s;
}

.chat-input:focus {
    border-color: var(--primary, #1b4332);
}

.chat-send-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--accent, #d4a853);
    color: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.2s, background 0.2s;
}

.chat-send-btn:hover {
    transform: scale(1.05);
    background: var(--primary, #1b4332);
}

.chat-send-btn:disabled {
    background: var(--border, #cbd5e1);
    cursor: not-allowed;
    transform: none;
}

/* Scrollbar styling for chat */
.chat-messages::-webkit-scrollbar {
    width: 6px;
}
.chat-messages::-webkit-scrollbar-track {
    background: transparent;
}
.chat-messages::-webkit-scrollbar-thumb {
    background: var(--border, #ccc);
    border-radius: 3px;
}
</style>
@endpush

@section('content')
@php
    $otherPerson = auth()->id() === $conversation->user_id ? $conversation->agent : $conversation->user;
@endphp

<div class="container-wide">
    <div class="chat-wrapper">
        {{-- Header --}}
        <div class="chat-header">
            <a href="{{ route('messages.index') }}" class="chat-back-btn" aria-label="Back to Inbox">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            
            <div class="conversation-avatar" style="width:40px;height:40px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:bold;">
                {{ strtoupper(substr($otherPerson->first_name, 0, 1)) }}
            </div>
            
            <div class="chat-user-info">
                <div class="chat-user-name">{{ $otherPerson->first_name }} {{ $otherPerson->last_name }}</div>
                <a href="{{ route('listings.show', $conversation->property->slug) }}" class="chat-property-link" target="_blank">
                    <i class="fa-solid fa-house"></i> {{ Str::limit($conversation->property->title, 40) }}
                </a>
            </div>
        </div>

        {{-- Messages Area --}}
        <div class="chat-messages" id="chatMessages">
            @if($conversation->messages->isEmpty())
                <div style="text-align:center; color:var(--text-muted); margin:auto; padding:20px;">
                    <i class="fa-regular fa-comments" style="font-size:32px; margin-bottom:12px;"></i>
                    <p>{{ __('No messages here yet. Start the conversation!') }}</p>
                </div>
            @else
                @php
                    $lastDate = null;
                @endphp
                @foreach($conversation->messages as $msg)
                    @php
                        $msgDate = $msg->created_at->format('Y-m-d');
                    @endphp
                    
                    @if($lastDate !== $msgDate)
                        <div style="text-align:center; margin: 16px 0;">
                            <span style="background:var(--border-light, #f1f5f9); color:var(--text-muted); font-size:11px; padding:4px 12px; border-radius:12px; font-weight:600;">
                                {{ $msg->created_at->isToday() ? __('Today') : ($msg->created_at->isYesterday() ? __('Yesterday') : $msg->created_at->format('M d, Y')) }}
                            </span>
                        </div>
                        @php $lastDate = $msgDate; @endphp
                    @endif

                    @if($msg->sender_id === auth()->id())
                        {{-- Sent Message --}}
                        <div class="message-row sent">
                            <div class="message-bubble">
                                {{ $msg->message }}
                            </div>
                            <div class="message-time">
                                {{ $msg->created_at->format('H:i') }}
                                @if($msg->read_at)
                                    <i class="fa-solid fa-check-double" style="color:var(--accent); margin-left:4px;" title="Read"></i>
                                @else
                                    <i class="fa-solid fa-check" style="margin-left:4px;" title="Delivered"></i>
                                @endif
                            </div>
                        </div>
                    @else
                        {{-- Received Message --}}
                        <div class="message-row received">
                            <div class="message-bubble">
                                {{ $msg->message }}
                            </div>
                            <div class="message-time">
                                {{ $msg->created_at->format('H:i') }}
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        {{-- Input Area --}}
        <div class="chat-input-area">
            <form action="{{ route('messages.store', $conversation) }}" method="POST" class="chat-form" id="chatForm">
                @csrf
                <textarea 
                    name="message" 
                    class="chat-input" 
                    id="messageInput"
                    placeholder="{{ __('Type a message...') }}" 
                    rows="1" 
                    required 
                    maxlength="1000"
                    oninput="this.style.height = '';this.style.height = Math.min(this.scrollHeight, 120) + 'px'"
                ></textarea>
                <button type="submit" class="chat-send-btn" id="sendBtn" aria-label="Send Message">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
            @error('message')
                <div style="color: #ef4444; font-size: 12px; margin-top: 8px;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const messagesContainer = document.getElementById('chatMessages');
        const input = document.getElementById('messageInput');
        const form = document.getElementById('chatForm');
        const sendBtn = document.getElementById('sendBtn');
        
        // Scroll to bottom immediately
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Auto-focus input on desktop
        if(window.innerWidth > 768) {
            input.focus();
        }

        // Submit on Enter (Shift+Enter for new line)
        input.addEventListener('keydown', function(e) {
            if(e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if(input.value.trim() !== '') {
                    sendBtn.disabled = true;
                    form.submit();
                }
            }
        });

        form.addEventListener('submit', function() {
            if(input.value.trim() === '') {
                return false;
            }
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        });
    });
</script>
@endpush
