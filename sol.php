<?php
/*******************************************************************/
/************* Próba feladat: SOLution endpoint ********************/
/*** Sáros Csaba                                                  **/
/*** 2021.07.29                                                   **/
/*******************************************************************/
/*******************************************************************/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
/*** INIT ***/
session_start();
require_once('class/class_base.php');
$base = new base("math.ini");
if (!$base->getResult()->DB)
  {
    $res = array ("ERROR"=>$base->getResult()->errCode.' - '.$base->getResult()->errMessage);
    echo json_encode($res); 
    exit;    
  }  
/*************/
require_once('class/class_dbfunc.php');
 $dbfx = new dbFuncs($base->getDb());

 $solution = json_decode(file_get_contents("php://input")); // Beadvány
 if (!(isset($solution->taskId) && isset($solution->x)))
   {//Ha valamelyik paraméter hiányzik, akkor hisztizünk és game over
    echo json_encode(array("FAIL"=>"Nem megfelelő paraméter"));
    exit;
   }  
   
 $rightSolution = $dbfx->getResult($solution->taskId); // A helyes eredményt elővesszük
 if ($rightSolution)
   {//Megvan az eredmény
    if ($rightSolution['ta_op_x'] == $solution->x)
      {//A megoldás helyes 
       $answer = array ("msg"=>"Ügyes vagy, az eredmény helyes"); 
      }
    else
      {//Megoldás helytelen (Nem egyezik a tárolttal)
       $answer = array ("msg"=>"Sajnálom, hibás megoldás. (A helyes eredmény: ".$rightSolution['ta_op_x'].") Ezt még egy kicsit gyakorolni kell!");   
      }
   }
 else
   {//A beküldött ID-val nincs találat!
    $answer = array ("msg"=>"A megadott azonosítóval (".$solution->id.") nem találtam feladatot!");
   }  
        
echo json_encode($answer);
/********************************************************/
?>