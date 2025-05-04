<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Elzero</title>
    <link rel="stylesheet" href="{{ asset('web_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/elzero.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .user-profile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            object-fit: cover;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            min-width: 200px;
            z-index: 1000;
        }

        .profile-trigger:hover .dropdown-content {
            display: block;
        }

        .user-info {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .user-name {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .user-email {
            font-size: 14px;
            color: #666;
        }

        .dropdown-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dropdown-menu li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: background 0.3s;
        }

        .dropdown-menu li a:hover {
            background: #f5f5f5;
        }

        .login-btn {
            padding: 8px 20px;
            background: #2196f3;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .login-btn:hover {
            background: #1976d2;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f1f5f9;
        }

        .container {
            padding: 0 15px;
            margin: 0 auto;
            max-width: 1200px;
        }

        .header {
            background-color: white;
            box-shadow: 0 2px 15px rgb(0 0 0 / 10%);
            position: relative;
        }

        .header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: relative;
        }

        .my-courses {
            padding: 40px 0;
        }

        .my-courses h1 {
            color: #2196f3;
            text-align: center;
            margin-bottom: 40px;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .course-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgb(0 0 0 / 10%);
            transition: transform 0.3s;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-10px);
        }

        .course-image {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-info {
            padding: 20px;
        }

        .course-title {
            color: #2196f3;
            font-size: 1.2em;
            margin-bottom: 15px;
        }

        .week-circle {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: #2196f3;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .week-number {
            font-size: 1.2em;
        }

        .week-text {
            font-size: 0.8em;
        }

        .progress-container {
            margin-top: 20px;
            background: #eee;
            height: 10px;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: #2196f3;
            border-radius: 5px;
            transition: width 0.3s ease;
        }

        .progress-text {
            margin-top: 5px;
            color: #666;
            font-size: 0.9em;
            text-align: right;
        }
    </style>
</head>
<body>

@include('layouts.Student.header')

<div class="my-courses-section">
    <div class="container">
        <h2 class="section-title">My Courses</h2>
        
        @if($courses->isEmpty())
        <div class="no-courses">
            <i class="fas fa-graduation-cap"></i>
            <h3>No courses yet</h3>
            <p>Start learning by enrolling in a course!</p>
            <a href="{{ route('home') }}" class="browse-courses-btn">
                <i class="fas fa-search"></i> Browse Courses
            </a>
        </div>
        @else
        <div class="courses-grid">
            @foreach($courses as $enrollment)
            <div class="course-card">
                <div class="course-image">
                    <img src="{{ asset('Image/'.$enrollment->course->image) }}" alt="{{ $enrollment->course->name }}">
                    <div class="progress-badge" style="--progress: {{ $enrollment->progress }}%">
                        {{ number_format($enrollment->progress, 0) }}%
                    </div>
                </div>
                <div class="course-content">
                    <h3>{{ $enrollment->course->name }}</h3>
                    <div class="course-code">{{ $enrollment->course->code }}</div>
                    
                    <div class="course-info">
                        <div class="teacher">
                            <img src="{{ asset('Image/'.$enrollment->course->teacher->img) }}" 
                                 alt="{{ $enrollment->course->teacher->name }}">
                            <span>{{ $enrollment->course->teacher->name }}</span>
                        </div>
                        <div class="stats">
                            <span><i class="fas fa-book"></i> {{ $enrollment->course->modules->count() }} modules</span>
                        </div>
                    </div>

                    <div class="progress-bar">
                        <div class="progress" style="width: {{ $enrollment->progress }}%"></div>
                    </div>

                    <div class="course-actions">
                        <a href="{{ route('student.course.content', $enrollment->course->id) }}" class="continue-btn">
                            @if($enrollment->progress == 0)
                                <i class="fas fa-play"></i> Start Learning
                            @elseif($enrollment->progress == 100)
                                <i class="fas fa-redo"></i> Review Course
                            @else
                                <i class="fas fa-forward"></i> Continue Learning
                            @endif
                        </a>
                        <a href="{{ route('student.course.details', $enrollment->course->id) }}" class="details-btn">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<style>
.my-courses-section {
    padding: 40px 0;
    background: #f8f9fa;
}

.section-title {
    text-align: center;
    margin-bottom: 40px;
    color: #333;
    font-size: 32px;
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
}

.course-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.course-image {
    position: relative;
    height: 200px;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.progress-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 50px;
    height: 50px;
    background: rgba(33, 150, 243, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 16px;
}

.course-content {
    padding: 20px;
}

.course-content h3 {
    margin: 0 0 10px 0;
    font-size: 18px;
    color: #2196f3;
}

.course-code {
    color: #666;
    font-size: 14px;
    margin-bottom: 15px;
}

.course-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.teacher {
    display: flex;
    align-items: center;
    gap: 10px;
}

.teacher img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
}

.stats {
    font-size: 14px;
    color: #666;
}

.progress-bar {
    height: 6px;
    background: #e0e0e0;
    border-radius: 3px;
    margin: 15px 0;
    overflow: hidden;
}

.progress {
    height: 100%;
    background: linear-gradient(to right, #2196f3, #1976d2);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.course-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.continue-btn {
    flex: 1;
    padding: 10px;
    background: #2196f3;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    text-align: center;
    transition: background 0.3s;
}

.continue-btn:hover {
    background: #1976d2;
}

.details-btn {
    padding: 10px 15px;
    background: #f5f5f5;
    color: #666;
    text-decoration: none;
    border-radius: 6px;
    transition: background 0.3s;
}

.details-btn:hover {
    background: #e0e0e0;
}

.no-courses {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.no-courses i {
    font-size: 48px;
    color: #2196f3;
    margin-bottom: 20px;
}

.no-courses h3 {
    color: #333;
    margin-bottom: 10px;
}

.no-courses p {
    color: #666;
    margin-bottom: 20px;
}

.browse-courses-btn {
    display: inline-block;
    padding: 12px 24px;
    background: #2196f3;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    transition: background 0.3s;
}

.browse-courses-btn:hover {
    background: #1976d2;
}
</style>
</body>
</html>
