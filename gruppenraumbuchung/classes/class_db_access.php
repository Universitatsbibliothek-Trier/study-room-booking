<?php
// Klasse DB_Access

class DB_Access
{
	
	// Members
	protected $db_name;
	protected $db_user;
	protected $db_password;
	protected $database;
	protected $db_host;
	public $connection;
	public $result;
	public $rows;
	public $fields;
	public $db_data;
	
	
	// Constructor
	

	
	function __construct($db)
	{
		switch($db)
		{
			case "gap":
			    $this->db_name=""; // Name der Datenbank
			    $this->db_host=""; // Datenbank-Host
			    $this->db_user=""; // Datenbank-User
			    $this->db_password=""; // Password
				
				break;	
		}
		
				
		$this->establishConnection();
	}
	
	
	// Methods
	
	function setDatabase($database)
	{
		$this->database=$database;
	}
	
	function setHost($db_host)
	{
		$this->db_host=$db_host;
	}
	
	function setUser($db_user)
	{
		$this->db_user=$db_user;
	}
	
	function setPassword($db_password)
	{
		$this->db_password=$db_password;
	}
	
	function establishConnection()
	{
		if($this->db_host and $this->db_user and $this->db_password)
		{
			$this->connection=mysqli_connect($this->db_host,
					$this->db_user,
					$this->db_password,
					$this->db_name);
		}
		else die("Host, user, or password is not defined.");
	}
	
	function buildSQL($purpose, $table, $data, $filter="id")
	{
		switch($purpose)
		{
			case "INSERT":
				$fields=array();
				$values=array();
				foreach($data as $field=>$value)
				{
					$fields[]="$field";
					$values[]="'" . mysql_real_escape_string($value) . "'";
				}
				$fields=implode(", ", $fields);
				$values=implode(", ", $values);
				
				$sql="INSERT INTO $table ($fields) VALUES ($values)";
				
				break;
				
			case "UPDATE":
				$allocations=array();
				foreach($data as $field=>$value)
				{
					if($field==$filter) continue;
					$allocations[]="$field = '" . mysql_real_escape_string($value) . "'";
				}
				$allocations=implode(",\n", $allocations);
				
				$sql="UPDATE $table SET $allocations WHERE $filter='" . $data[$filter] . "'";
				
				break;
		}
		
		return $sql;
	}
	
	function mysqli_field_name($result, $field_offset)
	{
		$properties = mysqli_fetch_field_direct($result, $field_offset);
		return is_object($properties) ? $properties->name : null;
	}
	
	function mysqli_result($res,$row=0,$col=0){
		$numrows = mysqli_num_rows($res);
		if ($numrows && $row <= ($numrows-1) && $row >=0){
			mysqli_data_seek($res,$row);
			$resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
			if (isset($resrow[$col])){
				return $resrow[$col];
			}
		}
		return false;
	}
	
	
	function executeSQL($sql)
	{
		//$result=mysql_db_query($this->db_name, $sql, $this->connection);
		$result=mysqli_query($this->connection, $sql);
		if($result AND preg_match("!^(SELECT|SHOW)!", $sql))
		{
			$this->rows=mysqli_num_rows($result);
			$this->fields=mysqli_num_fields($result);
			
			$this->db_data=array();
			
			for($r=0;$r<$this->rows;$r++)
			{
				for($f=0;$f<$this->fields;$f++)
				{
					$field_name=$this->mysqli_field_name($result, $f);
					$this->db_data[$r][$field_name]=$this->mysqli_result($result,$r,$field_name);
				}
			}
			
			return $this->db_data;
		}
		else return $result;
	}	
	
	function getObjectData($table, $value, $field="id")
	{
		$value=preg_replace("!([^\;]*)\;(.*)!","$1", $value);
		
		$sql="SELECT * FROM $table WHERE $field='$value'";
		$result=mysqli_query($this->connection, $sql);
		
		if($result)
		{
			$rows=mysqli_num_rows($result);
			$fields=mysqli_num_fields($result);
			
			if($rows)
			{
				for($f=0; $f<$fields; $f++)
				{
					$field_name=$this->mysqli_field_name($result, $f);
					$object_data[$field_name]=$this->mysqli_result($result, 0, $field_name);
				}
				return $object_data;
			}
			else return false;
		}
		else return false;
	}
	
	function getTableFields($table)
	{
		//SHOW COLUMNS FROM tabelle
		$result=mysql_list_fields($this->db_name, $table, $this->connection);
		$number_of_fields=mysql_num_fields($result);
		$fields=array();
		
		for ($x=0; $x < $number_of_fields; $x++ )
		{
			$fields[]=mysql_field_name ($result, $x);
		}
		return $fields;
	}
	
	function isUnique($uniq_id, $table, $field="uniq_id")
	{
		$sql="SELECT id FROM $table WHERE $field='$uniq_id'";
		$this->executeSQL($sql);
		
		if($this->rows) return false;
		else return true;
	}
	
	function getIdByUniqId($uniq_id, $table)
	{
		$sql="SELECT id FROM $table WHERE uniq_id='$uniq_id'";
		$this->executeSQL($sql);
		
		if($this->rows)
		{
			$id=$this->db_data[0]["id"];
			return $id;
		}
		else return false;
	}
	
}
