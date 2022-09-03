<?php

$secret_key = "yW5TFt23Xcg23sC"; //Tajny kod do zmiany, każdy użytkownik posiada swój
$sharexdir = "images/"; //To jest twój katalog plików, także link... (jeżeli zostawisz puste będą przesyłane tam gdzie plik up.php)
$domain_url = 'https://cdn.magicdev.pl/'; // Adres domeny, na której ma znajdować się uploader.
$lengthofstring = 8; //Długość randomowej nazwy zrzutu
$allowedExts = array('png', 'jpg', 'jpeg', 'gif'); //Sprawdzanie typy pliku
$allowedMime = array('image/png', 'image/jpeg', 'image/pjpeg', 'image/gif');  //Sprawdzanie typy pliku

function RandomString($length) {
  $keys = array_merge(range(0,9), range('a', 'z'));

  for($i=0; $i < $length; $i++) {
    $key .= $keys[mt_rand(0, count($keys) - 1)];
  }
  return $key;
}

// Sprawdź, czy request zawiera wartość secret.
if(isset($_POST['secret']))
{
  // Sprawdź, czy secret key jest taki sam, jak ten podany przy konfiguracji.
  if($_POST['secret'] == $secret_key)
  {
    // Ustaw nazwę pliku, wskaż ścieżkę.
    $filename = RandomString($lengthofstring);
    $target_file = $_FILES["sharex"]["name"];
    $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if ((in_array($_FILES['sharex']['type'], $allowedMime)) && (in_array(strtolower($fileType), $allowedExts))) {
      if (move_uploaded_file($_FILES["sharex"]["tmp_name"], $sharexdir.$filename.'.'.$fileType))
      {
        echo $domain_url.$sharexdir.$filename.'.'.$fileType;
      } else {
        echo 'Nie udało się przesłać pliku';
      }
    } else {
      echo "Nie obsługiwany typ pliku";
    }
  } else {
    echo 'Nieprawidłowy tajny klucz';
  }
} else {
  echo 'Nie otrzymano żadnych danych';
}
?>
