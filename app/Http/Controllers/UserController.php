<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\DeviceToken;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Otp;
use App\Models\Place;
use App\Models\Service;
use GuzzleHttp\Client;
use SimpleXMLElement;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->role = "user";
            $user->save();

            $token = $user->createToken('user-token')->plainTextToken;

            return response()->json(['message' => 'User created successfully', 'user' => $user, 'token' => $token], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating user', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $fieldsToUpdate = [
                'name',
                'email',
                'phone',
                'status',
                'supplier_code',
                'role'
            ];

            foreach ($fieldsToUpdate as $field) {
                if ($request->has($field)) {
                    $user->$field = $request->input($field);
                }
            }

            if ($request->has('email') && $request->input('email') !== $user->email) {
                $existingUser = User::where('email', $request->input('email'))->first();

                if ($existingUser) {
                    return response()->json(['message' => 'Email already exists'], Response::HTTP_BAD_REQUEST);
                }
            }

            $image = $request->file('image');

            if ($image) {
                $photo = $request->file('image');
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photoPath = '/photos/' . $photoName;
                $photo->move(public_path('photos'), $photoName);
                $photoUrl = $photoPath;
                $user->image = $photoUrl;
            }

            if ($request->input('role') == 'vendor') {
                $client = new Client();
                $apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';

                $response = $client->post('https://apitest.myfatoorah.com/v2/CreateSupplier', [
                    'headers' => [
                        'Authorization' => "Bearer $apiKey",
                    ],
                    'json' => [
                        'SupplierName' => $user->name,
                        'Mobile' => $user->phone,
                        'Email' => $user->email,
                        "CommissionPercentage" => 90
                    ],
                ]);

                $responseData = json_decode($response->getBody()->getContents(), true);

                if ($responseData['IsSuccess'] === true) {
                    $supplierCode = $responseData['Data']['SupplierCode'];
                    $user->supplier_code = $supplierCode;
                }

            }

            $user->save();

            return response()->json(['message' => 'User updated successfully', 'user' => $user], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating user', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }
            Place::where('vendor_id', $id)->delete();
            Service::where('vendor_id', $id)->delete();
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting user', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($user, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching user', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching users', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPlacesForOneUser($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $places = $user->places;

            return response()->json($places, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching places for user', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getServicesForOneUser($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $services = $user->services;

            return response()->json($services, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching services for user', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUser()
    {
        try {
            $userId = Auth::id();
            $user = User::findOrFail($userId);

            if (!$user) {
                return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($user, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching services for user', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function sendOtp(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)->first();
            $otp = '0000';

            $otpModel = new Otp();
            $otpModel->otp = $otp;
            $otpModel->expires_at = now()->addMinutes(2);

            if ($user) {

                $otpModel->user_id = $user->id;
                $otpModel->save();

                return response()->json(['message' => 'OTP sent successfully'], Response::HTTP_OK);
            } else {
                $otpModel->phone = $request->phone;
                $otpModel->save();

                return response()->json(['message' => 'OTP sent successfully'], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while logging in', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)->first();

            if ($user) {
                $otpModel = $user->otp()->latest()->first();

                if ($otpModel && $otpModel->otp == $request->code) {
                    $token = $user->createToken('user-token')->plainTextToken;
                    $otpModel->delete();
                    return response()->json(['message' => $user, 'token' => $token, 'is_registered' => true], Response::HTTP_OK);
                } else {
                    return response()->json(['message' => 'Invalid OTP'], Response::HTTP_BAD_REQUEST);
                }
            } else {
                $otpModel = Otp::where('phone', $request->phone)
                    ->latest()
                    ->first();
                if ($otpModel && $otpModel->otp == $request->code) {
                    $otpModel->delete();
                    return response()->json(['message' => 'OTP is correct', 'is_registered' => false], Response::HTTP_OK);
                } else {
                    return response()->json(['message' => 'Invalid OTP'], Response::HTTP_BAD_REQUEST);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while verifying OTP', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout()
    {
        try {
            $userId = Auth::id();

            if ($userId) {
                DeviceToken::where('user_id', $userId)->delete();
            }

            return response()->json(['message' => 'Logout successful'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while logging out', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function sendSms($recipientNumber, $message)
    {

        $client = new Client();

        try {
            $response = $client->post('https://www.smsbox.com/SMSGateway/XmlSMSGateway.aspx', [
                'form_params' => [
                    'username' => 'linetechnology',
                    'password' => 'Line@123',
                    'customerId' => '',
                    'senderText' => '',
                    'messageBody' => $message,
                    'recipientNumbers' => $recipientNumber,
                    'defDate' => null,
                    'isBlink' => false,
                    'isFlash' => false,
                ],
            ]);

            $xmlResponse = new SimpleXMLElement($response->getBody()->getContents());

            $message = (string) $xmlResponse->Message;
            $result = $xmlResponse->Result == 'true' ? true : false;
            $netPoints = (float) $xmlResponse->NetPoints;
            $messageId = (string) $xmlResponse->messageId;

            if ($result) {
                return response()->json(['message' => 'SMS sent successfully'], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'error sending the message'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while resending OTP', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getNumberOfUsers()
    {
        try {

            $counts = User::count();

            return response()->json(['value' => $counts], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}


