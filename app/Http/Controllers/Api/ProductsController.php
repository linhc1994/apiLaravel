<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductImage;
use Input;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::orderBy('id', 'DESC')->get(['id', 'name', 'price', 'image', 'cate_id', 'brand_id', 'created_at', 'updated_at']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "price" => "required",
            "intro" => "required",
            "content" => "required",
            "fImages" => "required",
        ]);

        $files = $request->file('fImages');
        $fileName = $file->getClientOriginalName();
        $input = $request->all();
        $input['alias'] = changeTitle($input['name']);
        $input['image'] = $fileName;
        $product  = Product::create($input);
        if($product){
            $files->move('resource/uploads/',$fileName);
            $product_id = $product->id;
            if(Input::hasFile('fProductImages')){
                foreach (Input::file('fProductImages') as $file) {
                    $productImages = new ProductImage();
                    if(isset($file)){
                        $productImages->image = $file->getClientOriginalName();
                        $productImages->product_id = $product_id;
                        $file->move('resource/uploads/detail/', $file->getClientOriginalName());
                        $productImages->save();
                    }
                }
            }
        }

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(!empty($product)){
            $productImages = $product->productImages();
            $products = [
                "product" => $product,
                "productImages" => $productImages
            ];
            return response()->json($user, 200);
        }else{
            throw new \Exception("Id is not found!");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
            "price" => "required",
            "intro" => "required",
            "content" => "required",
            "fImages" => "required",
        ]);

        $product = Product::find($id);
        if(!empty($product)){
            $files = $request->file('fImages');

            $product->name = $request->name;
            $product->alias = changeTitle($request->name);
            $product->price = $request->price;
            $product->intro = $request->intro;
            $product->content = $request->content;
            $product->keywords = $request->keywords;
            $product->descriptions = $request->descriptions;
            $product->user_id = $request->user_id;
            $product->cate_id = $request->cate_id;
            
            $imgCurrent = 'resource/uploads/detail/'.Request::input('imgCurrent');
            if(!empty($files)){
                $fileName = $files->getClientOriginalName();
                $product->image = $fileName;
                $files->move('resource/uploads/detail/', $fileName);
                if(File::exists($imgCurrent)){
                    File::delete($imgCurrent);
                }
            }else{
                throw new \Exception("Files is not define!");
            }
            $product->save(); 
            return response()->json($product, 201);
        }else{
            throw new \Exception("Id is not found!");
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
        $productDetails =  Product::find($id)->productImages()->toArray();
        if(!empty($productDetails)){
            foreach ($productDetails as $product) {
                File::delete('resource/uploads/detail/'.$Product["image"]);
            }
            $products = Product::find($id);
            File::delete('resource/uploads/'.$products->image);

            try {
                $Products->delete();
                return response()->json(null, 204);
            } catch (\Exception $exception) {
                throw $exception;
            }
        }else{
            throw new \Exception("Id is not found!");
        }
    }
}
