<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Teacher</title>
    <link rel="stylesheet" href="{{ asset('web_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/elzero.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .header {
            position: relative;
            z-index: 100;
            width: 100%;
        }
        .course-details {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            margin: 40px auto !important;
            max-width: 900px;
            padding: 32px 24px 24px 24px;
        }
        .chat-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }
        .chat-header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #007bff;
        }
        .chat-header .text h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #007bff;
        }
        .chat-container {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 18px 12px;
            margin-bottom: 18px;
            min-height: 300px;
            max-height: 350px;
            overflow-y: auto;
        }
        .message-row {
            display: flex;
            align-items: flex-end;
            margin-bottom: 1.2rem;
        }
        .message-row.teacher {
            flex-direction: row-reverse;
        }
        .message-row.student {
            flex-direction: row;
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 10px;
            border: 2px solid #007bff;
            background: #fff;
        }
        .message {
            max-width: 60%;
            padding: 12px 18px;
            border-radius: 18px;
            font-size: 1.05rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            position: relative;
            word-break: break-word;
        }
        .message.teacher {
            background: #e3f2fd;
            color: #0d47a1;
            border-bottom-right-radius: 4px;
            border-bottom-left-radius: 18px;
        }
        .message.student {
            background: #e8f5e9;
            color: #256029;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 18px;
        }
        .message-time {
            font-size: 0.8rem;
            color: #888;
            margin-top: 4px;
            text-align: right;
        }
        .chat-input {
            background: #fff;
            padding: 1rem;
            border-top: 1px solid #eee;
            border-radius: 0 0 12px 12px;
        }
        .input-group input {
            border-radius: 8px 0 0 8px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .input-group button {
            border-radius: 0 8px 8px 0;
            padding: 10px 18px;
            background: #007bff;
            color: #fff;
            border: none;
            font-weight: 600;
            transition: background 0.2s;
        }
        .input-group button:hover {
            background: #0056b3;
        }
        .alert {
            margin-bottom: 18px;
            border-radius: 6px;
            padding: 12px 18px;
            font-size: 1rem;
        }
        @media (max-width: 900px) {
            .course-details {
                padding: 16px 4px 16px 4px;
            }
            .chat-header img {
                width: 40px;
                height: 40px;
            }
            .chat-container {
                min-height: 180px;
                max-height: 220px;
                padding: 8px 2px;
            }
            .message {
                max-width: 80%;
                font-size: 0.98rem;
            }
            .avatar {
                width: 32px;
                height: 32px;
            }
        }
        .header .mega-menu {
            display: flex;
            opacity: 0;
            z-index: -1;
            pointer-events: none;
            top: calc(100% + 50px);
            transition: top var(--main-transition), opacity var(--main-transition);
        }
        .header .main-nav > li:hover .mega-menu {
            opacity: 1;
            z-index: 100;
            pointer-events: auto;
            top: calc(100% + 1px);
        }
    </style>
</head>
<body>
@include('layouts.Student.header')
<div class="course-details">
    @if (session('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
        </div>
    @endif
    @if (session('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
        </div>
    @endif
    <div class="chat-header">
        <img src="{{ asset('Image/' . $teacher->img) }}" alt="{{ $teacher->name }}">
        <div class="text">
            <h3>{{ $teacher->name }}</h3>
            <div class="code">Chatting about: {{ $course->name }}</div>
        </div>
    </div>
    <div class="chat-container" id="chatContainer">
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
                    class="form-control" 
                    name="message" 
                    placeholder="Type your message..."
                    required
                >
                <button class="register-btn" type="submit">
                    <i class="fa fa-paper-plane"></i> Send
                </button>
            </div>
        </form>
    </div>
</div>
<div class="footer">
    <div class="container">
        <div class="box">
            <h3>Elzero</h3>
            <ul class="social">
                <li>
                    <a href="#" class="facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="youtube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </li>
            </ul>
            <p class="text">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Temporibus nulla rem, dignissimos iste aspernatur
            </p>
        </div>
        <div class="box">
            <ul class="links">
                <li><a href="#">Important Link 1</a></li>
                <li><a href="#">Important Link 2</a></li>
                <li><a href="#">Important Link 3</a></li>
            </ul>
        </div>
    </div>
</div>
<script src="{{ asset('web_assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-scroll to bottom of chat
    const chatContainer = document.getElementById('chatContainer');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
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
                // إضافة الرسالة الجديدة مباشرة في الصفحة
                const messageRow = document.createElement('div');
                messageRow.className = 'message-row student';
                messageRow.innerHTML = `
                    <img src=\"{{ isset($student->img) ? asset('Image/' . $student->img) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}\" class=\"avatar\" alt=\"{{ $student->name }}\">
                    <div class=\"message student\">
                        <div class=\"message-content\">${data.message.content}</div>
                        <div class=\"message-time\">${data.message.created_at}</div>
                    </div>
                `;
                chatContainer.appendChild(messageRow);
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
</body>
</html> 