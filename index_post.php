
<?php

require_once "response.php";
$fieldsInformationTextField = array();
$fieldsInformationCheckBox = array();
$fieldsInformationCollection = array();
$exportValues = array();
if (!empty($_POST['mytext'])) {
    $mytext = $_POST['mytext'];
}
if (!empty($_POST['checkboxcaption'])) {
    $checkboxcaption = $_POST['checkboxcaption'];
}
if (!empty($_POST['myCombo'])) {
    $comboBox = $_POST['myCombo'];
    $comboBoxText = $_POST['comboboxtext'];
}

//print_r($comboBox);exit();
//TextField Collection
for ($i = 0; $i < count($mytext); $i++) {
    $fieldsInformationTextField[$i]['ID'] = $i;
    $fieldsInformationTextField[$i]['FieldType'] = "TextField";
    $fieldsInformationTextField[$i]['Caption'] = $mytext[$i];
    $fieldsInformationTextField[$i]['ListValues'] = array();
    $fieldsInformationTextField[$i]['ExportValue'] = "";
    $fieldsInformationTextField[$i]['EnteredValue'] = "";
}
//Extracting information about extracted values of CheckBox
//$response = json_decode($collection);
//foreach ($response as $key => $value) {
//    $data = (array) $response[$key];
//    switch ($data['FieldType']) {
//        case "CheckBox":
//            $exportValues[] = $data['ExportValue'];
//            break;
//    }
//}
//Checkbox collection
for ($i = 0; $i < count($checkboxcaption); $i++) {
    $exportValue = $i + 1;
    $fieldsInformationCheckBox[$i]['ID'] = $i + count($fieldsInformationTextField);
    $fieldsInformationCheckBox[$i]['FieldType'] = "CheckBox";
    $fieldsInformationCheckBox[$i]['Caption'] = $checkboxcaption[$i];
    $fieldsInformationCheckBox[$i]['ListValues'] = array();
    $fieldsInformationCheckBox[$i]['ExportValue'] = $exportValue;
    $fieldsInformationCheckBox[$i]['EnteredValue'] = "";
}
$textFieldAndCheckBox = array_merge($fieldsInformationTextField, $fieldsInformationCheckBox);

//ComboBox collection
//for ($i = 0; $i < count($comboBox); $i++) {
//    $fieldsInformationComboBox[$i]['ID'] = $i + count($textFieldAndCheckBox);
//    $fieldsInformationComboBox[$i]['FieldType'] = "Combobox";
//    $fieldsInformationComboBox[$i]['Caption'] = $comboBoxText[$i];
//    $fieldsInformationComboBox[$i]['ListValues'] = explode(",",$comboBox[$i]);
//    $fieldsInformationComboBox[$i]['ExportValue'] = "";
//    $fieldsInformationComboBox[$i]['EnteredValue'] = "";
//}
//
//$fieldsInformationCollection = json_encode(array_merge($textFieldAndCheckBox, $fieldsInformationComboBox));
//$data = $fieldsInformationCollection;
$data = json_encode($textFieldAndCheckBox);

$url = "http://192.168.2.212/api/DrawFields";
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

//    print_r($result);
}

