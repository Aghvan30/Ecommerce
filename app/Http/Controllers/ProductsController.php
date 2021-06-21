<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use App\Models\Category;
use App\Models\Coupons;
use App\Models\Products;
use App\Models\ProductsAttributes;
use App\Models\ProductsImages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use DB;
use Session;

use Image;

class ProductsController extends Controller
{
    public function addProduct(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $image = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image')->getClientOriginalName();

                $request->image->move(public_path('upload'), $image);
            }
            // echo "<pre>";print_r($data);
            $product = new Products;
            $product->category_id = $data['category_id'];
            $product->name = $data['product_name'];
            $product->code = $data['product_code'];
            $product->color = $data['product_color'];
            if (!empty($data['product_descr'])) {
                $product->description = $data['product_descr'];
            } else {
                $product->description = '';
            }
            $product->price = $data['product_price'];
            $product->image = $image;


            $product->save();
            return redirect('/admin/add-product')->with('flash_message_success', 'Product has been added successfully');

        }
        //Categories Dropdown menu code
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_drop = "<option value='' selected disabled>Select</option>";
        foreach ($categories as $cat) {
            $categories_drop .= "<option value='" . $cat->id . "'>" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_drop .= "<option value='" . $sub_cat->id . "'>&nbsp;--&nbsp" . $sub_cat->name . "</option>";

            }

        }
        return view('admin.products.add-product')->with(compact('categories_drop'));
    }


    public function viewProducts()
    {
        $products = Products::get();
        return view('admin.products.view-products')->with(compact('products'));
    }


    public function edit($id)
    {


    }

    public function editProduct(Request $request, $id)
    {
        $name = $request->name;
        $text_style = $request->text_style;
        $content = $request->banner_content;
        $link = $request->link;
        $sort_order = $request->sort_order;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->getClientOriginalName();

            $request->image->move(public_path('upload/banners'), $image);


            $banner = Banners::find($id);
            $banner->name = $name;
            $banner->text_style = $text_style;
            $banner->content = $content;
            $banner->link = $link;
            $banner->sort_order = $sort_order;
            $banner->image = $image;
            $banner->save();


        }


        $bannerDetails = Banners::where(['id' => $id])->first();
        return view('admin.banner.edit-banner')->with(compact('bannerDetails'));




    }

    public function deleteProduct($id = null)
    {
        Products::where(['id' => $id])->delete();
        Alert::success('Deleted Successfully', 'Success Message');
        return redirect()->back()->with('flash_message_error', 'Product Delete');

    }


    public function updateStatus(Request $request, $id = null)
    {
        $data = $request->all();
        Products::where('id', $data['id'])->update(['status' => $data['status']]);
    }


    public function products($id = null)
    {
        $productDetails = Products::with('attributes')->where('id', $id)->first();
        $productsAltImage = ProductsImages::where('product_id',$id)->get();
        $featuredProducts = Products::where(['featured_products'=>1])->get();
        return view('wayshop.product_detail')->with(compact('productDetails','productsAltImage','featuredProducts'));
    }


    public function addAttributes(Request $request, $id = null)
    {

        $productDetails = Products::with('attributes')->where(['id' => $id])->first();
        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['sku'] as $key => $val) {
                //Prevent duplicate SKU Record
                if (!empty($val)) {
                    $attrCountSKU = ProductsAttributes::where('sku', $val)->count();
                    if ($attrCountSKU > 0) {
                        return redirect('/admin/add-attributes/' . $id)->with('flash_message_error', 'SKU is already exist please select another sku');
                    }
                    //Prevent duplicate Size Record
                    $attrCountSizes = ProductsAttributes::where(['product_id' => $id, 'size' => $data['size'] [$key]])->count();
                    if ($attrCountSizes > 0) {
                        return redirect('/admin/add-attributes/' . $id)->with('flash_message_error', '' . $data['size'][$key] . 'size is already exist please select another size');
                    }
                    $attribute = new ProductsAttributes();
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();

                }

            }
            return redirect('/admin/add-attributes/' . $id)->with('flash_message_success', 'Product attributes added successfully');
        }
        return view('admin.products.add-attributes')->with(compact('productDetails'));
    }


    public function deleteAttribute($id)
    {
        $attribute = ProductsAttributes::find($id);
        $attribute->delete();
        return redirect()->back()->with('flash_message_error', 'Product Attributes is Delete');
    }

    public function editattribute($id)
    {
        $editattribute = ProductsAttributes::where(['id' => $id])->first();
        return view('admin.products.edit-attribute')->with(compact('editattribute'));;
    }

    public function updateattribute(Request $request, $id = null)
    {
        // dd($request);

        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['attr'] as $key => $attr) {
                ProductsAttributes::where(['id' => $data['attr'][$key]])
                    ->update(['sku' => $data['sku'][$key],
                        'size' => $data['size'][$key],
                        'price' => $data['price'][$key],
                        'stock' => $data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success', 'Product Attributes Updated!!');
        }
    }

    public function images(Request $request, $id = null)
    {
        $productDetails = Products::where(['id'=>$id])->first();
        $productImages = ProductsImages::where(['product_id' => $id])->get();

        return view('admin.products.add_images')->with(compact('productDetails','productImages'));
    }


    public function addimages(Request $request,$id=null)
    {
       // dd($request);

        if ($request->isMethod('post')) {
            $data = $request->all();
            $banner = new ProductsImages();
            if($request->file('image')){
                $file=$request->file('image');
                $filename=time().'.'.$file->getClientOriginalExtension();
                $request->image->move(public_path('upload/products'), $filename);

                $banner->images= $filename;
            }


            $banner->product_id = $data['id'];



            $banner->save();

            return redirect()->back()->with('flash_message_success', 'Image has been updated');


        }

    }
    public function deleteAltImage($id=null){
        $productImage = ProductsImages::where(['id'=>$id])->first();
        $image_path = 'upload/products/';
        if(file_exists($image_path.$productImage->images)){
            unlink($image_path.$productImage->images);
        }
        ProductsImages::where(['id'=>$id])
        ->delete();
        Alert::success('Deleted','Success Message');
        return redirect()->back();
    }

    public function updateFeatured(Request $request, $id = null)
    {
        $data = $request->all();
        Products::where('id', $data['id'])->update(['featured_products' => $data['status']]);
    }
    public function getPrice(Request $request){
        $data = $request->all();
       // echo "<pre>";print_r($data);die;
        $proArr = explode("-",$data['idSize']);
        $proAttr = ProductsAttributes::where(['product_id'=>$proArr[0],'size'=>$proArr[1]])->first();
        echo $proAttr->price;
    }
    public function addToCart(Request $request){
        $data = $request->all();
        if(empty($data['user_email'])){
            $data['user_email']='';
        }
        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = Str::random(40);
            Session::put('session_id',$session_id);
        }

        $sizeArr = explode('-',$data['size']);
       $countProducts=DB::table('cart')->where(['product_id'=>$data['product_id'],'product_code'=>$data['product_code'],
            'size'=>$sizeArr[1],'session_id'=>$session_id])->count();
       if($countProducts>0){
           return redirect()->back()->with('flash_message_error','Product already exists in cart');
       }else{
           DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],
               'product_code'=>$data['product_code'],'product_color'=>$data['color'],'price'=>$data['price'],
               'size'=>$sizeArr[1],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);
       }



        return redirect('/cart')->with('flash_message_success','Product has been added in cart');

    }
    public function cart(Request $request){
        $session_id = Session::get('session_id');
        $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
        foreach ($userCart as $key=>$products){
            $productDetails = Products::where(['id'=>$products->product_id])->first();
             $userCart[$key]->image =$productDetails->image;
        }
        return view('wayshop.products.cart')->with(compact('userCart'));
    }


    public function deleteCartProduct($id){
       DB::table('cart')->where('id',$id)->delete();
       return redirect('/cart')->with('flash_message_error','Product has been deleted!');
    }

    public function updateCartQuantity($id=null,$quantity=null){
        DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
        return redirect('/cart')->with('flash_message_success','Product Quantity has been updated successfully');
    }
    public function applyCoupon(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $couponCount = Coupons::where('coupon_code',$data['coupon_code'])->count();
            if($couponCount==0){
                return redirect()->back()->with('flash_message_error','Coupon code does not exists');

            }else{
               $couponDetails = Coupons::where('coupon_code',$data['coupon_code'])->first();
               //Coupon code status
                if($couponDetails->status==0){
                    return redirect()->back()->with('flash_message_error','Coupon code is not active');
                }
                //Check coupon expiry date
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date<$current_date){
                    return redirect('')->back()->with('flash_message_error','Coupon code is Expired');
                }
                //coupon is ready for discount
                $session_id = Session::get('session_id');
                $usercart = DB::table('cart')->where(['session_id'=>$session_id])->get();
                $total_amount = 0;
                foreach ($usercart as $item){
                    $total_amount = $total_amount + ($item->price*$item->quantity);
                }
                //Check if coupon amount is fixed or parcentage
                if($couponDetails->amount_type=="fixed"){
                    $couponAmount = $couponDetails->amount;
                }else{
                    $couponAmount = $total_amount * ($couponDetails->amount/100);
                }
                //Add Coupon code in Session
                Session::put('CouponAmount',$couponAmount);
                Session::put('CouponCode',$data['coupon_code']);
                return redirect()->back()->with('flash_message_success','Coupon Code is Successfully Applied.You are availing Discount');
            }
        }
    }
    public function checkout(Request $request){
        return view('wayshop.products.checkout');
    }

}
