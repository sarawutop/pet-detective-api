<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LostPetResource;
use App\Models\Comment;
use App\Models\LostPet;
use App\Models\PetDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class LostPetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

//    protected $dateFormat = 'Y-m-d';


    public function index()
    {
        $lostPet = LostPet::get();
        return LostPetResource::collection($lostPet);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', LostPet::class);

        $user = auth()->user();
        $lostPet = new LostPet();
        $lostPet->user_id = $user->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('public/images');
            $filename = basename($path);
            $lostPet->image_path = $filename;
        }

        $lostPet->location = $request->get('location');
        $lostPet->lost_at = $request->get('lost_at');
        $lostPet->description = $request->get('description');
        $lostPet->contact_info = $request->get('contact_info');
        $lostPet->status = $request->get('status');
        $lostPet->latitude = $request->get('latitude');
        $lostPet->longitude = $request->get('longitude');


        if ($lostPet->save()) {

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

            $lostPet->petDetail()->save($petDetail);


            return response()->json([
                'success' => true,
                'message' => 'Lost pet created with id ' . $lostPet->id,
                'lost_pet_id' => $lostPet->id
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
     * @param  \App\Models\LostPet  $lostPet
     * @return \Illuminate\Http\Response
     */
    public function show(LostPet $lostPet)
    {
        if(is_int($lostPet->view_count))
        {
            $lostPet->view_count = $lostPet->view_count + 1;
            $lostPet->save();
        }
        $petDetail = $lostPet->petDetail;
        $comments = $lostPet->comments;
        return new LostPetResource($lostPet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LostPet  $lostPet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LostPet $lostPet)
    {
        $this->authorize('update', $lostPet);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('public/images');
            $filename = basename($path);
            $lostPet->image_path = $filename;
        }

        if ($request->has('location'))
            $lostPet->location = $request->get('location');

        if ($request->has('lost_at'))
            $lostPet->lost_at = $request->get('lost_at');

        if ($request->has('description'))
            $lostPet->description = $request->get('description');

        if ($request->has('contact_info'))
            $lostPet->contact_info = $request->get('contact_info');

        if ($request->has('status'))
            $lostPet->status = $request->get('status');

        if ($request->has('latitude'))
            $lostPet->latitude = $request->get('latitude');

        if ($request->has('longitude'))
            $lostPet->longitude = $request->get('longitude');

        if ($lostPet->save()) {

            $petDetail = $lostPet->petDetail()->first();

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


            $lostPet->petDetail()->save($petDetail);

            return response()->json([
                'success' => true,
                'message' => 'Lost pet updated with id ' . $lostPet->id,
                'lost_pet_id' => $lostPet->id
            ], Response::HTTP_OK);
        }

        return respone()->json([
            'success' => false,
            'message' => 'Lost pet update failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LostPet  $lostPet
     * @return \Illuminate\Http\Response
     */
    public function destroy(LostPet $lostPet)
    {
        $this->authorize('delete', $lostPet);

        $id = $lostPet->id;
        if ($lostPet->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Lost pet id {$id} has been deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Lost pet id {$id} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }



    public function storeComment(Request $request, LostPet $lostPet)
    {
        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->message = $request->get('message');
        if ($lostPet->comments()->save($comment))
        {
            return response()->json([
                'success' => true,
                'message' => 'Add a comment in Found pet id ' . $lostPet->id,

            ], Response::HTTP_CREATED);
        }
    }

    public function getComments(LostPet $lostPet)
    {
        return CommentResource::collection($lostPet->comments);
    }

    public function search(Request $request)
    {
        $petType = $request->query('petType');
        $status = $request->query('status');
        $lat = $request->query('lat');
        $lng = $request->query('lng');
        $minDistance = $request->query('minDistance');
        $maxDistance = $request->query('maxDistance');


        $lostPets = LostPet::with('petDetail')->whereHas('petDetail', fn($lostPet) => $lostPet->where('type', 'LIKE', "%{$petType}%"));

        if ($status) {
            $lostPets = $lostPets->where('status', '=', $status);
        }

        if ($maxDistance && $lat && $lng) {
            $lostPets = $lostPets->get()
                ->where(fn ($lostPet) =>
                    round($this->getDistanceFromLatLonInKm($lostPet->latitude, $lostPet->longitude, $lat, $lng),2)
                    <= $maxDistance
                );
        } else {
            $lostPets = $lostPets->get();
        }

        return LostPetResource::collection($lostPets);
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
