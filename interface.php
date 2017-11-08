<?php

interface Cache
{
	public function get($key);
	public function set($key,$vr);
	public function delete($key);

}

class A implements Cache{
 
	public function get($key){
		return 	apc_fetch($key);
	}
	public function set($key,$vr){
		apc_store($key);
	}
	public function delete($key){
		apc_delete($key);
	}
}

$x=new A;
$x->set('test','dva');
echo $x->get('test');
//$x->delete('test');
//$x->set('test','tri');
//echo $x->get('test');


?>
