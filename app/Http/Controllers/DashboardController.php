<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Hautelook\Phpass\PasswordHash;
use App\Models\WpUser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
public function login(Request $request)
{
    if ($request->has(['token', 'key'])) {
       
        $hashed_username = $request->input('token');
        $hashed_password = $request->input('key');
        
        $decoded_username = $this->decrypt_username($hashed_username);

      
        $user = WpUser::where('user_login', $decoded_username)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'User not found.'])->withInput();
        }

       
        if ($hashed_password !== $user->user_pass) {
            return redirect()->route('login')->withErrors(['password' => 'Invalid password.'])->withInput();
        }

       
        Auth::guard('admin')->loginUsingId($user->ID);
        Session::put('user_id', $user->ID);
        
        if ($request->has('page')){
            return redirect()->route('study.plan');
        }else{
            return redirect()->route('dashboard');
        }
    }

    return view('admin.login');
}

public function wplogin(Request $request)
{
    try{
    if ($request->has(['token', 'key'])) {
       
        $hashed_username = $request->input('token');
        $hashed_password = $request->input('key');
        
        $decoded_username = $this->decrypt_username($hashed_username);
// dd($decoded_username, $hashed_password);

      
        $user = WpUser::where('user_login', $decoded_username)->where('user_pass', $hashed_password)->first();
// dd($user->ID);
// exit;
        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'User not found',
               'status'=> 404
            ])->header('Access-Control-Allow-Origin', 'https://lucidprep.org')
->header('Access-Control-Allow-Credentials', 'true');;
        }

       
        if ($hashed_password !== $user->user_pass) {
            return response()->json([
                'success' => true,
                'message' => 'Invalid Password',
               'status'=> 422
            ])->header('Access-Control-Allow-Origin', 'https://lucidprep.org')
->header('Access-Control-Allow-Credentials', 'true');;
        }

        if ( Auth::guard('admin')->login($user)) {
            Session::put('user_id', $user->ID);
             return response()->json([
                'success' => true,
                'message' => 'Login Successfull',
               'status'=> 200
            ])->header('Access-Control-Allow-Origin', 'https://lucidprep.org')
    ->header('Access-Control-Allow-Credentials', 'true');
            
        }else{
             return response()->json([
            'success' => false,
            'message' => 'Login Failed',
           'status'=> 404
        ])->header('Access-Control-Allow-Origin', 'https://lucidprep.org')
->header('Access-Control-Allow-Credentials', 'true');;
        }
        //  Auth::guard('admin')->login($user);
       

      
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Invalid credentials',
       'status'=> 400
    ]);

    }catch(Exception $e){
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
           'status'=> 400,
           'error' => $e->getMessage()
        ]);
    }
}


    
private function decrypt_username($encrypted_data) {
    $encryption_key = '12345'; // Must match WordPress
    $cipher = 'aes-256-cbc';

    // ✅ Convert back to standard Base64 (replace - and _)
    $base64_data = str_replace(['-', '_'], ['+', '/'], $encrypted_data);
    
    // Add back padding if needed
    $pad_length = 4 - (strlen($base64_data) % 4);
    if ($pad_length < 4) {
        $base64_data .= str_repeat('=', $pad_length);
    }

    // Decode and decrypt
    $data_parts = explode('::', base64_decode($base64_data), 2);
    if (count($data_parts) !== 2) {
        return null; // Invalid data
    }

    list($iv, $encrypted) = $data_parts;
    return openssl_decrypt($encrypted, $cipher, $encryption_key, 0, $iv);
}

public function redirectToWordPress()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    $sharedSecret = 'letmein'; // must match WordPress

    $wordpressUrl = "https://lucidprep.org/?user={$user->user_login}&dashboard={$sharedSecret}";

    return redirect($wordpressUrl);
}


//     public function loginPost(Request $request)
//     {
//         $user = WpUser::where(function ($query) use ($request) {
//             $query->where('user_login', $request->email)
//                 ->orWhere('user_email', $request->email);
//         })
//             ->first();
// // dd($user);

