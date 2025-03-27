<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }
    
    public function send(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required',
            ]);
    
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'user_id' => Auth::check() ? Auth::user()->id : null
            ];
    
            Contact::create($data);
            
            return redirect()->back()->with('success', 'Mesaj başarıyla gönderildi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mesajı gönderirken bir hata meydana geldi.' . $e->getMessage());
        }
        
    }
}
