<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $broadcast->title }} - Live Broadcast</title>
    <link rel="stylesheet" href="{{ asset('web_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/elzero.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .broadcast-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .video-container {
            position: relative;
            width: 100%;
            background: #000;
            aspect-ratio: 16/9;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
        }

        .broadcast-info {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .broadcast-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .status-live {
            background: #dc3545;
            color: white;
        }

        .status-scheduled {
            background: #ffc107;
            color: #000;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 20px;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #e0e0e0;
        }

        .waiting-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }

        .waiting-message i {
            font-size: 48px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    @include('layouts.Student.header')

    <div class="broadcast-container">
        <a href="{{ route('student.course.content', $course->id) }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Course
        </a>

        <div class="broadcast-info">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ $broadcast->title }}</h1>
                <span class="broadcast-status {{ $broadcast->status === 'live' ? 'status-live' : 'status-scheduled' }}">
                    {{ $broadcast->status === 'live' ? 'LIVE' : 'Scheduled' }}
                </span>
            </div>
            <p>{{ $broadcast->description }}</p>
            @if($broadcast->status === 'scheduled')
                <p>
                    <i class="fas fa-clock"></i>
                    Starts at: {{ $broadcast->scheduled_start->format('M d, Y H:i') }}
                </p>
            @endif
        </div>

        <div class="video-container">
            @if($broadcast->status === 'live')
                <video id="broadcastPlayer" autoplay playsinline controls style="width: 100%; height: 100%;">
                    <source src="{{ $broadcast->stream_url }}" type="application/x-mpegURL">
                    Your browser does not support the video tag.
                </video>
            @else
                <div class="waiting-message">
                    <i class="fas fa-broadcast-tower"></i>
                    <h2>Broadcast Not Started</h2>
                    <p>Please wait for the teacher to start the broadcast.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Poll for broadcast status if not live
        @if($broadcast->status !== 'live')
            function checkBroadcastStatus() {
                fetch('{{ route("student.course.broadcast.status", ["course" => $course->id, "broadcast" => $broadcast->id]) }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'live') {
                            window.location.reload();
                        }
                    });
            }

            setInterval(checkBroadcastStatus, 10000); // Check every 10 seconds
        @endif
    </script>
</body>
</html> 