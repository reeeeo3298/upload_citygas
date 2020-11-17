@extends('layouts/layout')
@section('pageCss')

@endsection

@section('content')
<h1>申込情報登録画面</h1>
<div class="content-block">
    {{ Form::open(array('url' => '/','id'=>'customer_data' ,'class' => 'form-horizontal','method' => 'post')) }}
    <div class="img-block">
        <figure><img id="zoom" src="../wordpress/upload/{{$accept_no}}/img.{{$file_type}}"></figure>
        <div class="conplete_btn_block">
            <button type="button" formaction="add_complete" name="complete" class="btn btn-primary btn-lg complete_btn">登録完了</button>
        </div>
        <div class="hold_btn_block">
            <button type="button" formaction="hold_complete" name="hold" class="btn btn-success btn-lg hold_btn">登録保留</button>
        </div>
    </div>
    <div class="form-block">
        <table class="table table-bordered table-striped">
            <tbody>
                @if(!empty($results))
                <tr>
                    <th>項目</th>
                    <th>内容</th>
                </tr>
                <tr>
                    <th>供給地点特定番号</th>
                    <td><input type="text" name="supply_no" value="{{$results->supply_no}}"></td>
                </tr>
                <tr>
                    <th>お客様名(姓)</th>
                    <td><input type="text" id="last_name" name="last_name" value="{{$results->last_name}}"></td>
                </tr>
                <tr>
                    <th>お客様名(名)</th>
                    <td><input type="text" id="first_name" name="first_name" value="{{$results->first_name}}"></td>
                </tr>
                <tr>
                    <th>お客様名カナ(姓)</th>
                    <td><input type="text" id="last_name_kana" name="last_name_kana" value="{{$results->last_name_kana}}"></td>
                </tr>
                <tr>
                    <th>お客様名カナ(名)</th>
                    <td><input type="text" id="first_name_kana" name="first_name_kana" value="{{$results->first_name_kana}}"></td>
                </tr>
                <tr>
                    <th>郵便番号</th>
                    <td><input type="text" onKeyUp="AjaxZip3.zip2addr(this,'','add_pref','add_city','add_detail');" name="add_no" value="{{$results->add_no}}"></td>
                </tr>
                <tr>
                    <th>都道府県</th>
                    <td><input type="text" name="add_pref" value="{{$results->add_pref}}"></td>
                </tr>
                <tr>
                    <th>市区群</th>
                    <td><input type="text" name="add_city" value="{{$results->add_city}}"></td>
                </tr>
                <tr>
                    <th>町名・番地</th>
                    <td><input type="text" name="add_detail" value="{{$results->add_detail}}"></td>
                </tr><tr>
                    <th>建物名</th>
                    <td><input type="text" name="add_building" value="{{$results->add_building}}"></td>
                </tr>
                <tr>
                    <th>部屋番号</th>
                    <td><input type="text" name="add_building_no" value="{{$results->add_building_no}}"></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><input type="text" name="mail_address" value="{{$results->mail_address}}"></td>
                </tr>
                <tr>
                    <th>電話番号区分</th>
                    <td><input type="text" name="tel_division" value="{{$results->tel_division}}"></td>
                </tr>
                <tr>
                    <th>電話番号１</th>
                    <td><input type="text" name="tel1" value="{{$results->tel1}}"></td>
                </tr>
                <tr>
                    <th>電話番号２</th>
                    <td><input type="text" name="tel2" value="{{$results->tel2}}"></td>
                </tr>
                <tr>
                    <th>電話番号３</th>
                    <td><input type="text" name="tel3" value="{{$results->tel3}}"></td>
                </tr>
                <tr>
                    <th>現小売事業者名</th>
                    <td><input type="text" name="now_company" value="{{$results->now_company}}"></td>
                </tr>
                <tr>
                    <th>現小売事業者お客様番号</th>
                    <td><input type="text" name="now_customer_no" value="{{$results->now_customer_no}}"></td>
                </tr>
                <tr>
                    <th>契約容量</th>
                    <td>
                    @if(empty($results->contracted_capacity))
                    <select id="select_type" name="contracted_capacity" class="form-control">
                        <option value="A">A</option>
                        <option value="KVA">KVA</option>
                    </select>
                    @else
                    <input type="text" name="contracted_capacity" value="{{$results->contracted_capacity}}"></td>
                    @endif
                </tr>
                <tr>
                    <th>A容量</th>
                    <td><input type="text" name="a_capacity" value="{{$results->a_capacity}}"></td>
                </tr>
                <tr>
                    <th>KVA容量</th>
                    <td><input type="text" name="kva_capacity" value="{{$results->kva_capacity}}"></td>
                </tr>
                <tr>
                    <th>KW容量</th>
                    <td><input type="text" name="kw_capacity" value="{{$results->kw_capacity}}"></td>
                </tr>
                <tr>
                    <th>料金メニュー</th>
                    <td><input type="text" name="plan_name" value="{{$results->plan_name}}"></td>
                </tr>
                <tr>
                    <th>支払方法</th>
                    <td><input type="text" name="payment" value="{{$results->payment}}"></td>
                </tr>
                <tr>
                    <th>キャンペーンCD</th>
                    <td><input type="text" name="campaign_cd" value="{{$results->campaign_cd}}"></td>
                </tr>
                <input type="hidden" name="accept_no" id="accept_no" value="{{$results->accept_no}}">
                {{ Form::close() }}
                @endif
            </tbody>
        </table>
    </div>
    
</div>
@endsection

@section('pageJs')

@endsection
