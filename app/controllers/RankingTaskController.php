<?php

require_once('src/models/RankingTask.php');
require_once("services/errors/BadRequestError.php");
require "services/responses/Response.php";
require_once("services/Database.php");

class RankingTask implements Controller
{

    private $connection;
    private $badRequestError;
    private $database;

    
    public function __construct($database)
    {
      $database->connect();
      $this->connection = $database->getConnection();
      $this->badRequestError = new BadRequestError();
      $this->database = new Database();
      $this->response = new Response();
    }

    public function get($params)

    {

      if(count($params) < 2){
        return BadRequestError::throw();
      }

      $paramsinput['code'] = $params[1];
      if(count($params) > 2){
      $paramsinput['id'] = $params[2];
      }

      if(count($params) > 2){
        $result = Ranking::get($paramsinput);
      }
      else{
        $result = Ranking::getAll($paramsinput);
      }
  
  
       if ($result['result'] == true) {
        $response['code'] = Response::successful()['code'];
        $response['message'] = Response::successful()['message'];
        $response ['data'] = $result['data'];
        return $response;
      } else {
        $response['code'] = NotFoundError::throw()['code'];
        $response['message'] = NotFoundError::throw()['message'];
        return $response;
      }
    }

    public function post($variables)
    {
      $this->database->connect();
      $result = Ranking::insert($variables);
  
  
      $response = Response::successful();
      $response ['message'] = $result['message'];
  
  
      if ($result == true) {
        return $response;
      } else {
        return false;
    }

  }

    public function put($variables)
    {
      $result = Ranking::update($variables);

      if ($result['result'] == true) {
        $response['code'] = Response::successful()['code'];
        $response['message'] = Response::successful()['message'];
        return $response;
      } else {
        $response = BadRequestError::throw();
        $response['message'] = $result['message'];
        return $response;
      }
    }

    public function delete($variables)
    {

      $paramsinput['code'] = $variables[1];
      $paramsinput['id'] = $variables[2];

      
      $result = Ranking::delete($paramsinput,'user');
  
      $response = Response::successful();
      $response ['message'] = $result['message'];
  
  
      if ($result == true) {
        return $response;
      } else {
        return false;
      }
    }
}