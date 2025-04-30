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

    <title>Watch Live Broadcast</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.Student.LinkHeader')

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
        .broadcast-info {
            background: rgba(0,0,0,0.1);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('layouts.Student.Sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('layouts.Student.NavBar')
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ $broadcast->title }}</h5>
                                    <p class="text-muted mb-0">{{ $course->name }}</p>
                                </div>

                                <div class="card-body">
                                    <div class="broadcast-info">
                                        <p><strong>Status:</strong> {!! $broadcast->status_badge !!}</p>
                                        <p><strong>Teacher:</strong> {{ $broadcast->teacher->name }}</p>
                                        @if($broadcast->description)
                                            <p><strong>Description:</strong> {{ $broadcast->description }}</p>
                                        @endif
                                    </div>

                                    <div class="broadcast-container">
                                        @if($broadcast->status === 'scheduled')
                                            <div class="broadcast-overlay">
                                                <i class="bx bx-time" style="font-size: 4rem;"></i>
                                                <h4 class="mt-2">Broadcast Not Started</h4>
                                                <p>Scheduled for {{ $broadcast->scheduled_start->format('M d, Y H:i') }}</p>
                                            </div>
                                        @elseif($broadcast->status === 'live')
                                            <div id="broadcastPlayer"></div>
                                        @else
                                            <div class="broadcast-overlay">
                                                <i class="bx bx-video-off" style="font-size: 4rem;"></i>
                                                <h4 class="mt-2">Broadcast Ended</h4>
                                                @if($broadcast->recorded_url)
                                                    <a href="{{ $broadcast->recorded_url }}" class="btn btn-primary mt-3">
                                                        <i class="bx bx-play me-1"></i> Watch Recording
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Content -->

                <!-- Footer -->
                @include('layouts.Student.Footer')
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

@include('layouts.Student.LinkJS')

<script>
    // Initialize broadcast player if broadcast is live
    @if($broadcast->status === 'live')
        // Add your video player initialization code here
        // Example using Video.js:
        // const player = videojs('broadcastPlayer', {
        //     sources: [{ src: '{{ $broadcast->stream_url }}' }]
        // });
    @endif

    // Polling for broadcast status updates
    @if($broadcast->status === 'scheduled' || $broadcast->status === 'live')
        setInterval(() => {
            fetch('{{ route("student.course.broadcast.status", ["course_id" => $course->id, "broadcast_id" => $broadcast->id]) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status !== '{{ $broadcast->status }}') {
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }, 10000); // Check every 10 seconds
    @endif
</script>

</body>
</html> 