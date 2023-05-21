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
}
