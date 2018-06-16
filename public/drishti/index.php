<?php
/* To manage database */
require_once 'library'.DIRECTORY_SEPARATOR.'Model.php';
$db = new Model();

echo '<html>    <head>         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">     <title></title>    </head>    <body>';
$lineno = 1;
$question_no = 1;
$paper = '';
$questions = explode("\n\n", file_get_contents("files/drishti/1.txt"));
//var_dump($questions[1]);

foreach ($questions as $question) {
//    echo $question."<br>";
//    print_r($question);
    $queparts = explode("(a)", $question);
    $qnowithstmt = $queparts[0]; //2nd part is answer

    $qno_array = explode(".", $qnowithstmt); //get q no //array consists of qno and other parts of the qstmt separated by '.'
    $qno= $qno_array[0] ;
    $qno = preg_replace('/\s+/', '', $qno);//remove new line and other white spaces
    echo "<br><br>Q no: " . $qno. '<br>'; // q no is first element
    $qno_size = strlen($qno_array[0]);
    $qstmt = substr($qnowithstmt, $qno_size+1);//remove q no part from statement which is at 0 position, qno size + size of '.' is removed

/*
    $qno = $question_no ++;
    echo "<br><br>Q no: " . $qno. '<br>'; 
    $qstmt = $qnowithstmt;
    */
    echo "Q statement : " .  nl2br($qstmt) . '<br>';


    // extract options and answers
    $ans_part = $queparts[1];
    $a_starting_array=explode("(b)", $ans_part);
    $opA=$a_starting_array[0];
    
    $b_starting_array = explode("(c)", $a_starting_array[1]);    
    $opB= $b_starting_array[0];
    
    $c_starting_array = explode("(d)", $b_starting_array[1]);    
    $opC= $c_starting_array[0];
    
    $d_starting_array = explode("Answer:", $c_starting_array[1]);    
    $opD= $d_starting_array[0];
   
    
    $ans= $d_starting_array[1];
        $ans = preg_replace('/\s/', '', $ans);

//    $ans_array=explode("(", $d_starting_array[1]); //contains ans
//    $ans = ucfirst(preg_replace('/\s/', '', $ans_array[1]));
    
    echo "option A: ".$opA."<br>";
    echo "option B: ".$opB."<br>";
    echo "option C: ".$opC."<br>";
    echo "option D: ".$opD."<br>";
    echo "Answer:".$ans."<br>";
   
   /*
    //now insert into DB
    $query = "INSERT INTO `questions` (`id`, `qno`, `qtype`, `qtype_value`, `statement`, `A`, `B`, `C`, `D`, `answer`, `explanation`, `subject`, `topic`, `subtopic`, `static`)
        VALUES (NULL, :qno , :qtype ,:paper, :qstmt , :opA, :opB, :opC, :opD , :ans, '', '', '', '', '');";
    $paramArray = Array(
      "qno" => $qno,
        "qtype" => "MOCK",
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
   
}

echo '    </body> </html>';
