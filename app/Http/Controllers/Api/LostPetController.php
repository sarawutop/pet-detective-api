<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LostPetResource;
use App\Models\LostPet;
use App\Models\PetDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LostPetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $lostPet = new LostPet();
        $lostPet->name = $request->get('name');
        $lostPet->location = $request->get('location');
        $lostPet->lost_at = $request->get('lost_at');
        $lostPet->description = $request->get('description');
        $lostPet->contact_info = $request->get('contact_info');

        if ($lostPet->save()) {
            $petDetail = new PetDetail();
            $petDetail->type = fake()->realText(10);
            $petDetail->age = fake()->numberBetween(1,100);
            $petDetail->gender = fake()->realText(10);
            $petDetail->breed = fake()->realText(10);
            $petDetail->color = fake()->realText(10);
            $petDetail->size = fake()->realText(10);
            $petDetail->collar = fake()->realText(10);
            $petDetail->leg_ring = fake()->realText(10);

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
        if ($request->has('name'))
            $lostPet->name = $request->get('name');


        if ($request->has('location'))
            $lostPet->location = $request->get('location');

        if ($request->has('lost_at'))
            $lostPet->lost_at = $request->get('lost_at');

        if ($request->has('description'))
            $lostPet->description = $request->get('description');

        if ($request->has('contact_info'))
            $lostPet->contact_info = $request->get('contact_info');

        if ($lostPet->save()) {
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
        $name = $lostPet->name;
        if ($lostPet->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Lost pet {$name} has been deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Lost pet {$name} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }

    public function search(Request $request) {
        $q = $request->query('q');
        $lost_pets = LostPet::where('name', 'LIKE', "%{$q}%")
                            ->orWhere('type', 'LIKE', "%{$q}%")
                            ->get();

        return $lost_pets;
    }
}
