<?
setcookie('id', '', time() - 7200, '/')
setcookie('hash', '', time() - 7200, '/')
Header('Location: /login ')
?>


