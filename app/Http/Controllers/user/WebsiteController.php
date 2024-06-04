<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateWebsiteRequest;
use App\Http\Requests\website\StoreWebsiteRequest;
use App\Http\Resources\website\WebsiteResources;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $websites = Website::search()->latest()->paginate();

        return WebsiteResources::collection($websites);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWebsiteRequest $request)
    {
        Website::create($request->validated());

        return response()->json(["data" => "website added "]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): WebsiteResources
    {
        $website = Website::find($id);
        return WebsiteResources::make($website);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebsiteRequest $request, string $id): JsonResponse
    {
        Website::find($id)->update($request->validated());

        return response()->json(["data" => "website updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        Website::find($id)->delete();

        return response()->json(["data" => "website deleted"]);
    }
}
