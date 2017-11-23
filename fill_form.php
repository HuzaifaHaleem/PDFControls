<?php
$conn = mysqli_connect("localhost", "root", "", "hassan_law");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    $templateId = 1;
//    $rows = array();
    $sql = "SELECT * FROM template_information WHERE template_id=" . $templateId . "";
    $result = mysqli_query($conn, $sql);

    // Fetch all
    $rows = array();

    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC))) {
        $rows[] = $row;
    }
}

//Get saved data for a template
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    $templateId = 3;
    $userId = 1;
//    $rows = array();
    $sql = "SELECT * FROM template_data WHERE template_id=" . $templateId . " AND user_id=" . $userId . "";
    $result = mysqli_query($conn, $sql);

    // Fetch all
    $templateData = array();

    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC))) {
        $templateData[] = $row;
    }
    $checkBoxes = array_column($templateData,'control_name');
//    print_r($templateData);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Fill Dynamic Form Using jQuery </title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <link href="css/style.css" rel="stylesheet">
        <script src="js/script.js" type="text/javascript"></script>
    </head>
    <body>

        <!--        <form action="index_post.php" method="POST">-->

        <div class="maindiv">
            <div id="header"></div>
            <!--            <div class="menu">
                            <button id="namebutton"> Text Box</button>
                            <button id="textbutton"> Group Text Box</button>
                            <button id="checkboxbutton">CheckBox</button>
                            <button id="radioaddbutton">Radio</button>
                            <button id="submitbutton" value="submit" name="submit">Submit</button>
                        </div>-->
            <div class="InputsWrapper1">
                <form action="fill_form_post.php" method="POST" class="iamform" id="iamform">
                    <div id="InputsWrapper">

                        <?php
                        foreach ($rows as $key => $value) {
//                            print_r($value['control_type']);
                            switch ($value['control_type']) {
                                case "TextField":
                                    $textFieldText = ((!empty($templateData[$key]['value']))?$templateData[$key]['value']:"");
                                    echo '<div>' . '<div class="name box-style" id="InputsWrapper_1' . 1 . '">' .
                                    '<input type="text" class="textBoxClass" value="' . $textFieldText . '" name="' . $value['caption'] . '" id="' . $key . '"/>' . ' ' . '<label>' . $value['caption'] . '</label>' . '<br>' . '</div>' . '</div>';
                                    break;
                                case "CheckBox":
                                    $check = ((in_array($value['caption'],$checkBoxes))? 1 : 0);
                                    if($check == 1) {
                                        echo '<div class="checkbox box-style" id="InputsWrapper_3_' . 2 . '">' . '<p class="checkbox_child" id="para' . 2 . '">' .
                                    '<input type="checkbox" class="checkBoxClass"  checked name="' . $value['caption'] . '" id="field_' . 2 . '" value="' . $value['export_value'] . '"/>' . ' ' . '<label>' . $value['caption'] . '</label>' . '</p>' . '</div>';
                                    } else {
                                        echo '<div class="checkbox box-style" id="InputsWrapper_3_' . 2 . '">' . '<p class="checkbox_child" id="para' . 2 . '">' .
                                    '<input type="checkbox" class="checkBoxClass" name="' . $value['caption'] . '" id="field_' . 2 . '" value="' . $value['export_value'] . '"/>' . ' ' . '<label>' . $value['caption'] . '</label>' . '</p>' . '</div>';
                                    }
                                    
                                    break;
                                case "Combobox":
                                    $list = json_decode($value['list_value']);
                                    echo '<div class="nameCombo box-style" id="InputsWrapper_1' . 1 . '">' .
                                    '<select class="selectBox" name="' . $value['caption'] . '" style="width:180px;height:30px" id=' . $key . '>';
                                    foreach ($list as $option) {
                                        echo "<option value=" . $option . ">" . $option . "</option>";
                                    }
                                    echo "</select>" . ' ' . '<label>' . $value['caption'] . '</label>' . '<br>' . '</div>';
                            }
                        }
                        if (count($rows) > 0) {
                            echo '<input type="submit" style="margin-top:20px" id="submitbutton" value="submit" name="submit" />';
                        }

