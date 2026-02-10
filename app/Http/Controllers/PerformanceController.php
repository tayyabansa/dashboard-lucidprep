<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestResult;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PerformanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;

        // Step 1: Fetch subjects from WordPress API
        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/courses-list";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";

        $subjectsFromApi = [];
        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($apiUrl);

        if ($response->successful()) {
            $courses = collect($response->json());
            $subjectsFromApi = $courses->pluck('title')->toArray(); // ['English', 'Math', 'Science', ...]
        }

        // Step 2: Fetch user's test results and group by subject_type
      
        $results = TestResult::join('tests', 'test_results.test_id', '=', 'tests.id')
            ->where('test_results.user_id', Auth::id())
            ->select('test_results.*', 'tests.subject_type')
            ->get();
           
         $groupedResults = $results->groupBy(function ($result) {
        return $result->subject_type ?? 'Unknown';
    });

    // ✅ Step 3: Match API order
    $finalResults = collect();
    foreach ($subjectsFromApi as $subject) {
        $finalResults[$subject] = $groupedResults[$subject] ?? collect();
    }

    // ✅ Step 3.5: Replace original grouping with ordered one
    $groupedResults = $finalResults;
        // Step 4: Overall performance (optional, if needed at top level)
        $total_questions = $results->count();
        $correct_answers = $results->where('is_correct', 1)->count();
        $incorrect_answers = $results->where('is_correct', 0)->count();
        $omitted_answers = $total_questions - ($correct_answers + $incorrect_answers);
        $omitted_percentage = $total_questions > 0 ? round(($omitted_answers / $total_questions) * 100, 2) : 0;
        $your_score = $total_questions > 0 ? round(($correct_answers / $total_questions) * 100, 2) : 0;

        $your_time = $results->avg('time_spent') ?? 0;
        $others_time = 0;

        $test_ids = $results->pluck('test_id')->filter()->unique();
        if ($test_ids->isNotEmpty()) {
            $others_time = TestResult::whereIn('test_id', $test_ids)
                ->where('user_id', '!=', $user_id)
                ->avg('time_spent') ?? 0;
        }

        return view('admin.questionbank.performance.index', compact(
            'groupedResults',
            'user',
            'your_score',
            'your_time',
            'others_time',
            'correct_answers',
            'incorrect_answers',
            'omitted_answers',
            'omitted_percentage'
        ));
    }



    public function graphGet()
    {
        $userId = Auth::id();

        // Fetch test results grouped by test_id
        $userResults = TestResult::selectRaw(
            'test_id, 
         SUM(is_correct = 1) as correct_count, 
         COUNT(id) as total_questions, 
         MIN(created_at) as test_date'
        )
            ->where('user_id', $userId)
            ->groupBy('test_id')
            ->orderBy('created_at', 'desc')
            ->get();

        $testCount = $userResults->count(); 

        // Initialize arrays
        $labels = [];
        $yourScores = [];
        $testDates = [];

        foreach ($userResults as $result) {
            $labels[] =  $result->test_id;

            $percentage = ($result->total_questions > 0)
                ? round(($result->correct_count / $result->total_questions) * 100, 2)
                : 0;

            $yourScores[] = $percentage;
            $testDates[] = date('d M Y', strtotime($result->test_date));
        }

        // Fetch test results grouped by date
        $dateResults = TestResult::selectRaw(
            'DATE(created_at) as test_date, 
         SUM(is_correct = 1) as correct_count, 
         COUNT(id) as total_questions'
        )
            ->where('user_id', $userId)
            ->groupBy('test_date')
            ->orderBy('created_at', 'desc')
            ->get();

        $dateLabels = [];
        $dateScores = [];

        foreach ($dateResults as $result) {
            $dateLabels[] = date('d M', strtotime($result->test_date));

            $percentage = ($result->total_questions > 0)
                ? round(($result->correct_count / $result->total_questions) * 100, 2)
                : 0;

            $dateScores[] = $percentage;
        }

        // Pass data to view
        return view('admin.questionbank.graphs.index', compact('labels', 'yourScores', 'testDates', 'dateLabels', 'dateScores', 'testCount'));
    }
}
