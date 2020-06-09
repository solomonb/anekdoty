<?php 
	session_start();
	include '../elems/init.php';	
	
	$reg= false; //Установим флаг, если значение изменится переходим на основную страницу 
	$info="";
	if(isset($_POST['submit'])){
			if(!empty($_POST['login2']) && !empty($_POST['password2'])&& !empty($_POST['confirm2'])
				&& !empty($_POST['email'])){
				if($_POST['password2']==$_POST['confirm2']){
									
					$login= $_POST['login2'];
					
					$password = password_hash($_POST['password2'],PASSWORD_DEFAULT);//хэшируем пароль
					$birth_date = $_POST['birth_date'];
					$email_a = $_POST['email'];
						//Получим данные из таблицы registration пользователя с логином $login									
					$query = "SELECT * FROM registration WHERE login = '$login'";
					$user = mysqli_fetch_assoc(mysqli_query($link,$query));
					
					
										
					
					if(empty($user)){
						if(preg_match("#^[a-zA-Z0-9]+$#",$login)){	//Проверка логина на соответствие символов(должны быть латинские буквы и/или цифры)
							$query = "INSERT INTO registration SET login = '$login', password= '$password',
								birth_date = '$birth_date', email = '$email_a', banned = '0', status= 'user'";							
								mysqli_query($link,$query);
								
								$reg=true;
								$_SESSION['reg']=true;
								$_SESSION['log']=$login;
								$_SESSION['status']='user';
								$_SESSION['email']=$email_a;
								
								
								$query = "SELECT * FROM registration WHERE login = '$login'";
								$user = mysqli_fetch_assoc(mysqli_query($link,$query));
								
								$_SESSION['id']=$user['id'];
									
						} else $info="Логин должен состоять из латинских букв и/или цифр.".'<br>'; 	
						
					}else $info="Логин $login занят, введите другой логин.".'<br>';
				} 
			}
		}				
			
	if($reg){
		 header("Location: ../index.php");
		exit; 	
		
	} else {?>


	
	<script type="text/javascript">
        
        function registration1(){						
            var login1 = document.registration.login2.value;
			var password1 = document.registration.password2.value;
			var confirm1 = document.registration.confirm2.value;
			var email1 = document.registration.email.value;
			var birth_date1 = document.registration.birth_date.value;
			var bad = "";			
			if(!login1){
				bad += "Вы не ввели логин" + "\n";
			} else 
				var logLen= login1.length;			
				if(logLen<4 || logLen>20)
				bad += "Логин не соответствует требованиям" + "\n";					
			if(!password1) {
				bad += "Вы не ввели пароль" + "\n";	
			} else
				var pasLen= password1.length;
				if(pasLen<6 || pasLen>20)
					bad += "Пароль не соответствует требованиям" + "\n";	
			if(!confirm1){ 
				bad += "Вы не ввели подтверждающую пароль" + "\n"; 
			} else 
				if(confirm1 !== password1) 
				bad += "Пароли  не совпадают" + "\n"; 
			if(!email1) 
				bad += "Вы не ввели емейл" + "\n"; 
			if(!birth_date1) 
				bad += "Вы не ввели день рождения" + "\n"; 	
			
			if(bad == "" ) alert ("Ваши данные успешно сохранены");	
				else alert(bad);
        }       
        
  </script>	
	
<link rel = "stylesheet" href = "style.css?v3">
<title>Анекдоты</title>
<body>
	<nav>
		<?php if(empty($_SESSION['reg'])){
			echo '<div class= "left" onclick="location.href=\'come.php\';">Войти</div>';
		}?>	
		<?php if(empty($_SESSION['reg'])){
			echo '<div class= "left" onclick="location.href=\'Registration.php\';">Регистрация<br></div>';
		}?>
		
		<div class= "center">
			<form action="" method="POST" name = "registration" onsubmit= "registration1()">	
				логин:<br>
				<input name="login2" value= "<?php if(isset($_POST['login2'])) echo $_POST['login2']?>">
				<img src = "favicon_info.png" alt="иконка" onclick ="alert('Логин должен состоять из латинских букв и/или цифр, длиной от 4 до 20 символов')" ><br>				
				пароль:<br>
				<input name="password2" type="password" value= "<?php if(isset($_POST['password2'])) echo $_POST['password2']?>">				
				<img src = "favicon_info.png" alt="иконка" onclick ="alert('Пароль должен состоять из латинских букв и/или цифр, длиной от 6 до 20 символов')" ><br>
				подтвердите пароль:<br>
				<input name="confirm2" type="password" value= "<?php if(isset($_POST['confirm2'])) echo $_POST['confirm2']?>"><br>
				емейл:<br>
				<input name="email" type = "email" value= "<?php if(isset($_POST['email'])) echo $_POST['email']?>" ><br>
				день рождения:<br>
				<input type ="date" name="birth_date" value= "<?php if(!empty($_POST['birth_date'])) echo $_POST['birth_date']?>"><br><br>
				<input type="submit" name = "submit" value="Зарегистрироваться">
			</form>
			<?php
				echo $info;				
			?>
			<br>
			<a href = "../index.php">Вернуться на главную страницу</a>
		</div>
		<div class="right" onclick="location.href='instruction.php';">Правила сайта</div>
		<div class="right" onclick="location.href='add.php';">Добавить анекдот</div>
	</nav>
</body>	
<?php
	}							
?>
 
