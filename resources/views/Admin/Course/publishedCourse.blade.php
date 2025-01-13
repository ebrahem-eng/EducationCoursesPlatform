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
                                    <th>Status</th>
                                    <th>Categories</th>
                                    <th>Teacher</th>
                                    <th>Published By</th>
                                    <th>change_status_by</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($courses as $course)
                                <tr>
                                    <th scope="row">{{$course->id}}</th>
                                    <td>{{$course->name}}</td>
                                    <td>{{$course->code}}</td>
                                    <td>
                                        <form method="post" action="{{ route('admin.course.update_status', $course->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-check form-switch mb-2">
                                                <!-- Checkbox to toggle the status -->
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    id="flexSwitchCheckDefault" 
                                                    name="status" 
                                                    value="1" 
                                                    {{ $course->status == 1 ? 'checked' : '' }} 
                                                    onchange="this.form.submit()" 
                                                />
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        @foreach($course->categories as $courseCategory)
                                         {{$courseCategory->category->name}} -
                                        @endforeach
                                    </td>
                                    <td>{{$course->teacher->name ?? '-'}}</td>
                                    <td>{{$course->pyblishedBy->name ?? '-'}}</td>
                                    <td>{{$course->changeStatusBy->name ?? '-'}}</td>
                                    
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
