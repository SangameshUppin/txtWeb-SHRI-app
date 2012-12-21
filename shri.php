<html>
    <head>
        <meta name="txtweb-appkey" content="YOUR-APP-KEY"/>
        <title></title>
    </head>
    <body>
<?php

$URL = "http://YOUR-HOST/shri.php";
if((!isset($_GET['txtweb-mobile']) || $_GET['txtweb-mobile']=="") || (!isset($_GET['txtweb-message']) || $_GET['txtweb-message']=="")){
    echo "Welcome to the world of imagination!!<br/><br/>A personal app of 'Sangamesh Uppin'.<br/><br/>Message your queries and comments on my apps:<br/><form action='$URL' class=\"txtweb-form\" method=\"get\"><br/>ur_name, msg<input type=\"text\" name=\"txtweb-message\"><input type=\"submit\" value=\"submit\"></form>";
    exit();
}

$hashcode=$_GET['txtweb-mobile'];
$msg=htmlentities($_GET['txtweb-message'],ENT_NOQUOTES,'UTF-8');
$message = str_replace("\n", "<br/>", $msg);
if(!isset($_GET["txtweb-hashcode"])){
    $mobile=urlencode("YOUR_MOBILE_HASHCODE");
    $message="Your fan:<br/>".$message."<br/><br/>To reply:<br/><form action='$URL' class=\"txtweb-form\" method=\"get\"><br/>msg<input type=\"text\" name=\"txtweb-message\"><input type=\"hidden\" name=\"txtweb-hashcode\" value='$hashcode'><input type=\"submit\" value=\"submit\"></form>";
    send($mobile,$message,0);
    echo "Message sent to:<br/>Sangamesh Uppin<br/><br/>Thanks for your valuable feedback, If possible i'll contact you soon!";
}
else{
    $mobile=$_GET["txtweb-hashcode"];
    $message="Sangamesh:<br/>".htmlentities($message)."<br/><br/>To reply:<br/><form action='$URL' class=\"txtweb-form\" method=\"get\"><br/>msg<input type=\"text\" name=\"txtweb-message\"><input type=\"submit\" value=\"submit\"></form>";
    send($mobile,$message,0);
    echo "Message sent to:<br/>$mobile";
}
function send($mmob,$mmsg,$index){

    if($index == 10)
        return;

    $appKey = array("YOUR-APP-KEY-1",
                    "YOUR-APP-KEY-2",
                    "YOUR-APP-KEY-3"
        );


    $pubkey=urlencode("YOUR-PUB-KEY");
    $mmsg1=urlencode("<html><head><meta name='txtweb-appkey' content='$appKey[$index]'/><title>@SHRI</title></head><body>$mmsg</body></html>");
    $encode="txtweb-message=$mmsg1&txtweb-pubkey=$pubkey&txtweb-mobile=$mmob";
    $url="http://api.txtweb.com/v1/push";
    $fields = array(
            'txtweb-message'=>$mmsg1,
            'txtweb-pubkey'=>$pubkey,
            'txtweb-mobile'=>$mmob,
     );

    //url-ify the data for the POST
    foreach($fields as $key=>$value) {
        $fields_string .= $key.'='.$value.'&';
    }
    rtrim($fields_string,'&');
    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
    curl_setopt($ch,CURLOPT_POST,count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
    //execute post
    $response = curl_exec($ch);
    if(count(explode("success",$response))==1){
        $index+=1;
        send($mmsg,$mmob,$index);
    }
    //close connection
    curl_close($ch);
    return;
}
?>
</body>
</html>
