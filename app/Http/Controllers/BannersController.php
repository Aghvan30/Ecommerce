<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use App\Models\Products;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class BannersController extends Controller
{
    public function banners()
    {
        $bannerDetails = Banners::get();
        return view('admin.banner.banners')->with(compact('bannerDetails'));
    }

    public function addBanner(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $image = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image')->getClientOriginalName();

                $request->image->move(public_path('upload/banner'), $image);
            }
            $banner = new Banners;
            $banner->name = $data['banner_name'];
            $banner->text_style = $data['text_style'];
            $banner->sort_order = $data['sort_order'];
            $banner->content = $data['banner_content'];
            $banner->link = $data['link'];
            $banner->image = $image;

            $banner->save();
            return redirect('/admin/banners')->with('flash_message_success', 'Banners has been updated Successfully');
        }
        return view('admin.banner.add-banner');
    }


    public function editBanner(Request $request,$id)
    {

        $name=$request->name;
        $text_style = $request->text_style;
        $content = $request->banner_content;
        $link = $request->link;
        $sort_order = $request->sort_order;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->getClientOriginalName();

            $request->image->move(public_path('upload/banner'), $image);


            $banner = Banners::find($id);
            $banner->name = $name;
            $banner->text_style = $text_style;
            $banner->content = $content;
            $banner->link = $link;
            $banner->sort_order = $sort_order;
            $banner->image = $image;
            $banner->save();


        }




        $bannerDetails = Banners::where(['id'=>$id])->first();
        return view('admin.banner.edit-banner')->with(compact('bannerDetails'));
    }


    public function deleteBanner($id=null){
        Banners::where(['id'=>$id])->delete();
        Alert::success('Deleted Successfully', 'Success Message');
        return redirect()->back()->with('flash_message_error','Banner Deleted');
    }


    public function updateStatus(Request $request,$id=null){
        $data = $request->all();
        Banners::where('id',$data['id'])->update(['status'=>$data['status']]);

    }
}
