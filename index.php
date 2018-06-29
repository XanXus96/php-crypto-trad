<?php
function cry_decry_chr ($chr,$key,$op){
	if ($op=='+') {
		return ($chr-97)+$key;
	}
	elseif ($op=='-') {
		return ($chr-97)-$key;
	}
}

function chr_modulo ($chr){
	if ($chr>=26) {
		$chr=$chr%26;
	}
	elseif ($chr<0) {
		$chr=-$chr;
		$chr=$chr-(97*intdiv($chr, 97));
		$chr=26-$chr;
	}
	$chr+=97;
	return $chr;
}
function cesar ($text,$key,$what){
		$text=strtolower($text);
		$tab1=explode(" ", $text);
		$tab2=array('');
		foreach ($tab1 as $word) {
			$new_word='';
			for ($i=0; $i < strlen($word) ; $i++) { 
				if ($what=='crypt') {
					$tmp=cry_decry_chr(ord($word[$i]),$key,'+');
				}
				elseif ($what=='decrypt') {
					$tmp=cry_decry_chr(ord($word[$i]),$key,'-');
				}
				$new_tmp=chr_modulo($tmp);
				$new_word.=chr($new_tmp);
			}
			array_push($tab2,$new_word); 
		}
		$new_text=implode(' ', $tab2);
		return $new_text;
}

function vignaire ($text,$key,$what){
		$text=strtolower($text);
		$key=strtolower($key);
		$tab1=explode(" ", $text);
		$tab2=array('');
		$key_len=strlen($key);
		$j=0;
		foreach ($tab1 as $word) {
			$new_word='';
			for ($i=0; $i < strlen($word) ; $i++) { 
				if ($j>=$key_len) {
					$j=0;
				}
				if ($what=='crypt') {
					$tmp=cry_decry_chr(ord($word[$i]),ord($key[$j])-97,'+');
				}
				elseif ($what=='decrypt') {
					$tmp=cry_decry_chr(ord($word[$i]),ord($key[$j])-97,'-');
				}
				$new_tmp=chr_modulo($tmp);
				$new_word.=chr($new_tmp);
				$j++;
			}
			array_push($tab2,$new_word); 
		}
		$new_text=implode(' ', $tab2);
		return $new_text;
}

function beaufort ($text,$key,$what){
		$text=strtolower($text);
		$key=strtolower($key);
		$tab1=explode(" ", $text);
		$tab2=array('');
		$key_len=strlen($key);
		$j=0;
		foreach ($tab1 as $word) {
			$new_word='';
			for ($i=0; $i < strlen($word) ; $i++) { 
				if ($j>=$key_len) {
					$j=0;
				}
				$tmp=cry_decry_chr(ord($key[$j]),ord($word[$i])-97,'-');
				$new_tmp=chr_modulo($tmp);
				$new_word.=chr($new_tmp);
				$j++;
			}
			array_push($tab2,$new_word); 
		}
		$new_text=implode(' ', $tab2);
		return $new_text;
}

function frequency ($text,$what){
		$txt=trim($text);
		$max=0;
		foreach (count_chars($txt, 1) as $i => $val) {
			if($val>$max) {
				$ord=$i;
			}
		}
		return cesar($text,$ord-ord('e'),$what);
}

if (isset($_POST['submit'])) {
	$text=$_POST['text'];
	$whats=array();
	if (isset($_POST['crypt'])) {
		array_push($whats,$_POST['crypt']); 
	}
	if (isset($_POST['decrypt'])) {
		array_push($whats,$_POST['decrypt']);
	}
	if (isset($_POST['ckey'])) {
		$ckey=$_POST['ckey'];
	}
	if (isset($_POST['vkey'])) {
		$vkey=$_POST['vkey'];
	}
	if (isset($_POST['bkey'])) {
		$bkey=$_POST['bkey'];
	}
}
?>






<html>
  <head>
      <title>Crypto</title>
      <link rel="stylesheet" href="main.css">
      <link href="https://fonts.googleapis.com/css?family=Ubuntu:300" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="half">
		<h2>Crypto</h2>
		<p>This web application brings you to the world of cryptographie, it allows you to crypt or decrypt an input text, using different methods :
			</br></br>- Cesar's code
			</br>- Vignaire's code
			</br>- Beaufort's code
			</br>- transposition's algorithm
			</br>- frequency's algorithm
		</p>
		<div class="input">
			<h4>Input text :</h4>
			<form method="POST" action="index.php">
				<textarea id="text" name="text" cols="75" rows="6" required></textarea> </br></br>
				<h4>Choose crypt or decrypt or both :</h4>
				<input type="checkbox" name="crypt" value="crypt">Crypt &nbsp;
				<input type="checkbox" name="decrypt" value="decrypt">Decrypt </br>
				<h4>Choose your desired method :</h4>
				<input type="checkbox" name="cesar" value="cesar">Cesar's code <input type="number" name="ckey" placeholder="key number"></br>
				<input type="checkbox" name="vignaire" value="vignaire">Vignaire's code <input type="text" name="vkey" placeholder="key string"></br>
				<input type="checkbox" name="beaufort" value="beaufort">Beaufort's code <input type="text" name="bkey" placeholder="key string"></br>
				<input type="checkbox" name="frequency" value="frequency">frequency's algorithm </br>
				<input type="checkbox" name="trans" value="trans">transposition's algorithm </br></br>
				<button name="submit">Submit</button>
			</form>
		</div>
	  </div>
      <div class="half">
		<h2>Results</h2>
		<?php
			if (isset($_POST['cesar'])) {
				$code=$_POST['cesar'];
				?>
				<div>
					<h3>Cesar's code :</h3>
				<?php
				foreach ($whats as $what) {
					?> <span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($what); ?> : </span>
					<?php echo $code($text,$ckey,$what); ?> <br><br>
				<?php	
				}
				?>	
				</div><br>
				<?php
			}
		?>

		<?php
			if (isset($_POST['vignaire'])) {
				$code=$_POST['vignaire'];
				?>
				<div>
					<h3>Vignaire's code :</h3>
				<?php
				foreach ($whats as $what) {
					?> <span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($what); ?> : </span>
					<?php echo $code($text,$vkey,$what); ?> <br><br>
				<?php	
				}
				?>	
				</div><br>
				<?php
			}
		?>

		<?php
			if (isset($_POST['beaufort'])) {
				$code=$_POST['beaufort'];
				?>
				<div>
					<h3>Beaufort's code :</h3>
				<?php
				foreach ($whats as $what) {
					?> <span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($what); ?> : </span>
					<?php echo $code($text,$bkey,$what); ?> <br><br>
				<?php	
				}
				?>	
				</div><br>
				<?php
			}
		?>

		<?php
			if (isset($_POST['frequency'])) {
				$code=$_POST['frequency'];
				?>
				<div>
					<h3>frequency's algorithm :</h3>
				<?php
				foreach ($whats as $what) {
					?> <span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($what); ?> : </span>
					<?php echo $code($text,$what); ?> <br><br>
				<?php	
				}
				?>	
				</div><br>
				<?php
			}
		?>

	  </div>
    </div>
  </body>
</html>
