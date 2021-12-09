<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Image;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function view_sponsors() 
        {

            $all_sponsors= Sponsor::orderby('id', 'desc')->get();

            return view('admin.sponsor.view_sponsor' , compact('all_sponsors'));

        }

    public function add_sponsor_view()
        {

            return view('admin.sponsor.add_sponsor');
        }

    public function add_sponsor(Request $request)
        {
            $rules = [
                        
                'sponsor_name' => 'required',
                'sponsor_url' => 'required|url|',
                'sponsor_image' => 'required',
            ];
            $this->validate($request, $rules);
            
            $image = $request->file('sponsor_image');
            $input['imagename'] = time().'.'.$image->extension();
            
            $filePath = public_path('/uploads/sponsors/thumbs');
            $img = Image::make($image->path());
            $img->resize(110, 110, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);

            $filePath = public_path('/uploads/sponsors');
            $image->move($filePath, $input['imagename']);

            $images= $input['imagename'];
            // $input =$request->input('name');
            $input = $request->all();

            $data = array(
                'sponsor_name' =>$input['sponsor_name'], 
                'sponsor_url' => $input['sponsor_url'],
                'sponsor_image' => $images,
                
                );
                Sponsor::insert($data);    



            Session::flash('success', 'Sponsor Added!'); 

            return redirect('/admin/sponsors');
        }

    public function edit_sponsor_view($id) 
        {
            $ifexist = Sponsor::find($id);
            return view('admin.sponsor.edit_sponsor' , compact('ifexist'));

        }
    public function edit_sponsor(Request $request,$id)
        {
            // return $request->file('sponsor_image');
            $rules = [
        
                'sponsor_name' => 'required',
                'sponsor_url' => 'required|url|',
                // 'sponsor_image' => 'required',
            
            ];
            $this->validate($request, $rules);  

            if($request->file('sponsor_image') )
                {

                    $image = $request->file('sponsor_image');
                    $input['imagename'] = time().'.'.$image->extension();
                
                    $filePath = public_path('/uploads/sponsors/thumbs');

                    $img = Image::make($image->path());
                    $img->resize(110, 110, function ($const) {
                        $const->aspectRatio();
                    })->save($filePath.'/'.$input['imagename']);

                    $filePath = public_path('/uploads/sponsors');
                    $image->move($filePath, $input['imagename']);

                    $images= $input['imagename'];
                    Sponsor::where('id', $id)
                        ->update([
                        'sponsor_image' =>  $images
                    ]);
                }
            $input = $request->all();

            $update['sponsor_name'] = $input['sponsor_name'];
            $update['sponsor_url'] = $input['sponsor_url'];
        
            Sponsor::where('id', $id)->update($update);
        
    

            Session::flash('success', 'Sponsor Edited!'); 
            return redirect('/admin/sponsors/');
        }

    public function delete_sponsor($id,$image) 
        {
            
            unlink("public/uploads/sponsors/thumbs/".$image);
            unlink("public/uploads/sponsors/".$image);
                $ifexist = Sponsor::where([
                'id' => $id
                ])->delete();

            Session::flash('success', 'Sponsor Deleted!'); 
            return redirect()->back();

        }
}
