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
use App\User;
use App\Models\Profile;
use App\Models\UserCard;
use App\Models\Message;
use App\Models\Product;
use App\Models\Project;
use App\Models\Order;
use App\Models\OrderDetail;

use App\Models\Investment;
// use App\Models\Message;

use App\Mail\Common;



use Image;
use Auth;
use Mail;

class ProfileController extends Controller
{
	public function __construct()
    {

    }

    public function index(Request $request)
    {
    	$user = User::where('id', Auth::user()->id)->with('profile')->first();
        $data['user'] = $user;
		return view('user.profile_update', $data);
    }

    public function indexAction(Request $request)
    {
    	$this->validate($request, [
            'first_name' => 'required|max:10',
            'last_name' => 'required|max:10',
            'phonetic' => 'required|regex:/[\x{30A0}-\x{30FF}]/u',
            'phonetic2' => 'required|regex:/[\x{30A0}-\x{30FF}]/u',
            'url' => 'nullable|url',
            // 'profile' => 'required',
            // 'birth_year' => 'required',
            // 'birth_month' => 'required',
            // 'birth_day' => 'required',
            'postal_code' => 'required',
            // 'division' => 'required',
            // 'municipility' => 'required',
            // 'address' => 'required',
            // 'room_no' => 'required',
            // 'phone_no' => 'required|min:10|max:11',
            // 'sex' => 'required'
            'phone_no' => ['min:10','max:11']
        ],[
            'phonetic.regex' => 'カタカナで入力してください ',
            'phonetic2.regex' => 'カタカナで入力してください ',
            'phone_no.min' => '電話番号は10文字以上にする必要があります。',
            'phone_no.max' => '電話番号は11文字を超えることはできません。'
        ]);
        


	    $User = User::find(Auth::user()->id);
	    $User->first_name = $request->first_name;
	    $User->last_name = $request->last_name;

			// $user->phonetic_first = $request->phonetic1;
			// $user->phonetic_last = $request->phonetic2;

        $User->phonetic_first = $request->phonetic1;
        $User->phonetic_last = $request->phonetic2;


	    if ($request->hasFile('pic')) {
            $extension = $request->pic->extension();
            $name = time().rand(1000,9999).'.'.$extension;
            // $path = $request->image->storeAs('products', $name);
            $img = Image::make($request->pic)->resize(300, 300);
            $img->save(public_path().'/uploads/profile/'.$name, 60);
            $User->pic = 'profile/'.$name;
        }

        $User->shipping_address = $request->address;
        $User->shipping_municipility = $request->municipility;
        $User->shipping_prefecture = $request->prefectures;
        $User->shipping_room_num = $request->room_no;
        $User->shipping_postal_code = $request->postal_code;
        $User->shipping_phone_num = $request->phone_no;

        $User->save();

        $Profile = Profile::where('user_id', $User->id)->first();
        if(!$Profile){
            $Profile = new Profile();
            $Profile->user_id = $User->id;
        }

        

        $Profile->phonetic = $request->phonetic;
		$Profile->phonetic2 = $request->phonetic2;

        $Profile->url = $request->url;
        $Profile->profile = $request->profile;
        // $Profile->dob = date("Y-m-d", strtotime($request->birth_year.'-'.$request->birth_month.'-'.$request->birth_day));
        $Profile->dob = $request->dob;
        $Profile->postal_code = $request->postal_code;
        $Profile->prefectures = $request->prefectures;
        $Profile->municipility = $request->municipility;
        $Profile->address = $request->address;
        $Profile->room_no = $request->room_no;
        $Profile->phone_no = $request->phone_no;
        $Profile->sex = $request->sex;
        $Profile->save();
        //send mail to user
        $emailData = [
            'name' => '',
            'register_token' => $User->register_token,
            'subject' => '【Crofun】アカウントの変更完了のお知らせ',
            'from_email' => 'noreply@crofun.com',
            'from_name' => 'CROFUN',
            'template' => 'user.email.5',
            'root'     => $request->root(),
            'email'     => $User->email,
            'your_name' =>  $User->first_name.' '.$User->last_name,
            'birth_date'  => '',
            'address' => $Profile->address,
            'phone_number' => $Profile->phone_no,
            

        ];

        Mail::to($User->email)
            ->send(new Common($emailData));

         //send mail to admin
         $emailData = [
            'name' => '',
            'register_token' => $User->register_token,
            'subject' => '【Crofun　管理者用】アカウントの変更通知',
            'from_email' => 'noreply@crofun.com',
            'from_name' => 'CROFUN',
            'template' => 'user.email.6',
            'root'     => $request->root(),
            'email'     => 'administrator@crofun.jp',
            'person_name' =>  $User->first_name.' '.$User->last_name,
            'birth_date'  => '',
            'address' => $Profile->address,
            'phone_number' => $Profile->phone_no,
            

        ];

        Mail::to('administrator@crofun.jp')
            ->send(new Common($emailData));
        


        return redirect()->back()->with('success', 'プロフィール情報を更新完了です。');

    }

