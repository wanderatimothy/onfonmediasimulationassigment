<?php
require_once "./middleware.php";
require_once "../app/app.php";

$LOVER = new Lover;

// if ($LOVER->validate($sms_body)) {

// Auth the service code sent or end point number eg 5001

if ($LOVER->code == $access_code) {

    // setting up operating  phone number
    $LOVER->phone_number = $sms_phone;

    // verify if number is in the system
    $verify = $LOVER->verifyPhone();

    // Auth ing number or welcoming new user to the service
    if ($verify == true) {

        // processes any request to the system

        $message['resp'] =  $LOVER->processRequest($sms_body);
    } else {
        // welcomes the new users
        $message['resp'] = $verify;
    }


    echo json_encode($message);
} else {
    echo json_encode(array('resp' => ''));
}
// }else{
//     echo json_encode(array('resp' => 'The message should not exceed 160 characters'));

// }