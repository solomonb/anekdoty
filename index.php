<?php
	error_reporting(E_ALL);
	ini_set('display_errors','on');	
	session_start();				
	
	
	$host = 'localhost'; 
	$user = 'root'; 
	$password = ''; 
	$db_name = 'anekdoty';
	
	$link = mysqli_connect($host, $user, $password, $db_name) or die(mysqli_error($link));	
	mysqli_query($link, "SET NAMES 'utf8'");
	
	//Пагинация(порядковая нумерация страниц)
	if(isset($_GET['page'])){	
		$page = $_GET['page'];		
	}else {
		$page = '1';		
	}
				
		$notesOnPage = 8;//Параметр, определяющий количество анекдотов на одной странице	
		
		if(preg_match("#^[1-9]+$#",$page)) {//Нумерация страницы должна состоять только из цифр	
			
			$from = ($page-1)*$notesOnPage;
					
			//выборка анекдотов из БД по выбранным параметрам
			$query = "SELECT * FROM joke WHERE id>0 ORDER BY id LIMIT $from,$notesOnPage";
			$result = mysqli_query($link,$query)or die(mysqli_error($link));
			for($data =[];$row = mysqli_fetch_assoc($result);$data[]=$row);

				$content='';
				foreach($data as $pages){
					if ($pages['banned']=='0' && $pages['status']=='просмотрен'){
						$content .= $pages['text'];
						$content .= '<p>'.$pages['date'].'</p>';
						$content .= '<p>***</p>';
					}
				} 				
			
			$query = "SELECT COUNT(*) as count FROM joke "; //Подсчет количества анекдотов для опрделения количества страниц
			$result = mysqli_query($link,$query)or die(mysqli_error($link));
			$count = mysqli_fetch_assoc($result)['count'];
			$pagesCount = ceil($count/$notesOnPage);
				
			$pagination='';
				if($page<=$pagesCount){		
					for($i = 1; $i<=$pagesCount; $i++){
						if($page==$i){
							$class = 'class="active"';
						} else {
							$class = '';
						}
						
						$pagination .="<div id='page'> <div $class onclick=\"location.href='index.php?page=$i';\">$i</div></div>";
									
					}						
					 
				}else header("Location: ../elems/404.php");		 
			
			 
		}else header("Location: ../elems/404.php");	
	
		include 'elems/layout.php';	 
		?>
		
		
		

			