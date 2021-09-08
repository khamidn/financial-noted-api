<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Resources\{ SubCategoriesResource, SubCategoryDetailResource };

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = SubCategory::paginate(5);

        return $this->sendResponsePaginate(SubCategoriesResource::collection($categories), 'Categories retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest $request)
    {
        SubCategory::create($request->only('name', 'category_id'));

        return $this->sendResponse('', 'Adding sub category successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = SubCategory::with('category')->where('id', $id)->firstOrFailToJson('Category not found.');

        return $this->sendResponse(new SubCategoryDetailResource($category), 'Get category successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryRequest $request, $id)
    {
        $category = SubCategory::where('id', $id)->firstOrFailToJson('Sub category not found.');

        $category->update($request->only('name'));

        return $this->sendResponse('', 'Update category successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = SubCategory::where('id', $id)->firstOrFailToJson('Sub category not found.');

        $category->delete();

        return $this->sendResponse('', 'Delete sub category successfully.');
    }
}
