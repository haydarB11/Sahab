<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{

    public function store(Request $request)
    {
        try {
            $service = new Service();
            $service->title = $request->title;
            $service->description = $request->description;
            $service->duration = $request->duration;
            $service->price = $request->price;
            $service->max_capacity = $request->max_capacity;
            $service->category_id = $request->category_id;
            $service->notice_period = $request->notice_period;
            $service->vendor_id = $request->vendor_id;
            $service->save();

            if ($request->hasFile('icon')) {
                foreach ($request->file('icon') as $photo) {
                    $photoName = time() . '_' . $photo->getClientOriginalName();
                    $photoPath = '/photos/services/' . $photoName;
                    $photo->move(public_path('photos/services'), $photoName);
                    $serviceImage = new ServiceImage();
                    $serviceImage->image = $photoPath;
                    $serviceImage->service_id = $service->id;
                    $serviceImage->save();
                }
            }

            return response()->json(['message' => 'Service added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating service', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $service = Service::findOrFail($id);

            if (!$service) {
                return response()->json(['message' => 'Service not found'], Response::HTTP_NOT_FOUND);
            }

            if ($request->hasFile('icon')) {
                foreach ($request->file('icon') as $photo) {
                    $photoName = time() . '_' . $photo->getClientOriginalName();
                    $photoPath = '/photos/services/' . $photoName;
                    $photo->move(public_path('photos/services'), $photoName);
                    $serviceImage = new ServiceImage();
                    $serviceImage->image = $photoPath;
                    $serviceImage->service_id = $service->id;
                    $serviceImage->save();
                }
            }

            $service->title = $request->title ?? $service->title;
            $service->description = $request->description ?? $service->description;
            $service->duration = $request->duration ?? $service->duration;
            $service->price = $request->price ?? $service->price;
            $service->max_capacity = $request->max_capacity ?? $service->max_capacity;
            $service->category_id = $request->category_id ?? $service->category_id;
            $service->vendor_id = $request->vendor_id ?? $service->vendor_id;
            $service->featured = $request->featured ?? $service->featured;
            $service->bookable = $request->bookable ?? $service->bookable;
            $service->available = $request->available ?? $service->available;
            $service->notice_period = $request->notice_period ?? $service->notice_period;
            $service->save();

            return response()->json(['message' => 'Service updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating service', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);

            if (!$service) {
                return response()->json(['message' => 'Service not found'], Response::HTTP_NOT_FOUND);
            }

            // $deletedImages = ServiceImage::where('service_id', $id)->delete();
            $service->delete();

            return response()->json(['message' => 'Service deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting service', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $service = Service::with(['serviceImages', 'bookings.ratings'])
                ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
                ->orderBy('price', 'asc')
                ->select(
                    'services.id',
                    'price',
                    'title',
                    'duration',
                    'description',
                    'bookable',
                    'featured',
                    'services.created_at',
                    DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
                )
                ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id')
                ->groupBy(
                    'services.id',
                    'price',
                    'title',
                    'duration',
                    'featured',
                    'services.created_at',
                    'bookable',
                    'description'
                )
                ->findOrFail($id);

            if (!$service) {
                return response()->json(['message' => 'Service not found'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($service, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching service details', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
    {
        try {
            $services = Service::with(['serviceImages', 'bookings.ratings'])
                ->join('bookings', 'services.id', '=', 'bookings.service_id')
                ->where('available', true)
                ->orderBy('price', 'asc')
                ->select(
                    'services.id',
                    'price',
                    'duration',
                    'title',
                    'max_capacity',
                    'available',
                    'featured',
                    'services.created_at',
                    DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
                )
                ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id')
                ->groupBy(
                    'services.id',
                    'price',
                    'title',
                    'duration',
                    'max_capacity',
                    'available',
                    'featured',
                    'services.created_at'
                )
                ->get();

            return response()->json($services, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching services', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getServicesForOneUser(Request $request)
    {
        $userId = auth()->id();

        $language = $request->input('language', 'en');
        $titleColumn = $language == 'ar' ? 'title_ar' : 'title';

        $services = Service::with(['serviceImages'])
            ->leftJoin('bookings', function ($join) {
                $join->on('services.id', '=', 'bookings.service_id')
                    ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id');
            })
            ->leftJoin('categories', 'categories.id', '=', 'services.category_id')
            ->where('services.vendor_id', $userId)
            ->orderBy('services.id', 'desc')
            ->select(
                'services.id',
                'price',
                'services.title AS title',
                "categories.$titleColumn AS category",
                'duration',
                'bookable',
                'available',
                'featured',
                'services.created_at',
                DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
            )
            ->groupBy(
                'services.id',
                'price',
                'title',
                'category',
                'featured',
                'duration',
                'bookable',
                'available',
                'services.created_at'
            )
            ->get();

        return response()->json($services, Response::HTTP_OK);
    }

    public function getAllFeatured()
    {
        $services = Service::with(['serviceImages'])
            ->leftJoin('bookings', function ($join) {
                $join->on('services.id', '=', 'bookings.service_id')
                    ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id');
            })
            ->where('available', true)
            ->where('featured', true)
            ->orderBy('price', 'asc')
            ->select(
                'services.id',
                'price',
                'title',
                'duration',
                'featured',
                'services.created_at',
                DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
            )
            ->groupBy(
                'services.id',
                'price',
                'title',
                'featured',
                'services.created_at'
            )
            ->get();

        return response()->json($services, Response::HTTP_OK);
    }

    public function getServicesForOneCategory($id, Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $query = Service::where('available', true)
            ->where('category_id', $id);

        $minPriceQuery = clone $query;
        $maxPriceQuery = clone $query;

        $minPrice = $minPriceQuery->selectRaw('MIN(price)')->value('MIN(price)');
        $maxPrice = $maxPriceQuery->selectRaw('MAX(price)')->value('MAX(price)');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            switch ($filter) {
                case 'newest':
                    $query->orderBy('services.created_at', 'desc');
                    break;
                case 'highest_rating':
                    $query->orderByDesc('rating');
                    break;
                case 'price_high_to_low':
                    $query->orderByDesc('price');
                    break;
                case 'price_low_to_high':
                    $query->orderBy('price');
                    break;
            }
        }

        if ($request->has('min_price')) {
            $minPrice = $request->input('min_price');
            $query->where('price', '>=', $minPrice);
        }

        if ($request->has('max_price')) {
            $maxPrice = $request->input('max_price');
            $query->where('price', '<=', $maxPrice);
        }

        $services = $query->with(['serviceImages'])
            ->leftJoin('bookings', function ($join) {
                $join->on('services.id', '=', 'bookings.service_id')
                    ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id');
            })
            ->select(
                'services.id',
                'price',
                'title',
                'duration',
                'featured',
                'services.created_at',
                DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
            )
            ->groupBy(
                'services.id',
                'price',
                'duration',
                'title',
                'featured',
                'services.created_at'
            )
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json(["data" => ["services" => $services, "min_price" => $minPrice, "max_price" => $maxPrice]], Response::HTTP_OK);
    }

    public function search(Request $request)
    {
        $searchWord = $request->input('search');

        $query = Service::where('available', true);

        $minPriceQuery = clone $query;
        $maxPriceQuery = clone $query;

        $minPrice = $minPriceQuery->selectRaw('MIN(price)')->value('MIN(price)');
        $maxPrice = $maxPriceQuery->selectRaw('MAX(price)')->value('MAX(price)');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            switch ($filter) {
                case 'newest':
                    $query->orderBy('services.created_at', 'desc');
                    break;
                case 'highest_rating':
                    $query->orderByDesc('rating');
                    break;
                case 'price_high_to_low':
                    $query->orderByDesc('price');
                    break;
                case 'price_low_to_high':
                    $query->orderBy('price');
                    break;
            }
        }

        if ($request->has('min_price')) {
            $minPrice = $request->input('min_price');
            $query->where('price', '>=', $minPrice);
        }

        if ($request->has('max_price')) {
            $maxPrice = $request->input('max_price');
            $query->where('price', '<=', $maxPrice);
        }

        if ($request->has('category')) {
            $category_ids = explode(',', $request->input('category'));
            $query->whereIn('category_id', $category_ids);
        }

        $services = $query->with(['serviceImages'])
            ->leftJoin('bookings', function ($join) {
                $join->on('services.id', '=', 'bookings.service_id')
                    ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id');
            })
            ->where('title', 'LIKE', '%' . $searchWord . '%')
            ->orderBy('rating', 'desc')
            ->select(
                'services.id',
                'max_capacity',
                'featured',
                'available',
                'price',
                'title',
                'services.created_at',
                DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
            )
            ->groupBy(
                'services.id',
                'price',
                'title',
                'featured',
                'max_capacity',
                'available',
                'services.created_at'
            )
            ->get();

        return response()->json($services, Response::HTTP_OK);
    }

    public function getNumberOfServices()
    {
        try {

            $counts = Service::count();

            return response()->json(['value' => $counts], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
