<?

/*
* Copyright (C) 2014
* Mauricio <soporte@hacamedia.com>
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

/**
* ==== ZMSQL Class
*
* ==== @category Database Access
* ==== @package ZMSQL
* ==== @author Mauricio <mauricio@jhacamedia.com>
* ==== @version 1.0
**/

// == ZMSQL Version 1.0
// == INICIO

class ZMSQL{
    
    private $mysqli;
 	private $access;

 	private $select;
 	private $insert;
 	private $update;
 	private $delete;

 /*===================================
  *-------------Constructor-----------
  *==================================*/

    public function __construct($user, $password, $database, $host = 'localhost'){


  //*Mensajes Varios
 
    	$msg = array(
 			'connection' => '<h2>Error al tratar de conectar a la base de datos.</h2>'
 		);

 //*Incio de objecto access.
 //*Almacena los datos de acceso a la base de datos.

 		$this->access = new stdClass();
 		$this->access->host =  $host;
 		$this->access->user =  $user;
 		$this->access->password =  $password;
 		$this->access->database =  $database;

 //*Conexión a la base de datos.
 //*Puedes remover el @ para mostrar posibles errores.

	    $this->access->connection = @new mysqli(
	                                    $this->access->host,
	                                    $this->access->user,
	                                    $this->access->password,
	                                    $this->access->database
	                                   );

	             if($this->access->connection->connect_error){
	                 die($msg['connection']);
	                 exit;
	             }else{
		             $this->access->connection->set_charset("utf8");
		         	 $this->mysqli = $this->access;
	         	}
	         
    }

     /*=================================
	  *-----------UPDATE----------------
	  *================================*/

     public function update($table){

    	$this->clear();

    	$this->update = new stdClass();

    	$this->update->status = true;
    	$this->update->from = $table;
    	$this->update->condition = '';
    	$this->select->operator = 'AND';

    	return $this;
    }


     /*=================================
	  *-----------DELETE----------------
	  *================================*/


     public function delete($table){

    	$this->clear();

    	$this->delete = new stdClass();

    	$this->delete->status = true;
    	$this->delete->from = $table;
    	$this->delete->condition = '';
    	$this->select->operator = 'AND';

    	return $this;
    }

     /*=================================
	  *-----------SELECT----------------
	  *================================*/

    public function select($table){

    	$this->clear();

    	$this->select = new stdClass();

    	$this->select->status = true;
    	$this->select->from = $table;
    	$this->select->ind = '*';
    	$this->select->condition = '';
    	$this->select->operator = 'AND';


    	return $this;
    }

//========================================================================


     /*=================================
	  *-----------INSERT----------------
	  *================================*/

    public function insert($table){

    	$this->clear();

    	$this->insert = new stdClass();

    	$this->insert->status = true;
    	$this->insert->from = $table;
    	$this->insert->condition = '';

    	return $this;
    }

    /*=================================
	 *-----------SET-------------------
	 * Uso para el método @update.
	 *================================*/

    public function set($update_data){

    		$this->update->columns = '';
    		$this->update->values = '';

    		$att = array();

		    foreach ($update_data as $key => $value) {

		        $att[] = "{$key}='{$value}'";
		    
		    }

            $this->update->values  .= join(", ", $att);

        return $this;

    }

    /*=================================
	 *-----------VALUES----------------
	 * Uso para el método @insert.
	 *================================*/

    public function values($insert_data){

    		$this->insert->columns = '';
    		$this->insert->values = '';

    		$att = array();
            $val = array();

            foreach ($insert_data as $key => $value) {

               $att[] ="'".$value."'";
               $val[] = $key;

           }

            $this->insert->values  .= join(", ", $att);
            $this->insert->columns  .= join(", ", $val);

        return $this;

    }

    /*=================================
	 *-----------SET-------------------
	 * Uso para el método @select.
	 *================================*/

    public function distinct($str){

    	$this->select->ind = 'DISTINCT '.$str;

    	return $this;

    }

    /*===================================================
	 *-----------------------WHERE-----------------------
	 * Uso para el método @select || @update || @delete  
	 *==================================================*/

    public function where($c, $cl = null){

    	$o = 'AND';

    	if(isset($this->select->status) && $this->select->status == true){

    		$o = $this->select->operator;

    		$this->obtainCondition($this->select, $c, $o, $cl);

    	}else if(isset($this->delete->status) && $this->delete->status == true){

    		$o = $this->delete->operator;

    		$this->obtainCondition($this->delete, $c, $o, $cl);

    	}else if(isset($this->update->status) && $this->update->status == true){

    		$o = $this->update->operator;

    		$this->obtainCondition($this->update, $c, $o, $cl);

    	}

    	return $this;
    }

