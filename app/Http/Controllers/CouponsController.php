<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CouponsController extends Controller
{
   public function addCoupon(Request $request){
       if($request->isMethod('post')){
           $data = $request->all();
           $coupon = new Coupons();
           $coupon->coupon_code = $data['coupon_code'];
           $coupon->amount = $data['amount'];
           $coupon->amount_type = $data['amount_type'];
           $coupon->expiry_date = $data['expiry_date'];
           $coupon->save();
           return redirect('/admin/add-coupon');
       }
       return view('admin.coupons.add_coupon');
   }
   public function viewCoupons(){
       $coupons = Coupons::get();
       return view('admin.coupons.view_coupons')->with(compact('coupons'));
   }

   public function editCoupons(Request $request,$id=null){
       if($request->isMethod('post')) {
           $data = $request->all();
           $coupon = Coupons::find($id);
           $coupon->coupon_code = $data['coupon_code'];
           $coupon->amount = $data['amount'];
           $coupon->amount_type = $data['amount_type'];
           $coupon->expiry_date = $data['expiry_date'];
           $coupon->save();
           return redirect('/admin/view-coupons')->with('flash_message_success','Coupons has been update Successfully');
       }
       $coupon = Coupons::where(['id'=>$id])->first();
         return view('admin.coupons.edit_coupon')->with(compact('coupon'));
   }


   public function updateStatus(Request $request,$id=null){
        $data = $request->all();
        Coupons::where('id',$data['id'])->update(['status'=>$data['status']]);
   }


   public function deleteCoupons($id){
       $delete = Coupons::find($id);
       $delete->delete();
       Alert::success('Deleted','Success Message');
       return redirect()->back();
   }
}
