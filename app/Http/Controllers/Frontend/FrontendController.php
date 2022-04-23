<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiResponseTrait;

class FrontendController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $user = Auth::user();
        $featured_product = Product::where('trending', '1')->take(15)->get();
        $categories = Category::get();
        if ($featured_product && $categories) {
            return $this->apiResponse([$categories, $featured_product, $user], 'DONE', 200);
        } else {
            return $this->apiResponse([$categories, $featured_product, $user], 'Error home page category or product not found', 404);
        }
    }
    public function getallcategory()
    {

            $category = Category::all();
            if ($category) {
                return response()->json($category);
            } else {
                return $this->apiResponse(null, 'Error', 404);
            }
    }
    public function getallproduct()
    {

            $products = Product::where('quantity','>',0)->get();
            if ($products)
                return response()->json($products);

            return $this->apiResponse(null, 'Error', 404);
        }


    public function viewcategory($slug)
    {
        if (Category::where('slug', $slug)->exists()) {
            $category = Category::where('slug', $slug)->first();
            $products = Product::where('category_id', $category->id)->get();
            if ($category && $products) {
                return $this->apiResponse([$category, $products], 'DONE', 200);
            } else {
                return $this->apiResponse([$category, $products], 'Error category slug or product', 404);
            }
        }
    }

    public function viewproduct($cat_slug, $prod_slug)
    {
        $category = Category::where('slug', $cat_slug)->exists();
        if (Category::where('slug', $cat_slug)->exists()) {
            if (Product::where('slug', $prod_slug)->exists()) {
                $products=Product::where('slug',$prod_slug)->first();
                return $this->apiResponse($products, 'DONE', 404);


            } else {
                // return response()->json($category);

                return $this->apiResponse(null, 'prod slug not found', 404);
            }
        } else {
            return $this->apiResponse(null, 'category slug not found', 404);
        }
    }



    public function getProductsbyCategory($category_id)
    {
 
        $category=Category::find($category_id);
        $products= $category->product()->get();
        if($products)
        return response()->json($products);
       


    }    

}
