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

    <title>Course Companies</title>

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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <!-- Header -->
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="mb-0">Course Companies</h5>
                                    <button 
                                        type="button" 
                                        class="btn btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#addCompanyModal"
                                    >
                                        Add Company
                                    </button>
                                </div>

                                @if(session('success_message'))
                                    <div class="alert alert-success alert-dismissible m-4">
                                        {{ session('success_message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session('error_message'))
                                    <div class="alert alert-danger alert-dismissible m-4">
                                        {{ session('error_message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <!-- Companies list -->
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Logo</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Website</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($courseCompanies as $courseCompany)
                                                <tr>
                                                    <td>
                                                        <img 
                                                            src="{{ asset('Image/' . $courseCompany->company->logo) }}" 
                                                            alt="Company Logo" 
                                                            class="rounded-circle" 
                                                            width="40"
                                                        >
                                                    </td>
                                                    <td>{{ $courseCompany->company->name }}</td>
                                                    <td>{{ $courseCompany->company->email }}</td>
                                                    <td>{{ $courseCompany->company->phone }}</td>
                                                    <td>
                                                        <a href="{{ $courseCompany->company->website }}" target="_blank">
                                                            {{ $courseCompany->company->website }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('teacher.course.companies.delete', ['company_id' => $courseCompany->company_id, 'course_id' => $course->id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this company?')">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Company Modal -->
                <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Company to Course</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('teacher.course.companies.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <div class="mb-3">
                                        <label class="form-label">Select Company</label>
                                        <select name="company_id" class="form-select" required>
                                            <option value="">Select a company</option>
                                            @foreach($availableCompanies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Company</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                @include('layouts.Teacher.Footer')
                <!-- / Footer -->
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