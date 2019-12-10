<?php
include_once 'telegram source dragon.php';
include_once 'db.php';

$send_reply_obj = new SendReply();
$insertToDb = new DataDase();


function show_menu(){

    $json_kb = json_encode($GLOBALS['reply_keyboard_options']);
    $reply = "به ربات شرکت بلک دراگون خوش آمدید لطفا یکی از گزینه هایی زیر را انتخاب کنید"
    .
        "\xf0\x9f\x91\x87"
    ;

    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
    $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $reply , 'reply_markup' =>$json_kb];

    send_reply($url, $post_params);


}
function detect_callback_recive_and_reply(){
    $callback_data = $GLOBALS['data'];
    if ($callback_data == "اطلاعات"){
        send_information_in_reply();

        $reply = "
برای مشاوره رایگان شماره ی خود را وارد کنید 
";
        $GLOBALS['send_reply_obj'] ->send_reply($reply);

    }

}
function send_information_in_reply(){
    $reply = ":سیستم صوتی و تصویری خودرو بلک دراگون
    
    فروش انواع سیستم صوتی و تصویری خودرو با نازل ترین قیمت در تمام کشور
 جهت کسب اطلاعات بیشتر گزینه ی مورد نظر را از بین دکمه های زیر انتخاب کنید
"
    .
        "\xf0\x9f\x91\x87"
    ;

    $json_kb = json_encode($GLOBALS['reply_keyboard_options_information']);
    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
    $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $reply , 'reply_markup' =>$json_kb];
    send_reply($url, $post_params);


}
function send_photo_in_reply(){
    $Photo = "sc.png";
    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendPhoto" ;
    $post_params_photo = ['chat_id' => $GLOBALS['chat_id'] ,
        'photo' => new CURLFile(realpath($Photo)),
        'caption' => "توضیحات" ,
    ];
    send_reply($url,$post_params_photo);

}
function send_phone_numbers_in_reply(){
    $reply = "
    \xf0\x9f\x91\xa5 مشاورین فروش :
    1. سیستم صوتی  :
    09360000157
    2. سیستم تصویری(مانیتور خودرو) :
    09030000461
    3. پشتیبانی پس از فروش :
    09030000461
    021-55430694
   4. هماهنگی برای خودرو های خاص :
   09122949963
   5. همانگی برای مورانو :
   09122949963
";

    $GLOBALS['send_reply_obj'] ->send_reply($reply);

}
function send_audio_in_reply(){
    $Audio = "rooz.mp3";
    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendAudio";
    $post_params_Audio = ['chat_id' => $GLOBALS['chat_id'],
        'audio' => new CURLFile(realpath($Audio)),
        'caption' =>"آهنگ تست روزبه" ,
        'title' => "آهنگ تست",
        'performer' =>"roozbeh",
    ];
    send_reply($url,$post_params_Audio);
}
function send_location_in_reply(){
    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendLocation" ;
    $post_params_Location = ['chat_id' => $GLOBALS['chat_id'],
        'latitude'=> 35.672285,
        'longitude' => 51.385332,
    ];
    send_reply($url,$post_params_Location);
}
function send_address_in_reply(){
    $reply = "
خیابان قزوین ، مقابل اداره دخانیات ، ساختمان امپراطور ، طبقه ی اول واحد 23
";
    $GLOBALS['send_reply_obj'] ->send_reply($reply);

}
function send_products_in_reply(){
    $reply = "در این لینک می توانید محصولات ما را مشاهده و خرید کنید 
    
    "
    .
        "https://dp11.ir/shop/
        
        "
    ;

    $GLOBALS['send_reply_obj'] ->send_reply($reply);
}
function send_time_work_in_reply(){
    $reply = "
شنبه تا چهارشنبه از ساعت 9 صبح تا 19 شب
پنج شنبه ها از ساعت 9 صبح تا 18 شب
";

    $GLOBALS['send_reply_obj'] ->send_reply($reply);

}
function get_number_for_moshavere_in_reply(){
    $reply = "
برای مشاوره ی رایگان عدد 2 را به شماره 
09360000157
ارسال کنید

یا با شماره 02155430694 تماس بگیرید
"
    .
    "یا شماره تلفن همراه خود را به صورت کامل وارد کنید (با عداد انگلیسی)"
    ;

    $GLOBALS['send_reply_obj'] ->send_reply($reply);

}
function off_products(){
    $reply = "در این لینک می توانید محصولات تخفیف دار را مشاهده و خرید کنید
    
    "
    .
    "https://dp11.ir/amazing-suggestions/
    
    "
    ;

    $GLOBALS['send_reply_obj'] ->send_reply($reply);

}
function send_answer_to_get_number(){
    $reply = "شماره تلفن شما با موفقیت ثبت شد";

    $GLOBALS['send_reply_obj'] ->send_reply($reply);

}

function submit_number_to_dp($text)
{

    if(strlen($text)==11 && is_numeric($text)) {

        $GLOBALS['send_reply_obj']->send_reply('ثبت شد');
    }
    $name = "mmd";
    $number = $text;
    $GLOBALS['insertToDb']->insertDB($name,$number);
}

function send_reply($url,$post_params)
{

    $cu = curl_init();
    curl_setopt($cu, CURLOPT_URL, $url);
    curl_setopt($cu, CURLOPT_POSTFIELDS, $post_params);
    curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);  // get result
    $result = curl_exec($cu);
    curl_close($cu);
    return $result;

}


class SendReply{

    function send_reply($reply) {

        $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
        $post_params = [ 'chat_id' => $GLOBALS['chat_id'], 'text' => $reply ];

        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, $url);
        curl_setopt($cu, CURLOPT_POSTFIELDS, $post_params);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);  // get result
        $result = curl_exec($cu);
        curl_close($cu);
        return $result;
    }
}

/*
 function send_address_in_reply(){
    $reply = "
خیابان قزوین ، مقابل اداره دخانیات ، ساختمان امپراطور ، طبقه ی اول واحد 23
";

    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
    $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $reply ];
    send_reply($url, $post_params);
}
 * */

?>

