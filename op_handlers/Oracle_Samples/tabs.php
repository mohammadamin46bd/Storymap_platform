<?php
    header("Cache-Control: must-revalidate, max-age=0, s-maxage=0, no-cache, no-store");
    //header('Content-Type: text/html; charset=utf-8');
	  GetRequestParameters();

		
//login information for oracle database
   $un = "";//username
   $pw ="";//password
   $MYDB="";//tns

   $dbcon =oci_connect($un, $pw, $MYDB,'AL32UTF8');
  

			
		    		  
		    	       
						if (!$dbcon) {
							echo '{"save_status":"Error in connection"}';
							die();
		    	        }

                        if(empty($appName) == false && strlen($appName) != 0){							
                        $sql1 = "select count(*) COUNT from kristian.tabs where appname ='".$appName."' order by tabs_order ASC";				
                        $query1 = oci_parse($dbcon,$sql1);
						oci_execute($query1);
						
                       }else{
                       	$sql1 = "select count(*) from kristian.tabs order by tabs_order ASC;";
                        $query1 = oci_parse($dbcon,$sql1);
						oci_execute($query1);                        						                       	                     	
                       }
					   
		    	        if (!$query1) {
							echo '{"save_status":"'.$query.'"}';
							die();
	                    }
						
					   $count=0;
		    	       while (oci_fetch($query1)) {								 
                            $count =oci_result($query1,"COUNT");								
                        } 

                if($count > 0){						
	                   
                        if(empty($appName) == false && strlen($appName) != 0){							
                        $sql = "select tabs_id, tabs from kristian.tabs where appname ='".$appName."' order by tabs_order ASC";				
                        $query = oci_parse($dbcon,$sql);
						oci_execute($query);
						//$count =  oci_fetch_all($query, $res);						
                       }else{
                       	$sql = "select tabs_id, tabs from kristian.tabs order by tabs_order ASC;";
                        $query = oci_parse($dbcon,$sql);
						oci_execute($query);                        						                       	                     	
                       }
		    	        
						
						

		    	        
						
		    	        if (!$query) {
							echo '{"save_status":"'.$query.'"}';
							die();
	                    }
						
						
							$json ='{"kartorlista":[';
                        	$total_rows = $count;
                        	$i=0;
                          
                        	 while (oci_fetch($query)) {
								 
                        		$i =$i+1;
								
                        		$json = $json.
                        			'{'.                       				                       			
									'"tabs":"'.oci_result($query,"TABS").'",'.
									'"tabs_id":"'.oci_result($query,"TABS_ID").'"'
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
						
		                
						}
		                
		                OCILogoff($dbcon);	
						
			
			
   function GetParameters($params)
{
    global $appName;
	
	       if (isset($params['app'])){
	       	$appName = trim(rtrim($params['app']));  		
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