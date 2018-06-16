<?php

ini_set('max_execution_time', 0); //no limit 

/* To manage database */
require_once 'library' . DIRECTORY_SEPARATOR . 'Model.php';
$db = new Model();

echo '<html>    <head>         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">     <title></title>    </head>    <body>';

$question_no = 1;
$paper = '00';
$topic = "";
$name = "IB-T5";
$questions = explode("\r\n\r\n", file_get_contents("public/baba/test/5.txt"));
//var_dump($questions[1]);

foreach ($questions as $question) {
//    echo $question."<br>";
//    print_r($question);
    echo "<br><br>***************<br>"
    . "<br>$$$$$$$$$$$$$<br>";

    $queparts = explode("\n", $question);
    $qnowithstmt = $queparts[0];

    $qno_array = explode(".", $qnowithstmt); //get q no //array consists of qno and other parts of the qstmt separated by '.'
    $qno = $qno_array[0];
    $qno = preg_replace('/\s+/', '', $qno); //remove new line and other white spaces
    echo "<br><br>Q no: " . $qno . '<br>'; // q no is first element

    $qno_size = strlen($qno_array[0]);
    $qstmt1stline = substr($qnowithstmt, $qno_size + 1); //remove q no part from statement which is at 0 position, qno size + size of '.' is removed

    $totalLines = count($queparts);
    $ansLineNo = 0;
    foreach ($queparts as $part) {
        if (strpos($part, 'Answer:') !== FALSE) {//get pos of answer line
            break;
        }
        $ansLineNo++;
    }

    $qstmt = $qstmt1stline;
    $i = 1;
    while ($i < $ansLineNo - 4) {// dont include options in qstmt
//        var_dump($queparts[$i]);
        if (strpos($queparts[$i], 'Answer:') !== false) {
            break;
        }
        $qstmt.= "\n" . $queparts[$i];

        $i++;
    }
    /*
      $qno = $question_no ++;
      echo "<br><br>Q no: " . $qno. '<br>';
      $qstmt = $qnowithstmt;
     */
    echo "Q statement : " . nl2br($qstmt) . '<br>';
    /*

     */


    $opA = substr($queparts[$ansLineNo - 4], 2);
    $opB = substr($queparts[$ansLineNo - 3], 2);
    $opC = substr($queparts[$ansLineNo - 2], 2);
    $opD = substr($queparts[$ansLineNo - 1], 2);
    $ansStr = $queparts[$ansLineNo];
//    var_dump($ansStr);
   $ansNO = preg_replace('/\s+/', '', substr($ansStr, 8)); //remove new line and other white spaces

//    var_dump($ansNO);
    $ans = '';
    switch ($ansNO) {
        case 'A':
            $ans = 'A';
            break;
        case 'B':
            $ans = 'B';
            break;
        case 'C':
            $ans = 'C';
            break;
        case 'D':
            $ans = 'D';
            break;
    }
    echo "option A: " . $opA . "<br>";
    echo "option B: " . $opB . "<br>";
    echo "option C: " . $opC . "<br>";
    echo "option D: " . $opD . "<br>";
    echo "Answer:" . $ans . "<br>";
    $explanation = "";
    $i = $ansLineNo + 1;
    while ($i < $totalLines) {
//        var_dump($queparts[$i]);

        $explanation.= "\n" . $queparts[$i];

        $i++;
    }
    echo "Explanation:" . nl2br($explanation) . "<br>";

/*
   
      //now insert into DB
      $query = "INSERT INTO `questions` (`id`, `qno`, `qtype`, `qtype_value`, `statement`, `A`, `B`, `C`, `D`, `answer`, `explanation`, `subject`, `topic`, `subtopic`, `static`)
      VALUES (NULL, NULL , :qtype ,:paper, :qstmt , :opA, :opB, :opC, :opD , :ans, :exp, '', :topic, '', :name);";
      $paramArray = Array(

      "qtype" => "MOCK",
      "paper" => $paper,
      "qstmt" => $qstmt,
      "opA" => $opA,
      "opB" => $opB,
      "opC" => $opC,
      "opD" => $opD,
      "ans" => $ans,
      "exp"=>$explanation,
      "topic"=>$topic,
      "name"=>$name
      );
      $db->execute($query, $paramArray);
     */
}

echo '    </body> </html>';
