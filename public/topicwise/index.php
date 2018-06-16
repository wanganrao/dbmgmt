<?php
ini_set('max_execution_time', 0);//no limit 
/* To manage database */
require_once 'library' . DIRECTORY_SEPARATOR . 'Model.php';
$db = new Model();

echo '<html>    <head>         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">     <title></title>    </head>    <body>';
$totalQ = 1;
//$paper = '2016';
$topics = array("agriculture-in-economy", "agriculture", "ancient-history",
    "biology", "ca-international", "ca-national",
    "ca-snt-biotech", "ca-snt-comp-it", "ca-snt-defence",
    "ca-snt-nuclear", "ca-snt-space", "ca-sports",
    "chemistry", "constitution", "ecology-climate-change",
    "indian-geography", "indian-government", "indian-industries",
    "indian-panorama", "judiciary-legal-rights", "medieval-history",
    "modern-history", "national-movement", "panchayati-raj-public-policy",
    "physical-geography", "physics", "planning-development",
    "sports", "structure-of-indian-economy", "tertiary-sector-economy",
    "world-panorama", "world-political-geography");

foreach ($topics as $topic) {
//   $topic=$topics[1];
    $i = 0;

    echo "*************$topic*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************";
    $questions = explode("\r\n\r\n", file_get_contents("files/topicwise/$topic.txt"));
    echo "No of Q : " . sizeof($questions) . '<br>';

    $answers = explode("\r\n", file_get_contents("files/topicwise/$topic-answers.txt"));
    echo "No of Ans : " . sizeof($answers) . '<br>';
    if (sizeof($questions) != sizeof($answers)) {
        echo "no of ans and no of Q not matching bhau! &&&###&&&";
    }

//var_dump($questions[1]);
//print_r ($questions);
    foreach ($questions as $question) {
//    echo $question."<br>";
//    print_r($question);
        $queparts = explode("(a)", $question);
        $qnowithstmt = $queparts[0]; //2nd part is answer

        $qno_array = explode(".", $qnowithstmt); //get q no //array consists of qno and other parts of the qstmt separated by '.'
        $qno = $qno_array[0];
        $qno = preg_replace('/\s+/', '', $qno); //remove new line and other white spaces
        echo "<br><br><br><br>Topic: " . $topic . '<br>';
        echo "<br><br>Q no: " . $qno . '<br>'; // q no is first element
        $qno_size = strlen($qno_array[0]);
        $qstmt = substr($qnowithstmt, $qno_size + 1); //remove q no part from statement which is at 0 position, qno size + size of '.' is removed
        preg_match('/\[.*\]/', $qstmt, $matches);
//            var_dump($matches);
        $year = substr($matches[0], 1, 4); //returns year
        echo "Q Year : " . $year . '<br>';

        $qstmt = preg_replace('/\[.*\]/', '', $qstmt); //remove year from q stmt
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
          $d_starting_array = explode("Ans.", $c_starting_array[1]);
          $opD= $d_starting_array[0];


          $ansWithExplanation= $d_starting_array[1];
          $ans_array=explode("\n", $ansWithExplanation);
          $ans=$ans_array[0];
          $explanation=substr($ansWithExplanation, 3);
          $ans = preg_replace('/\s/', '', $ans);
         */
//    $ans_array=explode("(", $d_starting_array[1]); //contains ans
//    $ans = ucfirst(preg_replace('/\s/', '', $ans_array[1]));

        echo "option A: " . $opA . "<br>";
        echo "option B: " . $opB . "<br>";
        echo "option C: " . $opC . "<br>";
        echo "option D: " . $opD . "<br>";

        echo "Q Answer stmt: " . nl2br($answers[$i]) . '<br>';
        preg_match('/\(.\)/', $answers[$i], $matches); //to match option in ans
//    print_r($matches);
        $ans = substr($matches[0], 1, 1);
        $ans = ucfirst($ans);
        echo "Correct option : " .$ans . "<br>";
        //to get the explanation
        $temp = strpos($answers[$i], $matches[0]); //temp returns position of (a)
        $explanation = substr($answers[$i], $temp + 3);
        echo "Ans Explanation: " . $explanation . '<br>';

        /*
         * to check qno and ans no are matching

          $myQstmt=$qno.'. ('.$ans.')'.$explanation;
          if($myQstmt!=$answers[$i]){
          echo "ans not matching bhau! &&&###&&&";
          }
         * 
         */
        $i++;
//    echo "Answer:".nl2br($ans)."<br>";
//    echo "Answer:".$ans."<br>";
//       echo "exp:".nl2br($explanation)."<br>";
//       
       /*
        //now insert into DB
        $query = "INSERT INTO `explanations` (`id`, `qno`, `qtype`, `qtype_value`, `statement`, `A`, `B`, `C`, `D`, `answer`, `explanation`, `subject`, `topic`, `subtopic`, `static`)
          VALUES (NULL, :qno , :qtype ,:paper, :qstmt , :opA, :opB, :opC, :opD , :ans, :exp, '', :topic, '', '');";
        $paramArray = Array(
            "qno" => $qno,
            "qtype" => "CSP",
            "paper" => $year,
            "qstmt" => $qstmt,
            "opA" => $opA,
            "opB" => $opB,
            "opC" => $opC,
            "opD" => $opD,
            "ans" => $ans,
            "exp" => $explanation,
            "topic" => $topic,
        );
        $db->execute($query, $paramArray);
*/
        $totalQ++;
    }
}//end of topic loop

echo "<br><br><br>total no of questions on the page: " . $totalQ;
echo '    </body> </html>';
