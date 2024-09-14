<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeCategories = Category::where('status',1)->get();
        return view('admin.categories.list',compact('activeCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activeCategories = Category::where('status',1)->get();
        return view('admin.categories.add',compact('activeCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('id',$id)->first();
        return view('admin.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Category $category):RedirectResponse
    {
        $rules = [
            'name' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'category_details' => 'required',
        ];

        if(!empty($request->slug)){
            $rules = $rules +['slug' => 'required|unique:categories,slug,' . $category->id];
        }
        $request->validate($rules);
        try{
            DB::transaction(function () use ($request, $category) {
                $path = $this->checkFolder();

                if ($request->hasFile('image')){
                    $uploadResponse = $this->uploadFile($path,$request->file('image'));
                    $imagePath = $uploadResponse['path'];
                }else{
                    $imagePath = $category->image;
                }
                if(!empty($request->slug)){
                    $slug = $request->slug;
                }else{
                    $slug = Str::slug($request->name);
                }


                $category->update([
                    'name' => $request->input('name'),
                    'meta_title' => $request->input('meta_title'),
                    'meta_description' => $request->input('meta_description'),
                    'category_details' => $request->input('category_details'),
                    'slug' => $slug,
                    'image' => $imagePath,
                ]);

            });
            return redirect()->route('categories.index')->with('success', 'Category updated successfully');
        }catch (\Exception $e){
            return redirect()->to('/')->with('error',$e->getLine().'|'.$e->getMessage());
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
        //
    }

    public function getSubCategory($parentId){
        $categories = ProductCategory::where('parent_id',$parentId)->get();
        return response()->json($categories);
    }

    public function getCategoryById($categoryId){
        $category = ProductCategory::where('id',$categoryId)->first();
        return response()->json($category);
    }

    public function checkFolder(){
        $yFolder = "uploads/" . date("Y");
        if (!file_exists($yFolder)) {
            mkdir($yFolder, 0777, true);
            $myfile = fopen($yFolder . "/index.html", "w");
            fclose($myfile);
        }
        $ym = date("Y") . "/" . date("m") . "/";
        $ym1 = "uploads/" . date("Y") . "/" . date("m");
        if (!file_exists($ym1)) {
            mkdir($ym1, 0777, true);
            $myfile = fopen($ym1 . "/index.html", "w");
            fclose($myfile);
        }
        return $ym1;

    }

    public function uploadFile($path,$_file){
        $prefix = 'category_';
        $i = strripos($_file->getClientOriginalName(), '.');
        $ext = strtolower(substr($_file->getClientOriginalName(), $i + 1));
        $original_file = uniqid($prefix,true) . "." . $ext;
        $file_type = $_file->getClientMimeType();
        if ($file_type == 'application/pdf') {
            return array('code'=>-1,"error"=>"invalid file type");
        }
        $authoFileUrl = $original_file;
        $_file->move($path, $authoFileUrl);
        return array('code'=>1,"path"=>$path.'/'.$authoFileUrl);
    }
}
