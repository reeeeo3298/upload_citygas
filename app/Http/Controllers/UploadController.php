<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
//use Excel;

class UploadController extends Controller
{
    /**
     * ログイン画面表示
     */
    public function index(){
       
        return view('login.index');
    }
    
    /**
     * ログイン処理
     */
    public function login(Request $request){

      $staff_cd = $request->input('staff_cd');

      $result = DB::table('m_staff')
                ->where('staff_cd',$staff_cd)
                ->first();

      if($result == ''){
        return back()->with('message','入力された社員コードの登録がありません。');
      }else{

        //セッション追加
        session(['code' => $result->staff_cd, 'name' => $result->staff_name]);
        
        //データ取得
        $results = $this->data_all();
        
//        dd($results);

        return view('main.index',compact('results'));
      }
    }
    
    /**
     * お客様一覧画面表示
     */
    public function list_index(){
                
        //データ取得
        $results = $this->data_all();
       
        return view('main.index',compact('results'));
    }
    
    /**
     * お客様検索処理
     */
    public function search_index(Request $request){
        
        $all = $request->all();
        
        //セッション追加
        session(['search_data' => $all]);
                
        $upload_date = $request->input('upload_date');
        $update_user = $request->input('staff_cd');
        $last_name = $request->input('last_name');
        $first_name = $request->input('first_name');
        $last_name_kana = $request->input('last_name_kana');
        $first_name_kana = $request->input('first_name_kana');
        $supply_no = $request->input('supply_no');
        $mail_address = $request->input('mail_address');
        $status_cd = $request->input('status_cd');
        $area_type = $request->input('area_type');
                
        $startdate = substr($upload_date,0,10);
        $enddate = substr($upload_date,13,23);
                
        $list = DB::table('t_data as td')
                    ->join('m_area as ma','td.area_cd','=','ma.area_id');

        if($update_user !== null){
            $list->where('td.update_user',$update_user);
        }
        if($last_name !== null){
            $list->where('td.last_name',$last_name);
        }
        if($first_name !== null){
            $list->where('td.first_name',$first_name);
        }
        if($last_name_kana !== null){
            $list->where('td.last_name_kana',$last_name_kana);
        }
        if($first_name_kana !== null){
            $list->where('td.first_name_kana',$first_name_kana);
        }
        if($supply_no !== null){
            $list->where('td.supply_no',$supply_no);
        }
        if($mail_address !== null){
            $list->where('td.mail_address',$mail_address);
        }
        if($status_cd !== null){
            $list->where('td.status',$status_cd);
        }
        if($area_type !== null){
            $list->where('td.area_cd',$area_type);
        }
        
        $results = $list->whereBetween('add_date',["$startdate", "$enddate"])
                ->get();
                
        //データ取得
//        $results = $this->data_all();
       
        return view('main.index',compact('results'));
    }
    
