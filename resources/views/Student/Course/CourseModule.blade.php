<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - Elzero</title>
    <link rel="stylesheet" href="{{ asset('web_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/elzero.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .course-details {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            margin: 40px auto;
            max-width: 900px;
            padding: 32px 24px 24px 24px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            align-items: flex-start;
        }
        .image img {
            width: 260px;
            height: 260px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            background: #eee;
        }
        .info {
            flex: 1;
            min-width: 260px;
        }
        .info h2 {
            margin-top: 0;
            font-size: 2.2rem;
            color: #1a202c;
            margin-bottom: 8px;
        }
        .code {
            color: #888;
            font-size: 1rem;
            margin-bottom: 8px;
        }
        .info p {
            color: #444;
            font-size: 1.1rem;
            margin-bottom: 16px;
        }
        .teacher-info {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            gap: 16px;
        }
        .teacher-info img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #007bff;
        }
        .teacher-info .text h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #007bff;
        }
        .course-content {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 12px 18px;
            margin-bottom: 18px;
        }
        .course-content h3 {
            margin: 0 0 8px 0;
            font-size: 1.1rem;
            color: #333;
        }
        .course-content ul {
            margin: 0;
            padding-left: 18px;
        }
        .chat-link {
            display: inline-block;
            background: #28a745;
            color: #fff !important;
            padding: 10px 22px;
            border-radius: 6px;
            font-weight: 600;
            margin-bottom: 10px;
            text-decoration: none;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(40,167,69,0.08);
        }
        .chat-link:hover {
            background: #218838;
        }
        .register-btn {
            display: inline-block;
            background: #007bff;
            color: #fff !important;
            padding: 10px 22px;
            border-radius: 6px;
            font-weight: 600;
            margin-bottom: 10px;
            text-decoration: none;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,123,255,0.08);
        }
        .register-btn:hover {
            background: #0056b3;
        }
        .alert {
            margin-bottom: 18px;
            border-radius: 6px;
            padding: 12px 18px;
            font-size: 1rem;
        }
        .footer {
            background: #222;
            color: #fff;
            padding: 32px 0 0 0;
            margin-top: 40px;
            border-radius: 16px 16px 0 0;
        }
        .footer .container {
            display: flex;
            justify-content: space-between;
            gap: 32px;
            flex-wrap: wrap;
        }
        .footer .box h3 {
            margin: 0 0 12px 0;
            font-size: 1.5rem;
            color: #fff;
        }
        .footer .social {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }
        .footer .social a {
            color: #fff;
            font-size: 1.2rem;
            background: #444;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .footer .social a:hover {
            background: #007bff;
        }
        .footer .links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer .links li {
            margin-bottom: 8px;
        }
        .footer .links a {
            color: #fff;
            text-decoration: underline;
            transition: color 0.2s;
        }
        .footer .links a:hover {
            color: #28a745;
        }
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
            .image img {
                width: 100%;
                max-width: 320px;
            }
        }
    </style>
</head>
<body>

@include('layouts.Student.header')

<!-- Course Details Section -->
<div class="course-details">
    {{-- message Section --}}
    @if (session('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
        </div>
    @endif

    @if (session('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
        </div>
    @endif

    {{-- end message Section --}}

    <div class="container">

        <div class="image">
            <img src="{{ asset('Image/' . $course->image) }}" alt="{{ $course->name }}">
        </div>

        <div class="info">
            @if(Auth::guard('student')->check())
                @php
                    $student = Auth::guard('student')->user();
                    // استخدم pluck للحصول على قائمة معرفات الدورات المسجلة بشكل صحيح
                    $registeredCourseIds = $student->courses->pluck('course_id')->toArray();
                    $isRegistered = in_array($course->id, $registeredCourseIds);
                @endphp

                <a href="{{ route('student.course.chat', ['course_id' => $course->id, 'teacher_id' => $course->teacher->id]) }}" class="chat-link">Open Chat</a>
                @if(!$isRegistered)
                    <p>You need to register in this course to open chat.</p>
                @endif
            @else
                <a href="{{ route('student.login.page') }}" class="register-btn">Login to Register</a>
            @endif

            <h2>{{ $course->name }}</h2>
            <div class="code">Course Code: {{ $course->code }}</div>
            <p>{{ $course->description }}</p>

            <div class="code">Course Duration: {{ $course->duration }} (Week)</div>

            <div class="teacher-info">
                <img src="{{ asset('Image/' . $course->teacher->img) }}" alt="{{ $course->teacher->name }}">
                <div class="text">
                    <h3>{{ $course->teacher->name }}</h3>
{{--                    <p>{{ $course->teacher->specialization }}</p> --}}
                </div>
            </div>

            <div class="course-content">
                <h3>Course Content</h3>
                <ul>
                    <li>{{ $course->name }}</li>
                </ul>
            </div>

            @if(Auth::guard('student')->check())
                @if($isRegistered)
                    <br>
                    <a href="{{ route('student.course.content', $course->id) }}" class="register-btn">Let's Start</a>
                    <br>
                @else
                    <form action="{{ route('student.course.register', $course->id) }}" method="post">
                        @csrf
                        <button type="submit" class="register-btn">Register Now</button>
                    </form>
                @endif
            @else
                <a href="{{ route('student.login.page') }}" class="register-btn">Login to Register</a>
            @endif

        </div>
    </div>
</div>

<!-- Footer from your original page -->
<div class="footer">
    <div class="container">
        <!-- Footer content -->
    </div>
</div>

<script src="{{ asset('web_assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="footer">
    <div class="container">
        <div class="box">
            <h3>Elzero</h3>
            <ul class="social">
                <li>
                    <a href="#" class="facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="youtube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </li>
            </ul>
            <p class="text">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Temporibus nulla rem, dignissimos iste aspernatur
            </p>
        </div>
        <div class="box">
            <ul class="links">
                <li><a href="#">Important Link 1</a></li>
                <li><a href="#">Important Link 2</a></li>
                <li><a href="#">Important Link 3</a></li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
