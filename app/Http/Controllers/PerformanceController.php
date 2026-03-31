<?php

namespace App\Http\Controllers;

use App\Models\PerformanceEvaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class PerformanceController extends Controller
{
    /**
     * عرض الصفحة الرئيسية مع سجل التقييمات
     */
    public function index(Request $request)
    {
        $query = PerformanceEvaluation::with(['employee', 'evaluator'])->latest();

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->whereHas('employee', function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('employee_number', 'like', $searchTerm);
            });
        }

        $evaluations = $query->paginate(15);

        return view('performance.index', compact('evaluations'));
    }

    /**
     * البحث عن موظف بالرقم الوظيفي (AJAX)
     */
    public function searchEmployee(Request $request)
    {
        $searchQuery = $request->input('query');

        if (!$searchQuery) {
            return response()->json(['found' => false]);
        }

        $employee = User::where(function ($q) use ($searchQuery) {
            $q->where('employee_number', $searchQuery)
              ->orWhere('id', $searchQuery);
        })->first();

        if (!$employee) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'employee' => [
                'id' => $employee->id,
                'name' => $employee->name,
                'employee_number' => $employee->employee_number ?? '#' . $employee->id,
                'job_title' => $employee->job_title ?? 'غير محدد',
                'department' => $employee->department ?? 'غير محدد',
                'join_date' => $employee->join_date ? $employee->join_date->format('Y-m-d') : 'غير محدد',
                'avatar_initial' => mb_substr($employee->name, 0, 1),
            ],
        ]);
    }

    /**
     * حفظ تقييم جديد
     */
    public function store(Request $request)
    {
        $criteriaKeys = $this->getAllCriteriaKeys();

        $rules = [
            'employee_id' => 'required|exists:users,id',
            'notes' => 'nullable|string|max:2000',
            'evaluation_period' => 'required|in:' . implode(',', array_keys(PerformanceEvaluation::periodOptions())),
        ];

        foreach ($criteriaKeys as $key) {
            $rules["ratings.$key"] = 'required|integer|between:0,5';
        }

        $request->validate($rules);

        PerformanceEvaluation::create([
            'employee_id' => $request->employee_id,
            'evaluator_id' => auth()->id(),
            'ratings' => $request->ratings,
            'notes' => $request->notes,
            'evaluation_period' => $request->evaluation_period,
        ]);

        return redirect()->route('performance.index')->with('success', 'تم حفظ تقييم الأداء بنجاح!');
    }

    /**
     * عرض تقييم محدد
     */
    public function show(PerformanceEvaluation $performance)
    {
        $performance->load(['employee', 'evaluator']);
        return view('performance.show', compact('performance'));
    }

    /**
     * صفحة تعديل التقييم (للأدمن فقط)
     */
    public function edit(PerformanceEvaluation $performance)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('performance.index')->with('error', 'ليس لديك صلاحية لتعديل التقييم.');
        }

        $performance->load(['employee', 'evaluator']);
        return view('performance.edit', compact('performance'));
    }

    /**
     * تحديث التقييم (للأدمن فقط)
     */
    public function update(Request $request, PerformanceEvaluation $performance)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('performance.index')->with('error', 'ليس لديك صلاحية لتعديل التقييم.');
        }

        $criteriaKeys = $this->getAllCriteriaKeys();

        $rules = [
            'notes' => 'nullable|string|max:2000',
            'evaluation_period' => 'required|in:' . implode(',', array_keys(PerformanceEvaluation::periodOptions())),
        ];

        foreach ($criteriaKeys as $key) {
            $rules["ratings.$key"] = 'required|integer|between:0,5';
        }

        $request->validate($rules);

        $performance->update([
            'ratings' => $request->ratings,
            'notes' => $request->notes,
            'evaluation_period' => $request->evaluation_period,
        ]);

        return redirect()->route('performance.show', $performance)->with('success', 'تم تحديث التقييم بنجاح!');
    }

    /**
     * تصدير التقييم كملف PDF
     */
    public function exportPdf(PerformanceEvaluation $performance)
    {
        $performance->load(['employee', 'evaluator']);
        $pdf = PDF::loadView('pdf.performance', ['evaluation' => $performance]);
        return $pdf->stream('تقييم_أداء_' . $performance->employee->name . '.pdf');
    }

    /**
     * استخراج كل مفاتيح المعايير
     */
    private function getAllCriteriaKeys(): array
    {
        $keys = [];
        foreach (PerformanceEvaluation::criteriaStructure() as $category) {
            $keys = array_merge($keys, array_keys($category['items']));
        }
        return $keys;
    }
}
