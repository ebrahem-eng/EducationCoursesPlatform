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

    <title>Sub Category Table</title>

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


                        <h5 class="card-header">Sub Category Table</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr class="text-nowrap">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Category Name</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Last Updated Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subCategories as $subCategory)
                                    <tr>
                                        <th scope="row">{{$subCategory->id}}</th>
                                        <td>{{$subCategory->name}}</td>
                                        <td>{{$subCategory->code}}</td>
                                        <td>{{$subCategory->parent->name}}</td>
                                        <td>{{$subCategory->priority}}</td>
                                        <td>
                                            @if ($subCategory->status == 1)
                                                <div class="btn btn-success">Active</div>
                                            @else
                                                <div class="btn btn-danger">Not Active</div>
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{ asset('image/' . $subCategory->img) }}"
                                                 style="width: 100px; height: 100px;">
                                        </td>
                                        <td>{{$subCategory->admin->name}}</td>
                                        <td>{{$subCategory->created_at}}</td>
                                        <td>{{$subCategory->updated_at}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('admin.category.sub.category.edit' , $subCategory->id)}}"
                                                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                                                    >
                                                    <form method="post" action="{{route('admin.category.soft.delete' ,$subCategory->id)}}">
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
