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
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Course Status</th>
                                    <th>Categories</th>
                                    <th>Image</th>
                                    <th>Duration(Week)</th>
                                    <th>Publish Status</th>
                                    <th>Published By</th>
                                    <th>Reject Cause</th>
                                    <th>Reject By</th>
                                    <th>Change Status By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($courses as $course)
                                    <tr>
                                        <th scope="row">{{$course->id}}</th>
                                        <td>{{$course->name}}</td>
                                        <td>{{$course->code}}</td>
                                        <td>
                                            @if($course->status == 0)
                                                <div class="btn btn-danger">
                                                    Not Active
                                                </div>
                                            @else
                                                <div class="btn btn-success">
                                                    Active
                                                </div>
                                            @endif

                                        </td>

                                        <td>
                                            @foreach($course->categories as $courseCategory)
                                             {{$courseCategory->category->name}} -
                                            @endforeach
                                        </td>

                                        <td>
                                            <img src="{{ asset('image/' . $course->image) }}"
                                                 style="width: 100px; height: 100px;">
                                        </td>

                                        <td>
                                            {{$course->duration}}
                                        </td>

                                        <td>
                                            @if(!empty($course->rejected_cause))

                                                <div class="btn btn-primary">
                                                    Rejected
                                                </div>
                                            @else
                                            @if($course->status_publish == 0)
                                                <div class="btn btn-danger">
                                                    Not Published
                                                </div>
                                            @else
                                                <div class="btn btn-success">
                                                    Published
                                                </div>
                                                @endif
                                            @endif
                                        </td>

                                        <td>{{$course->pyblishedBy->name ?? '-'}}</td>

                                        <td>
                                            @if(empty($course->rejected_cause))
                                                -
                                            @else
                                            {{$course->rejected_cause}}
                                            @endif
                                        </td>
                                        <td>{{$course->rejectedBy->name ?? '-'}}</td>
                                        <td>{{$course->changeStatusBy->name ?? '-'}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <form method="post" action="{{route('teacher.course.delete' ,$course->id)}}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="dropdown-item btn" type="submit">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
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
