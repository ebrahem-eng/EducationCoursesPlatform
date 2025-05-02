<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Teacher - {{ $course->name }}</title>
    <link rel="stylesheet" href="{{ asset('web_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/elzero.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .chat-wrapper {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .chat-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .chat-header {
            background: #2196f3;
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .chat-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .chat-header .text h3 {
            margin: 0;
            font-size: 1.2rem;
        }

        .chat-header .text .course-name {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .back-to-course {
            margin-left: auto;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }

        .back-to-course:hover {
            background: rgba(255,255,255,0.2);
        }

        .messages-container {
            height: 500px;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }

        .message-row {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(20px);
            animation: messageAppear 0.3s forwards;
        }

        @keyframes messageAppear {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-row.teacher {
            flex-direction: row;
        }

        .message-row.student {
            flex-direction: row-reverse;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 12px;
        }

        .message {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .message.teacher {
            background: white;
            color: #333;
            border-top-left-radius: 4px;
        }

        .message.student {
            background: #2196f3;
            color: white;
            border-top-right-radius: 4px;
        }

        .message-time {
            font-size: 0.75rem;
            margin-top: 4px;
            opacity: 0.7;
        }

        .chat-input {
            padding: 20px;
            background: white;
            border-top: 1px solid #eee;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        .input-group input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            border-color: #2196f3;
            outline: none;
        }

        .input-group button {
            padding: 12px 24px;
            background: #2196f3;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .input-group button:hover {
            background: #1976d2;
            transform: translateY(-2px);
        }

        .input-group button:active {
            transform: translateY(0);
        }

        .input-group button i {
            font-size: 1.1em;
        }

        /* Alert Styling */
        .alert {
            margin-bottom: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-danger {
            background: #fbe9e7;
            color: #c62828;
            border: 1px solid #ffccbc;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.2em;
            cursor: pointer;
            padding: 0;
            color: inherit;
            opacity: 0.7;
        }

        .btn-close:hover {
            opacity: 1;
        }

        /* Scrollbar Styling */
        .messages-container::-webkit-scrollbar {
            width: 8px;
        }

        .messages-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .messages-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .chat-wrapper {
                margin: 20px auto;
                padding: 0 10px;
            }

            .messages-container {
                height: 400px;
            }

            .message {
                max-width: 85%;
            }

            .chat-header .text h3 {
                font-size: 1rem;
            }

            .back-to-course span {
                display: none;
            }
        }
    </style>
</head>
<body>
@include('layouts.Student.header')

<div class="chat-wrapper">
    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
        </div>
    @endif

    @if (session('error_message'))
        <div class="alert alert-danger">
            {{ session('error_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="chat-container">
        <div class="chat-header">
            <img src="{{ asset('Image/' . $teacher->img) }}" alt="{{ $teacher->name }}">
            <div class="text">
                <h3>{{ $teacher->name }}</h3>
                <div class="course-name">{{ $course->name }}</div>
            </div>
            <a href="{{ route('student.course.content', $course->id) }}" class="back-to-course">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Course</span>
            </a>
        </div>

        <div class="messages-container" id="chatContainer">
            @foreach($messages as $message)
                @php
                    $isTeacher = $message->sender_type === 'teacher';
                    $rowClass = $isTeacher ? 'teacher' : 'student';
                    $avatar = $isTeacher ? asset('Image/' . $teacher->img) : (isset($student->img) ? asset('Image/' . $student->img) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name));
                @endphp
                <div class="message-row {{ $rowClass }}">
                    <img src="{{ $avatar }}" class="avatar" alt="{{ $isTeacher ? $teacher->name : $student->name }}">
                    <div class="message {{ $rowClass }}">
                        <div class="message-content">{{ $message->content }}</div>
                        <div class="message-time">{{ $message->created_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="chat-input">
            <form id="messageForm" action="{{ route('student.course.chat.send') }}" method="POST">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="message" 
                        placeholder="Type your message..."
                        required
                        autocomplete="off"
                    >
                    <button type="submit">
                        <i class="fas fa-paper-plane"></i>
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-scroll to bottom of chat
    const chatContainer = document.getElementById('chatContainer');
    if (chatContainer) {
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
                // Clear input
                form.reset();

                // Create new message element
                const messageRow = document.createElement('div');
                messageRow.className = 'message-row student';
                messageRow.innerHTML = `
                    <img src="{{ isset($student->img) ? asset('Image/' . $student->img) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}" 
                         class="avatar" 
                         alt="{{ $student->name }}">
                    <div class="message student">
                        <div class="message-content">${data.message.content}</div>
                        <div class="message-time">${data.message.created_at}</div>
                    </div>
                `;

                // Add message to chat
                chatContainer.appendChild(messageRow);
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to send message. Please try again.');
        });
    });

    // Handle alert dismissal
    document.querySelectorAll('.btn-close').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.alert').remove();
        });
    });
</script>

</body>
</html> 