    public function emailChange(Request $request)
    {
    	return view('user.change_email');
    }

    public function emailChangeAction(Request $request)
    {
    	$this->validate($request, [
            'email' => 'required|email|confirmed|unique:users,email,'.Auth::user()->id
        ],[
            'email.email' => '正しいメールアドレスを入力してください。'
        ]);
        $old_email = Auth::user()->email;
	    $User = User::find(Auth::user()->id);
	    $User->email = $request->email;
        $User->save();
        

        $emailData = [
            'name' => Auth::user()->first_name.' '.Auth::user()->last_name,
            'contact_person' => 'Smith',
            'subject' => '【Crofun】アカウントの変更完了のお知らせ',
            'from_email' => 'noreply@crofun.com',
            'from_name' => 'CROFUN',
            'template' => 'user.email.update_email',
            'root'     => $request->root(),
            'email'     => $request->email
        ];

        Mail::to($request->email)
            ->send(new Common($emailData));
        Mail::to($old_email)
            ->send(new Common($emailData));

	    return redirect()->back()->with('success_message', 'メールアドレスが更新されました');
    }


    public function sendMessage(Request $request)
    {

        $Message = new Message();
        $Message->to_id = $request->to_id;
        $Message->from_id = Auth::user()->id;
        $Message->subject = $request->subject;
        $Message->message = $request->message;
        $Message->save();
        //send mail to msg receiver
        $Receiver = User::find($Message->to_id);
        $emailData = [
            'name' => '',
            'register_token' =>'',
            'subject' => '【Crofun】メッセージ受信のお知らせ',
            'from_email' => 'noreply@crofun.com',
            'from_name' => 'CROFUN',
            'template' => 'user.email.12',
            'root'     => $request->root(),
            'email'     => 'dev17red@gmail.com',
    
            ];
    
            Mail::to('dev17red@gmail.com')
                ->send(new Common($emailData));
        return redirect()->back()->with('success', 'Message sent successfully');
    }

    public function inboxMessage(Request $request)
    {
        $data['messages'] = Message::where('to_id', Auth::user()->id)->where('is_deleted', false)->orderBy('created_at', 'desc')->paginate(20);
        // return view('user.read_message', $data);
				return view('user.message_inbox', $data);

    }

