<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Create Skill</title>
    <meta name="description" content="" />
    @include('layouts.admin.LinkHeader')
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('layouts.Admin.Sidebar')
        <div class="layout-page">
            @include('layouts.Admin.NavBar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
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
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Create Skill</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.skill.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="skill-name">Skill Name</label>
                                    <input name="name" type="text" class="form-control" id="skill-name" placeholder="Skill Name" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="skill-image">Upload Image</label>
                                    <input type="file" name="image" id="skill-image" class="form-control" accept="image/*" required />
                                    <div class="form-text">Allowed formats: JPG, PNG, GIF</div>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
                @include('layouts.Admin.Footer')
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
@include('layouts.Admin.LinkJS')
</body>
</html> 