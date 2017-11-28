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
//print_r($data);exit();

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
}

$con = mysqli_connect("localhost", "root", "", "hassan_law");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {

    foreach ($fieldsCollection as $key => $value) {
        $captionAndValueArray = $fieldsCollection[$key];
        $caption = $captionAndValueArray['Caption'];
        $value = $captionAndValueArray['Value'];
        $templateId = 5;
        $userId = 1;


        $sql = "INSERT INTO template_data (user_id,template_id, control_name,value)
                VALUES ('$userId', '$templateId','$caption','$value')";

        if ($con->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
}
?>

