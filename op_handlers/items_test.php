<?php
    header("Cache-Control: must-revalidate, max-age=0, s-maxage=0, no-cache, no-store");
    
	GetRequestParameters();

		


			
		    		  
		               $dbh = pg_connect("host=localhost port=5432 dbname=geodata user=**** password=****");
		    	       
						if (!$dbh) {
							echo '{"save_status":"Error in connection"}';
							die();
		    	       	//die("Error in connection: " . pg_last_error());
		    	        } 	
	                   
                       
                        $sql = "select * from items_test where tabs_id = $1 order by items_order ASC;";
		                $result = pg_prepare($dbh, "allakartor", $sql);
		                $result = pg_execute($dbh, "allakartor", array($tabs_id));
		    	        
						
		    	        if (!$result) {
							echo '{"save_status":"'.$result.'"}';
							die();
		                //die("Error in SQL query: " . pg_last_error());
	                    }
						
						
							$json ='{kartorlista:[';
                        	$total_rows = pg_num_rows($result);
                        	$i=0;
                          
                        	 while ($row = pg_fetch_assoc($result)) {
                        		$i =$i+1;
                        		$json = $json.
                        			'{'.                       				                      			
									'items:"'.$row['items'].'",'.
									'items_id:"'.$row['items_id'].'",'.
									'items_order:"'.$row['items_order'].'",';
									
									if (!empty($row['content'])){
										$json = $json.'content:'.trim(str_ireplace("'","_@_",str_ireplace(array("\n", "\r"), '', $row['content']))).',';
									}else{
										$json = $json. 'content:"",';
									}
									$json = $json.																											
									'url:"'.$row['url'].'",'.
									'tabs_id:"'.$row['tabs_id'].'"'
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
    global $tabs_id;
	
	       if (isset($params['tabs_id'])){
	       	$tabs_id = $params['tabs_id'];           		
			}else{
	       	
	       	echo '{"save_status":"Invalid2 request"}';
			die();
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