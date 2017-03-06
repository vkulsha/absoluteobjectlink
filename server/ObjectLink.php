<?php
class ObjectLink {
	public $sql;
	
    public function __construct(SQL &$sql){
		$this->sql = $sql;
    }
	
	public function cO($params){//create object and link
		try {
			$n = $params[0];

			if ($n) {
				$ret = $this->sql->iT(["object", "n", "'$n'"]);  
			} else {
				$ret = 0;
			}
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}

	public function cL($params){//link objects
		$ret = 0;
		try {
			$o1 = $params[0];
			$o2 = $params[1];
			$ret = $this->sql->iT(["link", "o1, o2", "$o1,$o2"]);  
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}
	
	public function nO($params){//update object status
		try {
			$id = $params[0];
			
			$ret = $this->sql->uT(["link", "c=0", "and (o1=$id or o2=$id)"]);
			$ret = $this->sql->uT(["object", "c=0", "and id=$id"]);  
			return $ret;
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}
	
	public function nL($params){//update link status
		try {
			$o1 = $params[0];
			$o2 = $params[1];
			
			$ret = $this->sql->uT(["link", "c=0", "and ((o1=$o1 and o2=$o2) or (o2=$o1 and o1=$o2))"]);  
			return $ret;
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}
	
	public function gO($params){//get object name by id
		try {
			$id = $params[0];
			
			$ret = $this->sql->sT(["object", "n", "and id = '$id'", "", "limit 1"]);
			return $ret ? $ret[0][0] : null;
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}

	public function gL($params){//get objects link
		try {
			$o1 = $params[0];
			$o2 = $params[1];
			
			$ret = $this->sql->sT(["link", "id", "and ((o1 = '$o1' and o2 = '$o2') or (o1 = '$o2' and o2 = '$o1')) ", "", ""]);
			return $ret ? $ret[0][0] : null;
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}
	
	public function gLO($params){//get objects linked by
		try {
			$objects = join(",",$params[0]);
			$count = count($params[0]);
			
			$sel = "and c>0 and id in ( ".
					"select o1 from ( ".
					 "select o1, o2 from link where c>0 and o2 in ($objects) ".
					 "union all ".
					 "select o2, o1 from link where c>0 and o1 in ($objects) ".
					")x where 1=1 ".
					"group by o1 ".
					"having count(o1) = $count ".
				") ";
			return $this->sql->sT(["object", "*", $sel]);
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
	
	
	
}



















?>