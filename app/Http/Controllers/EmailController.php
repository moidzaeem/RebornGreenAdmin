<?php

namespace App\Http\Controllers;

use App\Mail\CustomEmail;
use App\Models\WebsiteUser;
use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller
{
    public function create()
    {
        $users = WebsiteUser::all();
        return view('email.create', compact('users'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'users' => 'required',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            foreach ($request->users as $key => $id) {
                $user = WebsiteUser::find($id);
                Mail::to($user->email)->send(new CustomEmail($request->subject, $request['message']));
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Email Configuration is not set');

        }

        return back()->with('success', 'Email sent successfully!');
    }
}
