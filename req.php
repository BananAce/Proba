<?php
/*******************************************************************/
/************* Prуba feladat: req endpoint *************************/
/*** Sбros Csaba                                                  **/
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
  {//Adatbбzis nem elйrhetх  
    $res = array ("ERROR"=>$base->getResult()->errCode.' - '.$base->getResult()->errMessage);
    echo json_encode($res); 
    exit; //game over   
  }  
/*************/
require_once('class/class_math.php');
require_once('class/class_dbfunc.php');

 $math = new myMath();
 $dbfx = new dbFuncs($base->getDb());

 $task = $math->getMath(); //$task array = opA, opB, opOp, opStr, opRes 

 $task['taskId'] = $dbfx->saveTask($task); //Elmentjьk jуl, ha taskId == -1, akkor a feladat йrvйnytelen  
 $task['opRes'] = 'x'; //Nem mondom meg bibнн
 
echo json_encode($task);
/*******************************************************************/
?>