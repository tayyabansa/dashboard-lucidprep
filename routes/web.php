<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PreviousController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StudyPlanController;
use App\Http\Controllers\DIDController;
use App\Http\Controllers\AvatarTTSController;
use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test-mail', function () {

    Mail::raw('This is test mail from Laravel Route', function ($message) {
        $message->to('tayyableavecode@gmail.com')
                ->subject('Test Mail');
    });

    return "Mail Sent Successfully";
});

Route::get('/user/create', [CrudController::class, 'index']);
Route::post('/user/create', [CrudController::class, 'create'])->name('user.create');
Route::get('/wp-login', [DashboardController::class, 'wplogin']);


Route::get('/login', [DashboardController::class, 'login'])->name('login');
Route::post('/login', [DashboardController::class, 'loginPost'])->name('login-post');



Route::middleware(['auth:admin'])->group(function () {
  Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');
  Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
  Route::get('/redirect-to-wordpress', [DashboardController::class, 'redirectToWordPress'])->name('wordpress.redirect');
  Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
  Route::get('/notes_all', [NoteController::class, 'allnotes']);
  Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
  Route::get('/notes/{id}', [NoteController::class, 'show'])->name('notes.show');
  Route::put('/notes/{id}', [NoteController::class, 'update'])->name('notes.update');
  Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
  Route::get('/search-note/{search?}', [NoteController::class, 'search'])->name('notes.search'); // Search notes
  Route::post('/notes/modal/save', [NoteController::class, 'modalSave'])->name('notes.modal.save');        
    
    
     Route::prefix('question-bank')->group(function () {
        Route::get('/create-test', [TestController::class, 'index'])->name('test');
        Route::post('/tests/store', [TestController::class, 'store'])->name('tests.store');
        Route::get('/fetch-question-counts/{subject}', [TestController::class, 'fetchQuestionCounts'])->name('questions.counts');
        Route::get('/launch-test/{user_id}/{test_id}', [TestController::class, 'launched'])->name('test.launched');
        Route::post('/launch-test/{test_id}/{question_id}', [TestController::class, 'submitAnswer'])->name('launch-test');
        Route::post('/english-bulk-submit/{test_id}', [TestController::class, 'englishBulkSubmit'])->name('english.bulk.submit');
        Route::post('/mark-question-seen', [TestController::class, 'markQuestionSeen'])->name('markQuestionSeen');
        Route::post('/bookmark-question', [TestController::class, 'bookmarkQuestion'])->name('bookmark.question');
        Route::get('/check-bookmark', [TestController::class, 'checkBookmark'])->name('check.bookmark');
        Route::get('/fetch-question-statuses/{user_id}/{test_id}', [TestController::class, 'fetchQuestionStatuses'])->name('fetch.question.statuses');
        Route::post('/custom-test', [TestController::class, 'customTest'])->name('custom.test');
        Route::post('/submit-feedback', [TestController::class, 'submitFeedback'])->name('submit.feedback');
        Route::get('/result-test/{user_id}/{test_id}', [TestController::class, 'testresult'])->name('test.result');
        Route::get('/previoustests', [PreviousController::class, 'index'])->name('previoustests');
        Route::get('/performance-overall', [PerformanceController::class, 'index'])->name('performance.overall');
        Route::get('/performance-reports', [ReportController::class, 'index'])->name('report.index');
        Route::get('/performance-graph', [PerformanceController::class, 'graphGet'])->name('performance.graph');
        Route::delete('suspendDestroy/tests/{id}', [TestController::class, 'suspendDestroy'])->name('tests.suspendDestroy');
        Route::get('/test/result/{user_id}/{test_id}', [TestController::class, 'resultIndex'])->name('results.index');
        Route::get('/test/create', [TestController::class, 'createTest'])->name('test.create.subject');
        Route::get('/fetch-tabs/{subject}', [TestController::class, 'fetchTabsCounts'])->name('fetch.tabs');
        Route::post('/create-test-manual', [TestController::class, 'createTestManual'])->name('create.test.manual');

    }
    );

    Route::prefix('resources')->group(function () {
        Route::get('/study-plan', [StudyPlanController::class, 'index'])->name('study.plan');
        Route::get('/act-book', [StudyPlanController::class, 'actIndex'])->name('act.book');
    });




    Route::post('/generate-avatar-speech', [DIDController::class, 'createAvatarSpeech']);
    Route::get('/check-avatar-speech/{id}', [DIDController::class, 'checkVideoStatus']);



    Route::prefix('tools')->group(function () {
        Route::get('/flashcards', [FlashcardController::class, 'index'])->name('flashcards');
         Route::post('/flashcards', [FlashcardController::class, 'store'])->name('flashcards.store');
         Route::post('/flashcards/view', [App\Http\Controllers\FlashcardController::class, 'recordView'])
    ->name('flashcards.recordView')
    ->middleware('auth');
          Route::delete('/flashcards/delete/{id}', [FlashcardController::class, 'delete'])->name('flashcards.delete');
        Route::put('/flashcards/{id}', [FlashcardController::class, 'update'])->name('flashcards.update');
            Route::post('/newcards', [FlashcardController::class, 'cardstore'])->name('newcards.store');
        Route::put('/cards/{id}', [FlashcardController::class, 'cardUpdate'])->name('cards.cardUpdate');
        Route::put('/cards/deck/{id}', [FlashcardController::class, 'cardDeckUpdate'])->name('cards.cardDeckUpdate');
        Route::delete('/cards/delete/{id}', [FlashcardController::class, 'CardDelete'])->name('cards.delete');

        Route::get('/search', [SearchController::class, 'index'])->name('search');

        Route::get('/notebook', [NoteController::class, 'index'])->name('notebook');
    });

    Route::prefix('help')->group(function () {
        Route::get('/', [HelpController::class, 'index'])->name('help');
    });
 });