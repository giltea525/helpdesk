{{-- layouts/contact.blade.phpを読み込む --}}
@extends('layouts.contact')

{{-- contact.blade.phpの@yield('title')に'問い合わせ新規入力'を埋め込む --}}
@section('title', '問い合わせ管理')

{{-- contact.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <h2>問い合わせ管理</h2>
        <form action="{{ route('contact.index') }}" method="get">
            <div class="form-group row">
                <label class="col-md-2">
                    所属
                    <select class="form-control" name="contact_division">
                        <option value="" {{--selected disabled--}}>所属</option>
                        <option value="学生" @if($contact_division=="学生") {{"selected"}}@endif>学生</option>
                        <option value="教員" @if($contact_division=="教員") {{"selected"}}@endif>教員</option>
                        <option value="事務局" @if($contact_division=="事務局") {{"selected"}}@endif>事務局</option>
                    </select>
                </label>
                <label class="col-md-2">
                    種別
                    <select class="form-control" name="contact_category">
                        <option value="" {{--selected disabled--}}>種別</option>
                        <option value="パソコン" @if($contact_category=="パソコン") {{"selected"}}@endif>パソコン</option>
                        <option value="iphone" @if($contact_category=="iphone") {{"selected"}}@endif>iphone</option>
                        <option value="android" @if($contact_category=="android") {{"selected"}}@endif>android</option>
                        <option value="プリンター" @if($contact_category=="プリンター") {{"selected"}}@endif>プリンター</option>
                    </select>
                </label>
                <label class="col-md-2">
                    対応状況
                    <select class="form-control" name="contact_status">
                        <option value="" {{--selected disabled--}}>対応状況</option>
                        <option value="未対応" @if($contact_status=="未対応") {{"selected"}}@endif>未対応</option>
                        <option value="対応中" @if($contact_status=="対応中") {{"selected"}}@endif>対応中</option>
                        <option value="完了" @if($contact_status=="完了") {{"selected"}}@endif>完了</option>
                    </select>
                </label>
                <label class="col-md-5">
                    フリーワード検索
                    <input type="text" class="form-control" name="freeword" value="{{ $freeword }}" placeholder="フリーワード">
                </label>
                <div class="col-md-1">
                    @csrf
                    <input type="hidden" name="month" value="{{$date->year.sprintf('%02d',$date->month)}}">
                    <input type="submit" class="btn btn-primary mt-4" value="検索">
                </div>
            </div>
        </form>
        @php
            if($date->month ==1){
                $lastmonth = $date->year-1;
                $lastmonth .= 12;
            }else{
                $lastmonth = $date->year;
                $lastmonth .= sprintf('%02d',$date->month-1);
            }
            if($date->month ==12){
                $nextmonth = $date->year+1;
                $nextmonth .= sprintf('%02d',1);
            }else{
                $nextmonth = $date->year;
                $nextmonth .= sprintf('%02d',$date->month+1);
            }
        @endphp
        <div>
            <a href="{{ route('contact.index',['month'=>$lastmonth]); }}"><<前月へ</a>
            {{$date->year;}}年{{ sprintf('%02d',$date->month);}}月
            <a href="{{ route('contact.index',['month'=>$nextmonth]); }}">翌月へ>></a>
            <!--<a href="#"><<前月へ</a>-->
            <!--2023年4月-->
            <!--<a href="#">翌月へ>></a>-->
        </div>
        
        <div class="row">
            <div class="list-contact col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="8%">受付日</th>
                                <th width="8%">所属</th>
                                <th width="8%">種別</th>
                                <th width="20%">問合内容</th>
                                <th width="20%">対応内容</th>
                                <th width="15%">コメント</th>
                                <th width="8%">対応状況</th>
                                <th width="8%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $contact)
                                <tr>
                                    <th>{{ $contact->id }}</th>
                                    <td>{{ $contact->contact_day }}</td>
                                    <td>{{ $contact->contact_division }}</td>
                                    <td>{{ $contact->contact_category }}</td>
                                    <td>{{ Str::limit($contact->contact_case, 250) }}</td>
                                    <td>{{ Str::limit($contact->contact_result, 250) }}</td>
                                    <td>{{ Str::limit($contact->contact_comment, 100) }}</td>
                                    <td>{{ $contact->contact_status }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route('contact.edit' , ['id' => $contact->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ route('contact.delete', ['id' => $contact->id]) }}">削除</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection