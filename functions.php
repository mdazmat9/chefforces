<?php
function take_user_to_codechef_permissions_page($config){

    $params = array('response_type'=>'code', 'client_id'=> $config['client_id'], 'redirect_uri'=> $config['redirect_uri'], 'state'=> 'xyz');
    header('Location: ' . $config['authorization_code_endpoint'] . '?' . http_build_query($params));
    die();
}

function generate_access_token_first_time($config, $oauth_details){

    $oauth_config = array('grant_type' => 'authorization_code', 'code'=> $oauth_details['authorization_code'], 'client_id' => $config['client_id'],
                          'client_secret' => $config['client_secret'], 'redirect_uri'=> $config['redirect_uri']);
    $response = json_decode(make_curl_request($config['access_token_endpoint'], $oauth_config), true);
    $result = $response['result']['data'];

    $oauth_details['access_token'] = $result['access_token'];
    $oauth_details['refresh_token'] = $result['refresh_token'];
    $oauth_details['scope'] = $result['scope'];

    return $oauth_details;
}

function generate_access_token_from_refresh_token($config, $oauth_details){
    $oauth_config = array('grant_type' => 'refresh_token', 'refresh_token'=> $oauth_details['refresh_token'], 'client_id' => $config['client_id'],
        'client_secret' => $config['client_secret']);
    $response = json_decode(make_curl_request($config['access_token_endpoint'], $oauth_config), true);
    $result = $response['result']['data'];

    $oauth_details['access_token'] = $result['access_token'];
    $oauth_details['refresh_token'] = $result['refresh_token'];
    $oauth_details['scope'] = $result['scope'];

    return $oauth_details;

}

function make_api_request($oauth_config, $path){
    $headers[] = 'Authorization: Bearer ' . $oauth_config['access_token'];
    return make_curl_request($path, false, $headers);
}


function make_curl_request($url, $post = FALSE, $headers = array())
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    if ($post) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
    }

    $headers[] = 'content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    return $response;
}
///////////////////////////////////////////////
//****************API Request ****************
///////////////////////////////////////////////

/* IDE  */
function runCode($config,$oauth_details,$sourceCode,$language,$input){
    $url = $config['api_endpoint']."ide/run";
    $headers[] = 'Authorization: Bearer ' . $oauth_details['access_token'];
    $headers[] = 'content-Type: application/json';
    $headers[] = 'Accept: application/json';
    $data=array(
        'sourceCode' => $sourceCode,
        'language' => $language,
        'input' => $input
    );
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    return $response;
}

function getstatusofcode($config,$oauth_details,$link){
    $url = $config['api_endpoint']."ide/status?link=".$link."";
    $response = make_api_request($oauth_details, $url);
    return $response;
}



/* ranklist */
function get_ranklist_of_contest_with_pageno($config,$oauth_details,$contest_code,$country,$institution){
    
    $institution = str_replace(" ","%20",$institution);
    $country = str_replace(" ","%20",$country);
    $path = $config['api_endpoint']."rankings/".$contest_code."?";
    if($country!="")
        $path=$path."&country=".$country;
    if($institution!="")
        $path=$path."&institution=".$institution;
    $response = make_api_request($oauth_details, $path);
    return $response;
}
/* countries */
function all_contries($config,$oauth_details,$search)
{
    $path = $config['api_endpoint']."country?search=".$search."&offset=0&limit=100";
    $response = make_api_request($oauth_details, $path);
    return $response;
}
/* language */
function all_language($config,$oauth_details)
{
    $path = $config['api_endpoint']."language?limit=100";
    $response = make_api_request($oauth_details, $path);
    return $response;
}


function get_submission_of_contest($config,$oauth_details,$contest_code){
    $path = $config['api_endpoint']."submissions/?contestCode=".$contest_code;
    $response = make_api_request($oauth_details, $path);
    return $response;
}

function get_problem($config,$oauth_details, $contest_code, $problem_code){
    $path = $config['api_endpoint']."contests/".$contest_code."/problems/".$problem_code;
    $response = make_api_request($oauth_details, $path);
    return $response;
}
function get_contest_details($config,$oauth_details,$contest_code){
    $path = $config['api_endpoint']."contests/".$contest_code;
    $response = make_api_request($oauth_details, $path);
    return $response;
}

function get_all_contest($config,$oauth_details){
    $path = $config['api_endpoint']."contests/";
    $response = make_api_request($oauth_details, $path);
    return $response;
}
function about_me($config,$oauth_details){
    $path = $config['api_endpoint']."users/me";
    $response = make_api_request($oauth_details, $path);
    return $response;
}


function get_ACsubmission_of_a_problem($config,$oauth_details,$contest_code,$problem_code){
    $path = $config['api_endpoint']."submissions/?result=AC&contestCode=".$contest_code."&problemCode=".$problem_code;
    $response = make_api_request($oauth_details, $path);
    return $response;
}

