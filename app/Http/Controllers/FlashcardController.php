<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\Deck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\FlashcardView;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class FlashcardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $decks = Deck::where('user_id', $userId)->with('cards')->orderBy('id', 'desc')->get();

        $flashcards = DB::table('flashcards')
            ->orderBy('id', 'asc')
            ->paginate(9);

        return view('admin.tools.flashcard.index', [
            'flashcards' => $flashcards,
            'decks' => $decks
        ]);
    }

   public function recordView(Request $request)
{
    // Ensure route uses auth middleware; double-check here as well
    if (! auth()->check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    $validator = Validator::make($request->all(), [
        'card_id' => 'required|integer|exists:flashcards,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Invalid data', 'errors' => $validator->errors()], 422);
    }

    $cardId = (int) $request->input('card_id');
    $userId = auth()->id();

    try {
        // Create new or update existing record (no duplicates)
        FlashcardView::updateOrCreate(
            ['user_id' => $userId, 'card_id' => $cardId], // search keys
            ['viewed_at' => Carbon::now()]               // values to update
        );

        return response()->json(['message' => 'View recorded'], 200);

    } catch (\Exception $e) {
        Log::error('Failed to create/update flashcard view', [
            'error' => $e->getMessage(),
            'user_id' => $userId,
            'card_id' => $cardId,
        ]);

        return response()->json(['message' => 'Could not record view. Please try again.'], 500);
    }
}


   
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'deck_name'  => 'required|string|max:255|unique:decks,deck_name',
    //         'deck_color' => 'required|string|max:7', 
    //     ]);
    //     Deck::create([
    //         'user_id' => Auth::id(),
    //         'deck_name' => $request->deck_name,
    //         'deck_color' => $request->deck_color,
    //     ]);

    //     return response()->json(['message' => 'Deck created successfully!']);
    // }
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'deck_name' => 'required|string|max:255',
    //         'deck_color' => 'required|string',
    //     ]);
    //     $deck = Deck::findOrFail($id);
    //     $deck->update([
    //         'deck_name' => $request->deck_name,
    //         'deck_color' => $request->deck_color,
    //     ]);
    //     return response()->json(['message' => 'Deck updated successfully!']);
    // }

    // public function delete($id)
    // {
    //     $deck = Deck::findOrFail($id);
    //     $deck->delete();

    //     return redirect()->back()->with('success', 'Deck deleted successfully.');
    // }

    // public function cardstore(Request $request)
    // {
    //     $request->validate([
    //         'deck_id' => 'required|exists:decks,id',
    //         'front_content' => 'required|string|max:2000',
    //         'back_content' => 'required|string|max:2000',
    //         'tags' => 'nullable|string',
    //     ]);

    //     Card::create([
    //         'user_id' => Auth::id(),
    //         'deck_id' => $request->deck_id,
    //         'front_content' => $request->front_content,
    //         'back_content' => $request->back_content,
    //         'tag' => $request->tags,
    //     ]);

    //     return response()->json(['message' => 'Card created successfully!']);
    // }

    // public function cardUpdate(Request $request, $id)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'front_content' => 'required|max:2000',
    //         'back_content' => 'required|max:2000',
    //         'deck_id' => 'required|exists:decks,id',
    //         'tags' => 'nullable|string',
    //     ]);

    //     $card = Card::find($id);

    //     if ($card) {
    //         $card->front_content = $request->front_content;
    //         $card->back_content = $request->back_content;
    //         $card->deck_id = $request->deck_id;
    //         $card->tag = $request->tags;
    //         $card->save();

    //         return response()->json(['message' => 'Card updated successfully.']);
    //     }

    //     return response()->json(['message' => 'Card not found.'], 404);
    // }
    // public function cardDeckUpdate(Request $request, $id)
    // {
    //     $card = Card::find($id);
    //     if ($card) {
    //         $card->deck_id = $request->deck_id; 
    //         $card->save(); 
    //         return response()->json(['message' => 'Card moved successfully.']);
    //     }
    //     return response()->json(['message' => 'Card not found.'], 404);
    // }



    // public function CardDelete($id)
    // {
    //     $card = Card::findOrFail($id);
    //     $card->delete();

    //     return redirect()->back()->with('success', 'Deck deleted successfully.');
    // }
}
