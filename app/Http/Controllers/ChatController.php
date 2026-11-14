<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Category;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $chats = Chat::with('user', 'category')->latest()->paginate(10); // Retrieve all chats with their associated user and category
        $categories = Category::all(); // Retrieve all categories for filtering or display purposes
        return view('chats.index', compact('chats', 'categories')); // Pass the chats and categories to the view for rendering
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id', // Validate that the category_id exists in the categories table
            'content' => 'required|string|max:200', // Validate that the content is a string and not too long
        ]);

        // Create a new chat associated with the authenticated user
        Auth()->user()->chats()->create($validated); 
        // Redirect back to the chats index with a success message
        return redirect()->route('chats.index')->with('success', 'Chat message sent successfully!'); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        // Retrieve the chat by its ID
        if($chat->user_id !== auth()->id()){
            abort(403); // If the authenticated user is not the owner of the chat, abort with a 403 Forbidden response
        }
        // Retrieve all categories for the edit form
        $categories = Category::all(); 
        // Pass the chat and categories to the edit view 
        return view('chats.edit', compact('chat', 'categories'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
        if($chat->user_id !== auth()->id()){
            abort(403); // If the authenticated user is not the owner of the chat, abort with a 403 Forbidden response
        }
        // Validate the incoming request data
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id', // Validate that the category_id exists in the categories table
            'content' => 'required|string|max:200', // Validate that the content is a string and not too long
        ]);
        // Update the chat with the validated data
        $chat->update($validated);
        // Redirect back to the chats index with a success message
        return redirect()->route('chats.index')->with('success', 'Chat message updated successfully!'); 
    }

     /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        // Check if the authenticated user is the owner of the chat before allowing deletion
        if($chat->user_id !== auth()->id()){
            abort(403); // If the authenticated user is not the owner of the chat, abort with a 403 Forbidden response
        }
        // Delete the chat from the database
        $chat->delete();
        // Redirect back to the chats index with a success message
        return redirect()->route('chats.index')->with('success', 'Chat message deleted successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    

    

   
}
