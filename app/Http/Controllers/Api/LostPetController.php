<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LostPetResource;
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
        $user = auth()->user();
        $lostPet = new LostPet();
        $lostPet->user_id = $user->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('public/images');
            $filename = basename($path);
            $lostPet->image_path = $filename;
        }

//        if ($request->hasFile('image')) {
//            $image = $request->file('image');
//            $path = $image->store('public/images');
//            $lostPet->image_path = $path;
//        }
//        if ($request->hasFile('image')){
//            $destination_path = 'public/images';
//            $image = $request->file('image');
//            $image_name = $image->hashName();
//            //$image_name = $image->getClientOriginalName();
//
//            $path = $request->file('image')->storeAs($destination_path,$image_name);
//            $lostPet->image_path = $image_name;
//        }
        $lostPet->location = $request->get('location');
        $lostPet->lost_at = $request->get('lost_at');
        $lostPet->description = $request->get('description');
        $lostPet->contact_info = $request->get('contact_info');
        $lostPet->status = $request->get('status');
        $lostPet->latitude = $request->get('latitude');
        $lostPet->longitude = $request->get('longitude');
//        $lostPet->created_at = Carbon::now()->format('Y-m-d H:i:s');
//        $lostPet->setDateFormat('Y-m-d H:i:s');
//        $lostPet->created_at = Carbon::now();
//        $lostPet->created_at = Carbon::parse(Carbon::now())->toDateTimeString();
//        Carbon::parse($lostPet->created_at)->format('d-m-Y');

        if ($lostPet->save()) {
//            $petDetail = new PetDetail();
//            $petDetail->name = fake()->realText(10);
//            if ($request->has('pet_detail.name'))
//                $petDetail->name = $request->get('pet_detail')['name'];
//            $petDetail->type = fake()->realText(10);
//            $petDetail->age = fake()->numberBetween(1,100);
//            $petDetail->gender = fake()->realText(10);
//            $petDetail->breed = fake()->realText(10);
//            $petDetail->color = fake()->realText(10);
//            $petDetail->size = fake()->realText(10);
//            $petDetail->collar = fake()->realText(10);
//            $petDetail->leg_ring = fake()->realText(10);
//
//            $lostPet->petDetail()->save($petDetail);
//
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

//            $testkub = $request->get('pet_details')['name'];

            return response()->json([
                'success' => true,
//                'test' => $testkub,
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

    public function search(Request $request) {
        $q = $request->query('q');
        $lost_pets = LostPet::where('type', 'LIKE', "%{$q}%")
                            ->get();

        return $lost_pets;
    }
}
