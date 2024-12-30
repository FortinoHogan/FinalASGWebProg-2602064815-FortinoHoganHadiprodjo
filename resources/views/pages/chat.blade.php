@extends('layouts.master')

@section('content')
    <style>
        .scrollbar-hidden::-webkit-scrollbar {
            width: 0;
            display: none;
        }
    </style>
    <div class="bg-light mx-auto d-flex" style="max-width: 1200px; min-height: 90vh;">
        <div class="w-25 p-3" style="border-right: 1px solid">
            @foreach ($friends as $friend)
                <a href="javascript:void(0)"
                    class="d-flex align-items-center gap-3 text-decoration-none text-black friend-link"
                    data-id="{{ $friend->user_id == auth()->user()->id ? $friend->friend->id : $friend->user->id }}">
                    <img src="{{ $friend->user_id == auth()->user()->id
                        ? $friend->friend->profile_picture ?? asset('assets/img/profile.png')
                        : $friend->user->profile_picture ?? asset('assets/img/profile.png') }}"
                        alt="" style="width: 50px; border-radius: 100%; border: 2px solid; padding: 5px">
                    <p class="mb-0">
                        {{ $friend->user_id == auth()->user()->id ? $friend->friend->name : $friend->user->name }}
                    </p>
                </a>
                <hr>
            @endforeach
        </div>

        <div class="w-75 p-3">
            <div id="chat-box"
                class="scrollbar-hidden" style="border: 1px solid black; min-height: 90vh; padding: 15px; overflow-y: auto; max-height: 90vh;">
                <p class="text-muted text-center">@lang('lang.select_chat')</p>
            </div>
            <form id="send-message-form" method="POST" class="mt-2 d-flex align-items-center">
                @csrf
                <input type="text" name="content" id="message-content" class="form-control me-2"
                    placeholder="@lang('lang.type_message')" required>
                <button type="submit" class="btn btn-primary">@lang('lang.send')</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById('chat-box');
            const sendMessageForm = document.getElementById('send-message-form');
            const messageContentInput = document.getElementById('message-content');
            let currentFriendId = null;

            document.querySelectorAll('.friend-link').forEach(link => {
                link.addEventListener('click', function() {
                    const friendId = this.getAttribute('data-id');
                    currentFriendId = friendId;
                    sendMessageForm.action = `/messages/${friendId}`;
                    chatBox.innerHTML = `<p class="text-muted text-center">Loading messages...</p>`;

                    fetch(`/messages/${friendId}`)
                        .then(response => response.json())
                        .then(data => {
                            chatBox.innerHTML = '';

                            if (data.messages.length > 0) {
                                data.messages.forEach(message => {
                                    const alignment = message.sender_id ===
                                        {{ auth()->user()->id }} ? 'text-end' :
                                        'text-start';
                                    chatBox.innerHTML += `
                                <div class="${alignment}">
                                    <p class="bg-light p-2 rounded d-inline-block">
                                        ${message.content}
                                    </p>
                                </div>
                            `;
                                });
                            } else {
                                chatBox.innerHTML =
                                    `<p class="text-muted text-center">@lang('lang.no_messages')</p>`;
                            }

                            chatBox.scrollTop = chatBox.scrollHeight;
                        })
                        .catch(error => console.error('Error fetching messages:', error));
                });
            });

            sendMessageForm.addEventListener('submit', function(event) {
                event.preventDefault();

                if (!currentFriendId) {
                    alert('Please select a friend to chat with.');
                    return;
                }

                const content = messageContentInput.value;

                fetch(`/messages/${currentFriendId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            content: content
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const newMessage = data.messages[data.messages.length - 1];
                        const alignment = newMessage.sender_id === {{ auth()->user()->id }} ?
                            'text-end' : 'text-start';
                        chatBox.innerHTML += `
                <div class="${alignment}">
                    <p class="bg-light p-2 rounded d-inline-block">
                        ${newMessage.content}
                    </p>
                </div>
            `;

                        chatBox.scrollTop = chatBox.scrollHeight;
                        messageContentInput.value = '';
                    })
                    .catch(error => console.error('Error sending message:', error));
            });
        });
    </script>
@endsection
