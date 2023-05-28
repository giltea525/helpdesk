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
}
