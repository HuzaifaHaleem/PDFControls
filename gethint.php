<?php
// Array with names
/*$a[] = "Anna";
$a[] = "Brittany";
$a[] = "Cinderella";
$a[] = "Diana";
$a[] = "Eva";
$a[] = "Fiona";
$a[] = "Gunda";
$a[] = "Hege";
$a[] = "Inga";
$a[] = "Johanna";
$a[] = "Kitty";
$a[] = "Linda";
$a[] = "Nina";
$a[] = "Ophelia";
$a[] = "Petunia";
$a[] = "Amanda";
$a[] = "Raquel";
$a[] = "Cindy";
$a[] = "Doris";
$a[] = "Eve";
$a[] = "Evita";
$a[] = "Sunniva";
$a[] = "Tove";
$a[] = "Unni";
$a[] = "Violet";
$a[] = "Liza";
$a[] = "Elizabeth";
$a[] = "Ellen";
$a[] = "Wenche";
$a[] = "Vicky";
$b[] = "A";
$b[] = "B";
$b[] = "C";
$b[] = "D";
$b[] = "E";
$b[] = "F";*/
$con=mysqli_connect("localhost","root","","hassan_law");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="SELECT caption FROM template_information";
$result=mysqli_query($con,$sql);

// Numeric array
$row=mysqli_fetch_all($result,MYSQLI_ASSOC);
for ($b = 0; $b < sizeof($row); $b++) {
            $a[$b] = ($row[$b]['caption']);
        } 
//print_r($a);

// Free result set
mysqli_free_result($result);

mysqli_close($con);
// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";
// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
		if($q == strtolower($name)) {
			$hint = $q . " already exist in record.";
		}
        /*if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }*/
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "" : $hint;
?>