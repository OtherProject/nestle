<?php

$foto = $_GET['ft'];
$basedomain = "http://rumahnutrisinestle.com/gowithactivgro/";

    if(count($_GET) == 2){

	}else{
		$redirect = $basedomain."public_assets/imageFramed/".$foto;
		echo "<meta http-equiv=\"Refresh\" content=\"0; url=$redirect\">";
	}
?>
<meta property="og:title" content="Go With ActivGro" />
<meta property="og:type" content="website" />

<img width="100%" src="<?php echo $basedomain?>public_assets/imageFramed/<?php echo $foto?>" class="bigImage1" id="profilePicture"/>



<p>
Senangnya melihat foto Si Kecil ceria dan aktif! Ayah dan Ibu, ayo tunjukkan foto keceriaan buah hati Anda melalui 
<a href="bit.ly/GowithActivGro">bit.ly/GowithActivGro</a> #GowithActivGro
</p>