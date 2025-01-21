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

    <title>Course Table</title>

    <meta name="description" content="" />

    @include('layouts.admin.LinkHeader')

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


                        <h5 class="card-header">Course Table</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr class="text-nowrap">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Categories</th>
                                    <th>Teacher</th>
                                    <th>Status Publish</th>
                                    <th>Reject By</th>
                                    <th>Reject Cause</th>
                                    <th>change_status_by</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($courses as $course)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{$course->name}}</td>
                                    <td>{{$course->code}}</td>
                                    <td>
                                        @foreach($course->categories as $courseCategory)
                                         {{$courseCategory->category->name}} -
                                        @endforeach
                                    </td>
                                    <th>{{$course->teacher->name}}</th>
                                    <td>
                                        <form method="post" action="{{ route('admin.course.change_published_status', $course->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-check form-switch mb-2">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    id="flexSwitchCheckDefault"
                                                    name="status_publish"
                                                    value="1"
                                                    {{ $course->status_publish == 1 ? 'checked' : '' }}
                                                    onchange="this.form.submit()"
                                                />
                                            </div>
                                        </form>
                                    </td>
                                    <td>{{$course->rejectedBy->name ?? '-'}}</td>
                                    <td>
                                    @if (empty($course->rejected_cause))
                                    -
                                    @else {{$course->rejected_cause}}
                                    @endif
                                    </td>
                                    <td>{{$course->changeStatusBy->name}}</td>
                                    <td>
                                        <!-- زر يفتح الـ Modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $course->id }}">
                                            Reject
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="rejectModal{{ $course->id }}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel">Reject Course</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="post" action="{{ route('admin.course.rejectCourse', $course->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <label for="reason" class="form-label">Reason for Rejection:</label>
                                                            <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
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