    /**
     * お客様情報csv出力
     */
    public function csv_index(Request $request){
        
        $search_data = $request->session()->get('search_data');
                
        $upload_date = $search_data['upload_date'];
        $update_user = $search_data['update_user'];
        $last_name = $search_data['last_name'];
        $first_name = $search_data['first_name'];
        $last_name_kana = $search_data['last_name_kana'];
        $first_name_kana = $search_data['first_name_kana'];
        $supply_no = $search_data['supply_no'];
        $mail_address = $search_data['mail_address'];
        $status_cd = $search_data['status_cd'];
        $area_type = $search_data['area_type'];
                
        $startdate = substr($upload_date,0,10);
        $enddate = substr($upload_date,13,23);
                
        $list = DB::table('t_data as td')
                    ->join('m_area as ma','td.area_cd','=','ma.area_id');

        if($update_user !== null){
            $list->where('td.update_user',$update_user);
        }
        if($last_name !== null){
            $list->where('td.last_name',$last_name);
        }
        if($first_name !== null){
            $list->where('td.first_name',$first_name);
        }
        if($last_name_kana !== null){
            $list->where('td.last_name_kana',$last_name_kana);
        }
        if($first_name_kana !== null){
            $list->where('td.first_name_kana',$first_name_kana);
        }
        if($supply_no !== null){
            $list->where('td.supply_no',$supply_no);
        }
        if($mail_address !== null){
            $list->where('td.mail_address',$mail_address);
        }
        if($status_cd !== null){
            $list->where('td.status',$status_cd);
        }
        if($area_type !== null){
            $list->where('td.area_cd',$area_type);
        }
        
        $results = $list->whereBetween('add_date',["$startdate", "$enddate"])
                ->get();
        $csv_list = (json_decode(json_encode($results), true));
        
//        dd($results);
        
        $csvHeader = ['申込み日', '取引先名（姓）','取引先名（名）','取引先名カナ（姓）','取引先名カナ（名）',
                    '取引先郵便番号','取引先都道府県','取引先市区郡','取引先町名・番地','取引先名建物名',
                    '取引先部屋番号','取引先メールアドレス','取引先連絡先１市外局番','取引先連絡先１市内局番',
                    '取引先連絡先１加入者番号','需要者名（姓）','需要者名（名）','需要者名カナ（姓）','需要者名カナ（名）',
                    '需要者郵便番号','需要者都道府県','需要者市区郡','需要者町名・番地','需要者名建物名','需要者部屋番号',
                    '需要者メールアドレス','需要者連絡先１電話番号区分','需要者連絡先１市外局番','需要者連絡先１市内局番',
                    '需要者連絡先１加入者番号','需要者と連絡先が同一','連絡者名（姓）','連絡者名（名）','連絡者名カナ（姓）',
                    '連絡者名カナ（名）','連絡者郵便番号','連絡者都道府県','連絡者市区郡','連絡者町名・番地','連絡者名建物名',
                    '連絡者部屋番号','連絡者連絡者１電話番号区分','連絡者連絡者１市外局番','連絡者連絡者１市内局番',
                    '連絡者連絡者１加入者番号','現小売事業者','現小売事業者お客様番号','供給地点特定番号','事業所コード',
                    '地区番号','利用開始希望日','引っ越し先の利用ですか？','契約容量','Ａ容量','ＫＶＡ容量','ＫＷ容量',
                    '契約種別（料金メニュー）','支払方法','申込者名（姓）','申込者名（名）','申込者名カナ（姓）','申込者名カナ（名）',
                    '申込者携帯番号市外局番','申込者携帯番号市内局番','申込者携帯番号加入者番号','申込者電話番号市外局番',
                    '申込者電話番号市内局番','申込者電話番号加入者番号','申込者様との関係','申込者様との関係（その他）',
                    '営業所','代理店コード','キャンペーンコード'];
//        array_unshift($csv_list, $csvHeader);  
        
        $stream = fopen('php://temp', 'r+b');
        
        //ヘッダー
        fputcsv($stream, $csvHeader);
        
        //データ
        foreach ($csv_list as $list) {
//            dd($list);
          fputcsv($stream, [
                $list['add_date'],//申込日
                '',//取引先名（姓）
                '',//取引先名（名）
                '',//取引先名カナ（姓）
                '',//取引先名カナ（名）
                '',//取引先郵便番号
                '',//取引先都道府県
                '',//取引先市区郡
                '',//取引先町名・番地
                '',//取引先名建物名
                '',//取引先部屋番号
                '',//取引先メールアドレス
                '',//取引先連絡先１市外局番
                '',//取引先連絡先１市内局番
                '',//取引先連絡先１加入者番号
                $list['last_name'],//需要者名（姓）
                $list['first_name'],//需要者名（名）
                $list['last_name_kana'],//需要者名カナ（姓）
                $list['first_name_kana'],//需要者名カナ（名）
                $list['add_no'],//需要者郵便番号
                $list['add_pref'],//需要者都道府県
                $list['add_city'],//需要者市区郡
                $list['add_detail'],//需要者町名・番地
                $list['add_building'],//需要者名建物名
                $list['add_building_no'],//需要者部屋番号
                $list['mail_address'],//需要者メールアドレス
                $list['tel_division'],//需要者連絡先１電話番号区分
                $list['tel1'],//需要者連絡先１市外局番
                $list['tel2'],//需要者連絡先１市内局番
                $list['tel3'],//需要者連絡先１加入者番号
                '0',//需要者と連絡先が同一
                '',//連絡者名（姓）
                '',//連絡者名（名）
                '',//連絡者名カナ（姓）
                '',//連絡者名カナ（名）
                '',//連絡者郵便番号
                '',//連絡者都道府県
                '',//連絡者市区郡
                '',//連絡者町名・番地
                '',//連絡者名建物名
                '',//連絡者部屋番号
                '自宅',//連絡者連絡者１電話番号区分
                '',//連絡者連絡者１市外局番
                '',//連絡者連絡者１市内局番
                '',//連絡者連絡者１加入者番号
                $list['now_company'],//現小売事業者
                $list['now_customer_no'],//現小売事業者お客様番号
                $list['supply_no'],//供給地点特定番号
                '',//事業所コード
                '',//地区番号
                '',//利用開始希望日
                'いいえ',//引っ越し先の利用ですか？
                $list['contracted_capacity'],//契約容量
                $list['a_capacity'],//Ａ容量
                $list['kva_capacity'],//ＫＶＡ容量
                $list['kw_capacity'],//ＫＷ容量
                $list['plan_name'],//契約種別（料金メニュー）
                $list['payment'],//支払方法
                '',//申込者名（姓）
                '',//申込者名（名）
                '',//申込者名カナ（姓）
                '',//申込者名カナ（名）
                '',//申込者携帯番号市外局番
                '',//申込者携帯番号市内局番
                '',//申込者携帯番号加入者番号
                '',//申込者電話番号市外局番
                '',//申込者電話番号市内局番
                '',//申込者電話番号加入者番号
                '',//申込者様との関係
                '',//申込者様との関係（その他）
                '010',//営業所
                '000009',//代理店コード
                '',//キャンペーンコード
          ]);
        }
        rewind($stream);
        
        $now_dt = Carbon::now()->format('YmdHis');
        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customerlist'.$now_dt.'.csv"',
        );

