@extends('layouts/layout')
@section('pageCss')
<link rel="stylesheet" type="text/css" href="public/css/plugin/daterangepicker.css">
@endsection

@section('content')
<h1>申込情報管理画面</h1>
    <!-- フラッシュメッセージ -->
        @if(session()->has('flash_message_success'))
            <div class="alert alert-success mb-3">
                {{session('flash_message_success')}}
            </div>
        @endif
        @if(session()->has('flash_message_danger'))
            <div class="alert alert-danger mb-3">
                {{session('flash_message_danger')}}
            </div>
         @endif
    <div class="customer_manegement_block panel panel-default">
         <div class="panel-heading">お客様情報検索</div>
           <div class="panel-body"> 
             {{ Form::open(array('url' => '/customer_search','id'=>'customer_search_detail' ,'class' => 'form-horizontal','method' => 'get')) }}
             <div class="form-group">
                 <div class="col-sm-6 form_date">
                     <div class="col-sm-3">申込期間</div>
                     <div class="col-sm-5 form-inline" style="padding: 3px;">
                       <input type="text" class="form-control upload_date" name="upload_date" id="upload_date" size="30" />
                     </div>
                 </div>

                 <div class="col-sm-6 form_staff">
                     <div class="col-sm-3">担当</div>
                     <div class="col-sm-5 form-inline dropdown" style="padding: 3px;">
                         <input type="text" class="form-control update_user" name="update_user" id="update_user" size="10" placeholder="社員番号" />
                     </div>
                 </div>
             </div>
             <div class="form-group">
                 <div class="col-sm-6 form_status">
                     <div class="col-sm-3">名前</div>
                     <div class="col-sm-5 form-inline name_form_width" style="padding: 3px;">
                        姓<input type="text" class="form-control last_name" name="last_name" id="last_name" placeholder="" />
                     </div>
                     <div class="col-sm-5 form-inline name_form_width" style="padding: 3px;">
                        名<input type="text" class="form-control first_name" name="first_name" id="first_name" placeholder="" />
                     </div>
                 </div>

                 <div class="col-sm-6 form_type">
                     <div class="col-sm-3">名前(カナ)</div>
                     <div class="col-sm-5 form-inline name_form_width" style="padding: 3px;">
                        姓<input type="text" class="form-control last_name_kana" name="last_name_kana" id="last_name_kana" placeholder="" />
                     </div>
                     <div class="col-sm-5 form-inline name_form_width" style="padding: 3px;">
                        名<input type="text" class="form-control first_name_kana" name="first_name_kana" id="first_name_kana" placeholder="" />
                     </div>
                 </div>
             </div>
             <div class="form-group">
                 <div class="col-sm-6 form_status">
                     <div class="col-sm-3">地点特定番号</div>
                     <div class="col-sm-5 form-inline dropdown" style="padding: 3px;">
                        <input type="text" class="form-control supply_no" name="supply_no" id="supply_no" size="22" placeholder="" />
                     </div>
                 </div>

                 <div class="col-sm-6 form_type">
                     <div class="col-sm-3">メールアドレス</div>
                     <div class="col-sm-5 form-inline dropdown" style="padding: 3px;">
                        <input type="text" class="form-control mail_address" name="mail_address" id="mail_address" placeholder="" />
                     </div>
                 </div>
             </div>
             <div class="form-group">
                 <div class="col-sm-6 form_status">
                     <div class="col-sm-3">ステータス</div>
                     <div class="col-sm-5 form-inline dropdown" style="padding: 3px;">
                       <select id="select_status" name="status_cd" class="form-control">
                         <option value="">すべて</option>
                         <option value="0">未登録</option>
                         <option value="1">編集中</option>
                         <option value="2">登録済</option>
                       </select>
                     </div>
                 </div>

                 <div class="col-sm-6 form_type">
                     <div class="col-sm-3">供給エリア</div>
                     <div class="col-sm-5 form-inline dropdown" style="padding: 3px;">
                       <select id="select_type" name="area_type" class="form-control">
                         <option value="">すべて</option>
                         <option value="2">東北</option>
                         <option value="3">東京</option>
                         <option value="4">中部</option>
                         <option value="5">北陸</option>
                         <option value="6">関西</option>
                         <option value="7">中国</option>
                         <option value="8">四国</option>
                         <option value="9">九州</option>
                       </select>
                     </div>
                 </div>
             </div>
            

             <div class="btn_block">
                 <button type="submit" id="search_btn" class="btn btn-primary">検索</button>
                 <button type="reset" id="reset_btn" style="margin-left: 10px;" class="btn btn-default">リセット</button>
             </div>
             {{ Form::close() }}
           </div>
    </div>
    <div class="middle_block">
        <div class="csv_output">
            {{Form::open(array('url' => '/csv','id'=>'csv_output' ,'class' => 'form-horizontal','method' => 'get')) }}
                <button type="submit" class="btn btn-success btn-xm csv_btn">csv出力</button>
                <input type="hidden" name="search_results" value="{{$results}}">
            {{ Form::close() }}
        </div>
    </div>
    <div class="content_list">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>受付No</th>
                    <th>ステータス</th>
                    <th>申込日時</th>
                    <th>お客様名</th>
                    <th>電話番号</th>
                    <th>メールアドレス</th>
                    <th>供給地点特定番号</th>
                    <th>料金プラン</th>
                    <th>契約容量</th>
                    <th>支払方法</th>
                    <th>処理</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($results))
                @foreach($results as $r)
                <tr data-no="{{$r->accept_no}}">
                    <td class="accept_no"><p>{{$r->accept_no}}</p></td>
                    <td class="status">
                        <p>
                            @switch($r->status)
                                @case(0)
                                    未登録
                                    @break
                                @case(1)
                                    編集中
                                    @break
                                @case(2)
                                    登録済
                                    @break
                            @endswitch
                        </p>
                    </td>
                    <td class="add_date"><p>{{$r->add_date}}</p></td>
                    <td class="name"><p>{{$r->last_name}}{{$r->first_name}}</p></td>
                    <td class="tel"><p>{{$r->tel1}}{{$r->tel2}}{{$r->tel3}}</p></td>
                    <td class="mail_address"><p>{{$r->mail_address}}</p></td>
                    <td class="supply_no"><p>{{$r->supply_no}}</p></td>
                    <td class="plan_name"><p>{{$r->plan_name}}</p></td>
                    <td class="a_capacity"><p>{{$r->a_capacity}}</p></td>
                    <td class="payment"><p>{{$r->payment}}</p></td>
                    <td>
                        <div class="detail_btn_block">
                            <button type="button" class="btn btn-info btn-xs detail_btn">詳細</button>
                        </div>
                        <div class="add_btn_block">
                            {{Form::open(array('url' => '/add','id'=>'add_view' ,'class' => 'form-horizontal','method' => 'get')) }}
                                <button type="submit" class="btn btn-success btn-xs add_btn">登録</button>
                                <input type="hidden" name="accept_no" id="accept_no" value="{{$r->accept_no}}">
                            {{ Form::close() }}
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div id="detail_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <h3>お客様情報内容確認</h3>
                <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>項目</th>
                    <th>内容</th>
                </tr>
                <tr>
                    <th>供給地点特定番号</th>
                    <td><span id="supply_no_modal"></span></td>
                </tr>
                <tr>
                    <th>お客様名</th>
                    <td><span id="name"></span></td>
                </tr>
                <tr>
                    <th>お客様名カナ</th>
                    <td><span id="name_kana"></span></td>
                </tr>
                <tr>
                    <th>郵便番号</th>
                    <td><span id="add_no"></span></td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td><span id="address"></span></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><span id="mail_address_modal"></span></td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td><span id="tel_number"></span></td>
                </tr>
                <tr>
                    <th>現小売事業者名</th>
                    <td><span id="now_company"></span></td>
                </tr>
                <tr>
                    <th>現小売事業者お客様番号</th>
                    <td><span id="now_customer_no"></span></td>
                </tr>
                <tr>
                    <th>契約容量</th>
                    <td><span id="contracted_capacity"></span></td>
                </tr>
                <tr>
                    <th>A容量</th>
                    <td><span id="a_capacity"></span></td>
                </tr>
                <tr>
                    <th>KVA容量</th>
                    <td><span id="kva_capacity"></span></td>
                </tr>
                <tr>
                    <th>KW容量</th>
                    <td><span id="kw_capacity"></span></td>
                </tr>
                <tr>
                    <th>料金メニュー</th>
                    <td><span id="plan_name"></span></td>
                </tr>
                <tr>
                    <th>支払方法</th>
                    <td><span id="payment"></span></td>
                </tr>
                <tr>
                    <th>キャンペーンCD</th>
                    <td><span id="campaign_cd"></span></td>
                </tr>
            </tbody>
        </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('pageJs')

@endsection
