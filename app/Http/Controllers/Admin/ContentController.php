<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\PageContent;
use Illuminate\Support\Str;
use App\Models\Language;

class ContentController extends Controller
{
    public function view_page_contents() 
        {

            $all_content = PageContent::select("*")
                ->where("lang_key", "=", "en")
                ->orderby('id', 'desc')->get();
                return view('admin.page_content.view_content' , compact('all_content'));

        }

    
    public function edit_page_content($page_key) 
        {
     
            $ifexist = PageContent::where([
                'page_key' => $page_key
            ])->get();
         

            $language =  Language::where('status', 'active')->get();
        
            return view('admin.page_content.edit_content' , compact('ifexist','language'));

        }

    public function edit_content(Request $request,$key)
        {
         
            $input = $request->all();
      
            $language =  Language::where('status', 'active')->get();
  
            $page = PageContent::where('page_key', $key)->get();
           // $page_key = Str::slug($input['page_name_en'], '-');
            $cat_lang_array = [];
            foreach($page as $single_page)
            {
                $cat_lang_array[] = $single_page->lang_key;
            }
            if($language->isNotEmpty()){
              foreach($language as $single_language){   
                $rules = [
         
                                'page_name_'.$single_language->lang_key => 'required',
                                'page_content_'.$single_language->lang_key => 'required',
                                'meta_title_'.$single_language->lang_key => 'required',
                                'meta_keyword_'.$single_language->lang_key => 'required',
                                'meta_description_'.$single_language->lang_key => 'required',
                            ];
                            $this->validate($request, $rules);  
                  if(in_array($single_language->lang_key,$cat_lang_array)){
                      $update['page_name'] = $input['page_name_'.$single_language->lang_key];
                      $update['page_content'] = $input['page_content_'.$single_language->lang_key];
                      $update['meta_title'] = $input['meta_title_'.$single_language->lang_key];
                      $update['meta_keywords'] = $input['meta_keyword_'.$single_language->lang_key];
                      $update['meta_description'] = $input['meta_description_'.$single_language->lang_key];
                      //$update['page_key'] = $page_key;
                   
                      PageContent::where('page_key', $key)->where('lang_key',$single_language->lang_key )->update($update);
                  }
      
              }
          }

            Session::flash('success', 'Page Content Edited!'); 
            return redirect('/admin/page/content');
        }

}
