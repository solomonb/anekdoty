<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "elems/style.css?v17">
		<link rel="icon" href="elems/faviconka.png" type="image/png" />        
        <link rel="shortcut icon" href="elems/faviconka.png" type="image/png">
		<title>Анекдоты</title>
		
	</head>
	<body>						
		<header>
			<nav>							
				<?php if(empty($_SESSION['reg'])){
					echo '<div class= "left" onclick="location.href=\'elems/come.php\';">Войти</div>';
					}?>
					
				<?php if(empty($_SESSION['reg'])){
					echo '<div class= "left" onclick="location.href=\'elems/Registration.php\';">Регистрация<br></div>';
					}?>			
				  
				<?php if(!empty($_SESSION['reg']) && $_SESSION['status']=='admin'){
					echo '<div class= "left" onclick="location.href=\'elems/admin.php\';">admin</div>';
					}?>					
				
				<?php if(!empty($_SESSION['reg'])){
					echo '<div class= "left" onclick="location.href=\'elems/personalArea.php\';">Личный профиль</div>';
					}?>					
				
				<?php if(!empty($_SESSION['reg'])){
					echo '<div class= "left" onclick="location.href=\'elems/logout.php\';">Выйти</div>';
					}?>
					
				<div class="right" onclick="location.href='elems/instruction.php';">Правила сайта</div>
				<div class="right" onclick="location.href='elems/add.php';">Добавить анекдот</div>	
				
			</nav>		
			<div id="box">
				<div id="hello">
					<?php if(!empty($_SESSION['reg'])){
						 echo "Здравствуйте, ".$_SESSION['log'];			
					}else echo ''; ?>
				</div>
					
				<div id = "container">	
					<h1>АНЕКДОТЫ</h1>						
					<div class = "pagination"><?= $pagination?></div>	
					<div id= "content"><?= $content ?></div>
					<div class = "pagination"><?= $pagination?></div>			
				</div>	
				<div id = "empty">
				</div>
			</div>			
		</header>
		<footer>				
			Copyright &copy; 2020.Все права защищены			
		</footer>
	</body>	
	
</html>
<script src=”https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script>
// Отправка данных на сервер
$('#form').trigger('reset');
$(function() {
  'use strict';
  $('#form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: 'send.php',
      type: 'POST',
      contentType: false,
      processData: false,
      data: new FormData(this),
      success: function(msg) {
        console.log(msg);
        if (msg == 'ok') {
          alert('Сообщение отправлено');
          $('#form').trigger('reset'); // очистка формы
        } else {
          alert('Ошибка');
        }
      }
    });
  });
});
</script>