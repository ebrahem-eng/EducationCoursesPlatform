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

    <title>Pending Certificates</title>

    <meta name="description" content="" />

    @include('layouts.admin.LinkHeader')

    <style>
        .score-info {
            padding: 8px;
            border-radius: 4px;
            background-color: #f8f9fa;
        }
        
        .score-text {
            font-weight: 600;
            margin-bottom: 4px;
            color: #566a7f;
        }
        
        .progress {
            margin-bottom: 4px;
            background-color: #ebeef0;
        }
        
        .progress-bar {
            transition: width 0.3s ease;
        }
        
        .score-info small {
            display: block;
            text-align: right;
            color: #697a8d;
        }
    </style>

</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        @include('layouts.Admin.Sidebar')

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('layouts.Admin.NavBar')

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

                        <h5 class="card-header">Pending Certificates</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Certificate Number</th>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Exam Score</th>
                                        <th>Homework Score</th>
                                        <th>Submission Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse($certificates as $certificate)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $certificate->certificate_number }}</td>
                                            <td>{{ $certificate->student->name }}</td>
                                            <td>{{ $certificate->course->name }}</td>
                                            <td>
                                                <div class="score-info">
                                                    <div class="score-text">{{ $certificate->exam_score['achieved'] }}/{{ $certificate->exam_score['total'] }}</div>
                                                    <div class="progress" style="height: 5px;">
                                                        <div class="progress-bar {{ $certificate->exam_score['percentage'] >= 60 ? 'bg-success' : 'bg-danger' }}" 
                                                             role="progressbar" 
                                                             style="width: {{ $certificate->exam_score['percentage'] }}%"
                                                             aria-valuenow="{{ $certificate->exam_score['percentage'] }}" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">{{ $certificate->exam_score['percentage'] }}%</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="score-info">
                                                    <div class="score-text">{{ $certificate->homework_score['achieved'] }}/{{ $certificate->homework_score['total'] }}</div>
                                                    <div class="progress" style="height: 5px;">
                                                        <div class="progress-bar {{ $certificate->homework_score['percentage'] >= 60 ? 'bg-success' : 'bg-danger' }}" 
                                                             role="progressbar" 
                                                             style="width: {{ $certificate->homework_score['percentage'] }}%"
                                                             aria-valuenow="{{ $certificate->homework_score['percentage'] }}" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">{{ $certificate->homework_score['percentage'] }}%</small>
                                                </div>
                                            </td>
                                            <td>{{ $certificate->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <form action="{{ route('admin.certificate.approve', $certificate->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="bx bx-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $certificate->id }}">
                                                            <i class="bx bx-x me-1"></i> Reject
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Reject Modal -->
                                                <div class="modal fade" id="rejectModal{{ $certificate->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Reject Certificate</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.certificate.reject', $certificate->id) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="rejection_reason" class="form-label">Rejection Reason</label>
                                                                        <textarea class="form-control" name="rejection_reason" rows="3" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-danger">Reject</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No pending certificates found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-3">
                        {{ $certificates->links() }}
                    </div>
                </div>
                <!-- / Content -->

                <!-- Footer -->
                @include('layouts.Admin.Footer')
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

@include('layouts.Admin.LinkJS')

</body>
</html> 