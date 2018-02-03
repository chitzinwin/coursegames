<?PHP

//var_dump($_POST);

$url = $_POST['launch_presentation_return_url'];
$query=parse_url($url,PHP_URL_QUERY);
parse_str($query, $out);

$course_id=$out['course_id'];
$course_title=$_POST['context_title'];
$course_batchUID=$_POST['context_label'];
$user_id=$_POST['user_id'];
$name=$_POST['lis_person_name_full'];

//replacement for the Constant public $HOSTNAME =
preg_match_all('/\//', $url,$matches, PREG_OFFSET_CAPTURE);  
$clientURL = substr($url, 0, $matches[0][2][1]);

//echo "Welcome $name.  Your course is $course_title ($course_batchUID).<br /><br /><br />";

require_once('classes/Rest.class.php');
require_once('classes/Token.class.php');

$rest = new Rest($clientURL);
$token = new Token();

$token = $rest->authorize();
$access_token = $token->access_token;
//$course = $rest->readCourse($access_token, $course_id);
//var_dump($course);

//echo $user_id;
$user = $rest->readUser($access_token, "uuid:".$user_id);
//echo $user->id;

//$membership = $rest->readMembership($access_token, $course_id, "");

//var_dump($membership);
//die();
$columns = $rest->readGradebookColumns($access_token, $course_id);
$c=$columns->results;


foreach($c as $row)
{
        //if ($row->externalGrade == 1)
        if ($row->name == "Total")
        {
         $finalGradeName=$row->name;
         $finalGradeID=$row->id;
         $finalPossible=$row->score->possible;
         break;
        }
}


//echo $finalGradeName . " " . $finalGradeID;

$grades = $rest->readGradebookGrades($access_token, $course_id, $finalGradeID);

$g=$grades->results;
/*
foreach($g as $row)
{
        echo "<br />".$row->userId . " " .$row->score." ouf of ".$finalPossible;
}
*/



?>
