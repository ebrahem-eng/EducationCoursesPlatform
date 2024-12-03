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

    <title>Create Teacher</title>

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

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Create Teacher</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{route('admin.teacher.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Full Name -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                                        <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="bx bx-user"></i>
                        </span>
                                            <input
                                                name="name"
                                                type="text"
                                                class="form-control"
                                                id="basic-icon-default-fullname"
                                                placeholder="John Doe"
                                                aria-label="John Doe"
                                                aria-describedby="basic-icon-default-fullname2"
                                                required
                                            />
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Email</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input
                                                type="email"
                                                name="email"
                                                id="basic-icon-default-email"
                                                class="form-control"
                                                placeholder="john.doe"
                                                aria-label="john.doe"
                                                aria-describedby="basic-icon-default-email2"
                                                required
                                            />
                                            <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                                        </div>
                                        <div class="form-text">You can use letters, numbers & periods</div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-password">Password</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-lock"></i></span>
                                            <input
                                                type="password"
                                                name="password"
                                                id="basic-icon-default-password"
                                                class="form-control"
                                                placeholder="Enter your password"
                                                aria-label="Enter your password"
                                                aria-describedby="basic-icon-default-password2"
                                                required
                                            />
                                        </div>
                                    </div>


                                    <!-- Phone Number -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Phone No</label>
                                        <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text">
                            <i class="bx bx-phone"></i>
                        </span>
                                            <input
                                                type="text"
                                                name="phone"
                                                id="basic-icon-default-phone"
                                                class="form-control phone-mask"
                                                placeholder="0987654321"
                                                aria-label="0987654321"
                                                aria-describedby="basic-icon-default-phone2"
                                                required
                                            />
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <!-- Age Input -->
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="basic-icon-default-age">Age</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input
                                                type="number"
                                                name="age"
                                                id="basic-icon-default-age"
                                                class="form-control"
                                                placeholder="Enter your age"
                                                aria-label="Enter your age"
                                                aria-describedby="basic-icon-default-age2"
                                                required
                                            />
                                        </div>
                                    </div>

                                    <!-- Status Input -->
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="basic-icon-default-status">Status</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-toggle-left"></i></span>
                                            <select
                                                name="status"
                                                id="basic-icon-default-status"
                                                class="form-control"
                                                aria-label="Select status"
                                                aria-describedby="basic-icon-default-status2"
                                                required
                                            >
                                                <option value="" selected disabled>Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Gender Input -->
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="basic-icon-default-gender">Gender</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-male-female"></i></span>
                                            <select
                                                name="gender"
                                                id="basic-icon-default-gender"
                                                class="form-control"
                                                aria-label="Select gender"
                                                aria-describedby="basic-icon-default-gender2"
                                                required
                                            >
                                                <option value="" selected disabled>Select Gender</option>
                                                <option value="1">Male</option>
                                                <option value="0">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Image Upload Input -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="basic-icon-default-image">Upload Image</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-image"></i></span>
                                            <input
                                                type="file"
                                                name="img"
                                                id="basic-icon-default-image"
                                                class="form-control"
                                                aria-label="Upload image"
                                                accept="image/*"
                                                required
                                            />
                                        </div>
                                        <div class="form-text">Allowed formats: JPG, PNG, GIF</div>
                                    </div>
                                </div>



                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
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
