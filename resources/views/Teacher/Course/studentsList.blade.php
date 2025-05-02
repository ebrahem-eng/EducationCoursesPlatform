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

    <title>Course Students</title>

    <meta name="description" content="" />

    @include('layouts.Teacher.LinkHeader')

    <style>
        .progress-details {
            min-width: 300px;
        }
        
        .progress {
            background-color: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            transition: width 0.6s ease;
        }

        .progress-stats {
            color: #666;
            font-size: 0.85rem;
        }

        .progress-stats .overall {
            color: #333;
        }

        .progress-stats .details {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .progress-stats .details span {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .progress-stats .details i {
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .progress-stats .details {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            
            .progress-stats .details span {
                margin: 0 !important;
            }
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
                        {{-- message Section --}}
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
                        {{-- end message Section --}}

                        <h5 class="card-header">Course Students - {{ $course->name }}</h5>
                        
                        <!-- Search Form -->
                        <div class="card-body">
                            <form action="{{ route('teacher.course.students.search', $course->id) }}" method="GET" class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                            <th>Join Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('Image/' . $student->student->img) }}" 
                                                             alt="Student" 
                                                             class="rounded-circle me-2"
                                                             width="32"
                                                             height="32">
                                                        {{ $student->student->name }}
                                                    </div>
                                                </td>
                                                <td>{{ $student->student->email }}</td>
                                                <td>{{ $student->student->phone }}</td>
                                                <td>
                                                    @switch($student->status)
                                                        @case('active')
                                                            <span class="badge bg-success">Active</span>
                                                            @break
                                                        @case('completed')
                                                            <span class="badge bg-info">Completed</span>
                                                            @break
                                                        @case('canceled')
                                                            <span class="badge bg-danger">Canceled</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">Unknown</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <div class="progress-details">
                                                        <div class="progress mb-2" style="height: 10px;">
                                                            <div class="progress-bar bg-primary" 
                                                                 role="progressbar" 
                                                                 style="width: {{ $student->progress['percentage'] }}%;" 
                                                                 aria-valuenow="{{ $student->progress['percentage'] }}" 
                                                                 aria-valuemin="0" 
                                                                 aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <div class="progress-stats small">
                                                            <div class="overall mb-1">
                                                                <strong>Overall Progress:</strong> {{ $student->progress['percentage'] }}%
                                                            </div>
                                                            <div class="details">
                                                                <span class="text-primary">
                                                                    <i class="fas fa-video"></i> 
                                                                    {{ $student->progress['completed_videos'] }}/{{ $student->progress['total_videos'] }} Videos
                                                                </span>
                                                                <span class="text-success mx-2">
                                                                    <i class="fas fa-tasks"></i> 
                                                                    {{ $student->progress['completed_homework'] }}/{{ $student->progress['total_homework'] }} Homework
                                                                </span>
                                                                <span class="text-info">
                                                                    <i class="fas fa-clipboard-check"></i> 
                                                                    {{ $student->progress['completed_exams'] }}/{{ $student->progress['total_exams'] }} Exams
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $student->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('teacher.course.student.chat', ['course_id' => $course->id, 'student_id' => $student->student->id]) }}">
                                                                <i class="bx bx-message-square-dots me-1"></i> Chat
                                                            </a>
                                                         
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $students->links() }}
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
<!-- / Layout wrapper -->

@include('layouts.Teacher.LinkJS')
</body>
</html> 