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
    
    //設定途中：一覧画面での検索
    public function index(Request $request)
    {
        $contact_division = $request->contact_division;
        if ($contact_division != '') {
            // 検索されたら検索結果を取得する
            $posts = Contact::where('contact_division', $contact_division)->get();
        } else {
            // それ以外はすべてのデータを取得する
            $posts = Contact::all();
        }
        return view('contact.index', ['posts' => $posts, 'contact_division' => $contact_division]);
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
