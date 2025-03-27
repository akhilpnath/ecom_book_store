<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('is_read')->latest()->paginate(10);
        return view('admin.messages.index', compact('messages'));
    }

    public function markRead(Message $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        return redirect()->route('admin.messages.index')->with('success', 'Message marked as read.');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully!');
    }
}
