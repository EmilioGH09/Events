<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ArtistResource;
use App\Http\Requests\ArtistRequest;
use App\Models\Artist;

class ArtistsController extends Controller
{
     /**
     * Get all the artists
     *
     * @return void
     */
    public function index(Request $request)
    {
        return ArtistResource::collection(
            Artist::filter($request->query())
                ->paginate($request->get('limit', 25))
        );
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show(Artist $artist, Request $request)
    {
        $artist->load( 'events' );

        return new ArtistResource($artist);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(ArtistRequest $request)
    {
        $artist = Artist::create($request->validated());

        return new ArtistResource($artist);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Artist $artist, ArtistRequest $request)
    {
        $artist->update($request->validated());

        return new ArtistResource($artist);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function destroy(Artist $artist)
    {
        $artist->delete();

        return response([
            'message' => 'Artist has been deleted'
        ], 200);
    }
}