//                        include_once 'response.php';
//                        foreach ($response as $key => $value) {
//                            $data = (array) $response[$key];
//                            switch ($data['FieldType']) {
//                                case "TextField":
//                                    echo '<div>' . '<div class="name box-style" id="InputsWrapper_1' . 1 . '">' .
//                                    '<input type="text" class="textBoxClass" name="mytext[]" id="' . $key . '"/>' . '<button class="removeclass1">x</button>' .
//                                    '<button class="addclass1">+</button>' . '<br>' . '</div>' . '</div>';
//                                    break;
//                                case "CheckBox":
//                                    echo '<div class="checkbox box-style" id="InputsWrapper_3_' . 2 . '">' . '<p class="checkbox_child" id="para' . 2 . '">' .
//                                    '<input type="checkbox" class="checkBoxClass" name="mycheckbox[]" id="field_' . 2 . '" value="CheckBox' . 2 . '"/>' . '<input type="text" style="width:160px;height:25px" name="checkboxcaption[]" id="' . $key++ . '" value=""/>' . '<button class="removeclass3">x</button>' . '<button class="addclass3">+</button>' . '</p>' . '</div>';
//                                    break;
//                                case "Combobox":
//                                    echo '<div class="nameCombo box-style" id="InputsWrapper_1' . 1 . '">' .
//                                    '<select class="selectBox" style="width:180px;height:30px" id=' . $key . '>';
//                                    foreach ($data['ListValues'] as $value) {
//                                        echo "<option value=" . $value . ">" . $value . "</option>";
//                                    }
//                                    echo '<input type="hidden"  name="myCombo[]" id="cb' . $key . '" value=""/>' . '<input type="text" class="textBoxClass" name="comboboxtext[]" id="' . $key . '"/>' . '<button class="removeclassCombo">x</button>' .
//                                    '<button class="addclassCombo">+</button>' . '<button class="selectSelect" id=' . $key . '>Remove Option</button>' . '<input type="text" style="width:60px;height:8px" id=ot' . $key . ' />' . '<button class="addOptionButton" id=' . $key . '>Add Option</button>' . '<br>' . '</div>';
//                            }
//                        }
//                        if (count($response) > 0) {
//                            echo '<input type="submit" id="submitbutton" value="submit" name="submit" />';
//                        }
                        ?>

                    </div>
                </form>
            </div>
            <!-- Display DPF Here -->
            <div class="PDFViewer">
                <object data="fw9.pdf" type="application/pdf" width="650" height="900">
                    alt : <a href="#">Unable to display PDF preview.</a>
                </object>
            </div>
        </div>
        <!--</form>-->
    </body>
</html>

