<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestResult;

class SearchController extends Controller
{
     public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');

            $questions = TestResult::with('test')
                ->where(function ($q) use ($query) {
                    $q->where('id', 'like', "%{$query}%")
                        ->orWhere('question_id', 'like', "%{$query}%")
                        ->orWhere('user_answer', 'like', "%{$query}%")
                        ->orWhere('correct_answer', 'like', "%{$query}%")
                        ->orWhere('questions_status', 'like', "%{$query}%");
                })
                ->orWhereHas('test', function ($q) use ($query) {
                    $q->where('subject_type', 'like', "%{$query}%")
                        ->orWhere('test_mode', 'like', "%{$query}%")
                        ->orWhereJsonContains('selected_subjects', $query);
                })
                ->get();

            return response()->json([
                'questions' => $questions,
                'total' => $questions->count(),
            ]);
        }

        return view('admin.tools.search');
    }
}
