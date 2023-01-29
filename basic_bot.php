<?php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'api');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'apaajalah');

$conn = mysqli_connect(DB_HOST,DB_NAME,DB_PASSWORD,DB_USERNAME);

$data = json_decode(file_get_contents('php://input'), true); 

$number   = $data["from"];
$message  = $data["message"];

$wa_no = $number;
$wa_text0 = $message;
$wa_text = strtoupper($message);

if ($wa_no . $wa_text == '') { exit ; } 

$exp = explode(' ', $wa_text) ;
$text1 = $exp[0];
$text2 = $exp[1];
$text3 = $exp[2];
 
if ($text1 == 'INFO') { 
    
$msg = "Halo ini bot perpustakaan SMA Negeri 1 Cepu

Silahkan gunakan kata kunci berikut untuk melakukan pencarian.

Untuk mencari berdasarkan judul
Ketik : search title judul yg mau dicari
Contoh : search title sejarah

Untuk mencari berdasarkan penulis
Ketik : search author nama penulis
Contoh : search author andi

Untuk mencari berdasarkan ISBN
Ketik : search isbn kode isbn
Contoh : search isbn 0123456789

Untuk mencari berdasarkan ISSN
Ketik : search isbn kode issn
Contoh : search issn 0123456789

Terima kasih.";
     
    sendMessage($wa_no, $msg);
}

if ($text2 == 'TITLE') { 
    
$result = (mysqli_query($conn,"SELECT * FROM biblio a left join biblio_author b on a.biblio_id=b.biblio_id left join mst_author c on b.author_id=c.author_id
 WHERE `title` LIKE '%$text3%'")) or die (mysqli_error($result));
        if(mysqli_num_rows($result) > 0){
          while ($row=mysqli_fetch_array($result)){
$msg .= 'Title: '.$row['title'].'
Author: '.$row['author_name'].'
ISBN/ISSN: '.$row['isbn_issn'].'
Year: '.$row['publish_year'].'

';
            }
    } else {
        $msg .= 'Data tidak ditemukan';
    }
     
    sendMessage($wa_no, $msg);
}

if ($text2 == 'AUTHOR') { 
    
$result = (mysqli_query($conn,"SELECT * FROM biblio a left join biblio_author b on a.biblio_id=b.biblio_id left join mst_author c on b.author_id=c.author_id
 WHERE author_name LIKE '%$text3%'")) or die (mysqli_error($result));
        if(mysqli_num_rows($result) > 0){
          while ($row=mysqli_fetch_array($result)){
$msg .= 'Title: '.$row['title'].'
Author: '.$row['author_name'].'
ISBN/ISSN: '.$row['isbn_issn'].'
Year: '.$row['publish_year'].'

';
            }
    } else {
        $msg .= 'Data tidak ditemukan';
    }
     
    sendMessage($wa_no, $msg);
}

if ($text2 == 'ISBN') { 
   
$result = (mysqli_query($conn,"SELECT * FROM biblio a left join biblio_author b on a.biblio_id=b.biblio_id left join mst_author c on b.author_id=c.author_id
 WHERE isbn_issn LIKE '%$text3%'")) or die (mysqli_error($result));
        if(mysqli_num_rows($result) > 0){
          while ($row=mysqli_fetch_array($result)){
$msg .= 'Title: '.$row['title'].'
Author: '.$row['author_name'].'
ISBN/ISSN: '.$row['isbn_issn'].'
Year: '.$row['publish_year'].'

';
            }
    } else {
        $msg .= 'Data tidak ditemukan';
    }
     
    sendMessage($wa_no, $msg);
}

if ($text2 == 'ISSN') { 
   
$result = (mysqli_query($conn,"SELECT * FROM biblio a left join biblio_author b on a.biblio_id=b.biblio_id left join mst_author c on b.author_id=c.author_id
 WHERE isbn_issn LIKE '%$text3%'")) or die (mysqli_error($result));
        if(mysqli_num_rows($result) > 0){
          while ($row=mysqli_fetch_array($result)){
$msg .= 'Title: '.$row['title'].'
Author: '.$row['author_name'].'
ISBN/ISSN: '.$row['isbn_issn'].'
Year: '.$row['publish_year'].'

';
            }
    } else {
        $msg .= 'Data tidak ditemukan';
    }
     
    sendMessage($wa_no, $msg);
}

function sendMessage($wa_no, $wa_text) {
    $url = 'http://app.sman1cepu.sch.id/send';

    $ch = curl_init($url);
    
    $nohp= $wa_no;
    $pesan= $wa_text;
    
    $data = array(
        'device_id' => '081327663511',
        'number' => $nohp,
        'message' => $pesan,
    );
    $payload = $data;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    //echo $result;
    }
     
?>