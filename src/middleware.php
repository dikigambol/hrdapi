<?php

use Slim\App;

return function (App $app) {
	
//=========================================================================================================================//	
	$app->options('/{routes:.+}', function ($request, $response, $args) {
		return $response;
	});
//=========================================================================================================================//
    // e.g: $app->add(new \Slim\Csrf\Guard);
    //--validasi API Key
	$app->add(function ($request, $response, $next) {


	    $key = $request->getQueryParam("z");

	    if(!isset($key)){
	        return $response->withJson(["API Key" => "Required"], 401);
	    }
	    
	    $sql = "SELECT * FROM req_api WHERE ReqApi_key='".$key."'"; 
	    $stmt = $this->db->prepare($sql);
	    $stmt->execute([":ReqApi_key" => $key]);
	    
	    if($stmt->rowCount() > 0){
	        $result = $stmt->fetch();

//=========================================================================================================================//
		$respon = $next($request, $response);
		return $respon
			->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
			->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

			header("Access-Control-Allow-Origin: *");
			header("Content-Type: application/json; charset=UTF-8");
			header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
			header("Access-Control-Max-Age: 3600");
			header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//=========================================================================================================================//
	        
	        if($key == $result["ReqApi_key"]){
	            
	            // update hit
	            $sql = "UPDATE req_api SET ReqApi_hit=:ReqApi_hit+1 WHERE ReqApi_key=:ReqApi_key";
	            $stmt = $this->db->prepare($sql);
	            $stmt->execute([":ReqApi_key" => $key]);
	            
	            return $response = $next($request, $response);

	        }
	    }
	    return $response->withJson(["status" => "Unauthorized"], 401);
	});
};
