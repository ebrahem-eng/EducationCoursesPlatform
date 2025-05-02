<?php

namespace App\Http\Controllers\admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\StudentSubmission;
use App\Models\CourseModelExam;
use App\Models\CourseModuleHomeWork;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class CertificateController extends Controller
{
    public function pendingCertificates()
    {
        $certificates = Certificate::with([
            'student',
            'course.modules.courseModelExams',
            'course.modules.courseModuleHomeWorks'
        ])->where('status', 'pending')
        ->paginate(10);

        foreach ($certificates as $certificate) {
            // Get all exam submissions for this student in this course
            $examSubmissions = StudentSubmission::where('student_id', $certificate->student_id)
                ->where('submittable_type', CourseModelExam::class)
                ->whereIn('submittable_id', $certificate->course->modules->pluck('courseModelExams')->flatten()->pluck('id'))
                ->get();

            // Get all homework submissions for this student in this course
            $homeworkSubmissions = StudentSubmission::where('student_id', $certificate->student_id)
                ->where('submittable_type', CourseModuleHomeWork::class)
                ->whereIn('submittable_id', $certificate->course->modules->pluck('courseModuleHomeWorks')->flatten()->pluck('id'))
                ->get();

            // Calculate total and achieved marks for exams
            $totalExamMarks = $certificate->course->modules->pluck('courseModelExams')->flatten()->sum('total_mark');
            $achievedExamMarks = $examSubmissions->sum('score');

            // Calculate total and achieved marks for homework
            $totalHomeworkMarks = $certificate->course->modules->pluck('courseModuleHomeWorks')->flatten()->sum('total_mark');
            $achievedHomeworkMarks = $homeworkSubmissions->sum('score');

            // Add the calculated scores to the certificate object
            $certificate->exam_score = [
                'achieved' => $achievedExamMarks,
                'total' => $totalExamMarks,
                'percentage' => $totalExamMarks > 0 ? round(($achievedExamMarks / $totalExamMarks) * 100, 2) : 0
            ];

            $certificate->homework_score = [
                'achieved' => $achievedHomeworkMarks,
                'total' => $totalHomeworkMarks,
                'percentage' => $totalHomeworkMarks > 0 ? round(($achievedHomeworkMarks / $totalHomeworkMarks) * 100, 2) : 0
            ];
        }
        
        return view('admin.certificate.pending', compact('certificates'));
    }

    public function approvedCertificates()
    {
        $certificates = Certificate::with(['student', 'course'])
            ->where('status', 'approved')
            ->paginate(10);
        
        return view('admin.certificate.approved', compact('certificates'));
    }

    public function rejectedCertificates()
    {
        $certificates = Certificate::with(['student', 'course'])
            ->where('status', 'rejected')
            ->paginate(10);
        
        return view('admin.certificate.rejected', compact('certificates'));
    }

    public function approve($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->update([
            'status' => 'approved',
            'issue_date' => now()
        ]);

        return redirect()->back()->with('success_message', 'Certificate has been approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $certificate = Certificate::findOrFail($id);
        $certificate->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->back()->with('success_message', 'Certificate has been rejected.');
    }

    public function generateCertificate($id)
    {
        $certificate = Certificate::with([
            'student',
            'course',
            'course.teacher',
            'course.company'
        ])->findOrFail($id);

        if ($certificate->status !== 'approved') {
            return redirect()->back()->with('error_message', 'Certificate must be approved before generating.');
        }

        $pdf = PDF::loadView('certificates.template', compact('certificate'));
        
        return $pdf->download('certificate-' . $certificate->certificate_number . '.pdf');
    }
}
