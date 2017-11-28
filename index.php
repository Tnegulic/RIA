<?php

	use Phalcon\Mvc\Micro;
	use Phalcon\Db\Adapter\Pdo\Mysql;
	require "./php-restclient/restclient.php";

	$rc = new RestClient();
	$app = new Micro();

	$app->get('/{name}', function($name){

		echo 'hello '.$name;

	});


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
					 echo "<td bgcolor='black'></td>";}
				else{
					 echo "<td bgcolor='white'></td>";}
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

	$config = [
   	 "host"     => "localhost",
   	 "dbname"   => "negulic",
   	 "username" => "negulic",
   	 "password" => "hexis1",
	];

	$connection = new Mysql($config);

	$app->get('/api/form',function(){
		 echo '<form  action="/api/insert" method="POST">
                 Naslov:<br>
                  <input type="text" name="title">
                         <br>
               	 body:<br>
                  <input type="text" name="body">
                  <br><br>
                  <input type="submit" value="Submit">
                </form> ';

	});

	$app->post('/api/insert', function() use ($rc, $connection){

		$success = $connection->execute("INSERT INTO Tweets(Title,Body,Date) VALUES (?,?,now())", [
			$_POST['title'],
			$_POST['body'],
		]);
	echo $connection->lastInsertId();
	$rc->post("http://ratkajec.riteh.hexis.hr/api/insert", $_POST);
	});

	$app->get('/api/print/{ID}', function($ID) use ($connection){

			$results = $connection->fetchOne("SELECT * FROM Tweets WHERE ID= :id ", \Phalcon\Db::FETCH_ASSOC, ["id" => $ID] );

			print_r($results);
	});

	$app->get('/api/printall', function() use ($connection){

		$results = $connection->fetchAll("SELECT ID,Title FROM Tweets", \Phalcon\Db::FETCH_ASSOC );
		echo json_encode($results);
		});

	$app->get('/api/get', function() use ($rc, $connection){

		$domains = array("makovac","ratkajec","negulic");
		$res = $rc->get("http://negulic.riteh.hexis.hr/api/printall");
		$my = json_decode($res->response,true);
		$x = array();
		foreach($domains as $domain){
			$res = $rc->get('http://'.$domain.'.riteh.hexis.hr/api/printall');
			$x[$domain] = json_decode($res->response,true);
		}
		print_r ($my);
		echo '<br><br>' ;
		var_dump($x);

	});

	$app->handle();

?>
