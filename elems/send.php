<?php
include '../elems/init.php';	
	session_start();

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

if(isset($_GET['send_1'])){
	$id =$_GET['send_1'];	
	$query = "UPDATE joke SET send_status ='1' WHERE id=$id";
	mysqli_query($link, $query) or die(mysqli_error($link));
}

 $query = "SELECT * FROM joke WHERE id=$id";
 $result = mysqli_query($link, $query) or die(mysqli_error($link));
 for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
 foreach ($data as $elem) {
	$email=$elem['email'];
	$text=$elem['text'];
 }
  
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $msg = "Сообщение отправлено";
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";                                          
    $mail->SMTPAuth   = true;

    // Настройки вашей почты
    $mail->Host       = 'smtp.mail.ru'; // SMTP сервера GMAIL
    $mail->Username   = 'sbs18'; // Логин на почте
    $mail->Password   = 'Philips06'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('sbs18@mail.ru', 'Администратор сайта anekdoty.h1n.ru'); // Адрес самой почты и имя отправителя

	
    // Получатель письма
	
    $mail->addAddress("$email");  
   // $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

    // Прикрипление файлов к письму
/* if (!empty($_FILES['myfile']['name'][0])) {
    for ($ct = 0; $ct < count($_FILES['myfile']['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['myfile']['name'][$ct]));
        $filename = $_FILES['myfile']['name'][$ct];
        if (move_uploaded_file($_FILES['myfile']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Неудалось прикрепить файл ' . $uploadfile;
        }
    }   
} */

        
        $mail->isHTML(true);
    
        $mail->Subject = 'Уведомление от администратора';
        
		$mail->Body    = 'Ваш анекдот:'.'<br><b><i>'.$text.'</i></b><br>'.'не соответствует правилам сайта!';


// Проверяем отравленность сообщения
if ($mail->send()) {
    echo "$msg";
	echo '<br>';
	echo '<a href = "admin.php">Назад</a>';
	
} else {
echo "Сообщение не было отправлено. Неверно указаны настройки вашей почты";
}

} catch (Exception $e) {
    echo "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

?>
 