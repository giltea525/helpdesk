{{-- layouts/contact.blade.phpを読み込む --}}
@extends('layouts.contact')

{{-- contact.blade.phpの@yield('title')に'問い合わせ新規入力'を埋め込む --}}
@section('title', '問い合わせ編集')

{{-- contact.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <h2 class="contact_title">問い合わせ編集</h2>
        <form action="{{ route('contact.edit') }}" method="post" enctype="multipart/form-data">
            
            @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="form-group row">
                <label class="col-md-4">
                    受付日
                    <input type="date" name="contact_day" value="{{ $contact_form->contact_day }}" class="form-control">
                </label>
                <label class="col-md-4">
                    所属
                    <select class="form-control" name="contact_division">
                        <option value="">所属</option>
                        <option value="学生"@if($contact_form->contact_division=="学生") {{"selected"}}@endif>学生</option>
                        <option value="教員"@if($contact_form->contact_division=="教員") {{"selected"}}@endif>教員</option>
                        <option value="事務局"@if($contact_form->contact_division=="事務局") {{"selected"}}@endif>事務局</option>
                    </select>
                </label>
            </div>
            <div class="form-group row">
                <label class="col-md-4">
                    種別
                    <select class="form-control" name="contact_category">
                        <option value="">種別</option>
                        <option value="パソコン"@if($contact_form->contact_category=="パソコン") {{"selected"}}@endif>パソコン</option>
                        <option value="iphone"@if($contact_form->contact_category=="iphone") {{"selected"}}@endif>iphone</option>
                        <option value="android"@if($contact_form->contact_category=="android") {{"selected"}}@endif>android</option>
                        <option value="プリンター"@if($contact_form->contact_category=="プリンター") {{"selected"}}@endif>プリンター</option>
                    </select>
                </label>
            </div>
            <div class="form-group row">
                <label class="col-md-12">
                    問い合わせ内容
                    <div>
                        <textarea class="form-control" name="contact_case" rows="5">{{ old('contact_case' , $contact_form->contact_case) }}</textarea>
                    </div>
                </label>
            </div>
            <div class="form-group row">
                <label class="col-md-12">
                    対応内容
                    <div>
                        <textarea class="form-control" name="contact_result" rows="5">{{ old('contact_result' , $contact_form->contact_result) }}</textarea>
                    </div>
                </label>
            </div>
            <div class="form-group row">
                <label class="col-md-10">
                    コメント
                    <textarea class="form-control" name="contact_comment" rows="2">{{ old('contact_comment' , $contact_form->contact_comment) }}</textarea>
                </label>
                <label class="col-md-2">
                    対応状況
                    <select class="form-control" name="contact_status">
                        <option value="">対応状況</option>
                        <option value="未対応"@if($contact_form->contact_status=="未対応") {{"selected"}}@endif>未対応</option>
                        <option value="対応中"@if($contact_form->contact_status=="対応中") {{"selected"}}@endif>対応中</option>
                        <option value="完了"@if($contact_form->contact_status=="完了") {{"selected"}}@endif>完了</option>
                    </select>
                </label>
            </div>
            <input type="hidden" name="id" value="{{ $contact_form->id }}">
            @csrf
            <input type="submit" class="btn btn-primary" value="更新">
        </form>
    </div>
@endsection