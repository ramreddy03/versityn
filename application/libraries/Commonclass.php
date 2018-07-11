<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Commonclass {	
	
	
	/*
	*	Function : update_record
	*	Usage: to update one existing record in required table
	*
	*	Params : $table, $data, $pkeyfield, $pkeyval
	*	mandatory params: - All -
	*
	*	$table = required table name
	*	$data : field name and respective value to update
	*	$data = array(
	*	   'title' => 'My title' ,
	*	   'name' => 'My Name' ,
	*	   'date' => 'My date'
	*	);
	*	$pkeyfield = primary key fieldname of table
	*	$pkeyval = primary key value (edit id)
	*
	*
	*	return flag based on the query
	*	
	*/
	public function update_record($table, $data, $pkeyfield, $pkeyval)
	{
		$CI =& get_instance();  # codeigniter library
		$CI->db->where($pkeyfield, $pkeyval);
		$update_flag = $CI->db->update($table, $data);        
		return $update_flag;   
	}
	## update_record end
	

	## truncate table start
	public function truncate_table($db_table)
	{
		$CI =& get_instance();  # codeigniter library
		$truncate_flag = "";
		
		if (!empty($db_table)) {
			$truncate_flag = $CI->db->truncate($db_table);
		}
		return $truncate_flag;   
	}
	## truncate table end
	

	## Delete record start
	public function delete_table($db_table, $whrarr)
	{
		$CI =& get_instance();  # codeigniter library
		$delete_flag = "";
		
		if (!empty($db_table)) {
			$delete_flag = $CI->db->delete($db_table, $whrarr);
		}
		return $delete_flag;   
	}
	## delete record end
	

	## Execute SQL Query start
	public function execute_rawquery($query)
	{
		$CI =& get_instance();  # codeigniter library
		$query_flag = $CI->db->query($query);
	
		return $query_flag;   
	}
	## Execute SQL Query end
	
	
	/*
	*	Function : insert_record
	*	Usage: to insert one new record in required table
	*
	*	Params : $table, $data
	*	mandatory params: $table, $data
	*
	*	$table = required table name
	*	$data = array(
	*	   'title' => 'My title' ,
	*	   'name' => 'My Name' ,
	*	   'date' => 'My date'
	*	);
	*
	*	return flag based on the query
	*	
	*/
    public function insert_record($table, $data)
    {
		$CI =& get_instance();  # codeigniter library
	
		$insert_flag = $CI->db->insert($table, $data); 
		$insert_id = $CI->db->insert_id();
		return $insert_id;
	}
	## insert_record end
	
	/*
	*	Function : retrive_records
	*	Usage: to retrive one table data
	*
	*	Params : $table, $select, $where, $orderby, $limit
	*	mandatory params: $table
	*
	*	$table: required table name (STRING)
	*	$select: to write the SELECT portion of query (STRING)
	*	$where:	to write conditions to the query (STRING)
	*		$where = "name='Joe' AND status='boss' OR status='active'";
	*	$orderby: to write orderby conditionsto the query (ARRAY)
	*		$orderby = array("id" => "DESC", "date" => "ASC");
	*	$groupby: to write groupby conditions to the query (ARRAY)
	*		$groupby = array("title", "date")
	*	$having: to write having conditions to the query (ARRAY)
	*		$having = array('title =' => 'My Title', 'id <' => $id);
	*	$limit: to limit the results/records (INT)
	*
	*	return flag based on the query
	*	
	*/
  //  public function retrive_records($table, $select = "", $where = "", $orderby = array(), $limit = '', $groupby = array(), $having = array())
	 public function retrive_records($table, $select = "", $where = "", $join = '',$joincondition='', $orderby = array(), $limit = '', $groupby = array(), $having = array())
    {
			$CI =& get_instance();  # codeigniter library
			
			## ___________ query framing starts here _______________ ##
			# SELECT part other than *
			if ( $select != array() && $select != "" && strlen($select)>0) {
				$CI->db->select($select); 
			}
			
			#table name
			$CI->db->from($table);
			
			# where conditions
			if (strlen($where)>0) {
				$CI->db->where($where);
			}
			
			
			# order by
			if (count($orderby) > 0) {
				foreach ($orderby as $fldname => $order) {
					$CI->db->order_by($fldname, $order);
				}
			}
			
			# groupby
			if (count($groupby) > 0) {
				$CI->db->group_by($groupby); 
			}
				# join
			if (strlen($join) > 0) {
				$CI->db->join($join,$joincondition); 
			}
			
			# having
			if (count($having) > 0) {
				$CI->db->having($having); 
			}
			
			# order by
			if (count($orderby) > 0) {
				foreach ($orderby as $fldname => $order) {
					$CI->db->order_by($fldname, $order);
				}
			}
			
			#limit
			if ($limit > 0) {
				$CI->db->limit($limit);
			}
			## ___________ query framing ends here _______________ ## 
			
			# Query execution and retriving results			
			$query = $CI->db->get(); 
			//echo "<br/><br/>".$CI->db->last_query();
			//$resultset = $query->result();
			
			$resultset = $query->result_array();
			$resultset = (!empty($resultset)) ? $resultset : array();
			
			return $resultset; 
    }
	## retrive_records end
	

	/*
	*	Function : download_file
	*	Usage: to download a file from uploads directory
	*
	*	params:  - all mandatory -
	*		$filetype : MIME type of the file ex: application/pdf
	*		$org_file_path : file to be downloaded including C:// path (doc root)
	*		$download_name : desired name for the download file	*
	*
	*/
	function download_file( $filetype, $org_file_path, $download_name ) {
			//echo "<br/><br/>org__". $org_file_path.basename($download_name); exit;
			header('Content-Type: '.$filetype.'');
			header('Content-Disposition: attachment; filename='.basename($download_name));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($org_file_path));
			ob_clean();
			flush();
			readfile($org_file_path);
			exit;
	}
	
 /*
	*	Function : dateformat1
	*	Usage: to change date format from "YYYY-MM-DD" to "MM/DD/YYYY"
	*
	*	Params : $date
	*	mandatory params: - All -
	*
	*	$date ="YYYY-mm-dd" #date format
	*
	*
	*	return date with new format (MM/DD/YYYY)
	*	
	*/
	public function dateformat1 ($date) {
	
		if ($date != "0000-00-00") {
			# explode given date
			$explode_date = explode("-", $date);
			# given date new format
			$newformat = date("m/d/Y", mktime(0,0,0,$explode_date[1], $explode_date[2], $explode_date[0]) ); 
			//$newformat = date("M jS Y", mktime(0,0,0,$explode_date[1], $explode_date[2], $explode_date[0]) ); 
		} else if ($date == "0000-00-00") {
			# given date new format
			$newformat = "00/00/0000"; 
		}/* else {
			$newformat = $date;
		}*/
		
		return $newformat;
	}
	
	
	/*
	*	Function : dateformat2
	*	Usage: to change date format from MM/DD/YYYY to YYYY-MM-DD
	*
	*	Params : $date
	*	mandatory params: - All -
	*
	*	$date ="MM/DD/YYYY" #date format
	*
	*
	*	return date with new format (YYYY-MM-DD)
	*	
	*/
	public function dateformat2 ($date) {
		$date = explode(" ", $date);
		$convertdate = $date[0];
		# explode given date
		$explode_date = explode("/", $convertdate);
		# given date new format
		 $newformat = date("Y-m-d", mktime(0,0,0,$explode_date[0], $explode_date[1], $explode_date[2]) ); 		
		return $newformat;
	}
	
 /*
	*	Function : dateformat1
	*	Usage: to change date format from "YYYY-MM-DD" to "MM/DD/YYYY"
	*
	*	Params : $date
	*	mandatory params: - All -
	*
	*	$date ="YYYY-mm-dd" #date format
	*
	*
	*	return date with new format (MM/DD/YYYY)
	*	
	*/
	public function dateformat3 ($date) {
	
		if ($date != "0000-00-00") {
			# explode given date
			$explode_date = explode("-", $date);
			# given date new format
			$newformat = date("dS M Y", mktime(0,0,0,$explode_date[1], $explode_date[2], $explode_date[0]) ); 
			//$newformat = date("M jS Y", mktime(0,0,0,$explode_date[1], $explode_date[2], $explode_date[0]) ); 
		} else if ($date == "0000-00-00") {
			# given date new format
			$newformat = "00/00/0000"; 
		}/* else {
			$newformat = $date;
		}*/
		
		return $newformat;
	}
	
	
	
	
	/*
	*	Function : datetimeformat
	*	Usage: to change date format from "YYYY-MM-DD H:i:s" to "MM/DD/YYYY  H:i:s"
	*
	*	Params : $date
	*	mandatory params: - All -
	*
	*	$date ="YYYY-mm-dd  H:i:s" #date format
	*
	*
	*	return date with new format (MM/DD/YYYY  H:i:s)
	*	
	*/
	public function datetimeformat ($date) {
	
		if ($date != "0000-00-00 00:00:00") {
			# explode given date
			$explode_date_new = explode(" ", $date);
			$explode_date = explode("-", $explode_date_new[0]);
			$explode_time = explode(":", $explode_date_new[1]);
			# given date new format
			 $newformat = date("m/d/Y H:i:s", mktime($explode_time[0],$explode_time[1],$explode_time[2],$explode_date[1], $explode_date[2], $explode_date[0]) );
			//$newformat = date("M jS Y", mktime(0,0,0,$explode_date[1], $explode_date[2], $explode_date[0]) ); 
		} else if ($date == "0000-00-00 00:00:00") {
			# given date new format
			$newformat = "00/00/0000 00:00:00"; 
		}/* else {
			$newformat = $date;
		}*/
		
		return $newformat;
	}
	
	
	/*
	*	Function : delete_record
	*	Usage: to update one existing record in required table
	*
	*	Params : $table, $data, $pkeyfield, $pkeyval
	*	mandatory params: - All -
	*
	*	$table = required table name
	*	$data : field name and respective value to update
	*	$data = array(
	*	   'title' => 'My title' ,
	*	   'name' => 'My Name' ,
	*	   'date' => 'My date'
	*	);
	*	$pkeyfield = primary key fieldname of table
	*	$pkeyval = primary key value (edit id)
	*
	*
	*	return flag based on the query
	*	
	*/
	public function delete_record($table, $pkeyval)
	{
		$CI =& get_instance();  # codeigniter library
		$CI->db->where($pkeyval);
		$update_flag = $CI->db->delete($table);
		
		return $update_flag;   
	}
	## delete_record end
	
	
	/*
 * Create a random string
 * @param $length the length of the string to create
 * @return $str the string
 */
function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}
}

/* End of file commonclass.php */
