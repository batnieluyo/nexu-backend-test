<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModelRequest;
use App\Http\Requests\ModelUpdateRequest;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\ModelResource;
use App\Models\Brand;
use App\Models\BrandModel;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ModelCollection(BrandModel::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModelRequest $request, $brandId)
    {
        $brand = Brand::findOrFail($brandId);
        $model = $brand->models()->create($request->validated());

        return (new ModelResource($model))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModelUpdateRequest $request, string $modelId)
    {
        $model = BrandModel::findOrFail($modelId);
        $model->average_price = $request->average_price;
        $model->save();

        return new ModelResource($model);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