//         if (!$user) {
//             return back()->withErrors(['email' => 'User not found.'])->withInput();
//         }
//         $userPass = $user->user_pass;
//         $password = $request->password;
//         $passwordMatched = false;
    
//      if (strpos($userPass, '$wp$') === 0) {
//         $bcryptPassword = substr($user->user_pass, 4); // Removing the $wp$ prefix
//         $hashed = Crypt::decryptString($bcryptPassword);
        
//         if ($hashed === $password) {
//             $passwordMatched = true;
//         } 
       
//     } elseif (strpos($userPass, '$P$') === 0 || strpos($userPass, '$H$') === 0) {
//         // Old portable MD5 hash
//         $hasher = new PasswordHash(8, true);
//         $passwordMatched = $hasher->CheckPassword($password, $userPass);
//     } else {
//         return back()->withErrors(['password' => 'Unknown password format.'])->withInput();
//     }

//     if (!$passwordMatched) {
//         return back()->withErrors(['password' => 'Invalid password.'])->withInput();
//     }

//     // 🛠 Optional: Upgrade old $P$ password to new $wp$2y$ password after login
//     if (strpos($userPass, '$P$') === 0 || strpos($userPass, '$H$') === 0) {
//         $newHash = '$wp$' . password_hash($password, PASSWORD_BCRYPT);
//         $user->user_pass = $newHash;
//         $user->save();
//     }
//         // $hasher = new PasswordHash(8, true);
//         // $hashedPassword = $hasher->HashPassword($request->password);
//         // echo $hashedPassword;
//         // exit;
//         // if (!$hasher->CheckPassword($request->password, $user->user_pass)) {
//         //     return back()->withErrors(['password' => 'Invalid password'])->withInput();
//         // }
//         // if (!Hash::check($request->password, $user->user_pass)) {
//         //     return back()->withErrors(['password' => 'Invalid password.'])->withInput();
//         // }

//         Auth::guard('admin')->login($user);

//         Session::put('user_id', [
//             'id' => $user->ID,
//         ]);

//         return redirect()->route('dashboard');
//     }

  public function loginPost(Request $request)
    {
        $user = WpUser::where(function ($query) use ($request) {
            $query->where('user_login', $request->email)
                ->orWhere('user_email', $request->email);
        })
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.'])->withInput();
        }

        $storedHash = $user->user_pass;

        // Remove custom prefix if present
        if (str_starts_with($storedHash, '$wp$')) {
            $storedHash = substr($storedHash, 4);
        }
        
        $hasher = new PasswordHash(8, true);
        
        if ($hasher->CheckPassword($request->password, $storedHash)) {
            return back()->withErrors(['password' => 'Invalid password.'])->withInput();
        }

        Auth::guard('admin')->login($user);

        Session::put('user_id', [
            'id' => $user->ID,
        ]);

       return redirect()->intended(route('dashboard'));

    }



    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::flush(); // Clear session data
        return redirect()->route('login');
    }

   