    /*===================================================
	 *-----------------setOperator-----------------------
	 * Uso para el método @select || @update || @delete  
	 * Cambia el operador lógico (AND , OR)
	 *==================================================*/

    public function setOperator($op){

    	if(isset($this->select->status) && $this->select->status == true){

    		$this->select->operator = $op;


    	}else if(isset($this->delete->status) && $this->delete->status == true){

    		$this->delete->operator = $op;

    	}else if(isset($this->update->status) && $this->update->status == true){

    		$this->update->operator = $op;

    	}

    	return $this;
    }

    /*===================================
	 *-----------------Order-------------
	 * Uso para el método @select
	 *===================================*/

    public function order($attr, $order){

    	$this->select->order = $attr . ' ' . $order;

    	return $this;

    }

    /*===================================
	 *-----------------Limit-------------
	 * Uso para el método @select
	 *===================================*/

    public function limit($ini, $fin = null){

    	if(isset($ini) && !isset($fin)){

    		$this->select->limit = "{$ini}";
    	
    	}else if(isset($ini) && isset($fin)){

			$this->select->limit = "{$ini}" . ', ' . "{$fin}";

    	}

    	return $this;

    }


     /*==========================================================
	 *-----------------------WHERE-------------------------------
	 * Uso para el método @select || @update || @delete || @insert 
	 * Ejecuta el query
	 *==========================================================*/

    public function run(){


	    	if(isset($this->select->status) && $this->select->status == true){

	    			$querie = $this->select->syntax = "SELECT {$this->select->ind} FROM {$this->select->from}";

	    			if(isset($this->select->condition) && $this->select->condition != ''){

    					$this->select->condition = trim($this->select->condition, 'AND ');
    					$this->select->condition = trim($this->select->condition, 'OR ');

	    				$querie = $querie. " WHERE " .$this->select->condition;
	    			}

					if(isset($this->select->order) && $this->select->order != '')
	    				$querie = $querie. " ORDER by " .$this->select->order;

	    			if(isset($this->select->limit) && $this->select->limit != '')
	    				$querie = $querie. " LIMIT " .$this->select->limit;

			    	$exec = $this->mysqli->connection->query($querie);

			    	$this->throwError($exec);


			        $arr = array();

				        while($row=$exec->fetch_assoc()){

				            array_push($arr,$row);
				        
				        }


	        	return ($arr);

	    	}else if(isset($this->insert->status) && $this->insert->status == true){

	    			$querie = $this->insert->syntax = "INSERT INTO {$this->insert->from}({$this->insert->columns}) VALUES ({$this->insert->values})";
			    	
			    	$this->throwError($exec);

			    	$exec = $this->mysqli->connection->query($querie);

		    	return $exec;

	    	}else if(isset($this->delete->status) && $this->delete->status == true){

	    			$querie = $this->delete->syntax = "DELETE FROM {$this->delete->from}";

	    			if(isset($this->delete->condition) && $this->delete->condition != '')
	    				$querie = $querie. " WHERE " .$this->delete->condition;

			    	$exec = $this->mysqli->connection->query($querie);

	    			$this->throwError($exec);


		    	return $exec;

	    	}else if(isset($this->update->status) && $this->update->status == true){

	    			$querie = $this->update->syntax = "UPDATE {$this->update->from} SET {$this->update->values}";

					$querie = $querie. " WHERE " .$this->update->condition;

			    	$exec = $this->mysqli->connection->query($querie);

			    	$this->throwError($exec);

		    	return $exec;
	    	}

	   

    }

    /*=================================
	 *---------CLASES PRIVADAS---------
	 *================================*/

    private function clear(){

    	if(isset($this->select->status))$this->select->status = false;

    	if(isset($this->insert->status))$this->insert->status = false;

    	if(isset($this->update->status))$this->update->status = false;

    	if(isset($this->delete->status))$this->delete->status = false;

    }

    private function obtainCondition($sk, $condition, $operator, $cl){
    	if(is_array($condition)){

	    		$sk->condition = '';

	    		$att = array();

	            foreach ($condition as $key => $value) {

	               $att[] = "{$key}='{$value}'";

	           }

	            $sk->condition  .= join($operator." ", $att);

    		}else{

    			$condition = str_replace('?', "'".$cl."'", $condition);

    			$sk->condition .= " {$operator} " . $condition ;

    		}

    		return $sk->condition ;
    }
 
    private function throwError($exec){

    	if (!$exec) {

		    throw new Exception("Fatality!! [{$this->mysqli->connection->errno}] {$this->mysqli->connection->error}");
		
		}
    }
   
    

}