<?php
class ObjectLink {
	public $sql;
	public $u;
	public $object;
	public $link;
	
    public function __construct(SQL &$sql, $object, $link){
		$this->sql = $sql;
		$this->object = isset($object) ? $object : "object";
		$this->link = isset($link) ? $link : "link";
    }

	public function cD(){//create database
		try {
			$sqlObject = file_get_contents(($this->object).".sql");
			$sqlLink = file_get_contents(($this->link).".sql");
			if ($sqlObject) $retO = $this->sql->sql([$sqlObject]);
			if ($sqlLink) $retL = $this->sql->sql([$sqlLink]);
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return ($retO && $retL);
	}
	
	public function cO($params, $notPolicy=false){//create object and link
		$func = debug_backtrace()[0]['function'];
		if (!$notPolicy && !$this->getPolicy([$this->u, [$func, "iii"]])) return 0;
		try {
			$n = $params[0];
			$pid = isset($params[1]) ? $params[1] : 1;
			$u = $this->u;//isset($params[2]) ? $params[2] : 1;

			if ($n) {
				if ($pid) {
					//$id = 0;
					$id = $this->gO([$n, null, null, [$pid]]);
				}
				
				if (!$id) {
					$id = $this->sql->iT([$this->object, "n,u", "'$n',$u"]);
					
					if ($pid) {
						$this->cL([$id, $pid, $u]);
					}

				}

				$ret = $id;
			} else {
				$ret = 0;
			}
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}

	public function cL($params, $notPolicy=false){//link objects
		$func = debug_backtrace()[0]['function'];
		if (!$notPolicy && !$this->getPolicy([$this->u, [$func, "iii"]])) return 0;

		$ret = 0;
		try {
			$o1 = $params[0];
			$o2 = $params[1];
			$u = $this->u;//isset($params[2]) ? $params[2] : 1;
			
			$lid = $this->sql->sT([$this->link, "id", "and ( (o1 = $o1 and o2 = $o2) or (o1 = $o2 and o2 = $o1) )"]);  
			$lid = $lid ? $lid[0][0] : null;
			
			if (!$lid) {
				$ret = $this->sql->iT([$this->link, "o1, o2, u", "$o1,$o2,$u"]);  
			} else {
				$ret = $this->sql->uT([$this->link, "d = CURRENT_TIMESTAMP, u = $u, c = 1", "and id = $lid"]);  
			}
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}

	public function gO($params){//get object id by name
		try {
			$link = $this->link;
			$n = $params[0];
			$isClass = isset($params[1]) && $params[1] ? "and id in (select o1 from $link where o2 = 1) " : "";
			$isLike = isset($params[2]) && $params[2];
			$isLikeTxt = $isLike ? " and n like '%$n%' " : " and n = '$n' ";
			//$inClass  = isset($params[3]) && $params[3] ? " and id in ( select o1 from link where o2 = ".$params[3]." and o1 not in (select o1 from link where o2 = 1) ) " : "";
			$inClass  = isset($params[3]) && $params[3] ? " and id in ( select o1 from $link where o2 in (".join(",",$params[3]).") and o2 in (select o1 from $link where o2 = 1) ) " : "";
			$ret = $this->sql->sT([$this->object, $isLike ? "id,n" : "id", "$isLikeTxt $isClass $inClass", $isLike ? "order by n, c desc" : "order by c desc, d desc", $isLike ? "" : "limit 1"]);
			return $ret ? ($isLike ? $ret : $ret[0][0]) : null;
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}
	
	public function gN($params){//get object name by id
		try {
			$id = $params[0];
			
			$ret = $this->sql->sT([$this->object, "n", "and id = '$id'", "", "limit 1"]);
			return $ret ? $ret[0][0] : null;
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}

	public function gL($params){//get link objects
		try {
			$o1 = $params[0];
			$o2 = $params[1];
			
			$ret = $this->sql->sT([$this->link, "id", "and ((o1 = '$o1' and o2 = '$o2') or (o1 = '$o2' and o2 = '$o1')) ", "", ""]);
			return $ret ? $ret[0][0] : null;
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}
	
	public function uO($params, $notPolicy=false){//update object name by id
		$func = debug_backtrace()[0]['function'];
		if (!$notPolicy && !$this->getPolicy([$this->u, [$func, "iii"]])) return 0;
		try {
			$id = $params[0];
			$n = $params[1];
			//$u = isset($params[2]) ? $params[2] : 1;
			
			$ret = $this->sql->uT([$this->object, "n='$n'", "and id=$id"]);  
			return $ret;
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}
	
	public function eO($params, $notPolicy=false){//erase object from database
		$func = debug_backtrace()[0]['function'];
		if (!$notPolicy && !$this->getPolicy([$this->u, [$func, "iii"]])) return 0;
		return $this->nO($params);
	}
	
	public function nO($params){//update object status
		try {
			$id = $params[0];
			$fn = isset($params[1]) ? $params[1] : null;
			$u = $this->u;//isset($params[2]) ? $params[2] : 1;
			
			if ($fn) {
				try {
					$path = mb_convert_encoding($fn, "cp1251", "UTF-8");
					unlink($path);
				} catch(Exception $e) {
				}
			}
			
			$ret = $this->sql->uT([$this->link, "c=0,u=".$u, "and (o1=$id or o2=$id)"]);
			$ret = $this->sql->uT([$this->object, "c=0,u=".$u, "and id=$id"]);  
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
			$u = $this->u;//isset($params[2]) ? $params[2] : 1;
			
			$ret = $this->sql->uT([$this->link, "c=0,u=".$u, "and ((o1=$o1 and o2=$o2) or (o2=$o1 and o1=$o2))"]);  
			return $ret;
			
		} catch (Exception $e) {
			print($e);
			$ret = null;
		}
		return $ret;
	}
		
	public function eL($params, $notPolicy=false){//erase link from database
		$func = debug_backtrace()[0]['function'];
		if (!$notPolicy && !$this->getPolicy([$this->u, [$func, "iii"]])) return 0;
		return $this->nL($params);
	}

	public function getTableQuery2($params, $notPolicy=false){//[{id:1331, n:"ик", parentCol:0, inClass:false}]
		if (!$notPolicy && !$this->getPolicyLazy()) return [];
		try {
			$object = $this->object;
			$link = $this->link;
			$paramsArr = $params[0];
			$groupbyind = isset($params[1]) ? $params[1] : "0";
			$includeLinkDate = isset($params[2]) && $params[2] ? true : false;
			
			$result = [];
			$head = [];
			$body = [];
			$foot = [];
			$c_bigger_zero = [];
			$i = -1;
			foreach ($paramsArr as $cc){
				$i++;
				if (isset($cc["n"])) {
					$id = isset($cc["id"]) ? $cc["id"] : null;
					$col = isset($cc["n"]) ? $cc["n"] : "o".$id;
					$pcol = isset($cc["parentCol"]) ? $cc["parentCol"] : null;
					$inClass = isset($cc["inClass"]) ? $cc["inClass"] : null;
					if ($i==0){
						$h = "select o".$i.".id `id_".$col."`, o".$i.".n `".$col."` \n";
						if ($includeLinkDate) {
							$h = $h.", o".$i.".id `d_".$col."` \n";
						}
						$l = $id ? $id : "(select id from $object where n='".$col."' limit 1)";
						$b = 
							"from (\n".
							"	select id, n, c from $object where 2=2 and id in ( \n".
							"		select o1 from $link where 2=2 and c>0 and o2 = ".$l." \n".
							($inClass ? "" : "and o1 not in (select o1 from $link where o2 = 1) \n").
							"	) \n".
							"	group by id \n".
							")o".$i." \n";
						$c = " where 1=1 and (o".$i.".c>0  or o".$i.".id is null)\n";

						$head[] = $h;
						$body[] = $b;
						$c_bigger_zero[] = $c;
					} else {
						$h = "";
						if ($groupbyind !== false) {///*order by o".$i.".id desc*/
							$h = ",case when count(distinct o".$i.".id) <= 2 then group_concat(distinct o".$i.".id SEPARATOR ';') else concat(o".$i.".id,';..') end `id_".$col."` ".
								",case when count(distinct o".$i.".id) <= 2 then group_concat(distinct o".$i.".n SEPARATOR ';') else concat(o".$i.".n,';..') end `".$col."` ".
								",count(distinct o".$i.".id) `кол-во ".$col."` \n";
						} else {
							$h = ",o".$i.".id `id_".$col."` ".
								",o".$i.".n `".$col."` ";
							if ($includeLinkDate) {
								$h = $h.",l".$i.".d `d_".$col."` ".
										",l".$i.".c `c_".$col."` ";
							}
						}
						$l = $id ? $id : "(select id from $object where n='".$col."' limit 1)";
						$parentCol = $pcol ? $pcol : 0;
						$b = 
							"left join ( \n".
							"	select o1, o2, d, c from $link where 2=2 and o1 in ( \n".
							"		select o1 from $link where c>0 and o2 = ".$l." \n".
							($inClass ? "" : "and o1 not in (select o1 from $link where o2 = 1) \n").
							"	) \n".
							" union all \n".
							"	select o2, o1, d, c from $link where 2=2 and o2 in ( \n".
							"		select o1 from $link where c>0 and o2 = ".$l." \n".
							($inClass ? "" : "and o1 not in (select o1 from $link where o2 = 1) \n").
							"	) \n".
							"	group by o1, o2 \n".
							")l".$i." on l".$i.".o2 = o".$parentCol.".id and l".$i.".c>0 left join $object o".$i." on o".$i.".id = l".$i.".o1 \n";
						$c = " and (o".$i.".c>0  or o".$i.".id is null)\n";

						$head[] = $h;
						$body[] = $b;
						$c_bigger_zero[] = $c;
					}
				}
			}
			
			if ($groupbyind !== false) {
				$foot[] = "group by o".$groupbyind.".id having 1=1 \n\n";
			}
			$result = join("",$head).join("",$body).join("",$foot).join("",$c_bigger_zero);
			return $result;
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}

	public function gTq2($params, $notPolicy=false){//["a","b","c"], [[1,0],[2,0],[3,1]], [1], false
		try {
			$nArr = isset($params[0]) ? $params[0] : [];
			$parentColArr = isset($params[1]) ? $params[1] : [];
			$inClassArr = isset($params[2]) ? $params[2] : [];
			$groupByInd = isset($params[3]) ? $params[3] : false;

			//$fields = isset($params[4]) ? join(",", $params[4]) : "*";
			//$cond = isset($params[5]) ? $params[5] : "";
			$includeLinkDate = isset($params[6]) && $params[6] ? true : false;
			
			$opts = [];
			for ($i=0; $i < count($nArr); $i++){
				$opts[] = array("n"=>$nArr[$i], "parentCol"=>0, "linkParent"=>false);
			}
			for ($i=0; $i < count($parentColArr); $i++){
				$opts[$parentColArr[$i][0]]["parentCol"] = $parentColArr[$i][1];
			}
			for ($i=0; $i < count($inClassArr); $i++){
				$opts[$inClassArr[$i]]["inClass"] = true;
			}
			return $this->getTableQuery2([$opts, $groupByInd, $includeLinkDate], true);
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}	
	
	public function gT2($params, $notPolicy=false){//["a","b","c"], [[1,0],[2,0],[3,1]], [1], false, ["f1","f2"], "and a = 115"
		try {
			$fields = isset($params[4]) ? join(",", $params[4]) : "*";
			$cond = isset($params[5]) ? $params[5] : "";
			$includeLinkDate = isset($params[6]) && $params[6] ? true : false;

			//$funcarr = debug_backtrace();
			//$func1 = $funcarr[0]['function'];
			//$func2 = count($funcarr)>1 ? $funcarr[1]['function'] : "";
			//if ($this->u>=1 || $func2 == "policy" || $this->policy([$this->u, ["iii"]])) {
			$sel = $this->gTq2($params, true);
			return $sel ? $this->sql->sT(["(".$sel.")x", $fields, $cond]) : [];
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}	

	public function gTq3($params, $notPolicy=false){//["a","b","c"], [1], false
		try {
			$nArr = isset($params[0]) ? $params[0] : [];
			$level = isset($params[1]) ? $params[1] : 3;
			$inClassArr = isset($params[2]) ? $params[2] : [];
			$groupByInd = isset($params[3]) ? $params[3] : false;
			$excludeClasses = isset($params[4]) ? $params[4] : null;
			$opts = [];
			$arr = [$nArr[0]];
			$opts[] = array("n"=>$arr[0], "parentCol"=>0, "linkParent"=>false);
			for ($i=1; $i < count($nArr); $i++){
				$n = $nArr[$i];
				$cid1 = $this->gO([$n, true]);
				$minLevel = 100;
				$minChain = [];
				$minInd = -1;
				
				for ($j=0; $j < count($arr); $j++){
					$cid2 = $this->gO([$arr[$j], true]);
					$chain = $this->getLinkedObjectsLevel([$cid1, $cid2, $level, true, $excludeClasses]);
					$chain = $chain && count($chain) ? $chain[0] : [];
					$levelCount = $chain && count($chain) ? $chain[0] : 100;
					if ($levelCount < $minLevel){
						$minLevel = $levelCount;
						$minChain = $chain;
						$minInd = $j;
					};
				}

				$ind = -1;
				for ($k=2; $k < $minLevel+1; $k++){
					$cn = $this->gN([$minChain[$k]]);
					$arr[] = $cn;
					$ind = ($k==2 ? $minInd : count($arr)-2);
					$opts[] = array("n"=>$cn, "parentCol"=>$ind, "linkParent"=>false);
				}
				
				$c = $minChain && count($minChain)? $minChain[1] : null;
				$cn = $this->gN([$c]);
				array_push($arr, $cn);
				$opts[] = array("n"=>$arr[count($arr)-1], "parentCol"=>($ind == -1 ? $minInd : count($arr)-2), "linkParent"=>false);
				
			}
			
			for ($i=0; $i < count($inClassArr); $i++){
				$opts[$inClassArr[$i]]["inClass"] = true;
			}
			return $this->getTableQuery2([$opts, $groupByInd]);
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}	
	
	public function gT3($params, $notPolicy=false){//["a","b","c"], [1], false, "*", "and a = 115"
		try {
			$nArr = isset($params[0]) ? $params[0] : [];
			$fields = isset($params[5]) ? join(",", $params[5]) : "`".join("`,`", $nArr)."`";
			$cond = isset($params[6]) ? $params[6] : "";
			
			$sel = $this->gTq3($params, true);
			return $sel ? $this->sql->sT(["(".$sel.")x", $fields, $cond]) : [];
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}	
	
	public function gAnd($params, $notPolicy=false){
		if (!$notPolicy && !$this->getPolicyLazy()) return [];
		try {
			$link = $this->link;
			$objects = join(",",$params[0]);
			$count = count($params[0]);
			$fields = isset($params[1]) ? $params[1] : "*";
			$notIsClass = isset($params[2]) && $params[2] ? "not in (select o1 from $link where o2 = 1)" : "";
			$notIsClass1 = $notIsClass ? "and o1 $notIsClass" : "";
			$notIsClass2 = $notIsClass ? "and o2 $notIsClass" : "";
			$cond = isset($params[3]) ? $params[3] : "";
			$parent = isset($params[4]) && $params[4] ? "and parent" : (isset($params[4]) ? "and not parent" : "");
			$isClass = isset($params[5]) && $params[5] ? "in (select o1 from $link where o2 = 1)" : "";
			$isClass1 = $isClass ? "and o1 $isClass" : "";
			$isClass2 = $isClass ? "and o2 $isClass" : "";
			
			$sel = "and c>0 and id in ( ".
					"select o1 from ( ".
					"select o1, o2, false parent from $link where c>0 and o2 in ($objects) $notIsClass1 $isClass1 ".
					"union all ".
					"select o2, o1, true  parent from $link where c>0 and o1 in ($objects) $notIsClass2 $isClass2 ".
					")x where 1=1 ".
					"$parent ".
					"group by o1 ".
					"having count(o1) = $count ".
				") $cond";
			return $this->sql->sT([$this->object, $fields, $sel]);
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
 
	public function gLogin($params){
		try {
			$login = isset($params[0]) ? $params[0] : "";
			$pass = isset($params[1]) ? $params[1] : "";
			
			$u = $this->gAnd([[1576],"id",false,"and n='$login'"],true);
			$u = $u && count($u) && count($u[0]) ? $u[0][0] : 0;
			$p = $this->gAnd([[1579],"id",false,"and n='$pass'"],true);
			$p = $p && count($p) && count($p[0]) ? $p[0][0] : 0;
			$k = $this->gAnd([[$u, $p, 1596],"id"],true);
			$k = $k && count($k) && count($k[0]) ? $k[0][0] : 0;
			
			//return Array("uid"=>$u, "auth"=>!!$k, "cid"=>"1383", "oid"=>"1384");
			return Array("uid"=>$u, "auth"=>!!$k, "cid"=>"1251", "oid"=>"0");
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}

	public function getLogin($params){
		try {
			$login = isset($params[0]) ? $params[0] : "";
			$pass = isset($params[1]) ? $params[1] : "";
			$userClassName = isset($params[2]) ? $params[2] : "Пользователи системы";
			$loginClassName = isset($params[3]) ? $params[3] : "Логин пользователя системы";
			$passClassName = isset($params[4]) ? $params[4] : "Пароль пользователя системы";
			
			$loginclass = $this->gO([$loginClassName]);
			$l = $this->gAnd([[$loginclass],"id",false,"and n='$login'"],true);
			$l = $l && count($l) && count($l[0]) ? $l[0][0] : 0;
			$passclass = $this->gO([$passClassName]);
			$p = $this->gAnd([[$passclass],"id",false,"and n='$pass'"],true);
			$p = $p && count($p) && count($p[0]) ? $p[0][0] : 0;
			$userclass = $this->gO([$userClassName]);
			$u = $this->gAnd([[$l, $p, $userclass],"id"],true);
			$u = $u && count($u) && count($u[0]) ? $u[0][0] : 0;
			$u2 = $this->gAnd([[$l, $userclass],"id"],true);
			$u2 = $u2 && count($u2) && count($u2[0]) ? $u2[0][0] : 0;
			$auth = !!$u;
			if (!$u && $u2) { $u = $u2; };
			if ($u) {
				$res = $this->gT2([["Роли системы","Корневой класс роли системы","Пользователи системы"],
					[],[],false,null,"and `id_Пользователи системы` = $u"],true);

				$root = $res && count($res) ? $res[0][2] : 0;
				$rootobject = $this->gAnd([[$root],"id,n",true," order by c desc, n ",false,false],true);
				$rootobject = $rootobject && count($rootobject) && count($rootobject[0]) ? $rootobject[0][0] : 0;
				$rootclass = $this->gAnd([[$rootobject],"id,n",false," order by c desc, n ",true,true],true);
				$rootclass = $rootclass && count($rootclass) && count($rootclass[0]) ? $rootclass[0][0] : 1;
				return Array("uid"=>$u, "auth"=>$auth, "cid"=>$rootclass, "oid"=>$rootobject);
			} else {
				return null;
			}
		} catch (Exception $e){
			print($e);
			return null;
		}
	}

	public function getPolicy($params){
		$user = isset($params[0]) ? $params[0] : 0;
		$func = isset($params[1]) ? $params[1] : [""];
		
		$func = "('".(join("','", $func))."')";
		$res = $this->gT2([["Роли системы","Корневой класс роли системы","Пользователи системы","Правила группы функций системы","Функции системы"],[[4,3]],[],false,null,"and `id_Пользователи системы`=$user and `Функции системы` in $func"],true);
		//return $res && count($res);
		return $user == 1577 || $user == 1578 || $user == 41000;
	}
	
	public function getPolicyLazy(){
		//return $this->u>1 && $this->gL([$this->gO(["Пользователи системы"]),$this->u]); 
		return $this->u>1 && $this->gL([$this->gO(["Пользователи"]),$this->u]); 
	}
	
	public function iii($params, $notPolicy=false){
		$func = debug_backtrace()[0]['function'];
		if (!$this->getPolicy([$this->u, [$func,"eO"]])) return [];

		try {
			$object = $this->object;
			$link = $this->link;
			$where = isset($params[0]) ? $params[0] : "";
			$order = isset($params[1]) ? $params[1] : "";
			
			$query = "select * from ( ".
			"	select distinct $link.o1, $object.n, $link.o2, null c, $link.t, $object.c c_ from ( ".
			"		select o1, o2, 'child' t from $link where c>0 $where union all select o1, o2, t from (select o2 o1, o1 o2, 'parent' t from $link where c>0)l where 1=1 $where ".
			"	)$link ".
			"	join $object on $object.id = $link.o1 ".
			")x where 1=1 and c_>0 and (o1 <> o2 or (o1 = o2 and t='parent')) ";
			return $this->sql->sT(["(".$query.")x", "*", "", $order, ""]);
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
	
	public function test($params){
		return $params->oid;
	}
	
	public function objectsFromText($params, $notPolicy=false){
		if (!$notPolicy && !$this->getPolicyLazy()) return [];
		$pid = $params[0];
		$structIdent = isset($params[1]) ? $params[1] : "	";//TAB
		if ($pid) {
			$lines = file('load.txt');
			$arr = array();
			$level = array($pid,0,0,0,0,0,0,0,0,0);
			$pid = $level[0];
			foreach ($lines as $line_num => $line) {
				//if ($line_num > 4) break;//test
				$count = substr_count($line, $structIdent);
				$pid = $level[$count];
				$level[$count+1] = $this->cO([$line, $pid]);
			}
			return true;
		}
		return false;
	}
	
	public function createPolygonObject($params, $notPolicy=false){
		if (!$notPolicy && !$this->getPolicyLazy()) return [];
		try {
			$oid = (isset($params[0]) && $params[0]) ? $params[0] : 0;
			$func = (isset($params[1]) && $params[1]) ? $params[1] : "Marker";
			$param = (isset($params[2]) && $params[2]) ? $params[2] : "{weight:1, color:#0000ff}";
			$coords = (isset($params[3]) && $params[3]) ? $params[3] : "";
			if (!$oid) return 0;
			
			$maplink_cid = $this->gO(["Привязка к карте", true]);
			$caption = "привязка к карте объекта $oid";
			$maplink_oid = $this->cO([$caption, $maplink_cid]);
			$this->cL([$maplink_oid, $oid]);
			
			$func_cid = $this->gO(["Функции отрисовки", true]);
			$func_oid = $this->gO([$func, false, null, [$func_cid]]);
			$this->cL([$func_oid, $maplink_oid]);

			$params_cid = $this->gO(["Параметры функции отрисовки", true]);
			$params_oid = $this->cO([$param, $params_cid]);
			$this->cL([$params_oid, $maplink_oid]);
			
			$coords_cid = $this->gO(["Координаты на карте", true]);
			$coords_oid = $this->cO([$coords, $coords_cid]);
			$this->cL([$coords_oid, $maplink_oid]);
			
			return $maplink_oid;
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
	
	public function getObjectLikeName($params, $notPolicy=false){
		if (!$notPolicy && !$this->getPolicyLazy()) return [];
		try {
			$n = $params[0];
			return $this->sql->sT([$this->object, "id, n", " and n like '%$n%' and id not in (select o1 from $link where o2 = 1)", "order by id", ""]);
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
	
	private function getLevelSql($ind, $isClass1, $isClass2){
		$prev = $ind - 1;
		return "".
			"left join ".
			"( ".
			" select o1, o2 from $link where 1=1 $isClass1 ".
			" union all ".
			" select o2, o1 from $link where 1=1 $isClass2 ".
			")l$ind on l$prev.o2 = l$ind.o1 ".
			"";
	}
	
	public function getLinkedObjectsLevel($params){
		try {
			$link = $this->link;
			$cid1 = $params[0];
			$cid2 = $params[1];
			$level = $params[2];
			$isClass = isset($params[3]) && $params[3] ? true : false;
			$excludeClasses = isset($params[4]) ? "1,".join(",",$params[4]) : "1,1410";
			
			$isClass12 = $isClass ? " in (select o1 from $link where o2 = 1 and o1 not in ($excludeClasses)) " : "";
			$isClass1 = $isClass ? " and o1 $isClass12 " : " and o1 not in ($excludeClasses) ";
			$isClass2 = $isClass ? " and o2 $isClass12 " : " and o2 not in ($excludeClasses) ";
			
			$header = "select l1.o1 oid, l1.o2 l1 ";
			$case = ",case when l1.o2 = $cid2 then 1 ";
			
			$body = "".
				"from ( ".
				" select o1, o2 from $link where 1=1 $isClass1 ".
				" union all ".
				" select o2, o1 from $link where 1=1 $isClass2 ".
				")l1 ";
			$cond = " where l1.o1 = $cid1 and (l1.o2 = $cid2 ";
			$fields = "fondLevel, oid, l1";
			
			for ($i=2; $i <= $level; $i++){
				$header = $header.", l".$i.".o2 l$i ";
				$case = $case."when l$i.o2 = $cid2 then $i ";
				$bodyLevel = $this->getLevelSql($i, $isClass1, $isClass2);
				$body = $body.$bodyLevel;
				$cond = $cond." or l$i.o2 = $cid2";
				$fields = $fields.", l$i";
				
			}
			$cond = $cond.") order by fondLevel ";
			$case = $case." else 1000 end fondLevel ";
			
			$sel = $header.$case.$body.$cond;
			return $this->sql->sT(["(".$sel.")x", $fields, " limit 1 "]);
			//return $sel;
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}

	public function sql($params, $notPolicy=false){
		if (!$notPolicy && !$this->getPolicyLazy()) return [];
		try {
			$table = $params[0];
			$fields = isset($params[1]) ? $params[1] : "*";
			$cond = isset($params[2]) ? $params[2] : "";
			$order = isset($params[3]) ? $params[3] : "";
			$limit = isset($params[4]) ? $params[4] : "";
			
			//$result = $this->sql->sql(["select $fields from $table where 1=1 $cond $order $limit"]);
			$result = $this->sql->sql(["select * from $table"]);
			
			$columns = array();
			$colsCount = $result->columnCount();
			
			$colNum = 0;
			while ($colsCount > $colNum) 
			{
				$fieldName = $result->getColumnMeta($colNum)['name'];
				$columns[] = $fieldName;
				$colNum++;
			}

			$data = $result->fetchAll(PDO::FETCH_NUM);
			
			$jsonResult = array(
				"columns" => $columns,
				"data" => $data
			);
			
			return $jsonResult;
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}

	public function gOCQ($params){
		try {
			$object = $this->object;
			$link = $this->link;
			$cid = $params[0];
			return "select * from $object where id in ( select o1 from $link where o2 = $cid and o1 not in (select o1 from $link where o2 = 1) ) ";
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
	
	public function getObjectFromClass($params){
		try {
			$cid = $params[0];
			$n = $params[1];
			
			$q = $this->gOCQ([$cid]);
			$ret = $this->sql->sT(["(select id from ($q)x where 1=1 and n='$n')x","*"]);
			
			return $ret;
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
	
	public function getObject($params){
		try {
			$fields = isset($params[0]) ? $params[0] : "*";
			$cond = isset($params[1]) ? $params[1] : "";
			$object2 = isset($params[2]) ? $params[2] : $this->object;
			$ret = $this->sql->sT([$object2,$fields,$cond]);
			return $ret;
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
	
	public function getLink($params){
		try {
			$fields = isset($params[0]) ? $params[0] : "*";
			$cond = isset($params[1]) ? $params[1] : "";
			$link2 = isset($params[2]) ? $params[2] : $this->link;
			$ret = $this->sql->sT([$link2,$fields,$cond]);
			return $ret;
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}

	public function getObjectsAndLinks($params) {
		try {
			$arr = $params[0];//array of oid to need
			$arr = join(",",$arr);
			$object2 = isset($params[1]) ? $params[1] : $this->object;
			$link2 = isset($params[2]) ? $params[2] : $this->link;
			$obj = $this->getObject(["id, n", "and id in ($arr) order by id", $object2]);
			$lnk = $this->getLink(["o1, o2", "and ( o1 in ($arr) or o2 in ($arr) ) order by id", $link2]);
			
			return array($obj, $lnk);//array of [ [[oid, n]... ], [[o1, o2]... ] ]
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}

	public function createObjectsAndLinks($params) {
		try {
			$n = $params[0];//temp object name
			$arr = $params[1];//getObjectsAndLinks result
			
			$objArr = $arr[0];
			$lnkArr = $arr[1];
			
			$cid = $this->cO([$n]);
			
			foreach ($objArr as &$obj) {
				$id = &$obj[0];
				$n = &$obj[1];
				
				$oid = $this->cO([$n, $id == 1 ? 1 : $cid]);
				$obj[] = $oid;
				$id = "old_$id";
			}
			
			foreach ($lnkArr as &$lnk) {
				$o1 = &$lnk[0];
				$o2 = &$lnk[1];
				$o1 = "old_$o1";
				$o2 = "old_$o2";
				
				foreach ($objArr as &$obj) {
					$idOld = $obj[0];
					$idNew = $obj[2];
					
					if ($idOld == $o1) {
						$o1 = $idNew;
					}
					
					if ($idOld == $o2) {
						$o2 = $idNew;
					}
				}
			}
			
			foreach ($lnkArr as $lnk) {
				$o1 = $lnk[0];
				$o2 = $lnk[1];
				if ($o1 == 1 && $o2 == 1) continue;
				$this->cL([$o1, $o2]);
			}
			
			return array($objArr, $lnkArr);
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
	
	public function getMapProps($params) {
		try {
			$map = $params[0];
			$cid = $this->gO(["Карта", true]);
			$oid = $cid ? $this->gO([$map, false, null, [$cid]]) : $this->gO([$map]);
			
			$cid = $this->gO(["tileLayer", true]);
			$tileLayer = $cid ? $this->gAnd([[$oid, $cid], "n", true], true) : null;
			$tileLayer = $tileLayer && count($tileLayer)? $tileLayer[0][0] : "//mt{s}.googleapis.com/vt?lyrs=s,h&x={x}&y={y}&z={z}";

			$cid = $this->gO(["tileLayerParams", true]);
			$tileLayerParams = $cid ? $this->gAnd([[$oid, $cid], "n", true], true) : null;
			$tileLayerParams = $tileLayerParams && count($tileLayerParams)? $tileLayerParams[0][0] : '{"maxZoom": 18, "subdomains": [0,1,2,3]}';
			
			$cid = $this->gO(["setViewLatLng", true]);
			$setViewLatLng = $cid ? $this->gAnd([[$oid, $cid], "n", true], true) : null;
			$setViewLatLng = $setViewLatLng && count($setViewLatLng)? $setViewLatLng[0][0] : "[65, 100]";
			
			$cid = $this->gO(["setViewZoom", true]);
			$setViewZoom = $cid ? $this->gAnd([[$oid, $cid], "n", true], true) : null;
			$setViewZoom = $setViewZoom && count($setViewZoom)? $setViewZoom[0][0] : "3";

			$mapFunctionsArr = $this->gT2([["Функции отрисовки","Функции получения координат"],[],[],false,null,"order by `Функции отрисовки`"]);
			$mapFunctions = Array();
			if ($mapFunctionsArr && count($mapFunctionsArr)){
				foreach ($mapFunctionsArr as $obj){
					$mapFunctions[] = Array("drawFunc" => $obj[1], "getLatLngFunc" => $obj[3]);
				}
			}

			return array(
				"tileLayer"=>$tileLayer, 
				"tileLayerParams"=>json_decode($tileLayerParams), 
				"setViewLatLng"=>json_decode($setViewLatLng), 
				"setViewZoom"=>json_decode($setViewZoom),
				"mapFunctions"=>$mapFunctions
			);
			
		} catch (Exception $e){
			print($e);
			return null;
		}
	}
	
}



















?>