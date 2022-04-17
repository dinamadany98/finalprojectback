<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Api\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //use trait
    use ApiResponseTrait;

    public function index()
    {
        $user=auth()->user();
        if($user->role=="admin" ||$user->role=="manager"){
        $category = Category::all();
        if($category){
            return response()->json($category);
        }else{
            return $this->apiResponse(null,'Error', 404);
        }
    }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $category = new Category();
        $filename='';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/category',$filename);
            $category->image = $filename;


        $category->image = $filename;

        $request->validate([
            'name'=>'required|string',
            'slug'=>'required|string',
            'description'=>'required'
        ]);

        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->save();
        if($category){
            return response()->json($category);
        }

        }

        return $this->apiResponse(null,'Erorr', 404);

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
        if($category){
            return response()->json($category);
        }


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
        $user=auth()->user();
        if($user->role=="manager" || $user->role=="admin"){
        $category = Category::find($id);
        if($category){
            return response()->json($category);
        }
        }
            return $this->apiResponse(null,'Error', 404);

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
        $user=auth()->user();
        if($user->role=="manager" || $user->role=="admin"){
        $category = Category::find($id);
        if($request->hasFile('image')){
            $path = 'assets/uploads/category'.$category->image;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/category',$filename);
            $category->image = $filename;
        }
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        // dd($category);
        $category->update();
        if($category){
            return response()->json($category);
        }
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
        if($user->role=="manager" || $user->role=="admin"){
        $category = Category::find($id);
        if($category->image){
            $path = 'assets/uploads/category'.$category->image;
            if(File::exists($path)){
                File::delete($path);
            }
        }
          $category->delete();
           if($category){
            return $this->apiResponse(null,'DONE', 201);
             }
           }

            return $this->apiResponse(null,'Error', 404);

    }
}
