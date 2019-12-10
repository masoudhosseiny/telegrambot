<?php

// https://api.telegram.org/bot831820820:AAFyKhtDW4j6m4pzm10Kk_BrsIJFEPRyQv4/setwebhook?url=https://exercism.ir/telegrambot/telegram source dragon.php

//----------data base---------------------------

include_once 'dp.php';

//------------------------------------
$update = file_get_contents("php://input");

$update_array = json_decode($update, true);  // JSON

if( isset($update_array["message"]) ) {

    $text    = $update_array["message"]["text"];
    $chat_id = $update_array["message"]["chat"]["id"];
}
else if(isset($update_array["callback_query"])){
$text = $update_array["callback_query"]["data"];
$callback_query_id = $update_array["callback_query"]["id"];
$chat_id = $update_array["callback_query"]["message"]["chat"]["id"];
$detect_callback_recive_and_reply();
}

//-------------------------------------

//$reply = "پیام شما: ". $GLOBALS['text'] . " برای مشاوره ی رایگان در مورد سیستم صوتی خودرو با شماره ی 09122949963 تماس حاصل فرماییدیا به آی دی @j000222 پیام دهید";
//---- address
$Token = "831820820:AAFyKhtDW4j6m4pzm10Kk_BrsIJFEPRyQv4";
$BotUrl ="https://api.telegram.org/bot" ;

//----------دکمه ها---
$products = 'محصولات';
$offsproducts = 'محصولات تخفیف دار';
$information = 'اطلاعات';
$moshavere = 'مشاوره ی رایگان';
$location = 'مکان ما روی نقشه(لوکیشن)';
$phones = 'شماره تلفن';
$address = 'آدرس';
$time_work = 'ساعات کار';
$mainMenu = 'منو اصلی';


//-------چینش دکمه ها------
$reply_keyboard = [
                    [$products],
                    [$offsproducts],
                    [$information],
                    [$moshavere]
];

$reply_keyboard_information = [
    [$location],
    [$phones],
    [$address],
    [$time_work],
    [$mainMenu],

];

//------- تنظیمات دکمه ها---
$reply_keyboard_options = [
                              'keyboard' => $reply_keyboard,
                              'resize_keyboard' => true,
                              'one_time_keyboard' =>false,
];

$reply_keyboard_options_information = [
    'keyboard' => $reply_keyboard_information,
    'resize_keyboard' => true,
    'one_time_keyboard' =>false,
];

switch($text){
    case "/start"      : show_menu(); break;
    case $mainMenu     : show_menu(); break;
    case $products     : send_products_in_reply(); break;
    case $offsproducts : send_photo_in_reply(); break;
    case $information  : send_information_in_reply(); break;
    case $moshavere    : get_number_for_moshavere_in_reply(); break;
    case $location     : send_location_in_reply(); break;
    case $phones       : send_phone_numbers_in_reply();break;
    case $address      : send_address_in_reply();break;
    case $time_work      : send_time_work_in_reply();break;

}

//------------------------ارسال متن-------------
/*
$reply =  " برای مشاوره ی رایگان در مورد سیستم صوتی خودرو با شماره ی 09122949963 تماس حاصل فرمایید
یا به آی دی @j000222 پیام دهید
";

$url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
$post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $reply ];
send_reply($url, $post_params);

*/
//----دکمه شیشه ای---

$inline_keyboard =[
                     [
                         ['text' => "سایت ما" , 'url' => "https://dp11.ir"],
                         ['text' => "سایت ما" , 'url' => "https://dp11.ir"]
                     ],
                     [
                         ['text' => "سایت ما" , 'callback_data' => "/start"]
                     ],
                     [
                         ['text' => "اطلاعات" , 'callback_data' => "اطلاعات"]
                     ],
];

$inline_keyboard_options = [
                                'inline_keyboard' => $inline_keyboard
];

