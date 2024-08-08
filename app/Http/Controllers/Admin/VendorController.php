<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Client;


class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth('admin')->user()->hasPermissionTo('vendors_list'))
        abort(403);
        $vendors = User::where('role', 'vendor')->get();

        return view('admin.vendors.list', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vendors.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vendor = new User();

        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->commission = $request->commission;
        $vendor->role = 'vendor';


        $client = new Client();
        $apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';

        $response = $client->post('https://apitest.myfatoorah.com/v2/CreateSupplier', [
            'headers' => [
                'Authorization' => "Bearer $apiKey",
            ],
            'json' => [
                'SupplierName' => $vendor->name,
                'Mobile' => $vendor->phone,
                'Email' => $vendor->email,
                "CommissionPercentage" => $request->commission
            ],
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);

        if ($responseData['IsSuccess'] === true) {
            $supplierCode = $responseData['Data']['SupplierCode'];
            $vendor->supplier_code = $supplierCode;
        }

        $vendor->save();

        return response()->json(['message' => 'vendor created successfully'], Response::HTTP_OK);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $vendor)
    {
        return view('admin.vendors.edit',compact('vendor'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $vendor)
    {


        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->commission = $request->commission;


        $vendor->save();

        return response()->json(['message' => 'vendor updated successfully'], Response::HTTP_OK);

    }

    public function updateStatus(Request $request, User $vendor)
    {
        $status = $request->query('status');
        $vendor->status = $status == 1 ? "activated" : "deactivated";
        $vendor->save();

        return response()->json(['message' => 'vendor status updated successfully'], Response::HTTP_OK);
    }

    public function viewPlaces(User $vendor)
    {
        $places = Place::where('vendor_id',$vendor->id)->get();

        return view('admin.places.list',compact('places'));
    }
    public function viewServices(User $vendor)
    {
        $services = Service::where('vendor_id',$vendor->id)->get();

        return view('admin.services.list',compact('services'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $vendor)
    {
        $vendor->delete();

        return response()->json(['message' => 'vendor deleted successfully'], Response::HTTP_OK);
    }
}
