<?php

function stripZeroFromDate($string=''){
	$noZeros = str_replace('*0', '', $string);
	$cleanString = str_replace('*', '', $noZeros);
	return $cleanString;
}

function redirectTo($location = Null){
	if ($location != Null) {
		header("Location: {$location}");
		exit;
	}
}

function outputMessage($message = '', $type = 'success'){
	if (!empty($message)) {
		$result = "<div class=\"alert alert-{$type} alert-dismissible \">";
		$result .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
		$result .= " {$message} </div>";

		return $result;
	} else {
		return "";
	}
}

function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

?>
