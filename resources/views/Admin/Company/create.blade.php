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

    <title>Create Company</title>

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
                            <h5 class="mb-0">Create Company</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{route('admin.company.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Company Name -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-fullname">Company Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text">
                                                <i class="bx bx-buildings"></i>
                                            </span>
                                            <input
                                                name="name"
                                                type="text"
                                                class="form-control"
                                                id="basic-icon-default-fullname"
                                                placeholder="Company Name"
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
                                                placeholder="company@example.com"
                                                required
                                            />
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
                                                placeholder="0987654321"
                                                required
                                            />
                                        </div>
                                    </div>

                                    <!-- Website -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-website">Website</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-globe"></i></span>
                                            <input
                                                type="url"
                                                name="website"
                                                id="basic-icon-default-website"
                                                class="form-control"
                                                placeholder="https://example.com"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Address -->
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-address">Address</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-map"></i></span>
                                            <input
                                                type="text"
                                                name="address"
                                                id="basic-icon-default-address"
                                                class="form-control"
                                                placeholder="Company Address"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-description">Description</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-comment"></i></span>
                                            <textarea
                                                name="description"
                                                id="basic-icon-default-description"
                                                class="form-control"
                                                placeholder="Company Description"
                                                rows="3"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Logo Upload -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="basic-icon-default-logo">Upload Logo</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-image"></i></span>
                                            <input
                                                type="file"
                                                name="logo"
                                                id="basic-icon-default-logo"
                                                class="form-control"
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
