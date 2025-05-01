<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Chat with Student</title>

    <meta name="description" content="" />

    @include('layouts.Teacher.LinkHeader')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .chat-container {
            height: calc(100vh - 300px);
            overflow-y: auto;
        }
        .message {
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: 0.5rem;
            max-width: 70%;
        }
        .message.sent {
            background-color: #e3f2fd;
            margin-left: auto;
        }
        .message.received {
            background-color: #f5f5f5;
            margin-right: auto;
        }
        .message-time {
            font-size: 0.75rem;
            color: #666;
            margin-top: 0.25rem;
        }
        .chat-input {
            position: sticky;
            bottom: 0;
            background-color: #fff;
            padding: 1rem;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('layouts.Teacher.Sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('layouts.Teacher.NavBar')
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                Chat with {{ $student->name }}
                                <small class="text-muted">{{ $course->name }}</small>
                            </h5>
                        </div>

                        <div class="card-body chat-container" id="chatContainer">
                            @foreach($messages as $message)
                                <div class="message {{ $message->sender_type === 'teacher' ? 'sent' : 'received' }}">
                                    <div class="message-content">{{ $message->content }}</div>
                                    <div class="message-time">{{ $message->created_at->format('M d, Y H:i') }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer chat-input">
                            <form id="messageForm" action="{{ route('teacher.course.student.chat.send') }}" method="POST">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="message" 
                                        placeholder="Type your message..."
                                        required
                                    >
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bx bx-send"></i> Send
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- / Content -->

                <!-- Footer -->
                @include('layouts.Teacher.Footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

@include('layouts.Teacher.LinkJS')

<script>
    // Auto-scroll to bottom of chat
    const chatContainer = document.getElementById('chatContainer');
    chatContainer.scrollTop = chatContainer.scrollHeight;

    // Real-time updates (you'll need to implement WebSocket/Pusher for this)
    // This is just a placeholder for the real-time functionality
    function setupWebSocket() {
        // Initialize WebSocket connection
        const ws = new WebSocket('ws://your-websocket-server');

        ws.onmessage = function(event) {
            const message = JSON.parse(event.data);
            appendMessage(message);
        };
    }

    function appendMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${message.sender_type === 'teacher' ? 'sent' : 'received'}`;
        messageDiv.innerHTML = `
            <div class="message-content">${message.content}</div>
            <div class="message-time">${message.created_at}</div>
        `;
        chatContainer.appendChild(messageDiv);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Handle form submission
    document.getElementById('messageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                form.reset();
                appendMessage(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

</body>
</html> 