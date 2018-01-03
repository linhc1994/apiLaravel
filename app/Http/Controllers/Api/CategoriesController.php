<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'ASC')->get(['id', 'name', 'alias', 'parent_id', 'created_at', 'updated_at']);
        return response()->json($categories, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$category  = Category::get(['id', 'name', 'parent_id']);
        return response()->json($category, 200);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "parent_id" => "required"
        ]);
        $input = $request->all();
        $input['alias'] = changeTitle($input['name']);
        $category = Category::create($input);
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if(!empty($category))
            return response()->json($category, 200);
        throw new \Exception("Id is not found!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
            "parent_id" => "required"
        ]);

        $input = $request->all();
        $input['alias'] = changeTitle($input['name']);
        $category = Category::find($id)->update($input);
        if($category){
            $category = Category::find($id);
            return response()->json($category, 200);
        }else{
            return response()->json($category, 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(!empty($category)){
            try {
                $category->delete();
                return response()->json(null, 204);
            } catch (\Exception $exception) {
                throw $exception;
            }
        }else{
            throw new \Exception("Id is not found!");
        }
    }
}
