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

    <title>Course Live Broadcast</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.Teacher.LinkHeader')

    <style>
        .broadcast-container {
            position: relative;
            width: 100%;
            background: #000;
            aspect-ratio: 16/9;
        }
        .broadcast-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
        }
        .broadcast-controls {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            padding: 1rem;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        .stream-info {
            background: rgba(0,0,0,0.1);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .stream-key {
            font-family: monospace;
            background: #f8f9fa;
            padding: 0.5rem;
            border-radius: 0.25rem;
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
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Live Broadcast - {{ $course->name }}</h5>
                                    <div>
                                        @if(!$broadcast)
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scheduleBroadcastModal">
                                                <i class="bx bx-calendar-plus me-1"></i> Schedule Broadcast
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if($broadcast)
                                        <div class="stream-info">
                                            <h6>Stream Information</h6>
                                            <p><strong>Title:</strong> {{ $broadcast->title }}</p>
                                            <p><strong>Status:</strong> {!! $broadcast->status_badge !!}</p>
                                            @if($broadcast->scheduled_start)
                                                <p><strong>Scheduled Start:</strong> {{ $broadcast->scheduled_start->format('M d, Y H:i') }}</p>
                                            @endif
                                            <p><strong>Stream Key:</strong> <span class="stream-key">{{ $broadcast->stream_key }}</span></p>
                                            <p><strong>Stream URL:</strong> <span class="stream-key">{{ $broadcast->stream_url }}</span></p>
                                        </div>

                                        <div class="broadcast-container">
                                            @if($broadcast->status === 'scheduled')
                                                <div class="broadcast-overlay">
                                                    <i class="bx bx-broadcast" style="font-size: 4rem;"></i>
                                                    <h4 class="mt-2">Broadcast Not Started</h4>
                                                    <p>Scheduled for {{ $broadcast->scheduled_start->format('M d, Y H:i') }}</p>
                                                    <form action="{{ route('teacher.course.broadcast.start', ['course' => $course->id, 'broadcast' => $broadcast->id]) }}" method="POST" class="mt-3">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bx bx-play-circle me-1"></i> Start Broadcast
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($broadcast->status === 'live')
                                                <div id="broadcastPlayer"></div>
                                                <div class="broadcast-controls">
                                                    <form action="{{ route('teacher.course.broadcast.end', ['course' => $course->id, 'broadcast' => $broadcast->id]) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bx bx-stop-circle me-1"></i> End Broadcast
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bx bx-broadcast mb-3" style="font-size: 4rem;"></i>
                                            <h4>No Broadcast Scheduled</h4>
                                            <p>Click the "Schedule Broadcast" button to create a new broadcast.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
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

<!-- Schedule Broadcast Modal -->
<div class="modal fade" id="scheduleBroadcastModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Broadcast</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="scheduleBroadcastForm" action="{{ route('teacher.course.broadcast.schedule', $course->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Scheduled Start Time</label>
                        <input type="datetime-local" class="form-control" name="scheduled_start" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('layouts.Teacher.LinkJS')

<script>
    @if($broadcast && $broadcast->status === 'live')
        const videoElement = document.createElement('video');
        videoElement.autoplay = true;
        videoElement.playsInline = true;
        videoElement.muted = true;
        videoElement.style.width = '100%';
        videoElement.style.height = '100%';

        document.getElementById('broadcastPlayer').appendChild(videoElement);

        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then((stream) => {
                videoElement.srcObject = stream;
                // If you want to stream it to a server, add code here to send it.
            })
            .catch((error) => {
                console.error('Error accessing camera:', error);
                alert('Could not access your camera and microphone. Please allow permissions.');
            });
    @endif
</script>

</body>
</html> 