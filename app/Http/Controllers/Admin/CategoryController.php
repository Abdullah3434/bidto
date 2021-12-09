<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use App\Models\Category;
use Redirect;
use Session;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Language;


class CategoryController extends Controller
{
   

    public function add(Request $request)
        {
            $language =  Language::where('status', 'active')->get();
            return view('admin.category.add_category' , compact('language'));
        }
   

    public function add_category(Request $request)
        {
           
            $rules = [
                
                'cat_image' => 'required',
            ];
            $this->validate($request, $rules);
            
            $image = $request->file('cat_image');
            $input['imagename'] = time().'.'.$image->extension();
            
            $filePath = public_path('/uploads/categories/thumbs');

            $img = Image::make($image->path());
            $img->resize(110, 110, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);

            $filePath = public_path('/uploads/categories');
            $image->move($filePath, $input['imagename']);

            $images= $input['imagename'];
            // $input =$request->input('name');
            $input = $request->all();

            $language =  Language::where('status', 'active')->get();

            $cat_key = Str::slug($input['cat_name_en'], '-');
            if($language->isNotEmpty()){
            foreach($language as $single_language){
                $rules = [
         
                    'cat_name_'.$single_language->lang_key => 'required',
                ];
                $this->validate($request, $rules);  
                if($request->has('cat_name_'.$single_language->lang_key)){
                    $data = array(
                        'cat_name' =>$input['cat_name_'.$single_language->lang_key], 
                        'cat_key' => $cat_key,
                            'lang_key' => $single_language->lang_key,
                            'cat_image' => $images,
                           
                         );
                         Category::insert($data);    
                }
            }
        }
        

        Session::flash('success', 'Category Added!'); 
       
           return redirect('/admin/categories/');
        }

       
    public function view_category() 
        {
            $all_cat = Category::select("*")
            ->where("lang_key", "=", "en")
            ->get();
            return view('admin.category.view_category' , compact('all_cat'));

        }
        
    
    public function status($status,$key)
        {
            if($status=='active')
            {
                
                $status='in_active';
            
            }
            elseif($status=='in_active')
            {
                
                $status='active';
            }
            if($status=='in_active')
            {
                $message='In Active';
            }
            elseif($status=='active')
            {
                $message='Active';
            }

            $update= Category::where('cat_key', $key)->update(['status' => $status]);
            Session::flash('success', 'Status '.$message); 
                    return Redirect::back();
          
        }

    public function edit_category_view($cat_key) 
        {
     
            $ifexist = Category::where([
                'cat_key' => $cat_key
            ])->get();
         

             $language =  Language::where('status', 'active')->get();
        
            return view('admin.category.edit_category' , compact('ifexist','language'));

        }
 

    public function edit_category(Request $request,$key)
        {
            
          
            if($request->file('cat_image') )
            {

            $image = $request->file('cat_image');
            $input['imagename'] = time().'.'.$image->extension();
         
            $filePath = public_path('/uploads/categories/thumbs');
    
            $img = Image::make($image->path());
            $img->resize(110, 110, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);
       
            $filePath = public_path('/uploads/categories');
            $image->move($filePath, $input['imagename']);
       
            $images= $input['imagename'];
            Category::where('cat_key', $key)
            ->update([
           'cat_image' =>  $images
            ]);
            }
            $input = $request->all();
      
            $language =  Language::where('status', 'active')->get();
  
            $cat = Category::where('cat_key', $key)->get();
            $cat_lang_array = [];
            foreach($cat as $single_cat){
                $cat_lang_array[] = $single_cat->lang_key;
            }
            if($language->isNotEmpty()){
              foreach($language as $single_language){   
                $rules = [
         
                                'cat_name_'.$single_language->lang_key => 'required',
                            ];
                            $this->validate($request, $rules);  
                  if(in_array($single_language->lang_key,$cat_lang_array)){
                      $update['cat_name'] = $input['cat_name_'.$single_language->lang_key];
                   
                      Category::where('cat_key', $key)->where('lang_key',$single_language->lang_key )->update($update);
                  }else{
                      $create['cat_name'] = $input['cat_name_'.$single_language->lang_key];
                      $create['cat_key'] = $key;
                      $create['lang_key'] = $single_language->lang_key;
                      Category::create($create);
                  }
      
              }
          }
            Session::flash('success', 'Category Edited!'); 
            return redirect('/admin/categories/');
        }



    public function delete_category($cat_key) 
        {
            $ifexist = Category::where([
            'cat_key' => $cat_key
             ])->delete();
             Session::flash('success', 'Category Deleted!'); 
            return redirect()->back();
  
        }

      

}
