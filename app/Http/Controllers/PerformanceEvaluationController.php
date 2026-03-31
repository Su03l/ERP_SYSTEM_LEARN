<?php

namespace App\Http\Controllers;

use App\Models\PerformanceEvaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceEvaluationController extends Controller
{
    // عرض الصفحة الرئيسية لتقييم الأداء
    public function index()
    {
        // آخر التقييمات مع بياناتهم
        $recentEvaluations = PerformanceEvaluation::with(['employee', 'evaluator'])
            ->latest()
            ->take(10)
            ->get();

        return view('performance.index', compact('recentEvaluations'));
    }

    // AJAX: البحث عن موظف بالـ ID
    public function lookup(Request $request)
    {
        $request->validate(['employee_id' => 'required|integer']);

        $employee = User::find($request->employee_id);

        if (!$employee) {
            return response()->json(['found' => false, 'message' => 'لم يتم العثور على موظف بهذا الرقم.'], 404);
        }

        // جلب آخر تقييماته
        $evaluations = PerformanceEvaluation::where('employee_id', $employee->id)
            ->with('evaluator')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($e) {
                return [
                    'id'            => $e->id,
                    'period'        => $e->period,
                    'overall_score' => number_format($e->overall_score, 1),
                    'grade_label'   => $e->grade_label,
                    'grade_color'   => $e->grade_color,
                    'evaluator'     => $e->evaluator->name,
                    'created_at'    => $e->created_at->translatedFormat('j F Y'),
                    'punctuality'   => $e->punctuality,
                    'quality'       => $e->quality,
                    'teamwork'      => $e->teamwork,
                    'communication' => $e->communication,
                    'productivity'  => $e->productivity,
                    'notes'         => $e->notes,
                ];
            });

        return response()->json([
            'found'       => true,
            'id'          => $employee->id,
            'name'        => $employee->name,
            'job_title'   => $employee->job_title ?? '—',
            'department'  => $employee->department ?? '—',
            'email'       => $employee->email,
            'avatar'      => $employee->avatar ? asset('storage/' . $employee->avatar) : null,
            'status'      => $employee->status ?? 'active',
            'evaluations' => $evaluations,
        ]);
    }

    // حفظ تقييم جديد
    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:users,id',
            'period'        => 'required|string|max:50',
            'punctuality'   => 'required|integer|min:1|max:5',
            'quality'       => 'required|integer|min:1|max:5',
            'teamwork'      => 'required|integer|min:1|max:5',
            'communication' => 'required|integer|min:1|max:5',
            'productivity'  => 'required|integer|min:1|max:5',
            'notes'         => 'nullable|string|max:1000',
        ]);

        PerformanceEvaluation::create([
            'evaluator_id'  => Auth::id(),
            'employee_id'   => $request->employee_id,
            'period'        => $request->period,
            'punctuality'   => $request->punctuality,
            'quality'       => $request->quality,
            'teamwork'      => $request->teamwork,
            'communication' => $request->communication,
            'productivity'  => $request->productivity,
            'notes'         => $request->notes,
        ]);

        return redirect()->route('performance.index')
            ->with('success', 'تم حفظ تقييم الأداء بنجاح!');
    }
}
