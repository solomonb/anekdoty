<?php
	session_start();
	include '../elems/init.php';	
	
	$id=$_SESSION['id'];	
	//Проверка статуса пользователя
	$query = "SELECT * FROM registration WHERE id = '$id'"; 
	$result = mysqli_query($link, $query);
	$user = mysqli_fetch_assoc($result);	
	
	if($user['status']=='admin'){
	$_SESSION['status']='admin';
?>	

<title>Администратор</title>
	<body bgcolor="PaleGreen">
	<p><a href = "../index.php">Вернуться на главную страницу</a><p>
		<table border = "1">
		<tr>
			<th>id</th>
			<th>login</th>
			<th>email</th>
			<th>статус пользователя</th>
			<th>состояние пользователя</th>
			<th>удалить пользователя</th>
		</tr>

		<?php
				//Бан пользователя посредством гет запроса
					if(isset($_GET['bann'])){
						$bann =$_GET['bann'];
						$query = "UPDATE registration SET banned = '0' WHERE id=$bann";
						mysqli_query($link, $query) or die(mysqli_error($link));
					}
					if(isset($_GET['bann1'])){
						$bann =$_GET['bann1'];
						$query = "UPDATE registration SET banned = '1' WHERE id=$bann";
						mysqli_query($link, $query) or die(mysqli_error($link));
					}
					//Удаление пользователя посредством гет запроса
					if(isset($_GET['del'])){
						$del =$_GET['del'];
						$query = "DELETE FROM registration WHERE id=$del";
						mysqli_query($link, $query) or die(mysqli_error($link));
					}
					$query = "SELECT * FROM registration";
					$result = mysqli_query($link, $query) or die(mysqli_error($link));
					for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
					
					// Вывод на экран таблицу с данными пользователей:
					$result = '';					
					
						foreach ($data as $elem) {
							$result .= '<tr>';
							
							$result .= '<td>' . $elem['id'] . '</td>';
							$result .= '<td>' . $elem['login'] . '</td>';
							$result .= '<td>' . $elem['email'] . '</td>';
							if($elem['banned']=='1'){
								$result .= '<td align= "center">забанен</td>';	
							} else $result .= '<td align= "center">разбанен</td>';
							
							//Бан пользователя посредством гет запроса
							if($elem['banned']=='1'){
								$result .= '<td align= "center"><a href="?bann=' . $elem['id'] . '">разбанить</a></td>';
							} else $result .= '<td align= "center"><a href="?bann1=' . $elem['id'] . '">забанить</a></td>';
							
							//Удаление пользователя посредством гет запроса
							$result .= '<td align= "center"><a href="?del=' . $elem['id'] . '">удалить</a></td>';
							$result .= '</tr>';
						}
					
					echo $result;
				
		?>
		
		</table>
		<br><br><br>
		<table border = "1">
		<tr>
			<th>id</th>			
			<th>анекдоты</th>
			<th>email пользователя</th>
			<th>состояние анекдота</th>
			<th>статус анекдота</th>
			<th>забанить анекдот</th>
			<th>Отправить сообщение</th>
			<th>удалить анекдот</th>
		</tr>

		<?php
				//Вывод на экран таблицы с анекдотами	
					
				if(isset($_GET['bann'])){
						$bann =$_GET['bann'];
						$query = "UPDATE joke SET banned = '0' WHERE id=$bann";
						mysqli_query($link, $query) or die(mysqli_error($link));
					}
					if(isset($_GET['bann1'])){
						$bann =$_GET['bann1'];						
						$query = "UPDATE joke SET banned = '1' WHERE id=$bann";
						mysqli_query($link, $query) or die(mysqli_error($link));						
					}
					
					if(isset($_GET['seen'])){
						$bann =$_GET['seen'];
						$query = "UPDATE joke SET status = 'просмотрен' WHERE id=$bann";
						mysqli_query($link, $query) or die(mysqli_error($link));
					}					
						
					if(isset($_GET['del'])){
						$del =$_GET['del'];
						$query = "DELETE FROM joke WHERE id=$del";
						mysqli_query($link, $query) or die(mysqli_error($link));
					}
					$query = "SELECT * FROM joke WHERE id>0 ORDER BY id DESC";
					$result = mysqli_query($link, $query) or die(mysqli_error($link));
					for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
					
					// Вывод таблицы с анекдотами на экран:
					$result = '';
						
						foreach ($data as $elem) {
							$result .= '<tr>';
							
							$result .= '<td>' . $elem['id'] . '</td>';
							$result .= '<td>' . $elem['text'] . '</td>';
							$result .= '<td>' . $elem['email'] . '</td>';
							
							// Изменение статуса анекдота на "просмотрен"
							if($elem['status']=='новый'){
								$result .= '<td align= "center"><a href="?seen=' . $elem['id'] . '"style = "color:#FF0000">новый</a></td>';
							} else $result .= '<td align= "center"><a href="?seen1=' . $elem['id'] . '" >просмотрен</a></td>';
							
							//Бан анекдота посредством гет запроса
							if($elem['banned']=='1'){
								$result .= '<td align= "center" style = "color:#FF0000">забанен</td>';	
							} else $result .= '<td align= "center">разбанен</td>';
							
							//Бан анекдота посредством гет запроса
							if($elem['banned']=='1'){
								$result .= '<td align= "center"><a href="?bann=' . $elem['id'] . '">разбанить</a></td>';
							} else $result .= '<td align= "center"><a href="?bann1=' . $elem['id'] . '">забанить</a></td>';
							
							//Отправка анекдота пользователю посредством гет запроса
							if($elem['send_status']=='0'){
								$result .= '<td align= "center"><a href="send.php?send_1='.$elem['id'].'" >отправить</a></td>';								
							} else  $result .= '<td align= "center">отправлено</td>'; 
							
							//Удаление анекдота
							$result .= '<td align= "center"><a href="?del=' . $elem['id'] . '">удалить</a></td>';
							$result .= '</tr>';
						}
					
					echo $result;				
			
		?>
		</table>
		<?php } ?>			
</body>