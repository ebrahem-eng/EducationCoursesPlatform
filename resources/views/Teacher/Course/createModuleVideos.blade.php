<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Add Module Videos</title>
    <meta name="description" content="" />
    @include('layouts.Teacher.LinkHeader')
</head>

<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('layouts.Teacher.Sidebar')

        <div class="layout-page">
            @include('layouts.Teacher.NavBar')

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    @if (session('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Add Videos to Module: {{ $module->name }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- List of existing videos -->
                            @if($videos->count() > 0)
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Video Name</th>
                                            <th>Description</th>
                                            <th>Video</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($videos as $video)
                                        <tr>
                                            <td>{{ $video->name }}</td>
                                            <td>{{ $video->description }}</td>
                                            <td>
                                                <video width="200" controls>
                                                    <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm delete-video" 
                                                        data-video-id="{{ $video->id }}"
                                                        onclick="return confirm('Are you sure you want to delete this video?')">
                                                    <i class="bx bx-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            <!-- Form to add new videos -->
                            <form method="post" action="{{ route('teacher.course.module.videos.store') }}" id="videosForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="module_id" value="{{ $module->id }}">
                                
                                <div id="videos-container">
                                    <div class="row video-row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Video Name</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-video"></i></span>
                                                <input type="text" name="videos[0][name]" class="form-control" required>
                                            </div>
                                            @error('videos.0.name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Description</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-detail"></i></span>
                                                <input type="text" name="videos[0][description]" class="form-control" required>
                                            </div>
                                            @error('videos.0.description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Video File</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-upload"></i></span>
                                                <input type="file" name="videos[0][video_file]" class="form-control" accept="video/mp4,video/mov,video/avi" required>
                                            </div>
                                            <small class="text-muted">Max file size: 500MB. Supported formats: MP4, MOV, AVI</small>
                                            @error('videos.0.video_file')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-video" style="display: none;">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-secondary" id="add-video">
                                        <i class="bx bx-plus"></i> Add Another Video
                                    </button>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Save Videos</button>
                                    <a href="{{ route('teacher.course.index') }}" class="btn btn-secondary">Back to Courses</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @include('layouts.Teacher.Footer')
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>

@include('layouts.Teacher.LinkJS')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('videos-container');
    const addButton = document.getElementById('add-video');
    let videoCount = 0;

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-video');
        removeButtons.forEach(button => {
            button.style.display = document.querySelectorAll('.video-row').length > 1 ? 'block' : 'none';
        });
    }

    addButton.addEventListener('click', function() {
        videoCount++;
        const newRow = document.querySelector('.video-row').cloneNode(true);
        
        // Clear values and update names
        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            const oldName = input.getAttribute('name');
            input.setAttribute('name', oldName.replace('[0]', `[${videoCount}]`));
        });
        
        // Clear error messages
        newRow.querySelectorAll('.text-danger').forEach(error => error.remove());
        
        container.appendChild(newRow);
        updateRemoveButtons();
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-video') || e.target.closest('.remove-video')) {
            const row = e.target.closest('.video-row');
            if (document.querySelectorAll('.video-row').length > 1) {
                row.remove();
                updateRemoveButtons();
            }
        }
    });

    // Add file size validation
    document.getElementById('videosForm').addEventListener('submit', function(e) {
        const videoInputs = document.querySelectorAll('input[type="file"]');
        const maxSize = 524288000; // 500MB in bytes
        
        for (let input of videoInputs) {
            if (input.files.length > 0) {
                if (input.files[0].size > maxSize) {
                    e.preventDefault();
                    alert('Video file size must not exceed 500MB');
                    return;
                }
            }
        }
    });
});
</script>

</body>
</html> 