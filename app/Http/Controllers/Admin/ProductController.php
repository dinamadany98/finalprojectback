<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ApiResponseTrait;

    public function index()
    {

        $products=Product::get();
        if($products)
        return response()->json($products);

            return $this->apiResponse(null,'Error', 404);

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
          $user=auth()->user();
         if($user->role=="manager" || $user->role=="admin"){

          $request->validate
          ([

            'name' =>'required | unique:products,name'
            ,'slug' =>'required | unique:products,slug'
            ,'small_description' =>'required'
            ,'description'   => 'required'
            ,'original_price'   => 'required |numeric'
           ,'selling_price'   =>'required |numeric'
           // ,'image'  =>'required'
           ,'quantity'   =>'required | numeric'
          ]);

            $nameimage='';
            if($request->hasFile('image'))
            {

                $img=$request->file('image');

                $nameimage=time().'.'.$img->getClientOriginalExtension();
                $path=public_path('/assets/uploads');
                $img->move($path,$nameimage);
            }

            $product=$request->all();
            $product['image']=$nameimage;

           $products=Product::create($product);

           if($products)
           return response()->json($products);
          //  return $this->apiResponse([$products,$user],'DONE', 200);
            }

            return $this->apiResponse(null,'Error', 404);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productdetails($id)
    {
        $product = Product::find($id);
        if ($product)
            return response()->json($product);
        return $this->apiResponse(null, 'Error', 404);
    }
    
    public function show($id)
    {
         $product=Product::find($id);
           if($product)
           return response()->json($product);
            // return $this->apiResponse($product,'DONE', 200);

            return $this->apiResponse(null,'Error', 404);


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
    public function update(Request $request, Product $product)
    {
          $user=auth()->user();
          if($user->role=="manager"||$user->role=='admin'){
           $product=$product->update($request->all());

           if($product)
            return response()->json($product);

            }

            return $this->apiResponse(null,'Error', 404);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=auth()->user();
        if($user->role=="manager" ||$user->role='admin'){
        $product=Product::find($id);
        if(!$product)
        {
            return $this->apiResponse(null,'Error', 404);
        }

        $delete=$product->delete();
        if($delete)
        return response()->json(Product::get());
       }

         return $this->apiResponse(null,'Error', 404);


    }


    public function getProductsbyCategory($category_id)
    {

        $user=auth()->user();
        if($user->role=="manager" ||$user->role='admin'){
        $category=Category::find($category_id);
        $products= $category->product()->get();
        if($products)
        return response()->json($products);
        //return $this->apiResponse($products,'DONE', 200);
        }

        return $this->apiResponse(null,'Error', 404);


    }

    public function searchproduct($name)
    {


       $product=Product::where('name', 'Like', '%' . $name . '%')->where('quantity','>',0)->get();
       return $product;

    }


}
