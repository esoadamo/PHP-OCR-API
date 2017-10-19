<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

function get_nonexisting_file($folder, $extension, $create){
	/*
	Generates unique filename that does not exist yet
	:param folder: folder in which generate the filename
	:param extension: extension of the generated filename, can be blank
	:param create: if set to true, the new blank file is created
	:return: absolute file path
	*/
	$folder = realpath($folder);
	$i = 0;
	while (true){
		$hex = dechex($i);
		$filepath = ("{$folder}/{$hex}{$extension}");
		if (!file_exists($filepath)){
			if ($create)
				file_put_contents($filepath, "");
			return $filepath;
		}
		$i++;
	}
}

$target_file = get_nonexisting_file("/tmp/", "", false);
move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

header("Content-Type: text/plain");

$language = escapeshellarg(isset($_POST["lang"]) ? $_POST["lang"] : 'eng');
print(shell_exec("tesseract {$target_file} stdout -l {$language}"));

unlink($target_file);

die();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>OCR Online</title>
<meta charset="UTF-8">
</head>
<body>
<h1 id="title">Free online OCR</h1>
<form method="post" enctype="multipart/form-data">
    <p id="p_select_img" style="display: inline;">Select image to upload: </p>
    <input type="file" name="image" id="image"><br>
	<p style="display: inline;" id="p_language">Language:</p>
	<select id="select_lang" onchange="reloadLang()" name="lang">
		<option value="eng">ENG</option>
		<option value="ces">CZ</option>
	</select><br>
    <input id="btn_submit" type="submit" value="Upload Image" name="submit">
</form>
<script>
let title = document.getElementById("title");
let p_select_img = document.getElementById("p_select_img");
let p_language = document.getElementById("p_language");
let btn_submit = document.getElementById("btn_submit");
let select_lang = document.getElementById("select_lang");

function reloadLang(){
	switch(select_lang.value){
		case "ces":
			title.innerHTML = "Online rozpoznávání textu";
			p_language.innerHTML = "Jazyk: ";
			p_select_img.innerHTML = "Vyberte soubor obrázku: ";
			btn_submit.value = "Provést rozpoznání textu";
			break;
		default:
			title.innerHTML = "Free online OCR";
			p_language.innerHTML = "Language: ";
			p_select_img.innerHTML = "Select image to upload: ";
			btn_submit.value = "Do the OCR";
			break;
	}
}

switch(navigator.language || navigator.userLanguage){
	case "cs":
		select_lang.value = "ces";
		break;
	default:
		select_lang.value = "eng";
		break;
}
reloadLang();
</script>
</body>
</html>
