<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PetDetailResource;
use App\Models\PetDetail;
use Illuminate\Http\Request;

class PetDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petDetails = PetDetail::with('lostPet')->get();
        return PetDetailResource::collection($petDetails);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PetDetail  $petDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PetDetail $petDetail)
    {
        return new PetDetailResource($petDetail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PetDetail  $petDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PetDetail $petDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PetDetail  $petDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(PetDetail $petDetail)
    {
        //
    }
}
