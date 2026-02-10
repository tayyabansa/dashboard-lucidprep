<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Test;
use App\Models\Note;
use App\Models\Deck;
use App\Models\Question;
use App\Models\Subject;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        return view('admin.questionbank.test.index', compact('user_id'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_mode' => 'required',
            'question_mode' => 'required|in:standard,custom',
            'difficulty_levels' => 'required|array',
            'selected_subjects' => 'array',
            'num_of_passages' => 'required_without:num_of_questions|nullable|integer|min:0',
            'num_of_questions' => 'required_without:num_of_passages|nullable|integer|min:0',
        ]);
        
        

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $test_mode = is_array($request->test_mode) ? $request->test_mode[0] : $request->test_mode;
        $test = Test::create([
            'user_id' => Auth::id(),
            'subject_type' => $request->subject_type,
            'test_mode' => $test_mode,
            'question_mode' => $request->question_mode,
            'question_type' => json_encode($request->types),
            'practice_type' => $request->practice_type,
            'difficulty_levels' => json_encode($request->difficulty_levels),
            'selected_subjects' => json_encode($request->selected_subjects),
            'selected_topics' => json_encode($request->selected_topics),
            'num_of_passages' => $request->num_of_questions,
            'status' => 'Incomplete',
        ]);

        $user_id = Auth::id();
        $test_id = $test->id;

        if ($request->has('num_of_questions')) {
           $type = "questions";
        }
         if ($request->has('num_of_passages')) {
            $type = "passages";
        }
        $launchTestUrl = route('test.launched', [
            'user_id' => $user_id,
            'test_id' => $test_id,
            'difficulty_level' => json_encode($request->difficulty_levels),
            'type'=>$type
        ]);

        return response()->json([
            'success' => true,
            'test' => $test,
            'launch_url' => $launchTestUrl
        ]);
    }
    
    public function createTest(Request $request)
    {
       
        $subjectType         = $request->get('subject_type');
        $subjectName         = $request->get('subjects');
        $selectedTopicParam  = $request->get('selected_topic');       
        $questionsCountParam = $request->get('questions');
        $wp_test             = $request->get('wp_test');
    
        
        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/questions";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";
    
        $response = Http::withHeaders(['X-API-KEY' => $apiKey])->get($apiUrl);
        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch questions from the API.',
            ], $response->status());
        }
    
        $questions = collect($response->json());
    
        
    
        if ($subjectType === 'Math') {
    
           
            $mathQuestions = $questions->filter(function ($q) use ($subjectType) {
                return in_array($subjectType, $q['select_courses'] ?? []);
            });
    
           
            if ($selectedTopicParam) {
                $mathQuestions = $mathQuestions->filter(function ($q) use ($selectedTopicParam) {
                    $topics = is_array($q['select_topic']) ? $q['select_topic'] : [$q['select_topic']];
                    return in_array($selectedTopicParam, $topics);
                });
            }
    
           
               $subjects = $mathQuestions->flatMap(function ($q) {
               return $q['select_subject'] ?? [];
                })
                ->unique()
                ->values()
                ->toArray();
    
           
            if ($selectedTopicParam) {                              
                $topics = [$selectedTopicParam];                     
            } else {
                $topics = $mathQuestions->flatMap(function ($q) {
                            return is_array($q['select_topic']) ? $q['select_topic'] : [$q['select_topic']];
                          })->filter()->unique()->values()->toArray();
            }
    
           
            $questionCount = $questionsCountParam
                ? (int) $questionsCountParam
                : $mathQuestions->count();                            
    
        } else { 
    
            $matchedQuestions = $questions->filter(function ($q) use ($subjectType, $subjectName) {
                return in_array($subjectType, $q['select_courses'] ?? [])
                    && in_array($subjectName, $q['select_subject'] ?? []);
            });
    
            $subjects = [$subjectName];
    
            $topics = $matchedQuestions->flatMap(function ($q) {
                        return is_array($q['select_topic']) ? $q['select_topic'] : [$q['select_topic']];
                      })->filter()->unique()->values()->toArray();
    
           
            $questionCount = ($subjectType === 'Science' && $questionsCountParam)
                ? (int) $questionsCountParam
                : $matchedQuestions->count();
        }
    
      
        $test = Test::create([
            'user_id'           => Auth::id(),
            'subject_type'      => $subjectType,
            'test_mode'         => 'tutor',
            'question_mode'     => 'standard',
            'question_type'     => json_encode(['unused']),
            'practice_type'     => 'full-length',
            'difficulty_levels' => json_encode(['easy', 'medium', 'hard']),
            'selected_subjects' => json_encode($subjects),
            'selected_topics'   => json_encode($topics),               
            'num_of_passages'   => $questionCount,
            'wp_test'           => $wp_test,
            'status'            => 'Incomplete',
        ]);
    
        /* ------------------------------------------------
         *  5️⃣  Redirect to launch page
         * ---------------------------------------------- */
        try {
            return redirect()->route('test.launched', [
                'user_id' => Auth::id(),
                'test_id' => $test->id,
            ]);
        } catch (\Exception $e) {
            \Log::error('Redirect failed: '.$e->getMessage());
            return redirect('https://lucidprep.org/all-subjects/');
        }
    }


    public function fetchTabsCounts($subject)
    {
        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/courses-list";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";

        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($apiUrl);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Failed to fetch data'], 500);
    }
    
    public function createTestManual(Request $request)
    {
         $subjectType = ucfirst($request->subject_type); 
        $numOfPassages = $request->num_of_passages;

        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/questions";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";

        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($apiUrl);

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch questions from the API.',
            ], $response->status());
        }

        $questions = $response->json();

        // Filter questions based on subject type
        $subjectQuestions = collect($questions)->filter(function ($q) use ($subjectType) {
            return in_array($subjectType, $q['select_courses'] ?? []);
        });

        // Extract unique subjects and topics
        $subjects = $subjectQuestions->pluck('select_subject')->flatten()->unique()->values()->toArray();
        $topics = $subjectQuestions->pluck('select_topic')->flatten()->unique()->values()->toArray();

        // Create test with common parameters
        $test = Test::create([
            'user_id' => Auth::id(),
            'subject_type' => $subjectType,
            'test_mode' => 'tutor',
            'question_mode' => 'standard',
            'question_type' => json_encode(["unused"]),
            'practice_type' => 'full-length',
            'difficulty_levels' => json_encode(["easy", "medium", "hard"]),
            'selected_subjects' => json_encode($subjects),
            'selected_topics' => json_encode($topics),
            'num_of_passages' => $numOfPassages,
            'status' => 'Incomplete',
        ]);

        $user_id = Auth::id();
        $test_id = $test->id;
        $launchTestUrl = route('test.launched', [
            'user_id' => $user_id,
            'test_id' => $test_id,
        ]);

        return response()->json([
            'success' => true,
            'test' => $test,
            'launch_url' => $launchTestUrl
        ]);
    }

    public function customTest(Request $request)
    {
        $request->validate([
            'test_id' => 'required|integer|exists:tests,id',
            'subject_type' => 'required|string',
        ]);
        $user_id = auth()->id();
        $test = Test::where('id', $request->test_id)
            ->where('user_id', $user_id)
            ->first();
        if (!$test) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to access this test or it does not exist.',
            ], 403); 
        }
        if ($test->subject_type !== $request->subject_type) {
            return response()->json([
                'success' => false,
                'message' => "This is a {$test->subject_type} test. Please select the correct subject.",
            ], 400);
        }
        return response()->json([
            'success' => true,
            'redirect_url' => route('test.launched', ['user_id' => $user_id, 'test_id' => $test->id])
        ]);
    }


    public function fetchQuestionCounts($subject)
    {
       
        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/questions";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";

        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($apiUrl,['select_courses'   => $subject]);

        if ($response->successful()) {
            $questions = collect($response->json());

            // **Filter questions where select_courses contains the given subject**
            $filteredQuestions = $questions->filter(function ($question) use ($subject) {
                return in_array($subject, $question['select_courses']);
            });
            
            
            if ($subject === 'English') {
            $passageQuestions = $filteredQuestions->filter(function ($question) {
                return !empty($question['passages']);
            });
        
            $totalQuestions = $passageQuestions->count();
        
            $totalPassages = $passageQuestions->flatMap(function ($question) {
                return collect($question['passages'] ?? [])
                    ->filter(function ($passage) {
                        return isset($passage['id']) && !empty(trim($passage['content']));
                    })
                    ->pluck('id');
            })->unique()->count();
        } else {
            // Normal subjects ke liye
            $totalQuestions = $filteredQuestions->count();
        
            $totalPassages = $filteredQuestions->flatMap(function ($question) {
                return collect($question['passages'] ?? [])
                    ->filter(function ($passage) {
                        return isset($passage['id']) && !empty(trim($passage['content']));
                    })
                    ->pluck('id');
            })->unique()->count();
        }


            // **Group by difficulty level**
            $questionCounts = $filteredQuestions->groupBy('difficulty_level')
                ->map(function ($group, $difficulty) {
                    $uniquePassages = $group->flatMap(function ($question) {
                        return collect($question['passages'] ?? [])
                            ->filter(function ($passage) {
                                return isset($passage['id']) && !empty(trim($passage['content']));
                            })
                            ->pluck('id');
                    })->unique();
            
                    // ✅ Passage wale questions count
                    $passageQuestionCount = $group->filter(function ($question) {
                        return !empty($question['passages']);
                    })->count();
            
                    return [
                        'difficulty' => $difficulty,
                        'total' => $group->count(),
                        'passage_count' => $uniquePassages->count(),
                        'passage_question_count' => $passageQuestionCount // ✅ Add this key
                    ];
                })->values();


            // **Group by question type (assuming `select_courses` represents type)**
            $typeCounts = $filteredQuestions->flatMap(function ($question) {
                return $question['select_courses'];
            })->countBy()->map(function ($count, $type) {
                return [
                    'question_type' => $type,
                    'total' => $count
                ];
            })->values();

            // **Group by subject name**
          $subjectPassageMap = [];

        foreach ($filteredQuestions as $question) {
            $passageIds = collect($question['passages'] ?? [])
                ->filter(function ($passage) {
                    return isset($passage['id']) && !empty(trim($passage['content']));
                })
                ->pluck('id')
                ->unique();
        
            foreach ($question['select_subject'] as $subjectName) {
                if (!isset($subjectPassageMap[$subjectName])) {
                    $subjectPassageMap[$subjectName] = [
                        'total' => 0,
                        'has_passages' => false,
                        'passage_ids' => collect()
                    ];
                }
        
                $subjectPassageMap[$subjectName]['total']++;
                if ($passageIds->isNotEmpty()) {
                    $subjectPassageMap[$subjectName]['has_passages'] = true;
                    $subjectPassageMap[$subjectName]['passage_ids'] = $subjectPassageMap[$subjectName]['passage_ids']->merge($passageIds);
                }
            }
        }
        
        // Format final result
        $subjectCounts = collect($subjectPassageMap)->map(function ($data, $subjectName) {
            return [
                'subject_name' => $subjectName,
                'total' => $data['total'],
                'has_passages' => $data['has_passages'],
                'passage_count' => $data['passage_ids']->unique()->count()
            ];
        })->values();
        

            // **Extract Unique Topics**
          $topicMap = [];

        foreach ($filteredQuestions as $question) {
            $passageIds = collect($question['passages'] ?? [])
                ->filter(function ($passage) {
                    return isset($passage['id']) && !empty(trim($passage['content']));
                })
                ->pluck('id')
                ->unique();
        
            foreach ($question['select_topic'] as $topicName) {
                if (!isset($topicMap[$topicName])) {
                    $topicMap[$topicName] = [
                        'total' => 0,
                        'passage_ids' => collect()
                    ];
                }
        
                $topicMap[$topicName]['total']++;
        
                if ($passageIds->isNotEmpty()) {
                    $topicMap[$topicName]['passage_ids'] = $topicMap[$topicName]['passage_ids']->merge($passageIds);
                }
            }
        }
        
        // Final formatted array with passage_count
        $select_topics = collect($topicMap)->map(function ($data, $topicName) {
            return [
                'topic_name' => $topicName,
                'total' => $data['total'],
                'passage_count' => $data['passage_ids']->unique()->count()
            ];
        })->values();

            $groupedTopics = $select_topics->groupBy(function ($topic) use ($filteredQuestions) {
                $matchingQuestion = $filteredQuestions->firstWhere(function ($question) use ($topic) {
                    return in_array($topic['topic_name'], $question['select_topic']);
                });
                
                return $matchingQuestion ? $matchingQuestion['select_subject'][0] : null;
            });
            $uniquePassageIds = $filteredQuestions->flatMap(function ($question) {
                return collect($question['passages'])
                    ->filter(function ($passage) {
                        // ✅ Filters only those with an ID and non-empty content
                        return isset($passage['id']) && !empty(trim($passage['content']));
                    })
                    ->pluck('id');
            })->unique();
            
            $passageCount = $uniquePassageIds->count();
          
            return response()->json([
                'difficulties' => $questionCounts,
                'types' => $typeCounts,
                'subjectCounts' => $subjectCounts,
                'select_topics' => $select_topics, 
                'totalQuestions' => $totalQuestions,
                'totalPassages'=>$totalPassages,
                'groupedTopics'=>$groupedTopics,
                'passageCount'=>$passageCount
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch questions from API'], $response->status());
        }
    }
    
    // public function fetchQuestionCounts($subject)
    // {
    //     $apiUrl = "https://iamdeveloper.in/Kevin_harris_project_dev/wp-json/custom/v1/questions";
    //     $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";
    
    //     $response = Http::withHeaders([
    //         'X-API-KEY' => $apiKey,
    //     ])->get($apiUrl);
    
    //     if ($response->successful()) {
    //         $questions = collect($response->json());
    
    //         // ✅ Fetch previously used questions for uniqueness
    //         $usedQuestionIds = TestResult::where('user_id', auth()->id())
    //             ->pluck('question_id')
    //             ->toArray();
    
    //         // ✅ Filter questions where select_courses contains the given subject
    //         $filteredQuestions = $questions->filter(function ($question) use ($subject) {
    //             return in_array($subject, $question['select_courses']);
    //         });
    
    //         // ✅ Remove already used questions (for uniqueness)
    //         $filteredQuestions = $filteredQuestions->filter(function ($question) use ($usedQuestionIds) {
    //             return !in_array($question['id'], $usedQuestionIds);
    //         });
    
    //         // ✅ Get all unique 'select_subject' for this course (even if 0 questions after unique filtering)
    //         $allSubjectsForThisCourse = $questions->filter(function ($question) use ($subject) {
    //             return in_array($subject, $question['select_courses']);
    //         })->flatMap(function ($question) {
    //             return $question['select_subject'];
    //         })->unique()->values();
    
    //         // ✅ Initialize all possible subjects with default zero values
    //         $subjectPassageMap = [];
    //         foreach ($allSubjectsForThisCourse as $subjectName) {
    //             $subjectPassageMap[$subjectName] = [
    //                 'total' => 0,
    //                 'has_passages' => false,
    //                 'passage_ids' => collect()
    //             ];
    //         }
    
    //         // ✅ Now update with filteredQuestions (unique ones only)
    //         foreach ($filteredQuestions as $question) {
    //             $passageIds = collect($question['passages'] ?? [])
    //                 ->filter(function ($passage) {
    //                     return isset($passage['id']) && !empty(trim($passage['content']));
    //                 })
    //                 ->pluck('id')
    //                 ->unique();
    
    //             foreach ($question['select_subject'] as $subjectName) {
    //                 if (isset($subjectPassageMap[$subjectName])) {
    //                     $subjectPassageMap[$subjectName]['total']++;
    //                     if ($passageIds->isNotEmpty()) {
    //                         $subjectPassageMap[$subjectName]['has_passages'] = true;
    //                         $subjectPassageMap[$subjectName]['passage_ids'] = $subjectPassageMap[$subjectName]['passage_ids']->merge($passageIds);
    //                     }
    //                 }
    //             }
    //         }
    
    //         // ✅ Final formatted subjectCounts
    //         $subjectCounts = collect($subjectPassageMap)->map(function ($data, $subjectName) {
    //             return [
    //                 'subject_name' => $subjectName,
    //                 'total' => $data['total'],
    //                 'has_passages' => $data['has_passages'],
    //                 'passage_count' => $data['passage_ids']->unique()->count()
    //             ];
    //         })->values();
    
    //         // ✅ Other calculations remain as they are (difficulty, type, etc.)
    
    //         // Group by difficulty level
    //         $questionCounts = $filteredQuestions->groupBy('difficulty_level')
    //             ->map(function ($group, $difficulty) {
    //                 $uniquePassages = $group->flatMap(function ($question) {
    //                     return collect($question['passages'] ?? [])
    //                         ->filter(function ($passage) {
    //                             return isset($passage['id']) && !empty(trim($passage['content']));
    //                         })
    //                         ->pluck('id');
    //                 })->unique();
    
    //                 $passageQuestionCount = $group->filter(function ($question) {
    //                     return !empty($question['passages']);
    //                 })->count();
    
    //                 return [
    //                     'difficulty' => $difficulty,
    //                     'total' => $group->count(),
    //                     'passage_count' => $uniquePassages->count(),
    //                     'passage_question_count' => $passageQuestionCount
    //                 ];
    //             })->values();
    
    //         // Group by question type
    //         $typeCounts = $filteredQuestions->flatMap(function ($question) {
    //             return $question['select_courses'];
    //         })->countBy()->map(function ($count, $type) {
    //             return [
    //                 'question_type' => $type,
    //                 'total' => $count
    //             ];
    //         })->values();
    
    //         // Select Topics
    //         $topicMap = [];
    //         foreach ($filteredQuestions as $question) {
    //             $passageIds = collect($question['passages'] ?? [])
    //                 ->filter(function ($passage) {
    //                     return isset($passage['id']) && !empty(trim($passage['content']));
    //                 })
    //                 ->pluck('id')
    //                 ->unique();
    
    //             foreach ($question['select_topic'] as $topicName) {
    //                 if (!isset($topicMap[$topicName])) {
    //                     $topicMap[$topicName] = [
    //                         'total' => 0,
    //                         'passage_ids' => collect()
    //                     ];
    //                 }
    
    //                 $topicMap[$topicName]['total']++;
    //                 if ($passageIds->isNotEmpty()) {
    //                     $topicMap[$topicName]['passage_ids'] = $topicMap[$topicName]['passage_ids']->merge($passageIds);
    //                 }
    //             }
    //         }
    
    //         $select_topics = collect($topicMap)->map(function ($data, $topicName) {
    //             return [
    //                 'topic_name' => $topicName,
    //                 'total' => $data['total'],
    //                 'passage_count' => $data['passage_ids']->unique()->count()
    //             ];
    //         })->values();
    
    //         $groupedTopics = $select_topics->groupBy(function ($topic) use ($filteredQuestions) {
    //             $matchingQuestion = $filteredQuestions->firstWhere(function ($question) use ($topic) {
    //                 return in_array($topic['topic_name'], $question['select_topic']);
    //             });
    //             return $matchingQuestion ? $matchingQuestion['select_subject'][0] : null;
    //         });
    
    //         $uniquePassageIds = $filteredQuestions->flatMap(function ($question) {
    //             return collect($question['passages'])
    //                 ->filter(function ($passage) {
    //                     return isset($passage['id']) && !empty(trim($passage['content']));
    //                 })
    //                 ->pluck('id');
    //         })->unique();
    
    //         $passageCount = $uniquePassageIds->count();
    
    //         // Total Questions and Passages
    //         $totalQuestions = $filteredQuestions->count();
    //         $totalPassages = $passageCount;
    
    //         return response()->json([
    //             'difficulties' => $questionCounts,
    //             'types' => $typeCounts,
    //             'subjectCounts' => $subjectCounts,
    //             'select_topics' => $select_topics,
    //             'totalQuestions' => $totalQuestions,
    //             'totalPassages' => $totalPassages,
    //             'groupedTopics' => $groupedTopics,
    //             'passageCount' => $passageCount
    //         ]);
    //     } else {
    //         return response()->json(['error' => 'Failed to fetch questions from API'], $response->status());
    //     }
    // }
    
    // public function fetchQuestionCounts($subject)
    // {
    //     $apiUrl = "https://iamdeveloper.in/Kevin_harris_project_dev/wp-json/custom/v1/questions";
    //     $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";
    
    //     $response = Http::withHeaders([
    //         'X-API-KEY' => $apiKey,
    //     ])->get($apiUrl);
    
    //     if ($response->successful()) {
    //         $questions = collect($response->json());
    
    //         // ✅ Fetch previously used questions for uniqueness
    //         $usedQuestionIds = TestResult::where('user_id', auth()->id())
    //             ->pluck('question_id')
    //             ->toArray();
    
    //         // ✅ Filter questions where select_courses contains the given subject
    //         $filteredQuestions = $questions->filter(function ($question) use ($subject) {
    //             return in_array($subject, $question['select_courses']);
    //         });
    
    //         // ✅ Remove already used questions (for uniqueness)
    //         $filteredQuestions = $filteredQuestions->filter(function ($question) use ($usedQuestionIds) {
    //             return !in_array($question['id'], $usedQuestionIds);
    //         });
    
    //         // ✅ Get all unique 'select_subject' for this course (even if 0 questions after unique filtering)
    //         $allSubjectsForThisCourse = $questions->filter(function ($question) use ($subject) {
    //             return in_array($subject, $question['select_courses']);
    //         })->flatMap(function ($question) {
    //             return $question['select_subject'];
    //         })->unique()->values();
    
    //         // ✅ Initialize all possible subjects with default zero values
    //         $subjectPassageMap = [];
    //         foreach ($allSubjectsForThisCourse as $subjectName) {
    //             $subjectPassageMap[$subjectName] = [
    //                 'total' => 0,
    //                 'has_passages' => false,
    //                 'passage_ids' => collect()
    //             ];
    //         }
    
    //         // ✅ Now update with filteredQuestions (unique ones only)
    //         foreach ($filteredQuestions as $question) {
    //             $passageIds = collect($question['passages'] ?? [])
    //                 ->filter(function ($passage) {
    //                     return isset($passage['id']) && !empty(trim($passage['content']));
    //                 })
    //                 ->pluck('id')
    //                 ->unique();
    
    //             foreach ($question['select_subject'] as $subjectName) {
    //                 if (isset($subjectPassageMap[$subjectName])) {
    //                     $subjectPassageMap[$subjectName]['total']++;
    //                     if ($passageIds->isNotEmpty()) {
    //                         $subjectPassageMap[$subjectName]['has_passages'] = true;
    //                         $subjectPassageMap[$subjectName]['passage_ids'] = $subjectPassageMap[$subjectName]['passage_ids']->merge($passageIds);
    //                     }
    //                 }
    //             }
    //         }
    
    //         // ✅ Final formatted subjectCounts
    //         $subjectCounts = collect($subjectPassageMap)->map(function ($data, $subjectName) {
    //             return [
    //                 'subject_name' => $subjectName,
    //                 'total' => $data['total'],
    //                 'has_passages' => $data['has_passages'],
    //                 'passage_count' => $data['passage_ids']->unique()->count()
    //             ];
    //         })->values();
    
    //         // ✅ TotalQuestions and TotalPassages special handling for English
    //         if ($subject === 'English') {
    //             $passageQuestions = $filteredQuestions->filter(function ($question) {
    //                 return !empty($question['passages']);
    //             });
    
    //             $totalQuestions = $passageQuestions->count();
    
    //             $totalPassages = $passageQuestions->flatMap(function ($question) {
    //                 return collect($question['passages'] ?? [])
    //                     ->filter(function ($passage) {
    //                         return isset($passage['id']) && !empty(trim($passage['content']));
    //                     })
    //                     ->pluck('id');
    //             })->unique()->count();
    //         } else {
    //             // Other subjects
    //             $totalQuestions = $filteredQuestions->count();
    
    //             $totalPassages = $filteredQuestions->flatMap(function ($question) {
    //                 return collect($question['passages'] ?? [])
    //                     ->filter(function ($passage) {
    //                         return isset($passage['id']) && !empty(trim($passage['content']));
    //                     })
    //                     ->pluck('id');
    //             })->unique()->count();
    //         }
    
    //         // ✅ Group by difficulty level
    //         $questionCounts = $filteredQuestions->groupBy('difficulty_level')
    //             ->map(function ($group, $difficulty) {
    //                 $uniquePassages = $group->flatMap(function ($question) {
    //                     return collect($question['passages'] ?? [])
    //                         ->filter(function ($passage) {
    //                             return isset($passage['id']) && !empty(trim($passage['content']));
    //                         })
    //                         ->pluck('id');
    //                 })->unique();
    
    //                 $passageQuestionCount = $group->filter(function ($question) {
    //                     return !empty($question['passages']);
    //                 })->count();
    
    //                 return [
    //                     'difficulty' => $difficulty,
    //                     'total' => $group->count(),
    //                     'passage_count' => $uniquePassages->count(),
    //                     'passage_question_count' => $passageQuestionCount
    //                 ];
    //             })->values();
    
    //         // ✅ Group by question type
    //         $typeCounts = $filteredQuestions->flatMap(function ($question) {
    //             return $question['select_courses'];
    //         })->countBy()->map(function ($count, $type) {
    //             return [
    //                 'question_type' => $type,
    //                 'total' => $count
    //             ];
    //         })->values();
    
    //         // ✅ Select Topics
    //         $topicMap = [];
    //         foreach ($filteredQuestions as $question) {
    //             $passageIds = collect($question['passages'] ?? [])
    //                 ->filter(function ($passage) {
    //                     return isset($passage['id']) && !empty(trim($passage['content']));
    //                 })
    //                 ->pluck('id')
    //                 ->unique();
    
    //             foreach ($question['select_topic'] as $topicName) {
    //                 if (!isset($topicMap[$topicName])) {
    //                     $topicMap[$topicName] = [
    //                         'total' => 0,
    //                         'passage_ids' => collect()
    //                     ];
    //                 }
    
    //                 $topicMap[$topicName]['total']++;
    //                 if ($passageIds->isNotEmpty()) {
    //                     $topicMap[$topicName]['passage_ids'] = $topicMap[$topicName]['passage_ids']->merge($passageIds);
    //                 }
    //             }
    //         }
    
    //         $select_topics = collect($topicMap)->map(function ($data, $topicName) {
    //             return [
    //                 'topic_name' => $topicName,
    //                 'total' => $data['total'],
    //                 'passage_count' => $data['passage_ids']->unique()->count()
    //             ];
    //         })->values();
    
    //         $groupedTopics = $select_topics->groupBy(function ($topic) use ($filteredQuestions) {
    //             $matchingQuestion = $filteredQuestions->firstWhere(function ($question) use ($topic) {
    //                 return in_array($topic['topic_name'], $question['select_topic']);
    //             });
    //             return $matchingQuestion ? $matchingQuestion['select_subject'][0] : null;
    //         });
    
    //         $uniquePassageIds = $filteredQuestions->flatMap(function ($question) {
    //             return collect($question['passages'] ?? [])
    //                 ->filter(function ($passage) {
    //                     return isset($passage['id']) && !empty(trim($passage['content']));
    //                 })
    //                 ->pluck('id');
    //         })->unique();
    
    //         $passageCount = $uniquePassageIds->count();

    //         return response()->json([
    //             'difficulties' => $questionCounts,
    //             'types' => $typeCounts,
    //             'subjectCounts' => $subjectCounts,
    //             'select_topics' => $select_topics,
    //             'totalQuestions' => $totalQuestions,
    //             'totalPassages' => $totalPassages,
    //             'groupedTopics' => $groupedTopics,
    //             'passageCount' => $passageCount
    //         ]);
    //     } else {
    //         return response()->json(['error' => 'Failed to fetch questions from API'], $response->status());
    //     }
    // }


  
    public function suspendDestroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();
    
        return redirect()->route('test')->with('success', 'Test suspended successfully.');
    }
    
    public function launched(Request $request, $user_id, $test_id)
    {
        $test = Test::find($test_id);
        if (!$test) {
            return response()->json(['error' => 'Test not found'], 404);
        }
        $userId = Auth::id();
        $decks = Deck::where('user_id', $userId)->with('cards')->orderBy('id', 'desc')->get();
        $notes = Note::where('user_id', Auth::id())->get();

        $questionLimit =  $test->num_of_passages;
        $maxPassages = $questionLimit ? $questionLimit:0;
       
        $usedQuestionIds = TestResult::where('user_id', $user_id)
            ->pluck('question_id')
            ->toArray();

        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/questions";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";
        
         /* -----------------------------
        | Prepare Filters
        |------------------------------*/
        $selectedSubjects     = json_decode($test->selected_subjects, true) ?? [];
        $selectedTopics       = json_decode($test->selected_topics, true) ?? [];
        $selectedDifficulties = array_map('strtolower', json_decode($test->difficulty_levels, true) ?? []);
        $subjectType          = $test->subject_type;
        
        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($apiUrl, [
                    'select_courses'   => $subjectType,
                    'subject'          => $selectedSubjects,
                    'topics'           => $selectedTopics,
                    'difficulty_level' => $selectedDifficulties
                ]);
        
        if (!$response->successful()) {
            return response()->json([
                'error' => 'Unable to fetch data',
                'status' => $response->status(),
                'body' => $response->body(),
            ], $response->status());
        }
        
        $allQuestions = $response->json();
        
        /* -----------------------------
        | Prepare Filters
        |------------------------------*/
        $selectedSubjects     = json_decode($test->selected_subjects, true) ?? [];
        $selectedTopics       = json_decode($test->selected_topics, true) ?? [];
        $selectedDifficulties = array_map('strtolower', json_decode($test->difficulty_levels, true) ?? []);
        $subjectType          = $test->subject_type;
        
        /* -----------------------------
        | Filter Questions
        |------------------------------*/
        $filteredQuestions = array_values(array_filter($allQuestions, function ($q) use (
            $subjectType,
            $selectedSubjects,
            $selectedTopics,
            $selectedDifficulties
        ) {
            if (
                empty($q['select_courses']) ||
                empty($q['select_subject']) ||
                empty($q['difficulty_level'])
            ) {
                return false;
            }
        
            if (
                !in_array($subjectType, (array) $q['select_courses']) ||
                !in_array(strtolower($q['difficulty_level']), $selectedDifficulties)
            ) {
                return false;
            }
        
            // Topic priority over subject
            if (!empty($selectedTopics)) {
                return !empty($q['select_topic']) &&
                    count(array_intersect($selectedTopics, (array) $q['select_topic']));
            }
        
            return count(array_intersect($selectedSubjects, (array) $q['select_subject']));
        }));
        
        /* -----------------------------
        | Group By Passage
        |------------------------------*/
        $groupedByPassage = [];
        $noPassage       = [];
        $selectedPassages = [];
        
        foreach ($filteredQuestions as $q) {
            if (!empty($q['passages'][0]['id'])) {
                $pid = $q['passages'][0]['id'];
                $groupedByPassage[$pid][] = $q;
                $selectedPassages[$pid] ??= $q['passages'][0];
            } else {
                $noPassage[] = $q;
            }
        }
        
        /* Sort questions inside each passage */
        foreach ($groupedByPassage as &$questions) {
            usort($questions, fn($a, $b) => $a['id'] <=> $b['id']);
        }
        unset($questions);
        
        /* -----------------------------
        | Select Passage Limit
        |------------------------------*/
        $maxPassages = (int) ($test->num_of_passages ?? 0);
        $selectedGrouped = array_slice($groupedByPassage, 0, $maxPassages, true);
        
        /* -----------------------------
        | Build Final Question Set
        |------------------------------*/
        $finalQuestions = [];
        
        foreach ($selectedGrouped as $questions) {
            $finalQuestions = array_merge($finalQuestions, $questions);
        }
        
        $remaining = $questionLimit - count($finalQuestions);
        if ($remaining > 0) {
            $finalQuestions = array_merge($finalQuestions, array_slice($noPassage, 0, $remaining));
        }
        
        if (empty($finalQuestions)) {
            $test->update(['status' => 'NotStarted']);
            return back()->with('error', 'No questions found for the selected criteria.');
        }
        
        /* -----------------------------
        | Insert Test Results (Batch Safe)
        |------------------------------*/
        $subject = strtolower($subjectType);
        $existing = TestResult::where('user_id', $user_id)
            ->where('test_id', $test_id)
            ->pluck('question_id')
            ->toArray();
        
        $insertData = [];
        
        foreach ($finalQuestions as $q) {
            if (in_array($q['id'], $existing)) continue;
        
            if ($subject === 'english' && empty($q['passages'])) continue;
        
            $insertData[] = [
                'user_id'     => $user_id,
                'test_id'     => $test_id,
                'question_id' => $q['id'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }
        
        if (!empty($insertData)) {
            TestResult::insert($insertData);
        }
        
        /* -----------------------------
        | Calculate Time
        |------------------------------*/
        $timeMap = [
            'english' => 40,
            'math'    => 60,
            'science' => 50,
            'reading' => 52.5,
        ];
        
        $totalTimeInSeconds = count($finalQuestions) * ($timeMap[$subject] ?? 67);
        
        /* -----------------------------
        | Return View
        |------------------------------*/
            return view('admin.questionbank.test.launchtest', [
                'questions'           => $finalQuestions,
                'groupedQuestions'    => $selectedGrouped,
                'selectedPassages'    => $selectedPassages,
                'test'                => $test,
                'decks'               => $decks,
                'notes'               => $notes,
                'maxPassages'         => $maxPassages,
                'totalTimeInSeconds'  => $totalTimeInSeconds,
                'subject'             => $subject,
            ]);


    }
    
    // public function launched(Request $request, $user_id, $test_id)
    // {
    //     $test = Test::find($test_id);
    //     if (!$test) {
    //         return response()->json(['error' => 'Test not found'], 404);
    //     }
    
    //     $userId = Auth::id();
    //     $decks = Deck::where('user_id', $userId)->with('cards')->orderBy('id', 'desc')->get();
    //     $notes = Note::where('user_id', Auth::id())->get();
    
    //     $questionLimit = $test->num_of_passages;
    //     $maxPassages = $questionLimit ? $questionLimit : 0;
    
    //     $apiUrl = "https://iamdeveloper.in/Kevin_harris_project_dev/wp-json/custom/v1/questions";
    //     $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";
    
    //     $response = Http::withHeaders([
    //         'X-API-KEY' => $apiKey,
    //     ])->get($apiUrl);
    
    //     if ($response->successful()) {
    //         $allQuestions = $response->json();
    
    //         $selectedSubjects = json_decode($test->selected_subjects, true) ?? [];
    //         $selectedTopics = json_decode($test->selected_topics, true) ?? [];
    //         $selectedDifficulties = array_map('strtolower', json_decode($test->difficulty_levels, true) ?? []);
    
    //         // ✅ Pehle check karo kya TestResult mein questions stored hain
    //         $existingQuestions = TestResult::where('user_id', $user_id)
    //             ->where('test_id', $test_id)
    //             ->pluck('question_id')
    //             ->toArray();
    
    //         // ✅ User ke answers bhi nikaalo
    //         $userAnswers = TestResult::where('user_id', $user_id)
    //             ->where('test_id', $test_id)
    //             ->pluck('user_answer', 'question_id')
    //             ->toArray();
    
    //         if (!empty($existingQuestions)) {
    //             // ✅ Same questions wapas load karo
    //             $finalQuestions = array_filter($allQuestions, function ($question) use ($existingQuestions) {
    //                 return in_array($question['id'], $existingQuestions);
    //             });
    //             $finalQuestions = array_values($finalQuestions);
    
    //         } else {
    //             // ✅ Naye unique questions fetch karna h
    //             $usedQuestionIds = TestResult::where('user_id', $user_id)->pluck('question_id')->toArray();
    
    //             $filteredQuestions = array_filter($allQuestions, function ($question) use ($test, $selectedSubjects, $selectedTopics, $selectedDifficulties, $usedQuestionIds) {
    //                 return isset($question['select_courses'], $question['select_subject'], $question['difficulty_level']) &&
    //                     is_array($question['select_courses']) &&
    //                     is_array($question['select_subject']) &&
    //                     in_array($test->subject_type, $question['select_courses']) &&
    //                     in_array(strtolower($question['difficulty_level']), $selectedDifficulties) &&
    //                     !in_array($question['id'], $usedQuestionIds) &&
    //                     (
    //                         (!empty($selectedTopics) && isset($question['select_topic']) && is_array($question['select_topic']) && !empty(array_intersect($selectedTopics, $question['select_topic']))) ||
    //                         (empty($selectedTopics) && !empty(array_intersect($selectedSubjects, $question['select_subject'])))
    //                     );
    //             });
    
    //             $filteredQuestions = array_values($filteredQuestions);
    
    //             if (empty($filteredQuestions)) {
    //                 return redirect('https://iamdeveloper.in/Kevin_harris_project_dev/all-subjects?all_attempt_test=1'); 
    //             }
    
    //             // ✅ Passage/grouping logic
    //             $groupedQuestionsByPassage = [];
    //             $selectedPassages = [];
    //             $noPassageQuestions = [];
    
    //             foreach ($filteredQuestions as $question) {
    //                 if (!empty($question['passages']) && is_array($question['passages'])) {
    //                     $passageId = $question['passages'][0]['id'];
    //                     $groupedQuestionsByPassage[$passageId][] = $question;
    //                     $selectedPassages[$passageId] = $question['passages'][0];
    //                 } else {
    //                     $noPassageQuestions[] = $question;
    //                 }
    //             }
    
    //             foreach ($groupedQuestionsByPassage as &$questions) {
    //                 usort($questions, fn($a, $b) => $a['id'] <=> $b['id']);
    //             }
    //             unset($questions);
    
    //             $maxPassages = $test->num_of_passages ?? 0;
    //             $selectedGroupedQuestions = array_slice($groupedQuestionsByPassage, 0, $maxPassages, true);
    
    //             $finalQuestions = [];
    //             foreach ($selectedGroupedQuestions as $passageId => $questions) {
    //                 foreach ($questions as $q) {
    //                     $finalQuestions[] = $q;
    //                 }
    //             }
    
    //             $remainingSlots = $questionLimit - count($finalQuestions);
    //             if ($remainingSlots > 0) {
    //                 $finalQuestions = array_merge($finalQuestions, array_slice($noPassageQuestions, 0, $remainingSlots));
    //             }
    
    //             // ✅ Save questions to TestResult
    //             foreach ($finalQuestions as $question) {
    //                 TestResult::create([
    //                     'user_id' => $user_id,
    //                     'test_id' => $test_id,
    //                     'question_id' => $question['id']
    //                 ]);
    //             }
    //         }
    
    //         if (empty($finalQuestions)) {
    //             $test->update(['status' => 'NotStarted']);
    //             return redirect()->back()->with('error', 'No questions found for the selected criteria.');
    //         }
    
    //         $subject = strtolower($test->subject_type);
    //         $questionCount = count($finalQuestions);
    
    //         $totalTimeInSeconds = null;
    //         if ($subject === 'english') {
    //             $totalTimeInSeconds = $questionCount * 36;
    //         } elseif ($subject === 'math') {
    //             $totalTimeInSeconds = $questionCount * 60;
    //         } elseif ($subject === 'science') {
    //             $totalTimeInSeconds = $questionCount * 50;
    //         } else {
    //             $totalTimeInSeconds = $questionCount * 52.5;
    //         }
        
    //         return view('admin.questionbank.test.launchtest', [
    //             'questions' => $finalQuestions,
    //             'groupedQuestions' => $selectedGroupedQuestions ?? [],
    //             'selectedPassages' => $selectedPassages ?? [],
    //             'test' => $test,
    //             'decks' => $decks,
    //             'notes' => $notes,
    //             'maxPassages' => $maxPassages,
    //             'totalTimeInSeconds' => $totalTimeInSeconds,
    //             'subject' => $subject,
    //             'userAnswers' => $userAnswers,
    //         ]);
    
    //     } else {
    //         return response()->json([
    //             'error' => 'Unable to fetch data',
    //             'status' => $response->status(),
    //             'body' => $response->body(),
    //         ], $response->status());
    //     }
    // }
   
    public function markQuestionSeen(Request $request)
    {
        $questionId = $request->input('question_id');
        $testId = $request->input('test_id');
        $userId = auth()->id();

        if (!$testId || !$questionId) {
            return response()->json(['error' => 'Test ID and Question ID are required'], 400);
        }

        $testResult = TestResult::where([
            'user_id' => $userId,
            'test_id' => $testId,
            'question_id' => $questionId
        ])->first();

        if ($testResult) {
            if ($testResult->questions_status === 'Completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Question already completed, status not changed'
                ]);
            }

            $testResult->update(['questions_status' => 'Seen']);
        } else {
            TestResult::create([
                'user_id' => $userId,
                'test_id' => $testId,
                'question_id' => $questionId,
                'questions_status' => 'Seen'
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Question marked as seen']);
    }


  public function fetchQuestionStatuses($user_id, $test_id)
    {
        $questionStatuses = TestResult::select('test_results.*', 'wper_postmeta.meta_value')
            ->join('wper_postmeta', function ($join) {
                $join->on('test_results.question_id', '=', 'wper_postmeta.post_id')
                     ->where('wper_postmeta.meta_key', '=', 'passages'); // Only join where meta_key is 'passages'
            })
            ->where('test_results.user_id', $user_id)
            ->where('test_results.test_id', $test_id)
            ->orderBy('test_results.id', 'asc')
            ->get()
            ->map(function ($result, $index) {
                return [
                    'id'=>$result->question_id,
                    'number' => $index + 1,
                    'ispassage' => $result->meta_value ?? '', // Return meta_value or blank
                    'status' => $result->questions_status ?? 'Not seen',
                    'bookmark' => $result->bookmark == 1 ? '<i class="fas fa-bookmark mx-1 text-warning"></i>' : ''
                ];
            });
     
        return response()->json($questionStatuses);
    }

    
     public function submitFeedback(Request $request)
    {
        $request->validate([
            'test_id' => 'required|integer|exists:tests,id',
            'feedback' => 'required|string'
        ]);
        $test = Test::find($request->test_id);

        if ($test) {
            $test->feedback = $request->feedback;
            $test->save();

            return response()->json(['message' => 'Feedback submitted successfully']);
        }

        return response()->json(['error' => 'Test not found'], 404);
    }
    
    public function bookmarkQuestion(Request $request)
    {
        $request->validate([
            'test_id' => 'required|integer',
            'question_id' => 'required|integer',
            'bookmark' => 'required|boolean',
        ]);
    
        $result = TestResult::where('user_id', auth()->id())
            ->where('test_id', $request->test_id)
            ->where('question_id', $request->question_id)
            ->first();
    
        if ($result) {
            $result->bookmark = $request->bookmark;
            $result->save();
    
            return response()->json(['status' => true, 'message' => 'Bookmark status updated.']);
        }
    
        return response()->json(['status' => false, 'message' => 'TestResult not found.'], 404);
    }
    
    public function checkBookmark(Request $request)
    {
        $bookmarked = \App\Models\TestResult::where('test_id', $request->test_id)
            ->where('question_id', $request->question_id)
            ->where('user_id', auth()->id())
            ->value('bookmark');
    
        return response()->json(['bookmarked' => $bookmarked == 1]);
    }


    public function submitAnswer(Request $request, $test_id, $question_id)
    {
        // Fetch questions from API
        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/questions/$question_id";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";

        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($apiUrl);

        if (!$response->successful()) {
            return response()->json(['error' => 'Unable to fetch question data'], 500);
        }

        $questions = $response->json();
        $question = collect($questions)->firstWhere('id', $question_id);

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $options = $question['quiz_options'];
        $correctAnswerIndex = array_search('yes', $question['quiz_options_answer']);
        $correctAnswer = $options[$correctAnswerIndex] ?? null;

        $userAnswerRaw = $request->input('user_answer'); // this can be 'A' or direct text
        $userAnswer = null;
        
        if (!empty($question['quiz_options']) && array_filter($question['quiz_options'], fn($o) => trim($o) !== '')) {
            // MCQ mode
            $userAnswerIndex = ord(strtoupper($userAnswerRaw)) - 65;
            $options = $question['quiz_options'];
            $correctAnswerIndex = array_search('yes', $question['quiz_options_answer']);
            $correctAnswer = $options[$correctAnswerIndex] ?? null;
        
            $userAnswer = $options[$userAnswerIndex] ?? null;
        } else {
            // Text input mode
            $userAnswer = trim($userAnswerRaw);
            $correctAnswer = trim($question['correct_answer']);
        }
        function normalizeAnswer($answer) {
            return strtolower(
                trim(
                    preg_replace('/\s+/', '', str_replace("\xc2\xa0", '', html_entity_decode($answer)))
                )
            );
        }

        $isCorrect = normalizeAnswer($userAnswer) === normalizeAnswer($correctAnswer);



        $user_id = auth()->id();

        $totalAttempted = TestResult::where('user_id', $user_id)
            ->where('test_id', $test_id)
            ->count();

        $totalCorrect = TestResult::where('user_id', $user_id)
            ->where('test_id', $test_id)
            ->where('is_correct', true)
            ->count();

        // Include current question's result
        if ($isCorrect) {
            $totalCorrect += 1;
        }
        $totalAttempted += 1;

        $accuracy = ($totalAttempted > 0) ? round(($totalCorrect / $totalAttempted) * 100, 2) . "%" : "0%";

        $timeSpent = $request->input('elapsed_time');

        TestResult::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'test_id' => $test_id,
                'question_id' => $question_id
            ],
            [
                'user_answer' => $userAnswer,
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
                'time_spent' => $timeSpent,
                'accuracy' => $accuracy,
                'questions_status' => "Completed"
            ]
        );


        return response()->json([
            'isCorrect' => $isCorrect,
            'correctAnswer' => $correctAnswer,
            'explanation' => $question['excerpt'] ?? "No explanation available",
            'accuracy' => $accuracy,
            'timeSpent' => $timeSpent
        ]);
    }

    public function testresult($user_id, $test_id)
{
    // Find subject of the test
    $subject = strtolower(Test::find($test_id)->subject_type);

    // Check subject and apply orderBy accordingly
    $query = TestResult::where('test_results.user_id', $user_id)
        ->where('test_results.test_id', $test_id)
        ->join('tests', 'test_results.test_id', '=', 'tests.id')
        ->select(
            'test_results.question_id',
            'tests.selected_subjects',
            'tests.selected_topics',
            'test_results.accuracy',
            'test_results.time_spent',
            'test_results.is_correct'
        );

    // English: no change (DESC), others: ASC
    if($subject === 'english') {
        $query->orderBy('question_id', 'desc');
    } else {
        $query->orderBy('question_id', 'asc');
    }

    $results = $query->get();


    $total_questions = $results->count();
    $correct_answers = $results->filter(function ($item) {
        return $item->is_correct === 1;
    })->count();

    $incorrect_answers = $results->filter(function ($item) {
        return $item->is_correct === 0;
    })->count();

    $omitted_answers = $total_questions - ($correct_answers + $incorrect_answers);

    $your_score = $total_questions > 0 ? round(($correct_answers / $total_questions) * 100, 2) : 0;
    $your_time = $results->avg('time_spent');
    $others_time = TestResult::where('test_id', $test_id)
        ->where('user_id', '!=', $user_id)
        ->avg('time_spent');

    return view('admin.questionbank.test.result', compact(
        'results',
        'user_id',
        'test_id',
        'your_score',
        'your_time',
        'others_time',
        'correct_answers',
        'incorrect_answers',
        'omitted_answers'
    ));
}

    
     public function resultIndex($user_id, $test_id)
    {
        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/questions";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";
    
        $questionsResponse = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($apiUrl);
    
        $allQuestions = collect($questionsResponse->json());
    
        // Get test results from DB for this user + test
        $results = TestResult::where('user_id', $user_id)
                    ->where('test_id', $test_id)
                    ->orderBy('id', 'DESC')->get();
       
       $mergedResults = $results->map(function ($result) use ($allQuestions) {
    $question = $allQuestions->firstWhere('id', (string)$result->question_id);

    // Determine correct answer
    $correctAnswer = null;
    if (!empty($question['quiz_options']) && collect($question['quiz_options'])->filter()->count() > 0) {
        $correctIndex = collect($question['quiz_options_answer'] ?? [])->search('yes');
        if ($correctIndex !== false && isset($question['quiz_options'][$correctIndex])) {
            $correctAnswer = $question['quiz_options'][$correctIndex];
        }
    }

    // fallback
    if (!$correctAnswer && !empty($question['correct_answer'])) {
        $correctAnswer = $question['correct_answer'];
    }
    

        return [
            'question_id' => $result->question_id,
            'title' => $question['title'] ?? 'Question not found',
            'quiz_options' => $question['quiz_options'] ?? [],
            'quiz_options_answer' => $question['quiz_options_answer'] ?? [],
            'explanation' => $question['excerpt'] ?? null,
            'user_answer' => $result->user_answer,
            'correct_answer' => $result->correct_answer ?? $correctAnswer,
            'is_correct' => $result->is_correct,
            'accuracy' => $result->accuracy,
            'time_spent' => $result->time_spent,
            'explanation_video' =>  $question['explanation_video'] ?? null,
        ];
    });
    
    $subject = strtolower(Test::find($test_id)->subject_type);
    
    if($subject !== 'english'){
        $mergedResults = $mergedResults->reverse()->values();
    }

        return view('admin.questionbank.test.testresults',[
            'results' => $mergedResults,
            'score' => $results->where('is_correct', 1)->count(),
            'total' => $results->count(),
            'user_id'=>$user_id,
            'test_id'=>$test_id
        ]);
    }

    public function englishBulkSubmit(Request $request, $test_id)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);
// dd($request->time_spent);
        $user_id = auth()->id();
        $answers = $request->input('answers');
        $timeSpentArr = $request->input('time_spent', []);
        // Total time spent by user (in seconds)
        $totalTimeSpent = 0;
        $nonZeroCount = 0;
        foreach ($timeSpentArr as $val) {
            if (is_numeric($val) && $val > 0) {
                $totalTimeSpent += $val;
                $nonZeroCount++;
            }
        }
        // If all time_spent are zero or missing, fallback to elapsed_time (if sent)
        if ($totalTimeSpent == 0 && $request->has('elapsed_time')) {
            $totalTimeSpent = (int)$request->input('elapsed_time');
        }
        $numQuestions = count($answers);
        $avgTime = ($numQuestions > 0 && $totalTimeSpent > 0) ? round($totalTimeSpent / $numQuestions) : 0;
        // Fetch questions from API to get correct answers
        $apiUrl = "https://lucidprep.org/wp-json/custom/v1/questions";
        $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";

        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($apiUrl);

        if (!$response->successful()) {
            return response()->json(['error' => 'Unable to fetch question data'], 500);
        }

        $questions = $response->json();
        $results = [];
        $totalCorrect = 0;
        $totalAttempted = 0;

        foreach ($answers as $questionId => $userAnswerRaw) {
            $question = collect($questions)->firstWhere('id', $questionId);
            if (!$question) {
                continue;
            }
            $options = $question['quiz_options'];
            $correctAnswerIndex = array_search('yes', $question['quiz_options_answer']);
            $correctAnswer = $options[$correctAnswerIndex] ?? null;
            $userAnswer = null;
            if (!empty($question['quiz_options']) && array_filter($question['quiz_options'], fn($o) => trim($o) !== '')) {
                // MCQ mode
                $userAnswerIndex = ord(strtoupper($userAnswerRaw)) - 65;
                $userAnswer = $options[$userAnswerIndex] ?? null;
            } else {
                // Text input mode
                $userAnswer = trim($userAnswerRaw);
                $correctAnswer = trim($question['correct_answer']);
            }
            $isCorrect = $this->normalizeAnswer($userAnswer) === $this->normalizeAnswer($correctAnswer);
            if ($isCorrect) {
                $totalCorrect++;
            }
            $totalAttempted++;
            // Get time spent for this question
            $timeSpent = isset($timeSpentArr[$questionId]) && $timeSpentArr[$questionId] > 0 ? $timeSpentArr[$questionId] : $avgTime;
            // Save to database
            TestResult::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'test_id' => $test_id,
                    'question_id' => $questionId
                ],
                [
                    'user_answer' => $userAnswer,
                    'correct_answer' => $correctAnswer,
                    'is_correct' => $isCorrect,
                    'time_spent' => $timeSpent,
                    'accuracy' => round(($totalCorrect / $totalAttempted) * 100, 2) . "%",
                    'questions_status' => "Completed"
                ]
            );
            $results[] = [
                'question_id' => $questionId,
                'isCorrect' => $isCorrect,
                'correctAnswer' => $correctAnswer,
                'explanation' => $question['excerpt'] ?? "No explanation available"
            ];
        }
        $overallAccuracy = ($totalAttempted > 0) ? round(($totalCorrect / $totalAttempted) * 100, 2) . "%" : "0%";
        return response()->json([
            'success' => true,
            'results' => $results,
            'totalCorrect' => $totalCorrect,
            'totalAttempted' => $totalAttempted,
            'overallAccuracy' => $overallAccuracy,
            'message' => 'All questions submitted successfully!'
        ]);
    }

    private function normalizeAnswer($answer)
    {
        return strtolower(
            trim(
                preg_replace('/\s+/', '', str_replace("\xc2\xa0", '', html_entity_decode($answer)))
            )
        );
    }
}
