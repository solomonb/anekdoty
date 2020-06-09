<?php
	include '../elems/init.php';			
		if(!empty($_SESSION['reg'])){
			$id = $_SESSION['id']; // id юзера из сессии
			$query = "SELECT * FROM registration WHERE id='$id'"; // получаем юзера по $id из сессии
			$result = mysqli_query($link, $query);
			$user = mysqli_fetch_assoc($result);
				
			$hash = $user['password']; // соленый пароль из БД
			
			if(isset($_POST['submit'])){
				if(!empty($_POST['password'])){				
					// Проверяем соответствие хеша из базы введенному старому паролю
					if (password_verify($_POST['password'], $hash)) {
											
						// Выполним DELETE запрос:
						$query = "DELETE FROM registration WHERE id='$id'";
						mysqli_query($link, $query);
						$_SESSION['reg']=false;
						header("Location: ../index.php");
						exit;								
						
					} else echo 'Пароль введен неверно';	
				} else echo 'Вы не ввели пароль';
			}
		}
?>

<form action="" method="POST">	
	<p>пароль:<input name="password" type="password"></p>	
	<p><input type="submit" name = "submit" value="Удалить аккаунт"></p>
</form>