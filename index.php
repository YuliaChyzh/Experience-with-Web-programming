<?php
	if(isset($_POST['update']))
		add();
	else if(isset($_POST['show_gallery']))
		task2();
	else if(isset($_POST['show_site']))
		task3();
	else if(array_key_exists('clicked',$_POST))
		show();
	else if(array_key_exists('deleted',$_POST))
		delete_record();
	else if (isset($_POST['update1']))
		echo update_record();
	else echo task3();

	function add(){
		/*if(!preg_match('/^[А-Я][а-я]+|[A-Z][a-z]+$/', $_POST['name'])){
			header("Refresh: 0;  url=Feed.html");
			echo "<script>alert(\"Incorrect name\");</script>";
		}
		else*/ if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			header("Refresh: 0;  url=Feed.html");
			echo "<script>alert(\"Incorrect email\");</script>";
		} else {
			$name = $_POST['name'];
			$email = $_POST['email'];
      $tel = $_POST['tel'];
      $hour = $_POST['hourSelect'];
			echo "<script>alert('$email');</script>";
      $browser = $_SERVER['HTTP_USER_AGENT'];
			//$time = date("Y-m-d H:i:s");
			$IP = $_SERVER['REMOTE_ADDR'];

			$conn = new mysqli("127.0.0.1", "root", "1111", "user_db");

      $existname = $conn->query ("SELECT id FROM users WHERE name = $name");
			$existemail = $conn->query ("SELECT email FROM user_db.users WHERE email = '$email'");

			/*$result=$conn->query ("SELECT id FROM users WHERE email = $email");
			while($row=$result->fetch_assoc()) {
				$email = $row['email'];
				echo "<script>alert('$email');</script>";
			}
			$result->free();*/
			/*if ($result==NULL) {
				echo "<script>alert(\"Email doesnt exist\");</script>";
			}*/
			if($existemail->num_rows != 0) {
				header("Refresh: 0;  url=Feed.html");
				echo "<script>alert('Email already exist');</script>";
			}
			else {
				$conn->query ("INSERT INTO users (name, phone, email, hour) VALUES ('$name','$tel', '$email', '$hour')");
				header("Refresh: 0;  url=Feed.html");
				echo "<script>alert(\"You have been registered\");</script>";

			}

			/*if($existname->num_rows > 0){
				//header("Refresh: 0;  url=Feed.html");
				echo "<script>alert(\"Name already exist\");</script>";
			} else if($existemail->num_rows > 0) {
				//header("Refresh: 0;  url=Feed.html");
				echo "<script>alert(\"Email already exist\");</script>";
			}
			else{
				$conn->query ("INSERT INTO users (name, phone, email, hour) VALUES ('$name','$tel', '$email', '$hour')");
				header("Refresh: 0;  url=Feed.html");
				echo "<script>alert(\"You have been registered\");</script>";
			}*/


      $existbrowser = $conn->query ("SELECT id FROM user_system WHERE browser = $browser");
			$existtime = $conn->query ("SELECT id FROM user_system WHERE time = $time");
			if($existbrowser->num_rows > 0){
				header("Refresh: 0;  url=Feed.html");
				echo "<script>alert(\"Browser already exist\");</script>";
			}
			else{
				$existuserid = $conn->query ("SELECT id FROM users WHERE name = $name");
				//$row=$existuserid->fetch_assoc();
				$userid=$existuserid['id']*1;
				$conn->query ("INSERT INTO user_system (ip,browser,time,user) VALUES ('$IP', '$browser', '2017-05-31','$userid')");
				//header("Refresh: 0;  url=Feed.html");
				//echo "<script>alert(\"You have been registered\");</script>";
			}
      $conn->close();
		}
	}

	function task2(){
		$mysqli = new mysqli("127.0.0.1", "root", "1111", "site_db");
		$sqls = "SELECT * FROM gallery";
		$result = $mysqli->query($sqls);
		if ($result->num_rows > 0) {
			echo '<form action="index.php" method="post">';
	    	while($row = $result->fetch_assoc()) {
	    		$i = $row['id'];
	        echo "id: " . $row["id"]. " - Title: " . $row["name"]. " - Date: " . $row["date"]. " - Autor: " .$row["autor"]. "   "  ;
					echo '<input type="submit" name="clicked['.$i.']" value="Show coments" />';
					echo '</br>';
		    }
		    echo '</form>';
		} else {
		    echo "0 results";
		}
		$mysqli->close();
	}

	function task3(){
		$mysqli = new mysqli("127.0.0.1", "root", "1111", "site_db");
		$sqls = "SELECT * FROM page";
		$result = $mysqli->query($sqls);
		if ($result->num_rows > 0) {
			echo '<form action="index.php" method="post">';
	    	while($row = $result->fetch_assoc()) {
	    		$i = $row['id'];
	        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - URL: " . $row["url"]. " - Date: " . $row["d_create"]. "   " ;
					echo '<input type="submit" name="deleted['.$i.']" value="Delete" />';
					echo '</br>';
		    }
		    echo '</form>';
		    require_once('form.html');
		} else {
		    echo "0 results";
		}
		$mysqli->close();
	}

	function show(){
		$id = key($_POST['clicked']);
		$mysqli = new mysqli("127.0.0.1", "root", "1111", "site_db");
		$result = $mysqli->query("select caption from photo c join subgallery u on u.gallery = $id and u.photo = c.id");
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
	    		$i = $row['id'];
	        	echo $row['caption'];
				echo '</br>';
		    }
		} else {
		    echo "0 results";
		}
		$mysqli->close();
	}

	function delete_record(){
		$id = key($_POST['deleted']);
		$mysqli = new mysqli("127.0.0.1", "root", "1111", "site_db");
		$result = $mysqli->query("delete from page where id = $id");
		$mysqli->close();
		header("Location: index.php");
	}

	function update_record(){
		if(!preg_match('/^[1-9][0-9]*$/', $_POST['id'])){
			header("Refresh: 0;  url=index.php");
			echo "<script>alert(\"Incorrect id\");</script>";
		}
		else if($_POST['name']==""){
			header("Refresh: 0;  url=index.php");
			echo "<script>alert(\"Incorrect name\");</script>";
		}
		else if($_POST['url']==""){
			header("Refresh: 0;  url=index.php");
			echo "<script>alert(\"Incorrect URL\");</script>";
		}
		else{
			$mysqli = new mysqli("127.0.0.1", "root", "1111", "site_db");
			$id = $_POST['id'];
			$id *=1;
			$existid = $mysqli->query ("SELECT id FROM page WHERE id = $id");
			if($existid->num_rows == 0){
				header("Refresh: 0;  url=index.php");
				echo "<script>alert(\"id doesn't exist\");</script>";
			}
			else{
				$name = $_POST['name'];
				$url = $_POST['url'];
				$mysqli->query ("update page set name = '$name' WHERE id = $id");
				$mysqli->query ("update page set url = '$url' WHERE id = $id");
				header("Location: index.php");
			}
			$mysqli->close();
		}
	}
?>
