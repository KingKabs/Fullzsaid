<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportMessage;

class SupportController extends Controller {

    public function index() {
        $messages = SupportMessage::where('user_id', auth()->id())
                ->orderBy('created_at', 'asc')
                ->get();

        return view('support.index', compact('messages'));
    }

    public function store(Request $request) {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        SupportMessage::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender' => 'user',
        ]);

        return redirect()->back()->with('success', 'Message sent to support.');
    }
}
