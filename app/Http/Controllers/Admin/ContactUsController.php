<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    public function index()
    {
        if (!auth('admin')->user()->hasPermissionTo('contact_us_view'))
            abort(403);

        $messages = ContactRequest::orderByDesc('created_at')->get();
        return view( 'admin.messages.list',compact('messages'));
    }

    public function update(Request $request, ContactRequest $message,$status)
    {
        $message->status = $status;
        $message->save();
        return response()->json(['success'=>'status updated successfully']);
    }
}
