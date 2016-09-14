<?php
require_once("index.php");

class API
{
  public $data = "";
  const DB_SERVER = "localhost";
  const DB_USER = "";
  const DB_PASSWORD = "";
  const DB = "rest";

  private $db = NULL;

  public function __construct()
  {
    $this->dbConnect();// Initiate Database connection
  }

  //Database connection
  private function dbConnect()
  {
    $this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
    if($this->db)

      mysql_select_db(self::DB,$this->db);
  }

  //Public method for access api.
  //This method dynmically call the method based on the query string
  public function processApi()
  {
    $this->method  = $_SERVER['REQUEST_METHOD'];

    header("Access-Control-Allow-Orgin: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");

    if($this->method  == 'GET')
    {
      $table = $_GET['table'];
      $tableid = $_GET['tableuniqueid'];
    }
    elseif($this->method  == 'POST' || $this->method  == 'PUT')
    {
      $postData = $_POST ? $_POST : parse_str(file_get_contents("php://input"));
      $getData = $this->decodeData($data);
    }

    switch($this->method)
    {
      case 'DELETE':
        $this->request = $this->deleteStuff();
      case 'POST':
        $this->request = $this->insertStuff($_POST);
        break;
      case 'GET':
        $this->request = $this->getStuff($table,$tableid);
        break;
      case 'PUT':
        $this->request = $this->updateStuff($_GET);
        $this->file = file_get_contents("php://input");
        break;
      default:
        $this->_response('Invalid Method', 405);
        break;
    }
  }

  private function decodeData($data)
  {
    $clean_input = Array();
    if (is_array($data))
    {
      foreach ($data as $k => $v)
      {
        $clean_input[$k] = $this->_cleanInputs($v);
      }
    }
    else
    {
      $clean_input = trim(strip_tags($data));
    }
    return $clean_input;
  }

  private function _response($data, $status = 200)
  {
    header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
    return json_encode($data);
  }

  private function _requestStatus($code)
  {
    $status = array(
      200 => 'OK',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      500 => 'Internal Server Error',
    );
    return ($status[$code])?$status[$code]:$status[500];
  }

  private function getStuff($table,$tableid)
  {
    if($this->get_request_method() != "GET")
    {
      $this->response('',406);
    }
    $sql = mysql_query("SELECT * FROM".$table, $this->db);
    if(mysql_num_rows($sql) > 0)
    {
      $result = array();
      while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
      {
        $result[] = $rlt;
      }
      // If success everythig is good send header as "OK" and return list of users in JSON format
      $this->response($this->json($result), 200);
    }
    else
    {
      $this->response('',404);// If no records "No Content" status
    }
  }

  private function insertStuff($data=array())
  {
    if($this->get_request_method() != "POST")
    {
      $this->response('',406);
    }
    $sql = mysql_query("insert into".$_POST['table']);
    $last_id = mysqli_insert_id($this->db);
    if($last_id)
    {
      // If success everythig is good send header as "OK" and return list of users in JSON format
      $this->response($this->json($last_id), 200);
    }
    else
    {
      $this->response('',404);// If no records "No Content" status
    }
  }

  private function updateStuff($table,$tableid)
  {
    if($this->get_request_method() != "GET")
    {
      $this->response('',406);
    }
    $sql = mysql_query("update".$table.'set'.$getData.'where id='.$getData['id'], $this->db);
    if($sql)
    {
      // If success everythig is good send header as "OK" and return list of users in JSON format
      $this->response($this->json($sql), 200);
    }
    else
    {
      $this->response('',404);// If no records "No Content" status
    }
  }

  private function deleteStuff($table,$tableid)
  {
    if($this->get_request_method() != "GET")
    {
      $this->response('',406);
    }
    $sql = mysql_query("delete FROM".$table.'where id='.$tableid, $this->db);
    if($sql)
    {
      // If success everythig is good send header as "OK" and return list of users in JSON format
      $this->response($this->json($sql), 200);
    }
    else
    {
      $this->response('',404);// If no records "No Content" status
    }
  }

  //Encode array into JSON
  private function json($data)
  {
    if(is_array($data))
    {
      return json_encode($data);
    }
  }
}

// Initiiate Library
$api = new API;
$api->processApi();
?>