<script>
    $(document).ready(function () {

        $('input[name="name"]').val('Test Value');
    });

    //Caption repetition check
    $('input').blur(function () {
        var minput = $(this).val();
        var minputid = this.id;
        var check = false;
        $('#InputsWrapper input[type=text]').each(function () {
            if ($(this).val() != "" && minputid != this.id) {
                if (minput == $(this).val()) {
                    check = true;
                }
            }


        });
        if (check == true) {
            alert("Caption " + minput + " is repeated. Caption name must be unique.");
        }

    });
    $("body").on("click", ".selectSelect", function (event) {
        event.preventDefault();
        $('#' + this.id + ' option:selected').remove();
    });
    $("body").on("click", ".addOptionButton", function (event) {
        event.preventDefault();
        var optionText = $('#ot' + this.id).val();//Get value of option to be added

        $('#' + this.id).append($('<option>', {
            value: optionText,
            text: optionText
        }));

    });

    function getSelectValues() {

//        var str = "";
//        $('#21 option').each(function () {
//            str += $(this).text() + ",";
//        });

        var selectId = [];

<?php
$i = 0;
foreach ($response as $key => $value) {
    $data = (array) $response[$key];
    switch ($data['FieldType']) {
        case "Combobox":
            echo "selectId[$i]=" . $key . ";";
            $i++;
    }
}
?>;
        //alert(selectId.toString());
        for (i = 0; i < selectId.length; i++) {
            var str = "";
            $('#' + selectId[i] + ' option').each(function () {
                str += $(this).text() + ",";

            });
            document.getElementById("cb" + selectId[i]).value = str;
//        alert(document.getElementById("cb" + selectId[i]).value);
//        return false;
        }

        var numItemsSelect = $('.selectBox').length;
        var numItemsText = $('.textBoxClass').length;
        var numItemsCheck = $('.checkBoxClass').length;
        var total = numItemsSelect + numItemsText + numItemsCheck;
//        alert(total);
//        return false;
//        var orignalCountofFields = 0;

        var orignalCountofFields = <?php echo count($response); ?>;
        if (total > orignalCountofFields) {
//            alert("Here");
            for (j = orignalCountofFields; j < total; j++) {
                var str = "";
                $('#' + j + ' option').each(function () {
                    str += $(this).text() + ",";

                });
                document.getElementById("cb" + j).value = str;
//        alert(document.getElementById("cb" + selectId[i]).value);
//        return false;
            }
        }


    }
    $(document).ready(function () {
        /*------------------------------------------------
         To Edit Your Form Heading
         -------------------------------------------------*/
        $("#yourtitle").click(function () {
            $("#your").hide();
            var createhead = $(document.createElement('div'));
            createhead.attr("id", "your1");
            createhead.html('<label id="titleid">' + '<b>Title : </b>' + '</label>' + '<br/>' + '<input id="inputhead" "type=text placeholder="Type Your Choicehead"/>' +
                    '<button id="doneid">Done</button>');
            $("#yourhead").append(createhead);
            var get1 = $("#yourtitle").text();
            $("#inputhead").val(get1);
            $("#doneid").click(function () {
                var get = $("#inputhead").val();
                if (get == 0) {
                    alert("Cannot Leave Field Blank");
                } else {
                    $("#yourtitle").html('<h1>' + get + '</h1>');
                    $("#yourtitle").css({
                        "text-align": "center",
                        "font-size": "25px",
                        "color": "white",
                        "cursor": "pointer"
                    });
                    $("#your1").remove();
                    $("#your").show();
                    $("#your").css({
                        "background-color": "#F4D4FA",
                        "width": "530px"
                    });
                    $("#justclickid").hide();
                }
            });
        });
        /*-------------------------------------------------------------------*/
        var MaxInputs = 100; //Maximum Input Boxes Allowed
        /*-------------------------------------------------------------------
         To Keep Track of Fields And Divs Added
         -------------------------------------------------------------------*/
        var textFieldCount = 0;
        var text_sub_para_Count = 0;
        var textboxdivCount = 0;
        var checkboxFieldCount = 0;
        var checkboxCaptionCount = 0;
        var radiobuttonFieldCount = 0;
        var radiobuttonCaptionCount = 0;
        var checkboxdivCount = 0;
        var checkbox_sub_para_Count = 0;
        var radiobuttondivCount = 0;
        var radio_sub_para_Count = 0;
        var nameFieldCount = 0;
        var InputsWrapper = $("#InputsWrapper"); // Input Box Wrapper ID
        var x = InputsWrapper.length; // Initial Field Count
        var counttext = 0;
        var grouptext = 0;
        var checkboxfield = 0;
        var radiobuttonfield = 0;
        /*--------------------------------------------------------------
         To Get Fields Button ID
         ----------------------------------------------------------------*/
        var namefield = $("#namebutton");
        var textfield = $("#textbutton");
        var checkbox = $("#checkboxbutton");
        var radiobutton = $("#radioaddbutton");
        $(InputsWrapper).sortable(); // To Make Added Fields Sortable


        /*---------------------------------------------------------------
         To Add Name Field
         ----------------------------------------------------------------*/
        $(namefield).click(function () {
            if (x <= MaxInputs) {
                counttext++;
                nameFieldCount++;
                $(InputsWrapper).append('<div>' + '<div class="name box-style" id="InputsWrapper_1' + nameFieldCount + '">' +
                        '<input type="text" name="mytext[]" id="field_' + nameFieldCount + '"/>' + '<button class="removeclass1">x</button>' +
                        '<button class="addclass1">+</button>' + '<br>' + '</div>' + '</div>');
                x++;
            }
            return false;
        });
        $("body").on("click", ".removeclass1", function () {
            $(this).parent('div').remove(); // To Remove Name Field
            x--;
            return false;
        });
        $("body").on("click", ".addclass1", function () {
            counttext++;
            nameFieldCount++; // To Add More Name Fields
            $(this).parent('div').parent('div').append('<div class="name">' + '<input type="text" name="mytext[]" id="field_' +
                    nameFieldCount + '" />' + '<button class="removeclass1">x</button>' + '<button class="addclass1">+</button>' + '<br>' +
                    '</div>');
            x++;
            return false;
        });
        /*---------------------------------------------------------------
         To Add ComboBox
         ---------------------------------------------------------------*/
        $("body").on("click", ".removeclassCombo", function () {
            $(this).parent('div').remove(); // To Remove Name Field
            x--;
            return false;
        });
        $("body").on("click", ".addclassCombo", function (event) {
            event.preventDefault();
            var numItemsSelect = $('.selectBox').length;
            var numItemsText = $('.textBoxClass').length;
            var numItemsCheck = $('.checkBoxClass').length;
            var total = numItemsSelect + numItemsText + numItemsCheck;
            //alert(total);
            $(this).parent('div').after('<div class="nameCombo box-style" id="InputsWrapper_1' + 1 + '">' +
                    '<select class="selectBox" style="width:180px;height:30px" id=' + total + '>' + '<option value="' + total + '"' + '>' + total + '</option>' +
                    '<input type="hidden"  name="myCombo[]" id="cb' + total + '" value=""/>' + '<input type="text" class="textBoxClass" name="comboboxtext[]" id="' + total + '"/>' + '<button class="removeclassCombo">x</button>' +
                    '<button class="addclassCombo">+</button>' + '<button class="selectSelect" id=' + total + '>Remove Option</button>' + '<input type="text" style="width:60px;height:8px" id=ot' + total + ' />' + '<button class="addOptionButton" id=' + total + '>Add Option</button>' + '<br>' + '</div>');
            x++;
            return false;
        });
        /*---------------------------------------------------------------
         To Add group text Field
         ----------------------------------------------------------------*/
        $(textfield).click(function () {
            if (x <= MaxInputs) {
                counttext++;
                textFieldCount++;
                textboxdivCount++;
                text_sub_para_Count++;

                $(InputsWrapper).append('<div class="textbox box-style" id="InputsWrapper_0_' + textboxdivCount + '">' + '<div class="name_child" id="para' + text_sub_para_Count + '">' +
                        '<input type="text" name="textfields[]" id="textfield_' + textFieldCount + '"/>' + '<input type="hidden" name="textfields[]" value="' + counttext + '"/>' + '<button class="removeclass0">x</button>' + '<button class="addclass0">+</button>' + '</div>' + '<div class="name_child" id="para' +
                        text_sub_para_Count + '" >' + '<input type="text" name="textfields[]" id="textfield_' + textFieldCount + '" />' + '<input type="hidden" name="textfields[]" value="' + counttext + '"/>' + '<button class="removeclass0">x</button>' + '<button class="addclass0">+</button>' + '</div>' + '<div class="name_child" id="para' +
                        text_sub_para_Count + '" >' +
                        '<input type="text" name="textfields[]" id="textfield_' + textFieldCount + '" />' + '<input type="hidden" name="textfields[]" value="' + counttext + '"/>' +
                        '<button class="removeclass0">x</button>' + '<button class="addclass0">+</button>' + '</div>' + '</div>');
                x++;
            }
            return false;
        });

        $("body").on("click", ".removeclass0", function () {
            $(this).parent('div').remove(); // To Remove Name Field
            x--;
            return false;
        });
        $("body").on("click", ".addclass0", function () {
            counttext++;
            textFieldCount++; // To Add More Name Fields
            $(this).parent('div').parent('div').append('<div class="name_child" id="para' + text_sub_para_Count + '">' +
                    '<input type="text" name="textfields[]" id="field_' + textFieldCount + '"/>' + '<input type="hidden" name="textfields[]" value="' + counttext + '"/>' +
                    '<button class="removeclass0">x</button>' + '<button class="addclass0">+</button>' + '</div>');
            return false;
        });

        /*------------------------------------------------
         To Add Check-Box
         -------------------------------------------------*/
        $(checkbox).click(function () {
            if (x <= MaxInputs) {
                checkboxFieldCount++;
                checkboxCaptionCount++;
                checkboxdivCount++;
                counttext++;
                checkbox_sub_para_Count++;
                $(InputsWrapper).append('<div class="checkbox box-style" id="InputsWrapper_3_' + checkboxdivCount + '">' + '<p class="checkbox_child" id="para' + checkbox_sub_para_Count + '">' +
                        '<input type="checkbox" name="mycheckbox[]" id="field_' + checkboxFieldCount + '" value="CheckBox' +
                        checkboxFieldCount++ + '"/>' + '<input type="text" name="checkboxcaption[]" id="captionfield_' + '" value=""/>' + '<button class="removeclass3">x</button>' + '<button class="addclass3">+</button>' + '</p>' + '</div>');
                x++;
            }
            return false;
        });
        $("body").on("click", ".removeclass3", function () {
            $(this).parent('p').remove(); // To Remove Check-Box
            x--;
            return false;
        });
        $("body").on("click", ".addclass3", function () {
            counttext++;
            checkboxFieldCount++; // To Add More Check-Box
            $(this).parent('p').parent('div').append('<p class="checkbox_child" id="para' + checkbox_sub_para_Count + '">' +
                    '<input type="checkbox" name="mycheckbox[]" id="field_' + checkboxFieldCount + '" value="CheckBox' + checkboxFieldCount + '"/>' + '<input type="text" name="checkboxcaption[]" id="captionfield_' + '" value=""/>' +
                    '<button class="removeclass3">x</button>' + '<button class="addclass3">+</button>' + '</p>');
            x++;
            return false;
        });
        /*------------------------------------------------
         To Add Radio-Button
         -------------------------------------------------*/
        $(radiobutton).click(function () {
            if (x <= MaxInputs) {
                counttext++;
                radiobuttonFieldCount++;
                radiobuttonCaptionCount++;
                radiobuttondivCount++;
                radio_sub_para_Count++;
                $(InputsWrapper).append('<div class="radiobutton box-style" id="InputsWrapper_4_' + radiobuttondivCount + '">' + '<p class="radiobutton_child" id="para' + radio_sub_para_Count +
                        '">' + '<input type="radio" name="myradio[]" id="field_' + radiobuttonFieldCount + '" placeholder="Radio_' +
                        radiobuttonFieldCount++ + '"/>' + '<input type="text" name="radiocaption[]" id="captionfield_' + radiobuttonCaptionCount + '"/>' + '<input type="hidden" name="radiocaption[]" value="' + counttext + '"/>' + '<button class="removeclass4">x</button>' + '<button class="addclass4">+</button>' + '</p>' +
                        '<p class="radiobutton_child" id="para' + radio_sub_para_Count + '">' +
                        '<input type="radio" name="myradio[]" id="field_' + radiobuttonFieldCount + '" placeholder="Radio_' + radiobuttonFieldCount++ + '"/>' + '<input type="text" name="radiocaption[]" id="captionfield_' + radiobuttonCaptionCount + '"/>' + '<input type="hidden" name="radiocaption[]" value="' + counttext + '"/>' +
                        '<button class="removeclass4">x</button>' + '<button class="addclass4">+</button>' + '</p>' + '<p class="radiobutton_child" id="para' + radio_sub_para_Count +
                        '">' + '<input type="radio" name="myradio[]" id="field_' + radiobuttonFieldCount + '" placeholder="Radio_' +
                        radiobuttonFieldCount + '"/>' + '<input type="text" name="radiocaption[]" id="captionfield_' + radiobuttonCaptionCount + '"/>' + '<input type="hidden" name="radiocaption[]" value="' + counttext + '"/>' + '<button class="removeclass4">x</button>' + '<button class="addclass4">+</button>' + '</p>' + '</div>');
                x++;
            }
            return false;
        });
        $("body").on("click", ".removeclass4", function () {
            $(this).parent('p').remove(); // To Remove Radio-Button
            x--;
            return false;
        });
        $("body").on("click", ".addclass4", function () {
            counttext++;
            radiobuttonFieldCount++; // To Add More Radio-Button
            $(this).parent('p').parent('div').append('<p class="radiobutton_child" id="para' + radio_sub_para_Count + '">' +
                    '<input type="radio" name="myradio[]" id="field_' + radiobuttonFieldCount + '" placeholder="Radio_' + radiobuttonFieldCount + '"/>' + '<input type="text" name="radiocaption[]" id="captionfield_' + radiobuttonCaptionCount + '"/>' + '<input type="hidden" name="radiocaption[]" value="' + counttext + '"/>' +
                    '<button class="removeclass4">x</button>' + '<button class="addclass4">+</button>' + '</p>');
            x++;
            return false;
        });
        $("#reset").on("click", function () {
            $("#InputsWrapper").empty(); // To Reset All Elements
        });
    });




