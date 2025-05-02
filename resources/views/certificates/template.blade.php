<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Professional Course Certificate</title>
    <style>
        @page {
            margin: 0;
            size: landscape;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', sans-serif;
            color: #1F2937;
            margin: 0;
            padding: 0;
            background: #f0f4f8;
        }

        .certificate {
            width: 1123px;
            height: 794px;
            margin: 0 auto;
            position: relative;
            background: white;
            background-color: #ffffff;
            background-image: radial-gradient(#dbeafe 1px, transparent 1px);
            background-size: 20px 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .certificate-border {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid #2563eb;
            border-radius: 12px;
        }

        .certificate-inner {
            position: relative;
            height: 100%;
            padding: 50px 60px;
            z-index: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .accent-bar {
            height: 10px;
            background: linear-gradient(90deg, #2563eb, #3b82f6, #60a5fa);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .logo {
            max-height: 70px;
            width: auto;
        }

        .certificate-type {
            font-size: 22px;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .title {
            font-family: 'DejaVu Serif', 'Times New Roman', serif;
            font-size: 56px;
            font-weight: 700;
            color: #1e3a8a;
            margin: 20px 0;
            line-height: 1.1;
        }

        .content {
            text-align: center;
            margin: 40px 0;
            position: relative;
        }

        .student-name {
            font-size: 42px;
            color: #1e3a8a;
            margin: 20px 0;
            font-weight: 700;
            text-transform: capitalize;
            position: relative;
            display: inline-block;
        }

        .student-name::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #bfdbfe, #2563eb, #bfdbfe);
        }

        .completion-text,
        .score-info,
        .date-info {
            font-size: 20px;
            color: #4b5563;
            margin: 15px 0;
            font-weight: 400;
        }

        .course-name {
            font-size: 30px;
            margin: 25px 0;
            font-weight: 600;
            color: #1e3a8a;
            line-height: 1.3;
        }

        .footer {
            position: absolute;
            bottom: 60px;
            left: 60px;
            right: 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature {
            text-align: center;
            flex: 1;
            margin: 0 30px;
        }

        .signature-line {
            width: 200px;
            border-top: 2px solid #2563eb;
            margin: 10px auto;
        }

        .signature-name {
            font-size: 18px;
            font-weight: 600;
            color: #1F2937;
        }

        .signature-title {
            font-size: 14px;
            color: #4b5563;
        }

        .certificate-number {
            position: absolute;
            bottom: 25px;
            right: 25px;
            font-size: 12px;
            color: #6b7280;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            opacity: 0.03;
            font-size: 200px;
            font-weight: 700;
            color: #2563eb;
            white-space: nowrap;
            z-index: 0;
        }

        .seal {
            position: absolute;
            bottom: 60px;
            right: 60px;
            width: 110px;
            height: 110px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .seal-inner {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fef3c7, #fcd34d, #f59e0b);
            border: 3px solid #d97706;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .seal-text {
            font-size: 14px;
            color: #7c2d12;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 8px;
        }

        .seal-checkmark {
            font-size: 32px;
            color: #7c2d12;
            line-height: 1;
        }

        .corner-decoration {
            position: absolute;
            width: 80px;
            height: 80px;
            opacity: 0.2;
        }

        .top-left {
            top: 20px;
            left: 20px;
            border-top: 3px solid #2563eb;
            border-left: 3px solid #2563eb;
            border-top-left-radius: 15px;
        }

        .top-right {
            top: 20px;
            right: 20px;
            border-top: 3px solid #2563eb;
            border-right: 3px solid #2563eb;
            border-top-right-radius: 15px;
        }

        .bottom-left {
            bottom: 20px;
            left: 20px;
            border-bottom: 3px solid #2563eb;
            border-left: 3px solid #2563eb;
            border-bottom-left-radius: 15px;
        }

        .bottom-right {
            bottom: 20px;
            right: 20px;
            border-bottom: 3px solid #2563eb;
            border-right: 3px solid #2563eb;
            border-bottom-right-radius: 15px;
        }
        
        .verified-badge {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 20px;
            background: linear-gradient(90deg, #dbeafe, #93c5fd);
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            color: #1e40af;
            box-shadow: 0 2px 5px rgba(37, 99, 235, 0.2);
        }
        
        .verified-badge i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-border"></div>
        <div class="corner-decoration top-left"></div>
        <div class="corner-decoration top-right"></div>
        <div class="corner-decoration bottom-left"></div>
        <div class="corner-decoration bottom-right"></div>
        
        <div class="certificate-inner">
            <div class="accent-bar"></div>
            <div class="watermark">CERTIFIED</div>
            
            <div class="header">
                <div class="logo-container">
                    @if($certificate->course->company)
                        <img src="{{ public_path('Image/' . $certificate->course->company->logo) }}" alt="Company Logo" class="logo">
                    @endif
                    <img src="{{ public_path('web_assets/imgs/logo.png') }}" alt="Platform Logo" class="logo">
                </div>
                <div class="certificate-type">Certificate of Achievement</div>
                <div class="title">Professional Certification</div>
            </div>

            <div class="content">
                <div class="completion-text">This certifies that</div>
                <div class="student-name">{{ $certificate->student->name }}</div>
                <div class="completion-text">has successfully completed the online course</div>
                <div class="course-name">{{ $certificate->course->name }}</div>
                <div class="score-info">with distinction and an overall score of {{ $certificate->course->progress }}%</div>
                <div class="date-info">Issued on {{ $certificate->issue_date->format('F d, Y') }}</div>
                <div class="verified-badge">✓ Verified Certificate</div>
            </div>

            <div class="footer">
                <div class="signature">
                    <div class="signature-line"></div>
                    <div class="signature-name">{{ $certificate->course->teacher->name }}</div>
                    <div class="signature-title">Course Instructor</div>
                </div>
                @if($certificate->course->company)
                    <div class="signature">
                        <div class="signature-line"></div>
                        <div class="signature-name">{{ $certificate->course->company->name }}</div>
                        <div class="signature-title">Director of Education</div>
                    </div>
                @endif
            </div>

            <div class="seal">
                <div class="seal-inner">
                    <div class="seal-checkmark">✓</div>
                    <div class="seal-text">Certified</div>
                </div>
            </div>
            <div class="certificate-number">Certificate ID: {{ $certificate->id }}</div>
        </div>
    </div>
</body>
</html>