public function dashboard()
{
    $apiUrl = "https://lucidprep.org/wp-json/custom/v1/questions";
    $apiKey = "TqoRzM7pqadqVDr8mZxarSiK5m1weTsbl3NapWxzNN";

    $response = Http::withHeaders(['X-API-KEY' => $apiKey])->get($apiUrl);
    if (!$response->successful()) {
        return response()->json(['error' => 'Unable to fetch question data'], 500);
    }

    // ----- Courses count -----
    $courses = $response->json();
    $allCourses = [];
    foreach ($courses as $course) {
        if (!empty($course['select_courses'])) {
            $allCourses = array_merge($allCourses, $course['select_courses']);
        }
    }
    $totalUniqueCourses = count(array_unique($allCourses));

    // ----- Global student stats -----
    $totalStudents = WpUser::get();
    $studentsLast20DaysCount = WpUser::where('user_registered', '>=', now()->subDays(20))->count();
    $studentsBefore20DaysCount = WpUser::where('user_registered', '<', now()->subDays(20))->count();
    $studentsLast25DaysCount = WpUser::where('user_registered', '>=', now()->subDays(25))->count();
    $studentsBefore25DaysCount = WpUser::where('user_registered', '<', now()->subDays(25))->count();

    $percentageIncrease20 = $studentsBefore20DaysCount == 0
        ? ($studentsLast20DaysCount > 0 ? 100 : 0)
        : round(($studentsLast20DaysCount / ($studentsBefore20DaysCount + $studentsLast20DaysCount)) * 100, 2);

    $percentageIncrease25 = $studentsBefore25DaysCount == 0
        ? ($studentsLast25DaysCount > 0 ? 100 : 0)
        : round(($studentsLast25DaysCount / ($studentsBefore25DaysCount + $studentsLast25DaysCount)) * 100, 2);

    $userId = Auth::id();

    // ----- Roles -----
    $isAdmin = DB::table('wper_usermeta')
        ->where('user_id', $userId)->where('meta_key', 'wper_capabilities')
        ->where('meta_value', 'LIKE', '%administrator%')->exists();

    $isSchoolAdmin = DB::table('wper_usermeta')
        ->where('user_id', $userId)->where('meta_key', 'wper_capabilities')
        ->where('meta_value', 'LIKE', '%school_admin%')->exists();

    $isStudent = DB::table('wper_usermeta')
        ->where('user_id', $userId)->where('meta_key', 'wper_capabilities')
        ->where('meta_value', 'LIKE', '%student%')->exists();

    // ===== School Admin: fetch students + aggregated stats =====
    $schoolAdminStudents = collect();
    $schoolTitle = null;
    $schoolId = null;
    $schoolMetaKeyUsed = null;
    $stats = ['answered' => 0, 'spent' => '�', 'spent_seconds' => 0];

    if ($isSchoolAdmin) {
        $possibleSchoolKeys = ['school_post_id', 'associated_school', 'school', 'school_id', 'acf_school'];

        $schoolMeta = DB::table('wper_usermeta')
            ->where('user_id', $userId)
            ->whereIn('meta_key', $possibleSchoolKeys)
            ->whereNotNull('meta_value')
            ->orderByRaw("FIELD(meta_key,'school_post_id','associated_school','school','school_id','acf_school')")
            ->first();

        if ($schoolMeta && trim((string)$schoolMeta->meta_value) !== '') {
            $schoolId = trim((string)$schoolMeta->meta_value);
            $schoolMetaKeyUsed = $schoolMeta->meta_key;

            // (optional) school name from CPT
            $schoolPost = DB::table('wper_posts')
                ->where('ID', $schoolId)->where('post_status', 'publish')->first();
            $schoolTitle = $schoolPost ? $schoolPost->post_title : null;

            // Subquery A: aggregate per user from tests
            $testsAgg = DB::table('tests')
                ->select([
                    'user_id',
                    DB::raw('SUM(COALESCE(num_of_passages,0)) AS total_questions'),
                    DB::raw('MAX(updated_at) AS tests_last_updated_at'),
                    DB::raw('MAX(COALESCE(updated_at, created_at)) AS last_practiced_at'),
                ])
                ->groupBy('user_id');

            // Subquery B: aggregate per user from test_results (time)
            $resultsAgg = DB::table('test_results')
                ->select([
                    'user_id',
                    DB::raw('SUM(COALESCE(time_spent,0)) AS total_time_sec'),
                    DB::raw('MAX(updated_at) AS results_last_updated_at'),
                ])
                ->groupBy('user_id');

            // Main query: students in this school + left join both aggregates
            $schoolAdminStudents = DB::table('wper_users as u')
                ->join('wper_usermeta as role', function ($join) {
                    $join->on('role.user_id', '=', 'u.ID')
                         ->where('role.meta_key', 'wper_capabilities');
                })
                ->join('wper_usermeta as sch', function ($join) use ($schoolMetaKeyUsed) {
                    $join->on('sch.user_id', '=', 'u.ID')
                         ->where('sch.meta_key', $schoolMetaKeyUsed);
                })
                ->leftJoinSub($testsAgg, 't', function ($join) {
                    $join->on('t.user_id', '=', 'u.ID');
                })
                ->leftJoinSub($resultsAgg, 'tr', function ($join) {
                    $join->on('tr.user_id', '=', 'u.ID');
                })
                ->where('role.meta_value', 'LIKE', '%student%')
                ->where('sch.meta_value', $schoolId)
                ->select([
                    'u.ID',
                    'u.user_login',
                    'u.display_name',
                    'u.user_email',
                    'u.user_registered',
                    DB::raw('COALESCE(t.total_questions,0) AS total_questions'),
                    DB::raw('COALESCE(tr.total_time_sec,0) AS total_time_sec'),
                    't.last_practiced_at',
                    DB::raw("GREATEST(COALESCE(t.tests_last_updated_at,'1970-01-01 00:00:00'), COALESCE(tr.results_last_updated_at,'1970-01-01 00:00:00')) AS last_updated_at"),
                ])
                ->orderBy('u.user_registered', 'desc')
                ->get();

            // ---- 30-day totals across all students (counts + time) ----
            if ($schoolAdminStudents->isNotEmpty()) {
                $studentIds = $schoolAdminStudents->pluck('ID')->all();
                $since = now()->subDays(30);

                $answered30 = DB::table('tests')
                    ->whereIn('user_id', $studentIds)
                    ->where(function ($q) use ($since) {
                        $q->where('created_at', '>=', $since)
                          ->orWhere('updated_at', '>=', $since);
                    })
                    ->selectRaw('SUM(COALESCE(num_of_passages,0)) AS s')
                    ->value('s');
                $answered30 = (int) ($answered30 ?? 0);

                $timeSecs30 = DB::table('test_results')
                    ->whereIn('user_id', $studentIds)
                    ->where(function ($q) use ($since) {
                        $q->where('created_at', '>=', $since)
                          ->orWhere('updated_at', '>=', $since);
                    })
                    ->selectRaw('SUM(COALESCE(time_spent,0)) AS s')
                    ->value('s');
                $timeSecs30 = (int) ($timeSecs30 ?? 0);

                $hours = intdiv($timeSecs30, 3600);
                $mins  = intdiv($timeSecs30 % 3600, 60);
                $spentHuman = $timeSecs30 > 0 ? sprintf('%d hr %d min', $hours, $mins) : '�';

                $stats = [
                    'answered'       => $answered30,
                    'spent'          => $spentHuman,
                    'spent_seconds'  => $timeSecs30,
                ];
            }

            // ------ Fetch flashcard aggregates for the school students (single query) ------
            if (!empty($studentIds)) {
                // safer SQL: use CASE WHEN to count last7
                $cut = now()->subDays(7)->toDateTimeString();
                $fvRows = DB::table('flashcard_views')
                    ->select('user_id', DB::raw('COUNT(*) AS total_seen'),
                        DB::raw("SUM(CASE WHEN (viewed_at >= '$cut' OR created_at >= '$cut') THEN 1 ELSE 0 END) AS seen_last7"))
                    ->whereIn('user_id', $studentIds)
                    ->groupBy('user_id')
                    ->get()
                    ->keyBy('user_id');

                // attach counts to each $schoolAdminStudents row
                $schoolAdminStudents = $schoolAdminStudents->map(function($row) use ($fvRows) {
                    $id = $row->ID;
                    $row->flashcards_total = isset($fvRows[$id]) ? (int)$fvRows[$id]->total_seen : 0;
                    $row->flashcards_week  = isset($fvRows[$id]) ? (int)$fvRows[$id]->seen_last7  : 0;
                    return $row;
                });
            }
        }
    }

    // ----- Category distribution (legend + donut) -----
    $categories = [];
    if ($isSchoolAdmin && $schoolAdminStudents->isNotEmpty()) {
        $studentIds = $schoolAdminStudents->pluck('ID')->all();
        $since = now()->subDays(30);

        $rows = DB::table('tests')
            ->select('subject_type', DB::raw('COUNT(*) AS c'))
            ->whereIn('user_id', $studentIds)
            ->where(function ($q) use ($since) {
                $q->where('created_at', '>=', $since)
                  ->orWhere('updated_at', '>=', $since);
            })
            ->groupBy('subject_type')
            ->orderByDesc('c')
            ->get();

        $total = max(1, (int) $rows->sum('c'));
        $categories = $rows->map(function ($r) use ($total) {
            $label = $r->subject_type ?: 'Unknown';
            $count = (int) $r->c;
            $pct   = round($count * 100 / $total, 1);
            return ['label' => $label, 'count' => $count, 'pct' => $pct];
        })->values()->all();
    }

    // ===== NEW: daily totals for the last 30 days (inclusive) =====
    $byDayLabels = [];
    $byDayTotals = [];
    if ($isSchoolAdmin && $schoolAdminStudents->isNotEmpty()) {
        $studentIds = $schoolAdminStudents->pluck('ID')->all();
        $since = now()->startOfDay()->subDays(29); // 30 days inclusive

        $rows = DB::table('tests')
            ->selectRaw('DATE(COALESCE(updated_at, created_at)) as d, SUM(COALESCE(num_of_passages,0)) as q')
            ->whereIn('user_id', $studentIds)
            ->where(function ($w) use ($since) {
                $w->where('created_at', '>=', $since)
                  ->orWhere('updated_at', '>=', $since);
            })
            ->groupBy('d')
            ->orderBy('d')
            ->get()
            ->keyBy('d');

        // Build continuous day range and fill zeros
        $cursor = $since->copy();
        $end    = now()->startOfDay();
        while ($cursor->lte($end)) {
            $iso = $cursor->toDateString();          // YYYY-MM-DD
            $byDayLabels[] = $cursor->format('M j'); // e.g., "Aug 14"
            $byDayTotals[] = isset($rows[$iso]) ? (int) $rows[$iso]->q : 0;
            $cursor->addDay();
        }
    }

    // ===== Student (per-subject KPIs computed from per-question rows) =====
    $studentMetrics = [];

    if ($isStudent) {
        $userId    = Auth::id();
        $subjects  = ['English','Math','Reading','Science','College-Career-Readiness'];
        $since30   = now()->subDays(30);
        $goalMins  = 120;   // target minutes for "Time on Platform" arc
        $weeksBack = 6;     // sparkline points

        // Precompute flashcards global for logged-in student (single queries)
        $globalFlashcardsTotal = (int) DB::table('flashcard_views')->where('user_id', $userId)->count();
        $globalFlashcardsLast7  = (int) DB::table('flashcard_views')
            ->where('user_id', $userId)
            ->where(function($q) {
                $q->where('viewed_at', '>=', now()->subDays(7))
                  ->orWhere('created_at', '>=', now()->subDays(7));
            })->count();

        foreach ($subjects as $subj) {
            $key = strtolower(preg_replace('/\W+/', '_', $subj)); // e.g. college_career_readiness

            // Base: student's question-level results joined to tests for subject
            $base = DB::table('test_results as tr')
                ->join('tests as t', 't.id', '=', 'tr.test_id')
                ->where('tr.user_id', $userId)
                ->whereRaw('LOWER(COALESCE(t.subject_type,"")) = ?', [strtolower($subj)]);

            // 30-day window (created_at, like in your PerformanceController)
            $last30 = (clone $base)->where('tr.created_at', '>=', $since30);

            // Distinct tests in last 30 days
            $tests_count_30 = (int) (clone $last30)
                ->distinct('tr.test_id')->count('tr.test_id');

            // Time in last 30d (seconds -> minutes)
            $time_sec_30 = (int) (clone $last30)
                ->selectRaw('SUM(COALESCE(tr.time_spent,0)) as s')
                ->value('s');
            $time_minutes_30 = intdiv($time_sec_30, 60);

            // Accuracy from per-question rows (last 30d; fallback to all-time)
            $tot30     = (int) (clone $last30)->count(); // rows == questions answered
            $correct30 = (int) (clone $last30)->where('tr.is_correct', 1)->count();

            $accuracy_pct = null;
            if ($tot30 > 0) {
                $accuracy_pct = (int) round(($correct30 * 100) / $tot30);
            } else {
                // Fallback to all-time for this subject
                $totAll     = (int) (clone $base)->count();
                $correctAll = (int) (clone $base)->where('tr.is_correct', 1)->count();
                if ($totAll > 0) {
                    $accuracy_pct = (int) round(($correctAll * 100) / $totAll);
                }
            }

            // �Scaled� score derived from percent (simple 0�36 map)
            $scaled_score = $accuracy_pct !== null ? (int) round($accuracy_pct * 0.36) : null;

            // Questions in the last 7 days (for �Questions / Week� KPI)
            $weekStart = now()->startOfDay()->subDays(6);
            $questions_week = (int) (clone $base)
                ->where('tr.created_at', '>=', $weekStart)
                ->count();

            // Weekly sparkline: questions per Mon�Sun week, last N weeks
            $spark = [];
            for ($i = $weeksBack - 1; $i >= 0; $i--) {
                $start = now()->copy()->startOfWeek()->subWeeks($i);
                $end   = (clone $start)->addWeek();
                $sum   = (int) (clone $base)
                    ->whereBetween('tr.created_at', [$start, $end])
                    ->count();
                $spark[] = $sum;
            }

            // Status pill (same thresholds as the rest of your app)
            $acc  = $accuracy_pct ?? 0;
            $sc   = $scaled_score ?? 0;
            $mins = $time_minutes_30;
            $status = 'warn';
            if ($sc >= 26 && $mins >= 120 && $acc >= 80) $status = 'good';
            elseif ($sc < 20 || $mins < 60 || $acc < 65) $status = 'bad';

            // Flashcard counts per student (attach same totals to every subject panel so UI can read)
            $flashcardsTotal = $globalFlashcardsTotal;
            $flashcardsLast7 = $globalFlashcardsLast7;

            $studentMetrics[$key] = [
                'title'          => $subj,
                'score'          => $scaled_score,           // 0�36
                'accuracy'       => $accuracy_pct,           // 0�100
                'time_minutes'   => $time_minutes_30,        // minutes (last 30d)
                'tests'          => $tests_count_30,         // distinct tests (last 30d)
                'questions_week' => $questions_week,         // last 7 days
                'spark'          => $spark,                  // weekly question counts
                'status'         => $status,
                'time_pct'       => min(100, (int) round(($time_minutes_30 / $goalMins) * 100)),
                // flashcard metrics:
                'flashcards_seen' => $flashcardsTotal,
                'flashcards_week' => $flashcardsLast7,
            ];
        }

        // attach a global top-level flashcard object too
        $studentMetrics['__global_flashcards'] = [
            'total' => $globalFlashcardsTotal,
            'week'  => $globalFlashcardsLast7
        ];

        // ---- Video tutorial stats (per user) ----
        $videoSince = now()->subDays(30);

        $videoBase = DB::table('wper_video_analytics')
            ->where('user_id', $userId)
            ->where('viewed_at', '>=', $videoSince);

        // Number of DISTINCT videos watched by the user
        $videosWatched = (int) (clone $videoBase)
            ->distinct('video_url')
            ->count('video_url');

        // Optional: total plays (sum of view_count; fallback to 1 if null)
        $totalVideoViews = (int) (clone $videoBase)
            ->selectRaw('SUM(COALESCE(view_count,1)) AS s')
            ->value('s');

        // Attach to each subject metrics so UI can read from any panel
        foreach (array_keys($studentMetrics) as $k) {
            if ($k === '__global_flashcards') continue;
            $studentMetrics[$k]['videos_watched'] = $videosWatched;   // used by UI
            $studentMetrics[$k]['video_views']    = $totalVideoViews; // optional
        }
    }

    return view('admin.dashboard.index', compact(
        'totalStudents',
        'percentageIncrease20',
        'studentsLast25DaysCount',
        'percentageIncrease25',
        'totalUniqueCourses',
        'isAdmin',
        'isSchoolAdmin',
        'isStudent',
        'schoolAdminStudents',
        'schoolTitle',
        'schoolId',
        'schoolMetaKeyUsed',
        'stats',
        'categories',
        'byDayLabels',
        'byDayTotals',
        'studentMetrics'
    ));
}




}