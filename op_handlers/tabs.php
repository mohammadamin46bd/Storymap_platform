<?php
    header("Cache-Control: must-revalidate, max-age=0, s-maxage=0, no-cache, no-store");
    
	  GetRequestParameters();

		


			
		    		  $dbh = pg_connect("host=localhost port=5432 dbname=geodata user=**** password=****");
		             
		    	       
						if (!$dbh) {
							echo '{"save_status":"Error in connection"}';
							die();
		    	       	//die("Error in connection: " . pg_last_error());
		    	        } 	
	                   
                       if(empty($appName) == false && strlen($appName) != 0){
                        $sql = "select tabs_id, tabs from tabs where appname = $1 order by tabs_order ASC;";
                        $result = pg_prepare($dbh, "allakartor", $sql);
		                $result = pg_execute($dbh, "allakartor", array($appName));

                       }else{
                       	$sql = "select tabs_id, tabs from tabs order by tabs_order ASC;";
                       	$result = pg_prepare($dbh, "allakartor", $sql);
		                $result = pg_execute($dbh, "allakartor", array());  
                       	                     	
                       }
                        

		    	        
						
		    	        if (!$result) {
							echo '{"save_status":"'.$result.'"}';
							die();
		                //die("Error in SQL query: " . pg_last_error());
	                    }
						
						
							$json ='{"kartorlista":[';
                        	$total_rows = pg_num_rows($result);
                        	$i=0;
                          
                        	 while ($row = pg_fetch_assoc($result)) {
                        		$i =$i+1;
                        		$json = $json.
                        			'{'.                       				                       			
									'"tabs":"'.$row['tabs'].'",'.
									'"tabs_id":"'.$row['tabs_id'].'"'
				                    ;                        			                        			                       			
                        			if($i != $total_rows){
                        			$json = $json.'},';
                        			}else{
                        			$json = $json.'}';	
                        			}
                        		;
                        	 }     // end of loop  
                        	$json = $json. ']}';
                        	echo $json;	
						
		                
						
		                pg_free_result($result); 
		                pg_close($dbh);	
						
			
			
   function GetParameters($params)
{
    global $appName;
	
	       if (isset($params['app'])){
	       	$appName = $params['app'];  		
			}else{	       	
	        $appName = "";  	
	       }
}
 
  function GetRequestParameters()
{
    if($_SERVER['REQUEST_METHOD'] == "POST")
        GetParameters($_POST);
    else
        GetParameters($_GET);
}
	    	     		
		         	 

 ?>  