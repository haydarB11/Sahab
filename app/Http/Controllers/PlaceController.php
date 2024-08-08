<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Place;
use App\Models\PlaceImage;
use App\Models\SpecialDay;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{

    public function store(Request $request)
    {
        try {
            $request->validate([
                'amenities' => 'array'
            ]);


            $place = new Place();


            $place->title = $request->title;
            $place->address = $request->address;
            $place->area_id = $request->area_id;
            $place->description = $request->description;
            $place->weekday_price = $request->weekday_price;
            $place->weekend_price = $request->weekend_price;
            $place->tag = $request->tag;
            $place->category_id = $request->category_id;
            $place->vendor_id = $request->vendor_id;

            $place->save();
            if ($request->amenities) {
                if (is_array($request->amenities)) {
                    $existingAmenities = Amenity::whereIn('id', $request->amenities)->pluck('id');
                    $place->amenities()->attach($existingAmenities);
                } else {
                    $listArray = json_decode($request->amenities, true);
                    if (is_array($request->amenities)) {
                        $existingAmenities = Amenity::whereIn('id', $listArray)->pluck('id');
                        $place->amenities()->attach($existingAmenities);
                    } else {
                        return response()->json(['message' => 'wrong type amenities'], Response::HTTP_BAD_REQUEST);
                    }
                }

            }

            if ($request->specialDays) {
                foreach ($request->specialDays as $specialDayData) {
                    $specialDay = new SpecialDay();
                    $specialDay->title = $specialDayData['title'];
                    $specialDay->price = $specialDayData['price'];
                    $specialDay->start_date = $specialDayData['start_date'];
                    $specialDay->end_date = $specialDayData['end_date'];
                    $specialDay->place_id = $place->id;
                    $specialDay->save();
                }
            }

            if ($request->hasFile('icon')) {
                foreach ($request->file('icon') as $photo) {
                    $photoName = time() . '_' . $photo->getClientOriginalName();
                    $photoPath = '/photos/places/' . $photoName;
                    $photo->move(public_path('photos/places'), $photoName);
                    $placeImage = new PlaceImage();
                    $placeImage->image = $photoPath;
                    $placeImage->place_id = $place->id;
                    $placeImage->save();
                }
            }

            return response()->json(['message' => 'place added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $place = Place::findOrFail($id);

            if (!$place) {
                return response()->json(['message' => 'place not found'], Response::HTTP_NOT_FOUND);
            }

            if ($request->hasFile('icon')) {
                foreach ($request->file('icon') as $photo) {
                    // dd('photo');
                    $photoName = time() . '_' . $photo->getClientOriginalName();
                    $photoPath = '/photos/places/' . $photoName;
                    $photo->move(public_path('photos/places'), $photoName);
                    $placeImage = new PlaceImage();
                    $placeImage->image = $photoPath;
                    $placeImage->place_id = $place->id;
                    $placeImage->save();
                }
            }

            $place->title = $request->title ?? $place->title;
            $place->address = $request->address ?? $place->address;
            $place->area_id = $request->area_id ?? $place->area_id;
            $place->description = $request->description ?? $place->description;
            $place->address = $request->address ?? $place->address;
            $place->weekday_price = $request->weekday_price ?? $place->weekday_price;
            $place->weekend_price = $request->weekend_price ?? $place->weekend_price;
            $place->tag = $request->tag ?? $place->tag;
            $place->category_id = $request->category_id ?? $place->category_id;
            $place->vendor_id = $request->vendor_id ?? $place->vendor_id;
            $place->featured = $request->featured ?? $place->featured;
            $place->bookable = $request->bookable ?? $place->bookable;
            $place->available = $request->available ?? $place->available;

            if ($request->amenities) {
                $place->amenities()->detach();
                $existingAmenities = Amenity::whereIn('title', $request->amenities)->pluck('id');
                $place->amenities()->attach($existingAmenities);
            }

            $place->save();

            return response()->json(['message' => 'place updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $place = Place::findOrFail($id);

            if (!$place) {
                return response()->json(['message' => 'place not found'], Response::HTTP_NOT_FOUND);
            }

            $place->delete();
            return response()->json(['message' => 'place deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';
            $areaTitle = $language == 'ar' ? 'area_ar' : 'area';
            $place = Place::with([
                'placeImages',
                'amenities' => function ($query) use ($titleColumn) {
                    $query->where('amenities.status', 1)
                        ->select('amenities.id', "amenities.$titleColumn as title", 'amenities.icon');
                },
                'bookings.ratings',
                'specialDays'])
                ->where('places.id', $id)
                ->orderBy('weekday_price', 'asc')
                ->select(
                    'places.id',
                    'weekday_price',
                    'weekend_price',
                    'places.title',
                    'bookable',
                    'available',
                    'places.address',
                    "areas.$areaTitle as area",
                    'tag',
                    'description',
                    'places.created_at',
                    DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
                )
                ->leftJoin('bookings', 'bookings.place_id', '=', 'places.id')
                ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id')
                ->leftJoin('areas', 'areas.id', '=', 'places.area_id')
                ->groupBy(
                    'places.id',
                    'weekday_price',
                    'weekend_price',
                    'title',
                    'places.address',
                    "$areaTitle",
                    'tag',
                    'bookable',
                    'available',
                    'places.created_at',
                    'description'
                )
                ->findOrFail($id);

            if (!$place) {
                return response()->json(['message' => 'place not found'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($place, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(Request $request)
    {
        try {
            $language = $request->input('language', 'en');
            $areaTitle = $language == 'ar' ? 'area_ar' : 'area';
            $places = Place::with(['bookings.ratings'])
                ->join('bookings', 'places.id', '=', 'bookings.place_id')
                ->where('available', true)
                ->orderBy('weekday_price', 'asc')
                ->select(
                    'places.id',
                    'weekday_price',
                    'title',
                    'places.address',
                    "areas.$areaTitle as area",
                    'tag',
                    'places.created_at',
                    DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
                )
                ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id')
                ->leftJoin('areas', 'areas.id', '=', 'places.area_id')
                ->groupBy(
                    'places.id',
                    'weekday_price',
                    'title',
                    'places.address',
                    "$areaTitle",
                    'tag',
                    'places.created_at'
                )
                ->get();

            return response()->json($places, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPlacesForOneCategory($id, Request $request)
    {
        try {
            $language = $request->input('language', 'en');
            $areaTitle = $language == 'ar' ? 'area_ar' : 'area';

            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);

            $query = Place::where('available', true)
                ->where('category_id', $id)
                ->leftJoin('areas', 'areas.id', '=', 'places.area_id');

                $minPriceQuery = clone $query;
                $maxPriceQuery = clone $query;

                $minPrice = $minPriceQuery->selectRaw('MIN(weekday_price)')->value('MIN(weekday_price)');
                $maxPrice = $maxPriceQuery->selectRaw('MAX(weekday_price)')->value('MAX(weekday_price)');

            if ($request->has('filter')) {
                $filter = $request->input('filter');

                switch ($filter) {
                    case 'newest':
                        $query->orderBy('places.created_at', 'desc');
                        break;
                    case 'highest_rating':
                        $query->orderByDesc('rating');
                        break;
                    case 'price_high_to_low':
                        $query->orderByDesc('weekday_price');
                        break;
                    case 'price_low_to_high':
                        $query->orderBy('weekday_price');
                        break;
                }
            }

            if ($request->has('area')) {
                $area = explode(',', $request->input('area'));
                $query->whereIn('area', $area)
                    ->orWhereIn('area_ar', $area);
            }

            if ($request->has('tag')) {
                $tag = $request->input('tag');
                $query->where('tag', '=', $tag);
            }

            if ($request->has('min_price')) {
                $minPrice = $request->input('min_price');
                $query->where('weekday_price', '>=', $minPrice);
            }

            if ($request->has('max_price')) {
                $maxPrice = $request->input('max_price');
                $query->where('weekday_price', '<=', $maxPrice);
            }

            $places = $query
            ->leftJoin('bookings', function ($join) {
                $join->on('places.id', '=', 'bookings.place_id')
                    ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id');
            })
            ->select(
                'places.id',
                'weekday_price',
                'weekend_price',
                'title',
                'places.address',
                "areas.$areaTitle as area",
                'tag',
                'places.created_at',
                DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
            )
                ->groupBy(
                    'places.id',
                    'weekday_price',
                    'weekend_price',
                    'title',
                    'places.address',
                    "$areaTitle",
                    'tag',
                    'places.created_at'
                )
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json(["data" => ["places" => $places, "min_price" => $minPrice, "max_price" => $maxPrice]], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPlacesForOneUser(Request $request)
    {
        try {
            $userId = Auth::id();

            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';
            $areaTitle = $language == 'ar' ? 'area_ar' : 'area';

            $places = Place::with(['placeImages'])
                ->leftJoin('bookings', function ($join) {
                    $join->on('places.id', '=', 'bookings.place_id')
                        ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id');
                })
                ->leftJoin('categories', 'categories.id', '=', 'places.category_id')
                ->leftJoin('areas', 'areas.id', '=', 'places.area_id')
                ->where('places.vendor_id', $userId)
                ->orderBy('places.id', 'desc')
                ->select(
                    'places.id',
                    'weekday_price',
                    'weekend_price',
                    'places.title AS title',
                    "categories.$titleColumn AS category",
                    'available',
                    'places.address',
                    'featured',
                    'bookable',
                    "areas.$areaTitle as area",
                    'tag',
                    'places.created_at',
                    DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
                )
                ->groupBy(
                    'places.id',
                    'weekday_price',
                    'weekend_price',
                    'title',
                    'category',
                    'places.address',
                    'featured',
                    'bookable',
                    'available',
                    "$areaTitle",
                    'tag',
                    'places.created_at'
                )
                ->get();

            return response()->json($places, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllFeatured(Request $request)
    {
        try {
            $language = $request->input('language', 'en');
            $areaTitle = $language == 'ar' ? 'area_ar' : 'area';

            $query = Place::where('available', true)
            ->leftJoin('areas', 'areas.id', '=', 'places.area_id')
            ->where('featured', true);

            $minPriceQuery = clone $query;
            $maxPriceQuery = clone $query;

            $minPrice = $minPriceQuery->selectRaw('MIN(weekday_price)')->value('MIN(weekday_price)');
            $maxPrice = $maxPriceQuery->selectRaw('MAX(weekday_price)')->value('MAX(weekday_price)');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            switch ($filter) {
                case 'newest':
                    $query->orderBy('places.created_at', 'desc');
                    break;
                case 'highest_rating':
                    $query->orderByDesc('rating');
                    break;
                case 'price_high_to_low':
                    $query->orderByDesc('weekday_price');
                    break;
                case 'price_low_to_high':
                    $query->orderBy('weekday_price');
                    break;
            }
        }

        if ($request->has('area')) {
            $area = explode(',', $request->input('area'));
            $query->whereIn('area', $area)
                ->orWhereIn('area_ar', $area);
        }

        if ($request->has('tag')) {
            $tag = $request->input('tag');
            $query->where('tag', '=', $tag);
        }

        if ($request->has('min_price')) {
            $minPrice = $request->input('min_price');
            $query->where('weekday_price', '>=', $minPrice);
        }

        if ($request->has('max_price')) {
            $maxPrice = $request->input('max_price');
            $query->where('weekday_price', '<=', $maxPrice);
        }

        $numberOfRows = $request->input('limit', null);

        $places = $query->with(['placeImages'])
            ->leftJoin('bookings', function ($join) {
                $join->on('places.id', '=', 'bookings.place_id')
                    ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id');
            })
            ->select(
                'places.id',
                'weekday_price',
                'weekend_price',
                'title',
                'places.address',
                "areas.$areaTitle as area",
                'tag',
                'places.created_at',
                DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
            )
            ->groupBy(
                'places.id',
                'weekday_price',
                'weekend_price',
                'title',
                'places.address',
                "$areaTitle",
                'tag',
                'places.created_at'
            );

            if ($numberOfRows !== null && is_numeric($numberOfRows)) {
                $places = $places->take($numberOfRows);
            }

            $places = $places->get();
            return response()->json($places, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function search(Request $request)
    {
        try {
            $language = $request->input('language', 'en');
            $areaTitle = $language === 'ar' ? 'area_ar' : 'area';
            $searchWord = $request->input('search');
            $query = Place::where('available', true)
            ->leftJoin('areas', 'areas.id', '=', 'places.area_id');

            $minPriceQuery = clone $query;
            $maxPriceQuery = clone $query;

            $minPrice = $minPriceQuery->selectRaw('MIN(weekday_price)')->value('MIN(weekday_price)');
            $maxPrice = $maxPriceQuery->selectRaw('MAX(weekday_price)')->value('MAX(weekday_price)');

            if ($request->has('filter')) {
                $filter = $request->input('filter');

                switch ($filter) {
                    case 'newest':
                        $query->orderBy('places.created_at', 'desc');
                        break;
                    case 'highest_rating':
                        $query->orderByDesc('rating');
                        break;
                    case 'price_high_to_low':
                        $query->orderByDesc('weekday_price');
                        break;
                    case 'price_low_to_high':
                        $query->orderBy('weekday_price');
                        break;
                }
            }

            if ($request->has('area')) {
                $area = explode(',', $request->input('area'));
                $query->whereIn('area', $area)
                    ->orWhereIn('area_ar', $area);
            }

            if ($request->has('tag')) {
                $tag = $request->input('tag');
                $query->where('tag', '=', $tag);
            }

            if ($request->has('min_price')) {
                $minPrice = $request->input('min_price');
                $query->where('weekday_price', '>=', $minPrice);
            }

            if ($request->has('max_price')) {
                $maxPrice = $request->input('max_price');
                $query->where('weekday_price', '<=', $maxPrice);
            }

            if ($request->has('category')) {
                $category_ids = explode(',', $request->input('category'));
                $query->whereIn('category_id', $category_ids);
            }

            $places = $query->with(['placeImages'])
                ->leftJoin('bookings', function ($join) {
                    $join->on('places.id', '=', 'bookings.place_id')
                        ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id');
                })
                ->where('title', 'LIKE', '%' . $searchWord . '%')
                ->where('available', true)
                ->orderBy('weekday_price', 'asc')
                ->select('places.id', 'weekday_price', 'weekend_price', 'title', 'places.address',  "areas.$areaTitle AS area", 'tag', 'places.created_at', DB::raw('COALESCE(AVG(ratings.rate), 0) as rating'))
                ->groupBy('places.id', 'weekday_price', 'weekend_price', 'title', 'places.address', "$areaTitle", 'tag', 'places.created_at')
                ->get();

            return response()->json($places, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getNumberOfPlaces()
    {
        try {

            $counts = Place::count();

            return response()->json(['value' => $counts], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
