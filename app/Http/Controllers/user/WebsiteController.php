<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\website\StoreWebsiteRequest;
use App\Http\Requests\website\UpdateWebsiteRequest;
use App\Http\Resources\website\WebsiteResources;
use App\Models\Website;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $websites = Website::search()->latest()->paginate();

            return WebsiteResources::collection($websites);
        } catch (Exception $exception) {
            return response()->json(["data" => "error"], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWebsiteRequest $request): JsonResponse
    {
        try {
            Website::create($request->validated());

            return response()->json(["data" => "website added "]);

        } catch (Exception $exception) {
            return response()->json(["data" => "error"], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): WebsiteResources|JsonResponse
    {
        try {
            $website = Website::find($id);
            if ($website)
                return WebsiteResources::make($website);
            return response()->json(["data" => "not found"], 404);

        } catch (Exception $exception) {
            return response()->json(["data" => "error"], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebsiteRequest $request, string $id): JsonResponse
    {
        try {
            $website = Website::find($id);

            if ($website) {
                $website->update($request->validated());
                return response()->json(["data" => "website updated"]);
            }

            return response()->json(["data" => "not found"], 404);

        } catch (Exception $exception) {
            return response()->json(["data" => "error"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {

            $website = Website::find($id);
            if ($website) {
                $website->delete();
                return response()->json(["data" => "website deleted"]);
            }
            return response()->json(["data" => "not Fount"], 404);
        } catch (Exception $exception) {
            return response()->json(["data" => "error"], 500);
        }
    }
}
