<?php
ini_set('max_execution_time', 0);//no limit 

require_once 'library' . DIRECTORY_SEPARATOR . 'Model.php';
//$db = new Model(); /** uncomment when needed **/
echo '<html>    <head>         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">     <title></title>    </head>    <body>';


/*
  while($i<=100){
  $query= "SELECT * FROM questions WHERE qtype='MOCK' AND qtype_value='' ORDER BY RAND() LIMIT 1";
  $results=$db ->query($query);
  }
 * 
 */
//$query = "SELECT * FROM questions WHERE qtype='MOCK' AND qtype_value='' ORDER BY RAND() LIMIT 100";
$query = "SELECT * FROM questions";
$results = $db->query($query);
$qno=1;
//$paperid = 'IAS_5';

foreach ($results as $question) {
    $qid =  (int)$question['id'];
    $top=$question['topic'];
    $top=  str_replace(' ','-',  strtolower($top));
     $query = "UPDATE `questions` SET  `topic` = :topic
        WHERE `id`= :qid ";
    $paramArray = Array(
        "qid" => $qid,
        "topic" => $top
    );
    $db->execute($query, $paramArray);
    
    var_dump($paramArray);
    $qno++;
}
























echo '    </body> </html>';
