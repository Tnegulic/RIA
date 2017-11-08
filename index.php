<?php

	use Phalcon\Mvc\Micro;

	$app = new Micro();

	$app->get('/test',function(){
		for($i = 0; $i < 128; $i++){
  			echo  chr(rand(97, 122));
		}

	});

	$app->get('/zadatak',function(){
		echo "<table style='width:800px' border='1px'";
		for($i = 0; $i < 8 ; $i++){
			echo "<tr style='height:100px'>";
			for($j = 0; $j < 8; $j++){
				if(($i+$j)%2==0){
					 echo "<th bgcolor='black'></th>";}
				else{
					 echo "<th bgcolor='white'></th>";}
			}
			echo "</tr>";
		}
		echo "</table>";
	});

	$app->get('/upit',function(){
		if(isset($_GET["firstname"]) && isset($_GET["password"])){
			echo $_GET["firstname"].' >> '.md5($_GET["password"]);
		}
	 	echo '<form  method="GET">
 		 First name:<br>
		  <input type="text" name="firstname">
 			 <br>
       		password:<br>
		  <input type="text" name="password">
		  <br><br>
		  <input type="submit" value="Submit">
		</form> ';
	});
	$app->handle();
?>
