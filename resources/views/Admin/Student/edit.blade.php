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

    <title>Edit Student</title>

    <meta name="description" content="" />

    @include('layouts.admin.LinkHeader')

</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('layouts.Admin.Sidebar')

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('layouts.Admin.NavBar')

            <!-- Content wrapper -->
            <div class="content-wrapper">
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
                            <h5 class="mb-0">Edit Student</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.student.update', $student->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

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
                                                value="{{ $student->name }}"
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
                                                value="{{ $student->email }}"
                                                required
                                            />
                                            <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
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
                                                value="{{ $student->phone }}"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Age -->
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="basic-icon-default-age">Age</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input
                                                type="number"
                                                name="age"
                                                id="basic-icon-default-age"
                                                class="form-control"
                                                value="{{ $student->age }}"
                                                required
                                            />
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="basic-icon-default-status">Status</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-toggle-left"></i></span>
                                            <select
                                                name="status"
                                                id="basic-icon-default-status"
                                                class="form-control"
                                                required
                                            >
                                                <option value="1" {{ $student->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $student->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Gender -->
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="basic-icon-default-gender">Gender</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-male-female"></i></span>
                                            <select
                                                name="gender"
                                                id="basic-icon-default-gender"
                                                class="form-control"
                                                required
                                            >
                                                <option value="1" {{ $student->gender == 1 ? 'selected' : '' }}>Male</option>
                                                <option value="0" {{ $student->gender == 0 ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Image Upload -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="basic-icon-default-image">Upload Image</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-image"></i></span>
                                            <input
                                                type="file"
                                                name="img"
                                                id="basic-icon-default-image"
                                                class="form-control"
                                                accept="image/*"
                                            />
                                        </div>
                                        @if($student->img)
                                            <div class="form-text">Current Image: {{ $student->img }}</div>
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                @include('layouts.Admin.Footer')
            </div>
        </div>
    </div>
</div>

@include('layouts.Admin.LinkJS')
</body>
</html>
