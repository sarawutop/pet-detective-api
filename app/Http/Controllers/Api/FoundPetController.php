<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\FoundPetResource;
use App\Models\Comment;
use App\Models\FoundPet;
use App\Models\PetDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FoundPetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show', 'getComments', 'search', 'searchFoundPets']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foundPet = FoundPet::get();
        return FoundPetResource::collection($foundPet);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', FoundPet::class);

        $user = auth()->user();
        $foundPet = new FoundPet();
        $foundPet->user_id = $user->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('public/images');
            $filename = basename($path);
            $foundPet->image_path = $filename;
        }

        $foundPet->location = $request->get('location');
        $foundPet->found_at = $request->get('found_at');
        $foundPet->description = $request->get('description');
        $foundPet->contact_info = $request->get('contact_info');
        $foundPet->latitude = $request->get('latitude');
        $foundPet->longitude = $request->get('longitude');
        $foundPet->status = $request->get('status');

        if ($foundPet->save()) {
            $petDetail = new PetDetail();
            if ($request->has('pet_detail.name'))
                $petDetail->name = $request->get('pet_detail')['name'];

            if ($request->has('pet_detail.type'))
                $petDetail->type = $request->get('pet_detail')['type'];

            if ($request->has('pet_detail.age'))
                $petDetail->age = $request->get('pet_detail')['age'];

            if ($request->has('pet_detail.gender'))
                $petDetail->gender = $request->get('pet_detail')['gender'];

            if ($request->has('pet_detail.breed'))
                $petDetail->breed = $request->get('pet_detail')['breed'];

            if ($request->has('pet_detail.color'))
                $petDetail->color = $request->get('pet_detail')['color'];

            if ($request->has('pet_detail.size'))
                $petDetail->size = $request->get('pet_detail')['size'];

            if ($request->has('pet_detail.collar'))
                $petDetail->collar = $request->get('pet_detail')['collar'];

            if ($request->has('pet_detail.leg_ring'))
                $petDetail->leg_ring = $request->get('pet_detail')['leg_ring'];

            if ($request->has('pet_detail.description'))
                $petDetail->description = $request->get('pet_detail')['description'];


            $foundPet->petDetail()->save($petDetail);


            return response()->json([
                'success' => true,
                'message' => 'Found pet created with id ' . $foundPet->id,
                'found_pet_id' => $foundPet->id
            ], Response::HTTP_CREATED);
        }
        return respone()->json([
            'success' => false,
            'message' => 'Lost pet creation failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FoundPet $foundPet)
    {
        if(is_int($foundPet->view_count))
        {
            $foundPet->view_count = $foundPet->view_count + 1;
            $foundPet->save();
        }
        $petDetail = $foundPet->petDetail;
        $comments = $foundPet->comments;
        return new FoundPetResource($foundPet);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoundPet $foundPet)
    {
        $this->authorize('update', $foundPet);


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('public/images');
            $filename = basename($path);
            $foundPet->image_path = $filename;
        }

        if ($request->has('location'))
            $foundPet->location = $request->get('location');

        if ($request->has('found_at'))
            $foundPet->found_at = $request->get('found_at');

        if ($request->has('description'))
            $foundPet->description = $request->get('description');

        if ($request->has('contact_info'))
            $foundPet->contact_info = $request->get('contact_info');

        if ($request->has('status'))
            $foundPet->status = $request->get('status');

        if ($request->has('latitude'))
            $foundPet->latitude = $request->get('latitude');

        if ($request->has('longitude'))
            $foundPet->longitude = $request->get('longitude');

        if ($foundPet->save()) {

            $petDetail = $foundPet->petDetail()->first();

            if ($request->has('pet_detail.name'))
                $petDetail->name = $request->get('pet_detail')['name'];

            if ($request->has('pet_detail.type'))
                $petDetail->type = $request->get('pet_detail')['type'];

            if ($request->has('pet_detail.age'))
                $petDetail->age = $request->get('pet_detail')['age'];

            if ($request->has('pet_detail.gender'))
                $petDetail->gender = $request->get('pet_detail')['gender'];

            if ($request->has('pet_detail.breed'))
                $petDetail->breed = $request->get('pet_detail')['breed'];

            if ($request->has('pet_detail.color'))
                $petDetail->color = $request->get('pet_detail')['color'];

            if ($request->has('pet_detail.size'))
                $petDetail->size = $request->get('pet_detail')['size'];

            if ($request->has('pet_detail.collar'))
                $petDetail->collar = $request->get('pet_detail')['collar'];

            if ($request->has('pet_detail.leg_ring'))
                $petDetail->leg_ring = $request->get('pet_detail')['leg_ring'];

            if ($request->has('pet_detail.description'))
                $petDetail->description = $request->get('pet_detail')['description'];


            $foundPet->petDetail()->save($petDetail);


            return response()->json([
                'success' => true,
                'message' => 'Found pet updated with id ' . $foundPet->id,
                'found_pet_id' => $foundPet->id
            ], Response::HTTP_OK);
        }

        return respone()->json([
            'success' => false,
            'message' => 'Found pet update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoundPet $foundPet)
    {
        $this->authorize('delete', $foundPet);

        $id = $foundPet->id;

        if ($foundPet->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Found pet id {$id} has been deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Found pet id {$id} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }

    public function storeComment(Request $request, FoundPet $foundPet)
    {
        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->message = $request->get('message');

        if ($foundPet->comments()->save($comment))
        {
            return response()->json([
                'success' => true,
                'message' => 'Add a comment in Found pet id ' . $foundPet->id,

             ], Response::HTTP_CREATED);
        }
    }

    public function getComments(FoundPet $foundPet)
    {
        return CommentResource::collection($foundPet->comments);
    }


    public function search(Request $request)
    {
        $petType = $request->query('petType');
        $status = $request->query('status');
        $lat = $request->query('lat');
        $lng = $request->query('lng');
        $minDistance = $request->query('minDistance');
        $maxDistance = $request->query('maxDistance');




        $foundPets = FoundPet::with('petDetail')
            ->whereHas('petDetail', fn($foundPet) => $foundPet->where('type', 'LIKE', "%{$petType}%"));

        if ($status) {
            $foundPets = $foundPets->where('status', '=', $status);
        }

        if ($maxDistance && $lat && $lng) {
            $foundPets = $foundPets->get()
                ->where(fn ($foundPet) =>
                    round($this->getDistanceFromLatLonInKm($foundPet->latitude, $foundPet->longitude, $lat, $lng),2)
                    <= $maxDistance
                );
        } else {
            $foundPets = $foundPets->get();
        }

        return FoundPetResource::collection($foundPets);
    }

    public function getDistanceFromLatLonInKm($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // รัศมีของโลกในหน่วย km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2)
        ;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $R * $c; // ระยะทางในหน่วย km
        return $d;
    }



}
