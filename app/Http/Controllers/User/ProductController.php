<?php

/**
 * @Author: Redefinelab Ltd
 * @Date:   2017-10-16 13:37:36
 * @Last Modified by:   Md Shafkat Hussain Tanvir
 * @Last Modified time: 2017-10-16 13:37:41
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\Product;
use App\Models\FavouriteProduct;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Message;
use App\Models\Profile;

use App\Models\UserCard;
use App\Models\ProductColor;
use App\Models\ProductRank;
use App\Models\Product_rating;
use App\Mail\Common;
use App\User;

use Auth;
use Cart;
use Mail;
use Image;

class ProductController extends Controller
{
	public function __construct()
    {

    }

    public function purchaseList(Request $request)
    {
    	// $data['products'] = Product::where('status', 1)->whereHas('orderDetails', function ($query) {
        //     $query->whereHas('order', function($query1){
        //         $query1->where('user_id', Auth::user()->id);
        //     });
        // })->with('orderDetails')->get();
        // dd($data);
				
                $data['products'] = OrderDetail::whereHas('order', function ($query) {
                        $query->where('user_id', Auth::user()->id)->where('status', 1);
                })->orderBy('created_at', 'desc')->get();
        return view('user.my-purchase-list', $data);
    }

		public function productRating(Request $request){
			$checkIfRatings = Product_rating::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->first();
			if ($checkIfRatings) {
                $checkIfRatings->user_rating = $request->user_rating;
                $checkIfRatings->save();
                return redirect()->back();

            }
			$ratings = new Product_rating();
			$ratings->user_id = Auth::user()->id;
			$ratings->product_id = $request->product_id;
			$ratings->user_rating = $request->user_rating;

			$ratings->save();
			return redirect()->back();
		}

    public function index()
    {
        $data['products'] = Product::where('user_id', Auth::user()->id)->get();
				
    	return view('user.my_product_list', $data);
    }

    public function preNew()
    {
    	return view('user.pre_new_product');
    }
    public function add(Request $request)
    {
        $finish = false;
        if($request->finish){
            $finish = true;
        }
        $data['finish'] = $finish;
        $data['category'] = ProductCategory::where('status', 1)->get();
        $data['subcategory'] = ProductSubCategory::where('status', 1)->get();
    	return view('user.new_product', $data);
    }
    public function addAction(Request $request)
    {
        //dd($request->hasFile('other_file.0'));
        $Product = new Product();
        $Product->title = $request->title;

        $name = '';

        if ($request->hasFile('image')) {
            $extension = $request->image->extension();
            $name = time().rand(1000,9999).'.'.$extension;
            $img = Image::make($request->image);
            $img->save(public_path().'/uploads/products/'.$name, 60);
            // $path = $request->image->storeAs('products', $name);
        }

        $Product->image = $name;
        $Product->user_id = Auth::user()->id;
        $Product->subcategory_id = $request->subcategory;
        $Product->price = $request->price;
        // if(!empty($request->colors)){
        //     $colors = explode(',', $request->colors);
        //     $colors = json_encode($colors);
        //     $Product->colors = $colors;
        // }
        $Product->description = $request->description;
        $Product->explanation = $request->explanation;
        // if ($request->hasFile('explanation_image')) {
        //     $extension = $request->explanation_image->extension();
        //     $name = time().rand(1000,9999).'.'.$extension;
        //     $img = Image::make($request->explanation_image)->resize(300, 300);
        //     $img->save(public_path().'/uploads/products/'.$name, 60);
        //     // $path = $request->image->storeAs('products', $name);
        //     $Product->explanation_image = $name;
        // }

        $Product->company_name = $request->company_name;
        $Product->company_info = $request->company_info;
        
        if ($request->hasFile('company_info_image')) {
            $extension = $request->company_info_image->extension();
            $name = time().rand(1000,9999).'.'.$extension;
            $img = Image::make($request->company_info_image)->resize(300, 300);
            $img->save(public_path().'/uploads/products/'.$name, 60);
            // $path = $request->image->storeAs('products', $name);
            $Product->company_info_image = $name;
        }

        
        $Product->profile_info = '';
        

        $Product->status = 0;
        $Product->save();
      
        //send mail to admin
        $User = Auth::user();
        $emailData = [
            'name' => '',
            'register_token' =>'',
            'subject' => '【Crofun】商品発送のお知らせ',
            'from_email' => 'noreply@crofun.com',
            'from_name' => 'CROFUN',
            'template' => 'user.email.18',
            'root'     => $request->root(),
            'email'     => 'administrator@crofun.jp',
            'user_name' =>$User->first_name.' '.$User->last_name,
            'product_name'  =>$Product->title,
            'application_date' =>$Product->created_at,
            'detailed_url' =>'http://crofun.jp/product-details/'.$Product->id,
            
            ];
            Mail::to('administrator@crofun.jp')
                ->send(new Common($emailData));
        //send mail to seller
        $emailData = [
            'name' => '',
            'register_token' =>'',
            'subject' => '【Crofun】商品掲載申請を受け付けました',
            'from_email' => 'noreply@crofun.com',
            'from_name' => 'CROFUN',
            'template' => 'user.email.17',
            'root'     => $request->root(),
            'email'     => $User->email,
        
            ];
            Mail::to($User->email)
                ->send(new Common($emailData));

        foreach ($request->color as $key => $value) {           
                if(!empty($value) || !empty($request->type[$key])){
                    $ProductColor = new ProductColor();
                    $ProductColor->product_id = $Product->id;
                    $ProductColor->color = $value;
                    $ProductColor->color = $value;
                    $ProductColor->type = $request->type[$key];
                    $ProductColor->save();
                }
        }

        // return redirect()->to(route('user-my-page'));
        return redirect()->to(route('user-product-add', ['finish' => 1]));
    }
    public function edit(Request $request)
    {
        $finish = false;

        if($request->finish){
            $finish = true;
        }
        $data['finish'] = $finish;
        $data['category'] = ProductCategory::where('status', 1)->get();
        $data['subcategory'] = ProductSubCategory::where('status', 1)->get();
        $data['product'] = Product::where('id', $request->id)->first();
        // dd($request);
    	return view('user.edit_product', $data);
    }
    public function editAction(Request $request)
    {
        //dd($request->hasFile('other_file.0'));
        $Product = Product::where('id', $request->id)->first();
        $Product->title = $request->title;
        if ($request->hasFile('image')) {
            $extension = $request->image->extension();
            $name = time().rand(1000,9999).'.'.$extension;
            $img = Image::make($request->image);
            $img->save(public_path().'/uploads/products/'.$name, 60);
            // $path = $request->image->storeAs('products', $name);
        }
        if ($request->hasFile('image')) {
        $Product->image = $name;
        }
        $Product->user_id = Auth::user()->id;
        $Product->subcategory_id = $request->subcategory;
        $Product->price = $request->price;
        // if(!empty($request->colors)){
        //     $colors = explode(',', $request->colors);
        //     $colors = json_encode($colors);
        //     $Product->colors = $colors;
        // }
        $Product->description = $request->description;
        $Product->explanation = $request->explanation;
        // if ($request->hasFile('explanation_image')) {
        //     $extension = $request->explanation_image->extension();
        //     $name = time().rand(1000,9999).'.'.$extension;
        //     $img = Image::make($request->explanation_image)->resize(300, 300);
        //     $img->save(public_path().'/uploads/products/'.$name, 60);
        //     // $path = $request->image->storeAs('products', $name);
        //     $Product->explanation_image = $name;
        // }

        $Product->company_name = $request->company_name;
        $Product->company_info = $request->company_info;
        if ($request->hasFile('company_info_image')) {
            $extension = $request->company_info_image->extension();
            $name = time().rand(1000,9999).'.'.$extension;
            $img = Image::make($request->company_info_image)->resize(300, 300);
            $img->save(public_path().'/uploads/products/'.$name, 60);
            // $path = $request->image->storeAs('products', $name);
            $Product->company_info_image = $name;
        }

        // $Product->profile_info = $request->profile_info;
        $Product->profile_info = '';
        



        // $Product->status = 1;
        $Product->save();

        
        if(!empty($request->color)){
            $ProductColor = ProductColor::where('product_id', $request->id)->delete();
            foreach ($request->color as $key => $value) {
            
                // if(!empty($value) && !empty($request->type[$key]) && !empty($request->individual[$key])){
                    $ProductColor = new ProductColor();
                    $ProductColor->product_id = $Product->id;
                    $ProductColor->color = $value;
                    $ProductColor->type = $request->type[$key];
                    $ProductColor->save();
                
            }
        }
        

        // return redirect()->to(route('user-my-page'));

        return redirect()->to(route('user-product-edit', [ 'id' => $request->id, 'finish' => 1]));
    }

    public function addFavourite(Request $request)
    {

        $id = $request->id;
        $check = FavouriteProduct::where('product_id', $id)->where('user_id', Auth::user()->id)->first();
        if($check) return redirect()->back();
        $FavouriteProduct = new FavouriteProduct();
        $FavouriteProduct->user_id = Auth::user()->id;
        $FavouriteProduct->product_id = $id;
        $FavouriteProduct->save();
        return redirect()->back();
    }

    public function favouriteList(Request $request)
    {
        $data['products'] = FavouriteProduct::where('status', 1)->where('user_id', Auth::user()->id)->get();
        return view('user.favourite_product_list', $data);
    }

    public function removeFavourite(Request $request)
    {
        $id = $request->id;
        FavouriteProduct::where('product_id', $id)->where('user_id', Auth::user()->id)->delete();
        return redirect()->back();
    }

    public function payment(Request $request)
    {
        dd($request);
    }

    public function purchase(Request $request)
    {

        Cart::update($request->row_id, $request->quantity);
        $date = date("YmdHis");

        // dd(Cart::content());
				// return 'hello';


        $order_no = 'ORD-'.time().Auth::user()->id.rand(1000,9999);
        $remaining = 0;
        $cartSubtotal = (float)Cart::subtotal(false, false, false);
        $accountPoint = $cartSubtotal;
        if($cartSubtotal > Auth::user()->point){
            $remaining = $cartSubtotal-Auth::user()->point;
            $accountPoint = Auth::user()->point;
        }

       
        
        $Order = new Order();
        $Order->user_id = Auth::user()->id;
        $Order->order_no = $order_no;
        $Order->qty = Cart::count();
        $Order->total_point = $cartSubtotal;
        $Order->account_point = $accountPoint;
        $Order->purchase_point = $remaining;        
        $Order->delivery_option = '1';        
        $Order->delivery_date = '2012-12-12';        
        $Order->delivery_time = time();
        $Order->name = 1;
        $Order->number = 1;
        $Order->cvv = 1;
        $Order->exp_month = 1;
        $Order->custom_postal_code = $request->postal_code;
        $Order->custom_municipility = $request->municipility;
        $Order->custom_address = $request->address;
        $Order->custom_room_no = $request->room_no;
        $Order->custom_phone_no = $request->phone_num;
        $Order->status = true;



        if($remaining > 0){
            $Order->status = false;
        }





        
        $Order->created_at = date('Y-m-d H:i:s', strtotime($date));
        $Order->updated_at = date('Y-m-d H:i:s', strtotime($date));
        $Order->save(); 


        foreach(Cart::content() as $p) {
            $OrderDetail = new OrderDetail();
            $OrderDetail->order_id = $Order->id;
            $OrderDetail->product_id = $p->id;
            $OrderDetail->qty = $p->qty;
            $OrderDetail->color = isset($p->options['color']) ? $p->options['color'] : null;
            $OrderDetail->size = isset($p->options['size']) ? $p->options['size'] : null;
            $OrderDetail->unit_point = $p->price;
            $OrderDetail->total_point = $p->price*$p->qty;
            $OrderDetail->status = 1;
            $OrderDetail->save();
        }

        if($remaining > 0){
            $Order->status = false;
            return view('user.invest_payment', [
                'orderNo'   => $order_no,
                'amount'    => $remaining,
                'date'      => $date,
                'retUrl'    => route('purchase-payment-response'),
                'cancelUrl' => route('front-cart')
            ]); 
        }else{
            $User = User::find(Auth::user()->id);
            $User->point -= $accountPoint;
            $User->save();
            Cart::destroy();
            return redirect()->to(route('front-cart', ['finish' => true]));
        }
		
			
  }



  function purchasePaymentResponse(Request $request){
    // dd($request);
    $check = Order::where('order_no', $request->OrderID)->where('status', false)->first();
    if($check){

        if(!$request->Approve) return redirect()->to(route('front-cart'))->with('error_message', '支払いが完了していません。もう一度お試しください');

        $check->status = true;
        $check->save();
        $User = User::find($check->user_id);
        $User->point -= $check->account_point;
        $User->save();
     

           
             $Profile = Profile::where('user_id', $check->user_id)->first();
             $OrderDetails = OrderDetail::where('order_id', $check->id)->first();
             $Product = Product::find($OrderDetails->product_id);
             $Seller = User::find($Product->user_id);
             $Sellerprofile = Profile::where('user_id', $Product->user_id)->first();
             //send mail to admin
             $emailData = [
                'name' => '',
                'register_token' => $User->register_token,
                'subject' => '【Crofun　管理者用】商品購入の通知',
                'from_email' => 'noreply@crofun.com',
                'from_name' => 'CROFUN',
                'template' => 'user.email.9',
                'root'     => $request->root(),
                'email'     => 'administrator@crofun.jp',
                'buyer_name'  => $User->first_name.' '.$User->last_name,
                'buyer_reading'  => '',
                'buyer_address' => $Profile->address,
                'buyer_phone_number' => $Profile->phone_no,
                'product_name' =>  $Product->title,
                'point'  => $check->total_point,
                'seller_name'  => $Seller->first_name.' '.$Seller->last_name,
                'seller_reading'  => '',
                'seller_address' => $Sellerprofile->address,
                'seller_phone_number' => $Sellerprofile->phone_no,

            ];
    
            Mail::to('administrator@crofun.jp')
                ->send(new Common($emailData));

            //send mail to seller
            $emailData = [
                'name' => '',
                'register_token' => $User->register_token,
                'subject' => '【Crofun】商品発注・発送のお願い',
                'from_email' => 'noreply@crofun.com',
                'from_name' => 'CROFUN',
                'template' => 'user.email.8',
                'root'     => $request->root(),
                'email'     => $Seller->email,
                'product_name' =>  $Product->title,
                'buyer_name'  => $User->first_name.' '.$User->last_name,
                'buyer_home' => $Profile->address,
                'buyer_phone_number' => $Profile->phone_no,
                

            ];
    
            Mail::to($Seller->email)
                ->send(new Common($emailData));
            
            //send mail to buyer
            $emailData = [
                'name' => '',
                'register_token' => $User->register_token,
                'subject' => '【Crofun】ご注文完了のお知らせ',
                'from_email' => 'noreply@crofun.com',
                'from_name' => 'CROFUN',
                'template' => 'user.email.7',
                'root'     => $request->root(),
                'email'     => $User->email,
                'product_name' =>  $Product->title,
                'point'  => $check->total_point,
                'buyer_name'  => $User->first_name.' '.$User->last_name,
                'address' => $Profile->address,
              
            ];
    
            Mail::to($User->email)
                ->send(new Common($emailData));
    

            //send mail to seller
            $emailData = [
                'name' => '',
                'register_token' => $User->register_token,
                'subject' => '【Crofun】商品発送件数と代金について',
                'from_email' => 'noreply@crofun.com',
                'from_name' => 'CROFUN',
                'template' => 'user.email.30',
                'root'     => $request->root(),
                'email'     => $Seller->email,
                'product_name'  => $Product->title,
                'number_of_shipments' =>$check->qty,
                'total' => '',
                'transfer_destination'=> $check->custom_address,
                'financial_institution_name' =>'',
                'account_holder' => $User->first_name.' '.$User->last_name,
                'amount' => '' ,
                'scheduled_transfer_date' =>$check->delivery_date,
            ];
        
             Mail::to($Seller->email)
                    ->send(new Common($emailData));
        
        Cart::destroy();

        return redirect()->to(route('front-cart', ['finish' => true]));
    }
    if( redirect('front-cart')){
     return redirect('front-cart');
    }
    else{

    }
    
}




    public function getSubCategory(Request $request)
    {
        $id = $request->id;
        $data['sub_category'] = ProductSubCategory::where('category_id', $id)->where('status', 1)->get();
        return view('user.sub_category', $data);
    }

    public function sendRank(Request $request)
    {
        $product_id = $request->product_id;
        $rank = $request->rank;
        ProductRank::where('product_id', $product_id)->where('user_id', Auth::user()->id)->delete();
        $ProductRank = new ProductRank();
        $ProductRank->user_id = Auth::user()->id;
        $ProductRank->product_id = $product_id;
        $ProductRank->rank = $rank;
        $ProductRank->save();
        return redirect()->back()->with('success_message', 'Rank done');
    }
}
