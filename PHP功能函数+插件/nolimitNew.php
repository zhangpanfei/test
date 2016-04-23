<?php
	//生成父包子 子包孙 的关系数组
	function nolimit($arr,&$newArr,$parent=0,$level=0){
		foreach ($arr as $key => $value) {
			if($parent==$value['parent_id']){
				$newArr[$key]=$value;
				$newArr[$key]['level']=$level;
				unset($arr[$key]);
				nolimit($arr,$newArr[$key]['child'],$value['id'],$level+1);
			}
		}
		return $newArr;
	}
	nolimit($arr,$newArr);
	print_r($newArr);
?>