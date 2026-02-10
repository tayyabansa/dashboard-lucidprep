<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Auth;
class NoteController extends Controller
{
  
    
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())->get();
        return view('admin.tools.mynotebook.index', compact('notes'));
    }

   // Store New Note
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $note = Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'note' => $note]);
    }

    // Show a Single Note
    public function show($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($note);
    }

    // Update Existing Note
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json(['success' => true, 'note' => $note]);
    }

    // Delete Note
    public function destroy($id)
    {
        Note::where('user_id', Auth::id())->findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // Search Notes
    public function search(Request $request)
    {
  
        $query = $request->search;
        $notes = Note::where('user_id', Auth::id())
                    ->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->get();
        
        return response()->json($notes);
    }
    
      // Search Notes
    public function allnotes(Request $request)
    {
     
       $notes = Note::where('user_id', Auth::id())->get();
        
       return response()->json($notes);
    }
     public function modalSave(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $note = Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'note' => $note]);
    }
}
