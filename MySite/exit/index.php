<?
print "hello";
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
	print "hello";
    unset($_COOKIE['id']);
	unset($_COOKIE['hash']);
    setcookie('id', '', time() - 3600, '/')
	setcookie('hash', '', time() - 3600, '/')
	Header('Location: /check ')
}
?>


