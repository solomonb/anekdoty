<?php	
	session_start();
	include '../elems/init.php';
	require 'PHPMailer.php';
	require 'SMTP.php';
	require 'Exception.php';
	$flag='true';
		
	// Выводим форму для добавления анекдота (если пользователь зашел в свой аакаунт)
	if(!empty($_SESSION['reg'])){
			echo '<nav>';					
			function addText(){
				echo
					'<div id="add_text">
						<form  method = "POST">
						Анекдот:<br>
						<textarea name="text" placeholder="Ваш анекдот" rows="10" cols="55" ></textarea><br>
						<input type="submit">
						</form>
						
						<a href = "../index.php">Вернуться на главную страницу</a>
					</div>';
				
			}	
		$login=$_SESSION['log'];
		
		if (!empty($_POST['text'])){
			$text = $_POST['text'];	
			$email=$_SESSION['email'];
			$date = date('d-m-Y');
				//Проверка дублирования анекдота
				$query = "SELECT * FROM joke WHERE text = '$text'";
				$result = mysqli_fetch_assoc(mysqli_query($link,$query));
				if(empty($result)){	//	Если анекдот не дублируется, добавляется в БД 	
					$query = "INSERT INTO joke set text ='$text', banned = '0', status = 'новый',email ='$email',date= '$date', send_status = '0'";
					$result=mysqli_query($link,$query) or die(mysqli_error($link));						
					
					 echo '	<div class= "center">Ваш анекдот отправлен модератору на рассмотрение (время рассмотрения не более 24 ч)
								<p><a href="add.php" >Добавить еще анекдот</a></p>
								<p><a href = "../index.php">Вернуться на главную страницу</a></p>
							</div>'; 
						 
						 //Отправляется сообщение администратору о новом анекдоте
							$mail = new PHPMailer\PHPMailer\PHPMailer();
    
							$mail->isSMTP();   
							$mail->CharSet = "UTF-8";                                          
							$mail->SMTPAuth   = true;

							// Настройки вашей почты
							$mail->Host       = 'smtp.mail.ru'; // SMTP сервера GMAIL
							$mail->Username   = 'sbs18'; // Логин на почте
							$mail->Password   = 'Philips06'; // Пароль на почте
							$mail->SMTPSecure = 'ssl';
							$mail->Port       = 465;
							$mail->setFrom('sbs18@mail.ru', 'Анекдоты'); // Адрес самой почты и имя отправителя
							
							// Получатель письма							
							$mail->addAddress("solomon-st@mail.ru");         
							$mail->isHTML(true);    
							$mail->Subject = 'Новое письмо';        
							$mail->Body    = 'Посетитель '.$login.' добавил новый анекдот';

						// Проверяем отравленность сообщения
							$mail->send();
							
							$flag='false';
							
				}else 
																
						echo'<div class= "center">
							<p><b>Такой анекдот уже есть на сайте!</b></p>
							<p><a href="add.php" >Добавить новый анекдот</a></p>
							<p><a href = "../index.php">Вернуться на главную страницу</a></p>
							</div>'; 
						$flag='false';						
		}
		
	
			if ($flag=='true'){
			
				addText();				
		}
		echo '<div class="right" onclick="location.href=\'instruction.php\';">Правила сайта</div>
			  <div class="right" onclick="location.href=\'add.php\';">Добавить анекдот</div>';
		echo  '</nav>';
	} else 
			if(empty($_SESSION['reg'])){
			echo '<nav>';
					 
					echo '<div class= "left" onclick="location.href=\'come.php\';">Войти</div>';					
					
					echo '<div class= "left" onclick="location.href=\'Registration.php\';">Регистрация<br></div>';
					
					echo '<div class="right" onclick="location.href=\'instruction.php\';">Правила сайта</div>
						  <div class="right" onclick="location.href=\'add.php\';">Добавить анекдот</div>';
					echo '<div class= "center">Если хотите добавить свой анекдот,<br>
						  пожалуйста, зарегистрируйтесь!'.'<br>'.'<a href = "../index.php">Вернуться на главную страницу</a>'.'<br></div>';					
					
			echo '</nav>';
		}
		
	?><link rel = "stylesheet" href = "style.css?v6">
	<title>Анекдоты</title>
	