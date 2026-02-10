<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PreviousController extends Controller
{


    public function index()
    {
        $user_id = Auth::id();

        // Get dynamic subjects from WordPress API
        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/courses-list";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";

        $response = Http::withHeaders(['X-API-KEY' => $apiKey])->get($apiUrl);
        $subjects = [];

        if ($response->successful()) {
            $subjects = collect($response->json());
        }

        // Get all incomplete tests
        $incompleteTests = Test::where('user_id', $user_id)
            ->where('status', 'Incomplete')
            ->orderBy('created_at', 'desc')
            ->get();

        $testResults = TestResult::whereIn('test_id', $incompleteTests->pluck('id'))->get()->groupBy('test_id');

        foreach ($incompleteTests as $test) {
            $results = $testResults->get($test->id, collect());
            $total_questions = $results->count();
            $correct_answers = $results->where('is_correct', 1)->count();
            $test->total_questions = $total_questions;
            $test->score_percentage = $total_questions > 0
                ? round(($correct_answers / $total_questions) * 100, 2)
                : 0;
        }

        // Prepare subject-wise test lists
        $subjectTests = [];

        foreach ($subjects as $subject) {
            $subjectName = $subject['title'];

            $tests = Test::where('user_id', $user_id)
                ->where('subject_type', $subjectName)
                ->where('status', 'Incomplete')
                ->orderBy('created_at', 'desc')
                ->get();

            $subjectResults = TestResult::whereIn('test_id', $tests->pluck('id'))->get()->groupBy('test_id');

            foreach ($tests as $test) {
                $results = $subjectResults->get($test->id, collect());
                $total_questions = $results->count();
                $correct_answers = $results->where('is_correct', 1)->count();
                $test->total_questions = $total_questions;
                $test->score_percentage = $total_questions > 0
                    ? round(($correct_answers / $total_questions) * 100, 2)
                    : 0;
            }

            $subjectTests[$subjectName] = $tests;
        }

        return view('admin.questionbank.previoustest.index', [
            'incompleteTests' => $incompleteTests,
            'subjectTabs' => $subjects,
            'subjectTests' => $subjectTests
        ]);
    }
}
