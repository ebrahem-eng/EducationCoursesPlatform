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

    @include('layouts.Teacher.LinkHeader')

    <style>
        .dropdown-submenu {
            position: relative;
        }
        
        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
            display: none;
        }
        
        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }
        
        .dropdown-submenu > a::after {
            display: block;
            content: " ";
            float: right;
            border-color: transparent;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-left-color: #ccc;
            margin-top: 5px;
            margin-right: -10px;
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


                        <h5 class="card-header">Course Table</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr class="text-nowrap">
                                    <th>Course Name</th>
                                    <th>Course Code</th>
                                    <th>Course Image</th>
                                    <th>Publish Status</th>
                                    <th>Rejected By</th>
                                    <th>Rejected Cause</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->code }}</td>
                                        <td>
                                            <img src="{{ asset('Image/' . $course->image) }}" alt="Course Image" class="img-fluid" style="max-width: 100px;">
                                        </td>
                                        <td>
                                            @php
                                                $status = $course->status_publish;
                                                $rejectedBy = $course->rejected_by ?? null;
                                                $rejectedCause = $course->rejected_cause ?? null;
                                            @endphp

                                            @switch($status)
                                                @case(1)
                                                    <span class="badge bg-success">Published</span>
                                                    @break
                                                @case(2)
                                                    <span class="badge bg-danger">Canceled</span>
                                                    @break
                                                @default
                                                    @if(!empty($rejectedBy) || !empty($rejectedCause))
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                            @endswitch
                                        </td>
                                        <td>{{ $course->rejectedBy->name ?? '-' }} - {{ $course->rejectedBy->email ?? '-' }}</td>
                                        <td>{{ $course->rejected_cause ?? '-' }}</td>
                                        <td>
                                            @if($course->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif  
                                            </td>
                                            <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                @if($course->status_publish == 0 && empty($course->rejected_by) && empty($course->rejected_cause) )
                                                        <a class="dropdown-item" href="{{ route('teacher.course.create.modules', ['course_id' => $course->id]) }}">
                                                            <i class="bx bx-plus me-1"></i> Add Modules
                                                        </a>
                                              
                                                        <a class="dropdown-item" href="{{ route('teacher.course.edit.details', ['course_id' => $course->id]) }}">
                                                            <i class="bx bx-pencil me-1"></i> Edit Details
                                                        </a>
                                                    
                                                    @if($course->modules->count() > 0)
                                                        <div class="dropdown-divider"></div>
                                                        <h6 class="dropdown-header">Module Management</h6>
                                                        @foreach($course->modules as $module)
                                                            <div class="dropdown-submenu">
                                                                <a class="dropdown-item" href="#">
                                                                    {{ $module->name }} <i class="bx bx-chevron-right float-end"></i>
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="{{ route('teacher.course.module.videos', ['module_id' => $module->id]) }}">
                                                                        <i class="bx bx-video me-1"></i> Manage Videos
                                                                    </a>
                                                                    <a class="dropdown-item" href="{{ route('teacher.course.module.exams', ['module_id' => $module->id]) }}">
                                                                        <i class="bx bx-test-tube me-1"></i> Manage Exams
                                                                    </a>
                                                                    <a class="dropdown-item" href="{{ route('teacher.course.module.homework', ['module_id' => $module->id]) }}">
                                                                        <i class="bx bx-book me-1"></i> Manage Homework
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    
                                                   
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('teacher.course.cancel', ['id' => $course->id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Are you sure you want to Cancel this course?')">
                                                                <i class="bx bx-x-circle me-1"></i> Cancel Course
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('teacher.course.delete', ['id' => $course->id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this course?')">
                                                                <i class="bx bx-trash me-1"></i> Delete Course
                                                            </button>
                                                        </form>
                                                    @endif
                                               @if($course->status_publish == 1)
                                               <a href="{{ route('teacher.course.students.list', ['course_id' => $course->id]) }}" class="dropdown-item">
                                                <i class="bx bx-user-plus me-1"></i> Students List
                                               </a>
                                               <div class="dropdown-divider"></div>
                                               <h6 class="dropdown-header">Broadcast Live</h6>
                                               <a href="{{ route('teacher.course.broadcast', ['course' => $course->id]) }}" class="dropdown-item">
    <i class="bx bx-broadcast me-1"></i> Manage Live Broadcast
</a>
                                               @endif
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
