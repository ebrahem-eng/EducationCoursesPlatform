<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Edit Exam Question</title>
    <meta name="description" content="" />
    @include('layouts.Teacher.LinkHeader')
</head>

<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('layouts.Teacher.Sidebar')

        <div class="layout-page">
            @include('layouts.Teacher.NavBar')

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
                            <h5 class="mb-0">Edit Question</h5>
                            <div>
                                <span class="badge bg-primary">Exam: {{ $question->courseModelExam->name }}</span>
                                <span class="badge bg-info">Module: {{ $question->courseModelExam->module->name }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('teacher.course.module.exam.question.update', ['question_id' => $question->id]) }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Question</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-question-mark"></i></span>
                                            <input type="text" name="question" class="form-control" value="{{ $question->question }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Option A</label>
                                        <input type="text" name="option_a" class="form-control" value="{{ $question->option_a }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Option B</label>
                                        <input type="text" name="option_b" class="form-control" value="{{ $question->option_b }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Option C</label>
                                        <input type="text" name="option_c" class="form-control" value="{{ $question->option_c }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Option D</label>
                                        <input type="text" name="option_d" class="form-control" value="{{ $question->option_d }}" required>
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label class="form-label">Correct Answer</label>
                                        <select name="correct_answer" class="form-control" required>
                                            <option value="a" {{ $question->correct_answer == 'a' ? 'selected' : '' }}>A</option>
                                            <option value="b" {{ $question->correct_answer == 'b' ? 'selected' : '' }}>B</option>
                                            <option value="c" {{ $question->correct_answer == 'c' ? 'selected' : '' }}>C</option>
                                            <option value="d" {{ $question->correct_answer == 'd' ? 'selected' : '' }}>D</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label class="form-label">Mark</label>
                                        <input type="number" name="mark" class="form-control" value="{{ $question->mark }}" required>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Update Question</button>
                                    <a href="{{ route('teacher.course.module.exam.questions', ['exam_id' => $question->course_model_exam_id]) }}" 
                                       class="btn btn-secondary">Back to Questions</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @include('layouts.Teacher.Footer')
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>

@include('layouts.Teacher.LinkJS')

</body>
</html> 