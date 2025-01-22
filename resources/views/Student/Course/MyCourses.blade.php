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

<div class="my-courses">
    <div class="container">
        <h1>My Courses</h1>
        <div class="courses-grid">

            @foreach($student->courses as $course)
            <div class="course-card">
                <div class="course-image">
                    <img src="{{asset('Image/'.$course->course->image)}}" alt="Web Development">
                    <div class="week-circle">
                        <span class="week-number">{{$course->course->duration}}</span>
                        <span class="week-text">weeks</span>
                    </div>
                </div>
                <div class="course-info">
                    <h3 class="course-title">{{$course->course->name}} - {{$course->course->code}}</h3>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 75%"></div>
                    </div>
                    <div class="progress-text">75% Complete</div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>
