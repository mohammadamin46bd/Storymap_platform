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
	                   
                       
                        $sql = "select count(*) COUNT from kristian.items where tabs_id = '".$tabs_id."' order by items_order ASC";
                        $query = oci_parse($dbcon,$sql);
						oci_execute($query);
						
		    	        if (!$query) {
							echo '{"save_status":"'.$query.'"}';
							die();
	                    }
					   $count=0;
		    	       while (oci_fetch($query)) {								 
                            $count =oci_result($query,"COUNT");								
                        } 
						
		                $sql1 = "select * from kristian.items where tabs_id = '".$tabs_id."' order by items_order ASC";
                        $query1 = oci_parse($dbcon,$sql1);
						oci_execute($query1);
		    	        
						
		    	        if (!$query1) {
							echo '{"save_status":"'.$query1.'"}';
							die();
		                //die("Error in SQL query: " . pg_last_error());
	                    }
						
						
							$json ='{kartorlista:[';
                        	$total_rows = $count;
                        	$i=0;
                          
                        	 while (oci_fetch($query1)) {
                        		$i =$i+1;
                        		$json = $json.
                        			'{'.                       				                      			
									'items:"'.oci_result($query1,"ITEMS").'",'.
									'items_id:"'.oci_result($query1,"ITEMS_ID").'",'.
									'items_order:"'.oci_result($query1,"ITEMS_ORDER").'",';
									
									if (!empty(oci_result($query1,"CONTENT"))){
										//echo htmlentities(oci_result($query1,"CONTENT"));
										$json = $json.'content:'.trim(str_ireplace("'","_@_",str_ireplace(array("\n", "\r"), '', html_entity_decode(oci_result($query1,"CONTENT"),ENT_HTML5,'UTF-8')))).',';
									}else{
										$json = $json. 'content:"",';
									}
									$json = $json.																											
									'url:"'.oci_result($query1,"URL").'",'.
									'tabs_id:"'.oci_result($query1,"TABS_ID").'"'
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
						//file_put_contents('C:\Program Files\OSGeo\MapGuide\Web\www\op\op_handlers\log.txt', $json);
		                
						
		               OCILogoff($dbcon);		
						
			
			

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