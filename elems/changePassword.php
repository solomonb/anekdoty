<?php
	include '../elems/init.php';			
		if(!empty($_SESSION['reg'])){
			$id = $_SESSION['id']; // id юзера из сессии
			$query = "SELECT * FROM registration WHERE id='$id'"; // получаем юзера по $id из сессии
			$result = mysqli_query($link, $query);
			$user = mysqli_fetch_assoc($result);
				
			$hash = $user['password']; // соленый пароль из БД
			
			if(isset($_POST['submit'])){
				if(!empty($_POST['old_password'])&& !empty($_POST['new_password'])&& !empty($_POST['confirm'])){
				
					// Проверяем соответствие хеша из базы введенному старому паролю
					if (password_verify($_POST['old_password'], $hash)) {
						if(strlen($_POST['new_password'])>=6 && strlen($_POST['new_password'])<=12){
							if($_POST['new_password']== $_POST['confirm']){						
						
								// Хеш нового пароля:
								$newPasswordHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
								
								// Выполним UPDATE запрос:
								$query = "UPDATE registration SET password='$newPasswordHash' WHERE id='$id'";
								mysqli_query($link, $query);
								header("Location: ../index.php");
								exit;
								
							} else echo 'Пароли не совпадают';
						} else echo 'Пароль должен быть длиной от 6 до 12 символов';
					} else echo 'Старый пароль введен неверно';	
				} else echo 'Вы не заполнили какое-то из полей';
			}
		}
?>
<link rel = "stylesheet" href = "style.css?v2">
<title>Анекдоты</title>
	<body>
		<nav>
			<div class= "center">
			<form action="" method="POST">	
				старый пароль:<br>
				<input name="old_password" type="password"><br>
				новый пароль:<br>
				<input name="new_password" type="password"><br>
				подтвердите пароль:<br>
				<input name="confirm" type="password"><br>
				<input type="submit" name = "submit" value="Обновить">
			</form>

			<a href = "../index.php">Вернуться на главную страницу</a>
			</div>
		</nav>
	</body>