//Save this form information to DB
$con = mysqli_connect("localhost", "root", "", "hassan_law");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    $formFieldsInformation = json_decode($data);
//    print_r($formFieldsInformation);
//    exit();
    foreach ($formFieldsInformation as $key => $value) {
        $data = (array) $formFieldsInformation[$key];
        $controlId = $data['ID'];
        $controlType = $data['FieldType'];
        $caption = $data['Caption'];
        $exportValue = $data['ExportValue'];
        $listValue = json_encode($data['ListValues']);
        
        switch ($data['FieldType']) {
            case "TextField":
                $sql = "INSERT INTO template_information (template_id, template_path,control_id,control_type,caption)
                VALUES ('3', 'xyz/folder','$controlId','$controlType','$caption')";
                break;
            case "CheckBox":
                $sql = "INSERT INTO template_information (template_id, template_path,control_id,control_type,caption,export_value)
                VALUES ('3', 'xyz/folder','$controlId','$controlType','$caption','$exportValue')";
                break;
            case "Combobox":
                $sql = "INSERT INTO template_information (template_id, template_path,control_id,control_type,caption,list_value)
                VALUES ('3', 'xyz/folder','$controlId','$controlType','$caption','$listValue')";
                break;
        }
//        $sql = "INSERT INTO template_information (template_id, template_path,control_id,template_id,control_type,caption,export_value)
//                VALUES ('text', '$mytext[$i]','$mytext[$x]',$id)";

//        $textbox[] = '<input name="box" type = "text" />';

        if ($con->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
}

exit();
//$con = mysqli_connect("localhost", "root", "", "aht");
//
//// Check connection
//if (mysqli_connect_errno()) {
//    echo "Failed to connect to MySQL: " . mysqli_connect_error();
//}
////$count =$_POST['mytext'];
//$id = $_POST['template_name'];
//$sql = "SELECT file_path FROM tbl_uploads where id = $id";
//$result = mysqli_query($con, $sql);
//while ($row = mysqli_fetch_array($result)) {
//    $filePath = $row['file_path'];
//}
//$radiocaption = $_POST['radiocaption'];
//$textfields = $_POST['textfields'];
//$chechboxcaption = $_POST['checkboxcaption'];

for ($i = 0; $i < count($mytext); $i+=2) {
    $x = $i + 1;
    $sql = "INSERT INTO fields (type, caption,sequence,template_id)
VALUES ('text', '$mytext[$i]','$mytext[$x]',$id)";

    $textbox[] = '<input name="box" type = "text" />';

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

for ($i = 0; $i < count($textbox); $i++) {
    echo $textbox[$i];
}


/* for($i=0; $i<count($radiocaption);$i+=2)
  {
  $x = $i+1;
  $sql = "INSERT INTO fields (type, caption,sequence,template_id)
  VALUES ('radio', '$radiocaption[$i]','$radiocaption[$x]',$id)";

  $radio[] =  '<input type="radio" name="vehicle1" value="Car1">';
  if ($con->query($sql) === TRUE) {
  echo "New record created successfully";
  } else {
  echo "Error: " . $sql . "<br>" . $con->error;
  }

  }
  for($i=0; $i<count($textfields);$i+=2)
  {
  $x = $i+1;
  $sql = "INSERT INTO fields (type, caption,sequence,template_id)
  VALUES ('grouptext', '$textfields[$i]','$textfields[$x]',$id)";

  $grouptext[] =  '<input name="group" type = "text" value="text1" />';

  if ($con->query($sql) === TRUE) {
  echo "New record created successfully";
  } else {
  echo "Error: " . $sql . "<br>" . $con->error;
  }
  } */
/*
  for($i=0; $i<count($chechboxcaption);$i+=2)
  {
  $x = $i+1;
  $sql = "INSERT INTO fields (type, caption,sequence,template_id)
  VALUES ('checkbox', '$chechboxcaption[$i]','$chechboxcaption[$x]',$id)";

  $checkbox[] = '<input type="checkbox" name="vehicle" value="Car" >Service 2';

  if ($con->query($sql) === TRUE) {
  echo "New record created successfully";
  } else {
  echo "Error: " . $sql . "<br>" . $con->error;
  }

  } */
//	session_start(); 
//  $_SESSION['varName'] = $filePath;
//header("Location:form_db.php");
require("mpdf60\mpdf.php");
$mpdf = new mPDF();
$mpdf->useActiveForms = true;
$mpdf->SetImportUse();
$pagecount = $mpdf->SetSourceFile($filePath);
for ($i = 1; $i <= $pagecount; $i++) {
    $tplId = $mpdf->ImportPage($i);
    $mpdf->UseTemplate($tplId);

//        $mpdf->UseTemplate($tplId);
    for ($i = 0; $i < count($textbox); $i++) {
        $mpdf->WriteHTML($textbox[$i]);
    }
    for ($j = 0; $j < count($radio); $j++) {
        $mpdf->WriteHTML($radio[$j]);
    }
    for ($w = 0; $w < count($grouptext); $w++) {
        $mpdf->WriteHTML($grouptext[$w]);
    }
    for ($y = 0; $y < count($checkbox); $y++) {
        $mpdf->WriteHTML($checkbox[$y]);
    }
    if ($i < $pagecount)
        $mpdf->AddPage();
}
$mpdf->Output();
?>