</script>
<style>
    #header{
        background-color:#40B1ED;
        height:60px
    }
    .maindiv{
        border:1px solid #000;
        background:#FAFAFA;
        /*width:960px;*/
        width:1500px;
        height:1000px;
        position:absolute;
        top:20px;
        left:50px;
        overflow:auto
    }
    .menu{
        background-color:#fff;
        width:220px;
        height:350px;
        padding:15px;
        border:1px solid #000;
        border-radius:4px;
        position:absolute;
        top:70px;
        left:10px;
        box-shadow:0 0 5px #000
    }
    .menu img{
        float:left;
        padding-left:10px
    }
    #your{
        padding:10px;
        width:400px;
        height:120px;
        position:absolute;
        top:10px;
        left:50px;
        border:1px dashed #fff
    }
    #your:hover{
        background-color:#FBF0FC;
        border:1px dashed #000;
        cursor:pointer
    }
    #InputsWrapper{
        /*        position:absolute;*/
        top:150px;
        left:40px
    }
    #your1{
        padding:10px;
        width:500px;
        height:120px;
        position:absolute;
        top:10px;
        left:50px;
        border:1px dashed #000
    }
    #titleid{
        font-size:20px
    }
    #inputhead{
        font-size:30px;
        border-radius:2px;
        box-shadow:0 0 5px #40B1ED;
        border:1px solid #40B1ED;
        width:450px
    }
    #doneid{
        position:absolute;
        bottom:5px;
        right:5px;
        color:#fff;
        background-color:#40B1ED;
        border-radius:2px;
        border:2px solid #40B1ED
    }
    #textbutton{
        border:4px solid #9AB7F5;
        width:200px;
        height:50px;
        background:#E4E7F0 url(../images/tab-bg.png) repeat-x;
        margin-bottom:10px;
        font-size:20px;
        border-radius:2px
    }
    #namebutton{
        border:4px solid #9AB7F5;
        width:200px;
        height:50px;
        background:#E4E7F0 url(../images/tab-bg.png) repeat-x;
        margin-bottom:10px;
        font-size:20px;
        border-radius:2px
    }
    #emailbutton{
        border:4px solid #9AB7F5;
        width:200px;
        height:50px;
        background:#efefef url(../images/tab-bg.png) repeat-x;
        margin-bottom:10px;
        font-size:20px;
        border-radius:2px
    }
    #emailbutton:hover{
        border:4px solid #9680ED;
        border-radius:2px;
        cursor:pointer
    }
    #addressbutton{
        border:4px solid #9AB7F5;
        width:200px;
        height:50px;
        background:#efefef url(../images/tab-bg.png) repeat-x;
        margin-bottom:10px;
        font-size:20px;
        border-radius:2px
    }
    #addressbutton:hover{
        border:4px solid #9680ED;
        border-radius:2px;
        cursor:pointer
    }
    #checkboxbutton{
        border:4px solid #9AB7F5;
        width:350px;
        height:50px;
        background:#efefef url(../images/tab-bg.png) repeat-x;
        margin-bottom:10px;
        font-size:20px;
        border-radius:2px
    }
    #submitbutton{
        border:4px solid #9AB7F5;
        width:200px;
        height:50px;
        margin-bottom:10px;
        font-size:20px;
        border-radius:2px
    }
    #checkboxbutton:hover{
        border:4px solid #9680ED;
        border-radius:2px;
        cursor:pointer
    }
    #radioaddbutton{
        border:4px solid #9AB7F5;
        width:200px;
        height:50px;
        background:#efefef url(../images/tab-bg.png) repeat-x;
        margin-bottom:10px;
        font-size:20px;
        border-radius:2px
    }
    #radioaddbutton:hover{
        border:4px solid #9680ED;
        border-radius:2px;
        cursor:pointer
    }
    #reset{
        border:4px solid #9AB7F5;
        width:200px;
        height:50px;
        margin-bottom:10px;
        font-size:20px;
        border-radius:2px
    }
    .InputsWrapper1{
        background-color:#fff;
        /*width:650px;*/
        width:650px;
        height:900px;
        border:1px solid #000;
        margin-left: 15px;
        margin-top: 15px;
        /*position:absolute;*/
        top:70px;
        right:10px;
        border-radius:4px;
        overflow-y:scroll;
        box-shadow:0 0 5px #000
    }
    .PDFViewer{
        background-color:#fff;
        width:650px;
        height:900px;
        border:1px solid #000;
        margin-left: 40px;
        margin-top: 6px;
        position:absolute;
        top:70px;
        right:10px;
        border-radius:4px;
        float: left;
        /*        overflow-y: scroll;*/
        box-shadow:0 0 5px #000

    }
    div.name{
        background:#E1F3FC;
        margin-bottom:10px;
        margin-top:15px;
        margin-left:10px;
        width:350px;
        height:35px;
        border-radius:5px;
        border:1px solid blue;
        padding:5px;
        cursor:move
    }
    div.nameCombo{
        background:#E1F3FC;
        margin-bottom:10px;
        margin-top:15px;
        margin-left:10px;
        width:350px;
        height:35px;
        border-radius:5px;
        border:1px solid blue;
        padding:5px;
        cursor:move
    }
    .name input,.email input{
        padding:5px
    }
    div.email{
        background:#E1F3FC;
        margin-bottom:10px;
        margin-top:15px;
        margin-left:10px;
        width:300px;
        height:35px;
        border-radius:5px;
        border:1px solid blue;
        padding:5px;
        cursor:move
    }
    div.address{
        position:relative;
        background:#E1F3FC;
        margin-bottom:10px;
        margin-top:15px;
        margin-left:10px;
        width:320px;
        height:50px;
        border-radius:5px;
        border:1px solid blue;
        padding:5px;
        cursor:move
    }
    .address textarea{
        padding-left:5px
    }
    div.address label{
        position:absolute
    }
    div.address p{
        position:absolute;
        right:10px;
        top:-10px
    }
    .checkbox_child{
        background: #E1F3FC;
        margin-bottom: 10px;
        margin-top: 15px;
        margin-left: 10px;
        width: 350px;
        height: 35px;
        border-radius: 5px;
        border: 1px solid blue;
        padding: 5px;
        cursor: move;
    }
    .radiobutton_child{
        background:#E1F3FC;
        margin-bottom:10px;
        margin-top:20px;
        width:100%;
        height:25px;
        border-radius:5px;
        border:1px solid blue;
        padding:5px;
        cursor:move
    }
    .name_child{
        background:#E1F3FC;
        margin-bottom:10px;
        margin-top:20px;
        width:100%;
        height:25px;
        border-radius:5px;
        border:1px solid blue;
        padding:5px;
        cursor:move
    }
    .box-style {
        padding-bottom: 18px;

    }
</style>