<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class ReportController extends Controller
{
   public function index()
{
    $user_id = Auth::id();
    
    // Step 1: Fetch subjects from WordPress API
    $apiUrl = "https://lucidprep.org/wp-json/custom/v1/courses-list";
    $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";

    $subjectsFromApi = [];
    $response = Http::withHeaders([
        'X-API-KEY' => $apiKey,
    ])->get($apiUrl);

    if ($response->successful()) {
        $courses = collect($response->json());
        $subjectsFromApi = $courses->pluck('title')->toArray(); 
    }

    // Step 2: Fetch grouped test results
    $testResults = DB::table('tests as t')
        ->join('test_results as tr', 't.id', '=', 'tr.test_id')
        ->select(
            't.id as test_id',
            't.subject_type',
            DB::raw('COUNT(tr.id) AS total_questions'),
            DB::raw('SUM(CASE WHEN tr.is_correct = 1 THEN 1 ELSE 0 END) AS correct_questions'),
            DB::raw('ROUND((SUM(CASE WHEN tr.is_correct = 1 THEN 1 ELSE 0 END) / NULLIF(COUNT(tr.id), 0)) * 100, 2) AS correct_percentage'),
            DB::raw('SUM(CASE WHEN tr.is_correct = 0 THEN 1 ELSE 0 END) AS incorrect_questions'),
            DB::raw('ROUND((SUM(CASE WHEN tr.is_correct = 0 THEN 1 ELSE 0 END) / NULLIF(COUNT(tr.id), 0)) * 100, 2) AS incorrect_percentage'),
            DB::raw('SUM(CASE WHEN tr.is_correct IS NULL THEN 1 ELSE 0 END) AS omitted_questions'),
            DB::raw('ROUND((SUM(CASE WHEN tr.is_correct IS NULL THEN 1 ELSE 0 END) / NULLIF(COUNT(tr.id), 0)) * 100, 2) AS omitted_percentage')
        )
        ->where('t.user_id', $user_id)
        ->groupBy('t.id', 't.subject_type')
        ->havingRaw('COUNT(tr.id) > 0')
        ->get();

    $groupedResults = $testResults->groupBy('subject_type');

    // ✅ Maintain API order
    $finalResults = collect();
    foreach ($subjectsFromApi as $subject) {
        $finalResults[$subject] = $groupedResults[$subject] ?? collect();
    }

    return view('admin.questionbank.report.index', ['groupedResults' => $finalResults]);
}


}
