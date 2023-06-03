<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//追記：Contact Modelが扱えるようになる
use App\Models\Contact;

class ContactController extends Controller
{
    //viewを表示する
    public function add()
    {
        return view('contact.create');
    }

    //テーブルにデータを格納
    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, Contact::$rules);

        $contact = new Contact;
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $contact->fill($form);
        $contact->save();

        return redirect('contact/create');
    }
    
    //一覧画面での検索　$requestはformから送信された内容が配列で入っている
    public function index(Request $request)
    {
        $contact_division = $request->contact_division;//$requestのcontact_divisionを$contact_divisionに代入する
        $contact_category = $request->contact_category;
        $contact_status = $request->contact_status;
        $freeword = $request->freeword;
        $posts = Contact::orderBy('id', 'ASC')
                ->when(!is_null($contact_division), function($q) use ($contact_division){
            	$q->where('contact_division', $contact_division);//(テーブルのカラム名，フォームで選んだ変数)
      		    })
               	->when(!is_null($contact_category), function($q) use ($contact_category){
                $q->where('contact_category',$contact_category);
                })
                ->when(!is_null($contact_status), function($q) use ($contact_status){
                $q->where('contact_status',$contact_status);
                })
			    ->when(!is_null($freeword), function($q) use ($freeword){
                $q->where('contact_case','LIKE',"%$freeword%")->orwhere('contact_result','LIKE',"%$freeword%");
                })
                ->get();
        return view('contact.index', ['posts' => $posts, 'contact_division' => $contact_division,'contact_category' => $contact_category,'contact_status' => $contact_status,'freeword' => $freeword]);
    }
    
    //編集画面
    public function edit(Request $request)
    {
        // Contact Modelからデータを取得する
        $contact = Contact::find($request->id);
        if (empty($contact)) {
            abort(404);
        }
        return view('contact.edit', ['contact_form' => $contact]);
    }

    //編集画面から送信されたフォームデータを処理する
    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Contact::$rules);
        // News Modelからデータを取得する
        $contact = Contact::find($request->id);
        // 送信されてきたフォームデータを格納する
        $contact_form = $request->all();
        unset($contact_form['_token']);

        // 該当するデータを上書きして保存する
        $contact->fill($contact_form)->save();

        return redirect('contact/index');
    }
    
}