switch ($text){
    case "/start" : show_menu() ; break;
}
//-------ارسال عکس ---
/*

//-------ارسال ویدیو
$Video = "f.mp4";
$url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendVideo" ;
$post_params_Video = ['chat_id'=> $GLOBALS['chat_id'],
                        'video' => new CURLFile(realpath($Video)),
                        'caption' => "کپشن تست فیلم",
    ];
send_reply($url, $post_params_Video);

//----ارسال فایل
$Doc = "harmonica.pdf" ;
$url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendDocument" ;
$post_params_Doc = ['chat_id' => $GLOBALS['chat_id'],
                    'document' => new CURLFile(realpath($Doc)),
                    'caption' => "توضیحات فایل" ,

    ];
send_reply($url,$post_params_Doc);


//--------------------------

$url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendContact" ;
$post_params_Contact = ['chat_id' => $GLOBALS['chat_id'],
    'phone_number'=> "09124549822",
    'first_name' => "Masoud",
    'last_name' => "Programmer",
];
send_reply($url,$post_params_Contact);


*/

if($text == "09124549822"){
    sqlconn($text,$text);
    get_number_for_moshavere_in_reply();
    echo "done";

}


function show_menu(){
    $json_kb1 = json_encode($GLOBALS['inline_keyboard_options']);
    $json_kb = json_encode($GLOBALS['reply_keyboard_options']);
  $reply = "یکی از گزینه های زیر را انتخاب کنید1";
    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
    $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $reply , 'reply_markup' =>$json_kb];
    $post_params1 = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $reply , 'reply_markup' =>$json_kb1];
    send_reply($url, $post_params);
    send_reply($url, $post_params1);

}
function detect_callback_recive_and_reply(){
    $callback_data = $GLOBALS['data'];
    if ($callback_data == "اطلاعات"){
        send_information_in_reply();

        $reply = "
بaرای مشاوره رایگان شماره ی خود را وارد کنید 
" . $GLOBALS['chat_id'];

        $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
        $post_params = [ 'chat_id' => $GLOBALS['chat_id'], 'text' => $reply ];
        send_reply($url, $post_params);


    }

}
function send_information_in_reply(){
    $reply = ":سیستم صوتی و تصویری خودرو بلک دراگون
    
    فروش انواع سیستم صوتی و تصویری خودرو با نازل ترین قیمت در تمام کشور
 جهت کسب اطلاعات بیشتر گزینه ی مورد نظر را از بین دکمه های زیر انتخاب کنید
";

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
    مشاورین فروش :
    1. سیستم صوتی :
    02155430694
    2. سیستم تصویری :
    02155430694
    پشتیبانی پس از فروش :
    02155430694
   هماهنگی برای خودرو های خاص :
   09122949963
   همانگی برای مورانو :
   09122949963
   
   و یا با آی دی :
   @j000222

در ارتباط باشید
";

    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
    $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $reply ];
    send_reply($url, $post_params);
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

    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
    $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $reply ];
    send_reply($url, $post_params);
}
function send_products_in_reply(){}
function send_time_work_in_reply(){
    $reply = "
شنبه تا چهارشنبه از ساعت 9 صبح تا 19 شب
پنج شنبه ها از ساعت 9 صبح تا 18 شب
" . $GLOBALS['chat_id'];

    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
    $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $reply ];
    send_reply($url, $post_params);
}
function get_number_for_moshavere_in_reply(){
    $reply = "
بaرای مشاوره رایگان شماره ی خود را وارد کنید 
" . $GLOBALS['chat_id'];

    $url = $GLOBALS['BotUrl'] . $GLOBALS['Token'] . "/sendMessage";
    $post_params = [ 'chat_id' => $GLOBALS['chat_id'], 'text' => $reply ];
    send_reply($url, $post_params);
}

function send_reply($url, $post_params) {

    $cu = curl_init();
    curl_setopt($cu, CURLOPT_URL, $url);
    curl_setopt($cu, CURLOPT_POSTFIELDS, $post_params);
    curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);  // get result
    $result = curl_exec($cu);
    curl_close($cu);
    return $result;
}
?>