    public function sentMessage(Request $request)
    {
        $data['messages'] = Message::where('from_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(20);
        // return view('user.read_message', $data);
				return view('user.message_inbox', $data);

    }
    
    public function trashMessage(Request $request)
    {
        $data['messages'] = Message::where('to_id', Auth::user()->id)->where('is_deleted', true)->orderBy('created_at', 'desc')->paginate(20);
        // return view('user.read_message', $data);
				return view('user.message_inbox', $data);

    }


		public function showMessage(Request $request){
            $messages = Message::where('id', $request->id)->first();
            $messages->is_read = true;
            $messages->save();

			$from = User::where('id', $messages->from_id)->first();
			$data['messages'] = $messages;
			$data['from'] = $from;


			return view('user.show-message', $data);
		}
		public function replyMessage(Request $request){
            // dd($request->input('reply_message_id'));
			$messageReply = new Message();
			$messageReply->subject = $request->input('subject');
			$messageReply->to_id = $request->input('to_id');
			$messageReply->reply_message_id = $request->input('reply_message_id');

			$messageReply->from_id = Auth::user()->id;
			$messageReply->message = $request->input('message');
            // dd($messageReply);
			$messageReply->save();



			return redirect()->back()->with('success', '返信メッセージを送信しました');
		}
		public function deleteMessage(Request $request){
			Message::where('id', $request->id)->update(['is_deleted' => true]);
			return redirect()->back();
		}
		public function deleteMultipleMessage(Request $request){
            $delete = $request->input('delete');
            if(!empty($delete)){
                Message::whereIn('id', $delete)->where('is_deleted', true)->delete();
                Message::whereIn('id', $delete)->where('is_deleted', false)->update(['is_deleted' => true]);
                
            }
			return redirect()->back();
		}

    public function shippingAddressUpdate()
    {
        $data['user'] = User::find(Auth::user()->id);
        return view('user.shipping_address', $data);
    }

    public function shippingAddressUpdateAction(Request $request)
    {
        $this->validate($request, [
            //'first_name' => 'required|max:10',
            //'last_name' => 'required|max:10',
            //'phonetic' => 'required|regex:/[\x{30A0}-\x{30FF}]/u',
           // 'phonetic2' => 'required|regex:/[\x{30A0}-\x{30FF}]/u',
            //'url' => 'nullable|url',
            // 'profile' => 'required',
            // 'birth_year' => 'required',
            // 'birth_month' => 'required',
            // 'birth_day' => 'required',
            //'postal_code' => 'required',
            // 'division' => 'required',
            // 'municipility' => 'required',
            // 'address' => 'required',
            // 'room_no' => 'required',
            // 'phone_no' => 'required|min:10|max:11',
            // 'sex' => 'required'
            'shipping_phone_num' => ['min:10','max:11']
        ],[
           // 'phonetic.regex' => 'カタカナで入力してください ',
            //'phonetic2.regex' => 'カタカナで入力してください ',
            'phone_no.min' => '電話番号は10文字以上にする必要があります。',
            'phone_no.max' => '電話番号は11文字を超えることはできません。'
        ]);
        $User = User::find(Auth::user()->id);

        $User->shipping_address = $request->input('shipping_address');
        $User->shipping_municipility = $request->input('shipping_municipility');
        $User->shipping_prefecture = $request->input('prefectures');
        $User->shipping_room_num = $request->input('shipping_room_num');
        $User->shipping_postal_code = $request->input('shipping_postal_code');
        $User->shipping_phone_num = $request->input('shipping_phone_num');
				//
        $User->first_name = $request->input('first_name');
        $User->last_name = $request->input('last_name');
				//
				//
        $User->save();

        $User->profile->phonetic = $request->input('phonetic1');
        $User->profile->phonetic2 = $request->input('phonetic2');
        $User->profile->save();
        
        return redirect()->back()->with('success', '配送先情報を更新完了です。');
				// return $User->shipping_prefecture;
    }

    public function quitMembership()
    {
        return view('user.quit_membership');
    }

    public function quitMembershipUpdate(Request $request)
    {
        // $this->validate($request, [
        //     'checkbox' => 'required'
        // ]);

        $User = User::find(Auth::user()->id);
        $User->quit_request = true;
        $User->save();
        // Auth::logout();
        return redirect()->back()->with('success_message', 'Your request is submitted,we will get back to you soon.');
    }

    public function social(Request $request)
    {
        return view('user.social');
    }

    public function mypage(Request $request)
    {
				$user_id = Auth::user()->id;
				$user = User::where('id', Auth::user()->id)->with('profile')->first();
				$data['user'] = $user;
				
				$projects = Project::where('user_id', $user_id )->with('favourite')->get();
				// $project_data = array();
				// $i = 0;
				// foreach ($projects as $project) {
				// 	$project_data[$i][0] = $project;
				// 	$project_data[$i][1] = Investment::where('project_id', $project->id)->count();
				// 	$i++;
				// }
				// dd($projects);

				$data['projects'] = $projects;
				$data['products'] = Product::where('user_id', $user_id )->get();
				$invested_projects = Project::whereIn('status', [1,3])->whereHas('investment', function ($query) {
						$query->where('user_id', Auth::user()->id)->where('status', 1);
				})->orderBy('created_at', 'desc')->get();
				// $invested_project_data = array();
				// $i = 0;
				// foreach ($invested_projects as $invested_project) {
				// 	$invested_project_data[$i][0] = $invested_project;
				// 	$invested_project_data[$i][1] = Investment::where('project_id', $invested_project->id)->count();
				// 	$i++;
				// }
				$data['invested_projects'] = $invested_projects;

				// $data['orders'] = Order::where('user_id', $user_id )->with('details')->get();
				$data['OrderDetails'] = OrderDetail::where('status', 1)->whereHas('order', function($q){
                            $q->where('user_id', Auth::user()->id)->where('status', 1);
                        })->get();


				// dd($data['orders']);
				// return $user;

        return view('user.my_page', $data);
    }
}
