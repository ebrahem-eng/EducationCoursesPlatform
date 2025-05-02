<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $video->name }} - Course Video</title>
    <link rel="stylesheet" href="{{ asset('web_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/elzero.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .video-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .video-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .video-title {
            flex: 1;
        }

        .video-title h1 {
            color: #2196f3;
            font-size: 24px;
            margin: 0 0 10px;
        }

        .video-title p {
            color: #666;
            margin: 0;
            font-size: 16px;
        }

        .video-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .action-btn i {
            margin-right: 8px;
        }

        .back-btn {
            background: #f0f0f0;
            color: #333;
        }

        .back-btn:hover {
            background: #e0e0e0;
        }

        .download-btn {
            background: #4caf50;
            color: white;
        }

        .download-btn:hover {
            background: #43a047;
        }

        .mark-complete-btn {
            background: #2196f3;
            color: white;
        }

        .mark-complete-btn:hover {
            background: #1976d2;
        }

        .mark-complete-btn.completed {
            background: #28a745;
            cursor: default;
        }

        .video-player-container {
            position: relative;
            width: 100%;
            background: #000;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .video-player {
            width: 100%;
            max-height: 600px;
            display: block;
        }

        .video-description {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .video-description h3 {
            color: #2196f3;
            margin: 0 0 10px;
        }

        .video-description p {
            color: #666;
            line-height: 1.6;
            margin: 0;
        }

        @media (max-width: 768px) {
            .video-container {
                margin: 20px;
                padding: 15px;
            }

            .video-header {
                flex-direction: column;
                gap: 15px;
            }

            .video-actions {
                width: 100%;
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }

            .video-title h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.Student.header')

    <div class="video-container">
        <div class="video-header">
            <div class="video-title">
                <h1>{{ $video->name }}</h1>
                @if($video->description)
                    <p>{{ $video->description }}</p>
                @endif
            </div>
            <div class="video-actions">
                <a href="{{ route('student.course.content', $course->id) }}" class="action-btn back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Course
                </a>
                <a href="{{ asset('storage/' . $video->video_url) }}" download class="action-btn download-btn">
                    <i class="fas fa-download"></i> Download Video
                </a>
                @php
                    $isCompleted = \App\Models\VideoProgress::where('student_id', Auth::guard('student')->id())
                        ->where('video_id', $video->id)
                        ->where('completed', true)
                        ->exists();
                @endphp
                <button id="markCompleteBtn" 
                        class="action-btn mark-complete-btn {{ $isCompleted ? 'completed' : '' }}"
                        {{ $isCompleted ? 'disabled' : '' }}
                        onclick="markVideoComplete()">
                    <i class="fas {{ $isCompleted ? 'fa-check' : 'fa-check-circle' }}"></i>
                    {{ $isCompleted ? 'Completed' : 'Mark as Complete' }}
                </button>
            </div>
        </div>

        <div class="video-player-container">
            <video id="videoPlayer" class="video-player" controls controlsList="nodownload">
                <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        @if($video->description)
            <div class="video-description">
                <h3>About this Video</h3>
                <p>{{ $video->description }}</p>
            </div>
        @endif
    </div>

    <script>
        // Handle video completion
        const videoPlayer = document.getElementById('videoPlayer');
        let hasMarkedComplete = false;

        videoPlayer.addEventListener('ended', function() {
            if (!hasMarkedComplete) {
                markVideoComplete();
            }
        });

        function markVideoComplete() {
            const button = document.getElementById('markCompleteBtn');
            if (button.disabled) return;

            fetch("{{ route('student.course.video.complete', ['course_id' => $course->id, 'id' => $video->id]) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    hasMarkedComplete = true;
                    button.classList.add('completed');
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-check"></i> Completed';
                } else {
                    throw new Error(data.message || 'Failed to mark video as complete');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to mark video as complete. Please try again. Error: ' + error.message);
            });
        }
    </script>
</body>

</html>
