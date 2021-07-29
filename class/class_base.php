<?php
/*******************************************************************/
/****************** INI file handle  + db Init *********************/
/**************** CvikkeReM® egységesítés!!                       **/
/*** ©ProBienn                                                    **/
/*** Sáros Csaba                                                  **/
/*** 2020.04.30                                                   **/
/*******************************************************************/
/*******************************************************************/
/*** Próba feladathoz átvéve ***************************************/
/*** 2021.07.28 ****************************************************/
/*******************************************************************/
class base
{

private $result;
private $iniFile;
private $cfgs;
private $cfg;
private $db;
private $lastError;

/*********************************************************************************/
/**************************** Public functions ***********************************/
/*********************************************************************************/

public function __construct($iniFile)
{
  $this->iniFile = $iniFile;
  $this->result = new stdClass();
  $this->result->errCode = '0';
  $this->result->errMessage = "OK";
  $this->result->INI = $this->setCfg();
  if ($this->result->INI)
   {
    $host = $this->cfgs['database']['host'];
    $db   = $this->cfgs['database']['database'];
    $user = $this->cfgs['database']['username'];
    $pass = $this->cfgs['database']['password'];
    $this->connDb($host,$db,$user,$pass);
    if ($this->result->errCode=='0')
     {
      $this->result->DB = 1;
     }
    else
     {
      $this->result->DB = 0;
     } 
   }
}
//------------------------------------------------------------------------------//
public function getResult()
{
  return $this->result;
}
//------------------------------------------------------------------------------//
public function getDB()
{
  return $this->db;
}
//------------------------------------------------------------------------------//
public function getCfgValue($section,$node='NONE')
{

 if ($node=='NONE')
  return $this->cfg[$section];  
 else
  return $this->cfgs[$section][$node];
}
//------------------------------------------------------------------------------//

/*********************************************************************************/
/*************************** Private functions ***********************************/
/*********************************************************************************/
private function setCfg()
{// init konfig 
  $result = TRUE;
  $this->result->errCode = '0'; 
  $this->result->errMessage = "OK";
  if (!file_exists($this->iniFile))
   {
    $this->result->errCode    = 'F0001';
    $this->result->errMessage = "INI file nem található!";
    $result = FALSE;
    return $result;
   }


  $cfg = parse_ini_file($this->iniFile,TRUE);
  if ($cfg)
    {
     $this->cfgs = $cfg;
    }
  else
    {
     $this->result->errCode    = 'F0002';
     $this->result->errMessage = " INI file nem értelmezhető (Section)";
     $result = FALSE;
    }

  $cfg = parse_ini_file($this->iniFile);
  if ($cfg)
    {
     $this->cfg = $cfg;
    }
  else
    {
     $this->result->errCode    = 'F0003';
     $this->result->errMessage = " INI file nem értelmezhető";
     $result = FALSE;
    }  
  return $result;   
}
//------------------------------------------------------------------------------//
private function connDb($host,$database,$user,$password)
{
  $result = TRUE;
  $this->result->errCode = '0'; 
  $this->result->errMessage = "OK";

  try
      {
      $this->db = new PDO('mysql:host='.$host.';dbname='.$database,$user,$password); //,array(PDO::ATTR_PERSISTENT => true));
      $this->db->exec("SET CHARACTER SET utf8");
      $this->db->exec("SET NAMES UTF8");
      }
  catch (PDOException $e)
      {
       $result = FALSE; 
       $this->result->errCode = 'D0001';
       $this->result->errMessage = $e->getMessage();
       //die();
      }
  return $result;    
}
//------------------------------------------------------------------------------//
//End of Class
};