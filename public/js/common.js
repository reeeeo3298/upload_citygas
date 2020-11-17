$(function(){
    $('.complete_btn').click(function(){
        if(!confirm('登録完了でよろしいですか？')){
        return false;
        }else{
        /*　OKの時の処理 */
        $('#customer_data').attr('action','/Lpio_upload/add_complete');
        $('#customer_data').submit();
        }
    });
    $('.hold_btn').click(function(){
        if(!confirm('登録を保留しますか？')){
        return false;
        }else{
        /*　OKの時の処理 */
        $('#customer_data').attr('action','/Lpio_upload/hold_complete');
        $('#customer_data').submit();
        }
    });
    
//    詳細ボタン押下
    $('.detail_btn').on('click',function(){
        
        var no = $(this).closest('tr').data('no'); 
        
//        alert(no);
        
       //ajax処理
        $.ajax({
            url: '/lpio_upload/data_detail',
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'no': no
            }
        }).done(function(data){            
            var supply_no = data[0].supply_no === null ? "" : data[0].supply_no;
            var add_building = data[0].add_building === null ? "" : data[0].add_building;
            var last_name = data[0].last_name === null ? "" : data[0].last_name;
            var first_name = data[0].first_name === null ? "" : data[0].first_name;
            var last_name_kana = data[0].last_name_kana === null ? "" : data[0].last_name_kana;
            var first_name_kana = data[0].first_name_kana === null ? "" : data[0].first_name_kana;
            var add_no = data[0].add_no === null ? "" : data[0].add_no;
            var add_pref = data[0].add_pref === null ? "" : data[0].add_pref;
            var add_city = data[0].add_city === null ? "" : data[0].add_city;
            var add_detail = data[0].add_detail === null ? "" : data[0].add_detail;
            var add_building_no = data[0].add_building_no === null ? '' : data[0].add_building_no;
            var mail_address = data[0].mail_address === null ? "" : data[0].mail_address;
            var tel1 = data[0].tel1 === null ? "" : data[0].tel1;
            var tel2 = data[0].tel2 === null ? "" : data[0].tel2;
            var tel3 = data[0].tel3 === null ? "" : data[0].tel3;
            var now_company = data[0].now_company === null ? "" : data[0].now_company;
            var now_customer_no = data[0].now_customer_no === null ? "" : data[0].now_customer_no;
            var contracted_capacity = data[0].contracted_capacity === null ? "" : data[0].contracted_capacity;
            var a_capacity = data[0].a_capacity === null ? "" : data[0].a_capacity;
            var kva_capacity = data[0].kva_capacity === null ? "" : data[0].kva_capacity;
            var kw_capacity = data[0].kw_capacity === null ? "" : data[0].kw_capacity;
            var plan_name = data[0].plan_name === null ? "" : data[0].plan_name;
            var payment = data[0].payment === null ? "" : data[0].payment;
            var campaign_cd = data[0].campaign_cd === null ? "" : data[0].campaign_cd;
            
            $('#supply_no_modal').text(supply_no); 
            $('#name').text(last_name + first_name); 
            $('#name_kana').text(last_name_kana + first_name_kana); 
            $('#add_no').text(add_no);
            $('#address').text(add_pref + add_city + add_detail + add_building + add_building_no);  
            $('#mail_address_modal').text(mail_address); 
            $('#tel_number').text(tel1 + tel2 + tel3); 
            $('#now_company').text(now_company); 
            $('#now_customer_no').text(now_customer_no); 
            $('#contracted_capacity').text(contracted_capacity); 
            $('#a_capacity').text(a_capacity); 
            $('#kva_capacity').text(kva_capacity); 
            $('#kw_capacity').text(kw_capacity);
            $('#plan_name').text(plan_name); 
            $('#payment').text(payment); 
            $('#campaign_cd').text(campaign_cd); 
            
            console.log(supply_no);
            console.log(mail_address);
        
            $('#detail_modal').modal('show');
        });
        
    });
    
    $(function(){
      moment.locale("ja");
      $('#upload_date').daterangepicker(
        {
          ranges: {
            '今日': [moment(), moment()],
            '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '過去7日間': [moment().subtract(6, 'days'), moment()],
            '過去30日間': [moment().subtract(29, 'days'), moment()],
            '今月': [moment().startOf('month'), moment().endOf('month')],
            '先月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().startOf('month'),
          endDate: moment().endOf('month'),
          format: "YYYY-MM-DD",
          locale: { applyLabel: "OK", customRangeLabel: "カスタム"}
        },
        function(s, e){
        startdate = s.format('YYYY-MM-DD');
        enddate = e.format('YYYY-MM-DD');
      });
    });
    
    //フリガナ自動入力
    $(function() {
        $.fn.autoKana('#first_name', '#first_name_kana',{katakana:true});
        $.fn.autoKana('#last_name', '#last_name_kana',{katakana:true});
    });
    
    $(function() {
        $("#zoom").elevateZoom({
            zoomType : "lens",
            lensShape : "round",
            lensSize : 200,
            scrollZoom : true
        });
    });

    //半角➡全角に変換
//    $(function(){
//        $("#add3").change(function(){
//            var str = $(this).val();
//            str = str.replace( /[A-Za-z0-9-!"#$%&'()=<>,.?_\[\]{}@^~\\]/g, function(s) {
//                return String.fromCharCode(s.charCodeAt(0) + 65248);
//            });
//            $(this).val(str);
//        }).change();
//    });
});