function get_all_submission_of_a_problem_with_pageno($config,$oauth_details,$contest_code,$problem_code,$page_no){
    $offset=($page_no-1)*20;
    // $path = $config['api_endpoint']."submissions/?problemCode=".$problem_code."&offset=".$offset."&limit=20&contestCode=".$contest_code;
    $path = $config['api_endpoint']."submissions/?problemCode=".$problem_code."&contestCode=".$contest_code."&limit=20&offset=".$offset;
    $response = make_api_request($oauth_details, $path);
    return $response;
}

function get_all_submission_of_a_user_on_a_problem_with_pageno($config,$oauth_details,$contest_code,$problem_code,$page_no,$username){
    $offset=($page_no-1)*20;
    $path = $config['api_endpoint']."submissions/?username=".$username."&problemCode=".$problem_code."&contestCode=".$contest_code."&limit=20&offset=".$offset;
    $response = make_api_request($oauth_details, $path);
    return $response;
}
/////////////////////////////////////////
//****** Main *********************
/////////////////////////////////////////

function main(){
    $config = array('client_id'=> '1b8c33e6eef081de44e4edd8425e6803',
        'client_secret' => 'f64f78dd4bd1027bb54d6ab797cbba79',
        'api_endpoint'=> 'https://api.codechef.com/',
        'authorization_code_endpoint'=> 'https://api.codechef.com/oauth/authorize',
        'access_token_endpoint'=> 'https://api.codechef.com/oauth/token',
        'redirect_uri'=> 'http://localhost/chefforces/index.php',
        'website_base_url' => 'http://localhost/chefforces/index.php',
        'user_name' => 'mdazmat9');

    $oauth_details = array('authorization_code' => '',
        'access_token' => '',
        'refresh_token' => '');
    
    if(isset($_GET['code'])){
        $oauth_details['authorization_code'] = $_GET['code'];
        $oauth_details = generate_access_token_first_time($config, $oauth_details);
        $ret['config']=$config;
        $ret['outh']=$oauth_details;
//        $response = make_contest_problem_api_request($config, $oauth_details);
//        $result=json_decode($response,true);
//        return $result;
//        echo ($result['result']['data']['content']['body']);
        //        $oauth_details = generate_access_token_from_refresh_token($config, $oauth_details);         //use this if you want to generate access_token from refresh_token
        
    } else{
        take_user_to_codechef_permissions_page($config);
    }
     return $ret;
}

///////////////////////////////////////////
// ********** Database Code ****************
////////////////////////////////////////////

function getDBconnection(){
        $DB_SERVER='localhost';
        $DB_USER = 'root';
        $DB_PASSWORD = "";
        $DB_DATABASE = 'codechef';
        // define("DB_SERVER", "localhost");
        // define("DB_USER", "root");
        // define("DB_PASSWORD", "");
        // define("DB_DATABASE", "codechef");
        $con = mysqli_connect($DB_SERVER , $DB_USER, $DB_PASSWORD, $DB_DATABASE);
        return $con;
}
function fillDB(){
        $con=getDBconnection();
       $result=json_decode(get_all_contest($_SESSION['config'],$_SESSION['outh']),true);
        $sql="INSERT INTO contest (name,code) VALUES (";
        if(!$con){
            die('Could not connect');
        }
        $tbl="CREATE TABLE contest(
            name varchar(50) primary key,
            code varchar(20)
            )" ;
        mysqli_query($con,$tbl);
        foreach($result['result']['data']['content']['contestList'] as $x){
            $code=$x['code'];
            $name=$x['name'];
            $ex=$sql."'".$code."'".","."'".$code."'".")";
//            echo $ex;
            $row=mysqli_query($con,$ex);
            $ex=$sql."'".$name."'".","."'".$code."'".")";
            $row=mysqli_query($con,$ex);
//            echo $ex;
        }
}
function fillcountry(){
    $con=getDBconnection();
    if(!$con){
        die('Could not connect');
    }
   $tbl=" CREATE TABLE country(
            name varchar(50) primary key,
            code varchar(25)
            )";
    mysqli_query($con,$tbl);
    $sql="INSERT INTO country (name,code) VALUES (";

    for($search='a';$search<='z';$search++){
    $result=json_decode(all_contries($_SESSION['config'],$_SESSION['outh'],$search),true);
    foreach($result['result']['data']['content'] as $x){
        $name=$x['countryName'];
        $code=$x['countryCode'];
        $ex=$sql."'".$name."'".","."'".$code."'".")";
        $row=mysqli_query($con,$ex);
    }
}
}

function fill_language(){
    $con=getDBconnection();
    if(!$con){
        die('Could not connect');
    }
   $tbl=" CREATE TABLE language(
            name varchar(50) 
            )";
    mysqli_query($con,$tbl);
    $sql="INSERT INTO language (name) VALUES (";

    $result=json_decode(all_language($_SESSION['config'],$_SESSION['outh']),true);
    foreach($result['result']['data']['content'] as $x){
        $name=$x['shortName'];
        // echo $name;
        $ex=$sql."'".$name."')";
        mysqli_query($con,$ex);
    }

}

//main();
?>