        //response
        return \Response::make($csv, 200, $headers);
    }
    
    /**
     * 登録画面表示
     */
    public function add_index(Request $request){
        
        $accept_no = $request->input('accept_no');
        
        $results = DB::table('T_data as td')
//                    ->join('M_contacttype as mt','tc.type_id','=','mt.type_id')
//                    ->join('M_status as ms','tc.status_id','=','ms.status_id')
//                    ->join('M_staff as mst','tc.staff_cd','=','mst.staff_cd')
                    ->where('accept_no',$accept_no)
                    ->first();
        
        $file_type = $results->file_type;
        
//        dd($file_type);
        
        return view('add.index',compact('accept_no','results','file_type'));
    }
    
    /**
     * 登録処理
     */
    public function add_input(Request $request){
        
        $all = $request->all();
        $user = $request->session()->get('code');
        
//        dd($all);
        
        DB::table('t_data')
                ->where('accept_no',$all['accept_no'])
                ->update([
                    'supply_no' => $all['supply_no'],
                    'last_name' => $all['last_name'],
                    'first_name' => $all['first_name'],
                    'last_name_kana' => $all['last_name_kana'],
                    'first_name_kana' => $all['first_name_kana'],
                    'add_no' => $all['add_no'],
                    'add_pref' => $all['add_pref'],
                    'add_city' => $all['add_city'],
                    'add_detail' => $all['add_detail'],
                    'add_building' => $all['add_building'],
                    'add_building_no' => $all['add_building_no'],
                    'mail_address' => $all['mail_address'],
                    'tel_division' => $all['tel_division'],
                    'tel1' => $all['tel1'],
                    'tel2' => $all['tel2'],
                    'tel3' => $all['tel3'],
                    'now_company' => $all['now_company'],
                    'now_customer_no' => $all['now_customer_no'],
                    'contracted_capacity' => $all['contracted_capacity'],
                    'a_capacity' => $all['a_capacity'],
                    'kva_capacity' => $all['kva_capacity'],
                    'kw_capacity' => $all['kw_capacity'],
                    'plan_name' => $all['plan_name'],
                    'payment' => $all['payment'],
                    'campaign_cd' => $all['campaign_cd'],
                    'update_date' => Carbon::now(),
                    'update_user' => $user,
                    'status'     => 2
                ]);
        
        //データ取得
        $results = $this->data_all();
        
        return view('main.index',compact('results'));
    }
    
    /**
     * 登録保留処理
     */
    public function hold_input(Request $request){
        
        $all = $request->all();
        $user = $request->session()->get('code');
        
//        dd($all);
        
        DB::table('t_data')
                ->where('accept_no',$all['accept_no'])
                ->update([
                    'supply_no' => $all['supply_no'],
                    'last_name' => $all['last_name'],
                    'first_name' => $all['first_name'],
                    'last_name_kana' => $all['last_name_kana'],
                    'first_name_kana' => $all['first_name_kana'],
                    'add_no' => $all['add_no'],
                    'add_pref' => $all['add_pref'],
                    'add_city' => $all['add_city'],
                    'add_detail' => $all['add_detail'],
                    'add_building' => $all['add_building'],
                    'add_building_no' => $all['add_building_no'],
                    'mail_address' => $all['mail_address'],
                    'tel_division' => $all['tel_division'],
                    'tel1' => $all['tel1'],
                    'tel2' => $all['tel2'],
                    'tel3' => $all['tel3'],
                    'now_company' => $all['now_company'],
                    'now_customer_no' => $all['now_customer_no'],
                    'contracted_capacity' => $all['contracted_capacity'],
                    'a_capacity' => $all['a_capacity'],
                    'kva_capacity' => $all['kva_capacity'],
                    'kw_capacity' => $all['kw_capacity'],
                    'plan_name' => $all['plan_name'],
                    'payment' => $all['payment'],
                    'campaign_cd' => $all['campaign_cd'],
                    'update_date' => Carbon::now(),
                    'update_user' => $user,
                    'status'     => 1
                ]);
        
        //データ取得
        $results = $this->data_all();
        
        return view('main.index',compact('results'));
    }
    
    /**
     * データ取得
     */
    private function data_all(){
        
        $results = DB::table('T_data as td')
//                    ->join('M_contacttype as mt','tc.type_id','=','mt.type_id')
//                    ->join('M_status as ms','tc.status_id','=','ms.status_id')
//                    ->join('M_staff as mst','tc.staff_cd','=','mst.staff_cd')
//                    ->where('ms.status_id','1');
                    ->get();
        
        return $results;
    }
    
    /**
     * 詳細データ取得
     */
    public function data_detail(Request $request){
        
        $accept_no = $request->input('no');
        
        $results = DB::table('T_data as td')
//                    ->join('M_contacttype as mt','tc.type_id','=','mt.type_id')
//                    ->join('M_status as ms','tc.status_id','=','ms.status_id')
//                    ->join('M_staff as mst','tc.staff_cd','=','mst.staff_cd')
                    ->where('accept_no',$accept_no)
                    ->get();
        
        return $results;
    }
}
