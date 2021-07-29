<?php
/*******************************************************************/
/************* Próba feladat: megy a matek *************************/
/*** Sáros Csaba                                                  **/
/*** 2021.07.29                                                   **/
/*******************************************************************/
/*******************************************************************/

class myMath
{

private $result;
private $operators = array('+','*'); // Kivonás, Osztás nem volt feladat (úgy lenne "kerek")

/*********************************************************************************/
/**************************** Public functions ***********************************/
/*********************************************************************************/

public function __construct()
{
  //DONE - nincs teendő 
}
//------------------------------------------------------------------------------//
public function getMath()
{
  
  $idx = rand(0,(sizeof($this->operators)-1));
  $operator = $this->operators[$idx]; // Ezt lehetne cifrázni: megadhatná milyen műveletet szeretne gyakorolni, most random 
  $task = $this->genTask($operator); 
  return $task;    
}
//------------------------------------------------------------------------------//
/*********************************************************************************/
/**************************** Private functions **********************************/
/*********************************************************************************/
private function genTask($op)
{
 switch ($op)
   {//Melyik művelet
    case '+'  : {//Összeadás feladat
                 $x = rand(0,100);
                 $a = $x-rand(0,$x);
                 $b = $x-$a;
                }
      break;
    case '*'  : {//Szorzás feladat
                 $a = rand(0,10);
                 $b = rand(0,10);
                 $x = $a*$b;
                };
      break;
    case '-'  : {//Kivonás feladat
                 //Nem feladat
                };
      break;
    case '/'  : {//Osztás feladat
                 //Nem feladat
                };
      break;
   }
 $task = array('opA'=>$a, 'opB'=>$b, 'opOp' => $op, 'opStr'=>$a.$op.$b, 'opRes'=>$x);
 return $task;  
}
//------------------------------------------------------------------------------//
//End of Class
};