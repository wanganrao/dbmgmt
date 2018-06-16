<?php
ini_set('max_execution_time', 0);//no limit 

/* To manage database */
require_once 'library' . DIRECTORY_SEPARATOR . 'Model.php';
//$db = new Model();

echo '<html>    <head>         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">     <title></title>    </head>    <body>';
$lineno = 1;
$question_no = 1;
$paper = '2000';
$file = "public/papers/IAS_" . $paper . ".txt";
$splitFile = explode("*****", file_get_contents($file));
$questions = $splitFile[0];
$questions = explode("\n\n", $questions);

$answers = $splitFile[1];
$answers = preg_replace('/\.|\n/', '', $answers);
$answers = explode(" ", $answers);
// var_dump($answers);
//$my_ans_array = array(1 => 'asdf');
//$my_ans_array[2] = '2222fff';
$i = 0;
foreach ($answers as $answer) {
//    var_dump($answer);

    if (fmod($i, 2) == 0) {
//    if (is_int($answer)) {
        $my_ans_array[intval($answer)] = $answers[$i + 1];
    }
    $i++;
}
ksort($my_ans_array);
echo "<pre>";
print_r($my_ans_array);
echo "</pre>";

$i = 0;
foreach ($questions as $question) {
//    echo $question."<br>";
//    print_r($question);
    $queparts = explode("(a)", $question);
    $qnowithstmt = $queparts[0]; //2nd part is answer

    $qno_array = explode(".", $qnowithstmt); //get q no //array consists of qno and other parts of the qstmt separated by '.'
    $qno = $qno_array[0];
    $qno = preg_replace('/\s+/', '', $qno); //remove new line and other white spaces
    $qno = preg_replace('/Q/', '', $qno);
    echo "<br><br>Q no: " . $qno . '<br>'; // q no is first element
    $qno_size = strlen($qno_array[0]);
    $qstmt = substr($qnowithstmt, $qno_size + 1); //remove q no part from statement which is at 0 position, qno size + size of '.' is removed

    /*
      $qno = $question_no ++;
      echo "<br><br>Q no: " . $qno. '<br>';
      $qstmt = $qnowithstmt;
     */
    echo "Q statement : " . nl2br($qstmt) . '<br>';


    // extract options and answers
    $ans_part = $queparts[1];
    $a_starting_array = explode("(b)", $ans_part);
    $opA = $a_starting_array[0];

    $b_starting_array = explode("(c)", $a_starting_array[1]);
    $opB = $b_starting_array[0];

    $c_starting_array = explode("(d)", $b_starting_array[1]);
    $opC = $c_starting_array[0];
    $opD = $c_starting_array[1];

    /*
      $d_starting_array = explode("Answer:", $c_starting_array[1]);
      $opD = $d_starting_array[0];


      $ans = $d_starting_array[1];
      $ans = preg_replace('/\s/', '', $ans);
     */
//    $ans_array=explode("(", $d_starting_array[1]); //contains ans
//    $ans = ucfirst(preg_replace('/\s/', '', $ans_array[1]));
    $ans = $my_ans_array[$qno];
    echo "option A: " . $opA . "<br>";
    echo "option B: " . $opB . "<br>";
    echo "option C: " . $opC . "<br>";
    echo "option D: " . $opD . "<br>";
    echo "Answer:" . $my_ans_array[$qno] . "<br>";

    /*
      //now insert into DB
      $query = "INSERT INTO `questions` (`id`, `qno`, `qtype`, `qtype_value`, `statement`, `A`, `B`, `C`, `D`, `answer`, `explanation`, `subject`, `topic`, `subtopic`, `static`)
      VALUES (NULL, :qno , :qtype ,:paper, :qstmt , :opA, :opB, :opC, :opD , :ans, '', '', '', '', '');";
      $paramArray = Array(
      "qno" => $qno,
      "qtype" => "CSP",
      "paper" => $paper,
      "qstmt" => $qstmt,
      "opA" => $opA,
      "opB" => $opB,
      "opC" => $opC,
      "opD" => $opD,
      "ans" => $ans
      );
      $db->execute($query, $paramArray);
     */


    $i++;
}

echo '    </body> </html>';
