<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::select(
            'id', 'name'
        )->with(
            'models:id,brand_id,average_price'
        )->get();

        return new BrandCollection($brands);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        return (
            new BrandResource(Brand::create($request->validated()))
        )->response()->setStatusCode(201);
    }
}
