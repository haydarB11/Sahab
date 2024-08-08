<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!auth('admin')->user()->hasPermissionTo('customers_list'))
            abort(403);
        $customers = User::where('role', 'user')->get();

        return view('admin.customers.list', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    public function viewBookings(User $customer)
    {
        $bookings = Booking::where('user_id',$customer->id)->get();

        return view('admin.booking.list',compact('bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        return view('admin.customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {


        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;

        $customer->save( );

        return response()->json(['message' => 'customer updated successfully'], Response::HTTP_OK);

    }

    public function updateStatus(Request $request, User $customer)
    {
        $status = $request->query('status');
        $customer->status = $status == 1 ? "activated" : "deactivated";
        $customer->save();

        return response()->json(['message' => 'customer status updated successfully'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( User $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'customer deleted successfully'], Response::HTTP_OK);


    }
}
