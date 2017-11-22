<?php

$fieldsCollection = array();
$count = 0;
unset($_POST['submit']);
unset($_POST['State']);
//$fieldsInformation = json_encode($_POST);
foreach ($_POST as $key => $value) {
    $fieldsCollection[$count]['Caption'] = $key;
    $fieldsCollection[$count]['Value'] = $value;
    $count++;
}

//print_r(json_encode($fieldsCollection));exit();
$data = json_encode($fieldsCollection);

$url = "http://192.168.2.212/api/GetFilledPdf";
{
    $curl = curl_init();

    switch ("POST") {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, true);

            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    $result = curl_exec($curl);
    curl_close($curl);
    echo "Template written successfully";
//    print_r($result);

//    $file = "https://www.google.com.pk/url?sa=t&rct=j&q=&esrc=s&source=web&cd=2&cad=rja&uact=8&ved=0ahUKEwjplYqxk83XAhWQpKQKHTw3BlYQFgguMAE&url=http%3A%2F%2Fwww.axmag.com%2Fdownload%2Fpdfurl-guide.pdf&usg=AOvVaw3g6Rtx34k5lNisnuOCwVkK";
//
//    echo '<script type="text/javascript"> window.open("' . $file . '"); 
//            setTimeout(function(){window.location="fill_form.php"} , 10);
//            </script>';
} //- the missing closing brace
//$file_url = $result;
//header('Content-Type: application/pdf');
//header("Content-Transfer-Encoding: Binary");
//header("Content-disposition: attachment; filename=".$file_url);
//readfile($file_url);
//}
?>

