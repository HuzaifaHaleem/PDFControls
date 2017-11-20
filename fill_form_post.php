<?php
$fieldsCollection = array();
$count = 0;
unset($_POST['submit']);
unset($_POST['State']);
//$fieldsInformation = json_encode($_POST);
foreach($_POST as $key => $value) {
    $fieldsCollection[$count]['Caption'] = $key;
    $fieldsCollection[$count]['Value'] = $value;
    $count++;
}

print_r(json_encode($fieldsCollection));
?>

