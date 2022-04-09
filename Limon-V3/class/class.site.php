<?php
include("config.php");
class mth {  
	var $mth = array();
	var $inRows = 0;
	var $loginPage = false;
	var $cpTitle = 'Gelişmiş Yönetim Paneli';
	var $uploadFileName = '';
	var $types = array('.jpg','.jpeg','.gif','.png','.pdf','.doc','.csv');
	var $uploadError = '';
	
	function __construct(){
		session_start(); ob_start();
		$this->mth["SQL_HOST"] = dbHost;
		$this->mth["SQL_DB"] = dbName;
		$this->mth["SQL_USER"] = dbUser;
		$this->mth["SQL_PASSWORD"] = dbPass;
		$this->mysqlConnect();
		$this->sqlInjectionSecurity();
	}
	
	function __destruct(){
		$this->mysqlClose();
		ob_end_flush();	
	}
	
	function mysqlConnect(){
		$this->sqlConnect = @mysql_connect($this->mth['SQL_HOST'],$this->mth['SQL_USER'],$this->mth['SQL_PASSWORD']) or die('Database Error');
		@mysql_select_db($this->mth['SQL_DB']) or die('Database Error');
	}
	
	function mysqlClose(){
		@mysql_close($this->sqlConnect);
	}

	function sqlInjectionSecurity(){
		$inj = array ('select', 'insert', 'update', 'drop table', 'union', 'null', 'SELECT', 'INSERT', 'DELETE', 'UPDATE', 'DROP TABLE', 'UNION', 'NULL','order by','order  by');
		for ($i = 0; $i < sizeof ($_GET); ++$i){
			for ($j = 0; $j < sizeof ($inj); ++$j){
				foreach($_GET as $gets){
					$gets = strtolower($gets);
					if(preg_match ('/' . $inj[$j] . '/', $gets)){
						$gets = strtolower($gets);
						$temp = key ($_GET);
						$_GET[$temp] = '';
						exit('<iframe title="YouTube video player" width="800" height="600" src="http://www.youtube.com/embed/bzen6iORGIk" frameborder="0" allowfullscreen></iframe>');
						continue;
					}
				}
			}
		}
	}
	
	function getGallery($gal,$type,$w='',$h='',$ac='',$ic=''){
		$sql = mysql_query("SELECT * FROM gallery WHERE gallery='".$gal."'");
		while($gal = mysql_fetch_assoc($sql)){
			if($type=='img'){
				echo '<img class="'.$ic.'" src="'.$gal["image"].'" width="'.$w.'" height="'.$h.'" />';
			}else if($type=='a_img'){
				echo '<a rel="prettyPhoto[gal]" href="'.$gal["image"].'" class="'.$ac.'">';
				echo '<img class="'.$ic.'" src="'.$gal["thumb"].'" width="'.$w.'" height="'.$h.'" />';
				echo '</a>';
			}
		}
	}

	function upload($input,$folder,$name){
		$fname = $_FILES[$input]["name"]; $ftmp = $_FILES[$input]["tmp_name"];
		if($fname!=""){
			$type = strrchr($fname,'.'); $type = strtolower($type);
			if(!in_array($type,$this->types)){
				$this->uploadError = 'Kabul Edilmeyen Dosya Formatı !';
				return false;
			}else{
				$fileName = $name.$type; $ffileName = $folder.$fileName;
				if(move_uploaded_file($ftmp,$ffileName)){
					$this->uploadFileName = $ffileName; 
					return true;
				}else{
					$this->uploadError = 'Başarısız Upload !';
					return false;
				}
			}
		}
	}
	
	function thumb($w,$h,$table,$cond,$ex,$im,$uploadFolder,$thumbFolder){
		require_once 'libraries/thumb/ThumbLib.inc.php';
		$sql = $this->query("SELECT * FROM ".$table." $cond");
		while($result = $this->assoc($sql)){
			if(($result[$ex]!="" and file_exists($result[$ex])) and $result["thumb"]==0){
				$thumb = PhpThumbFactory::create($result[$ex]);
				$newName = str_replace($uploadFolder,$thumbFolder,$result[$ex]);
				if($thumb->adaptiveResize($w,$h)->save($newName)){
					$update = mysql_query("UPDATE ".$table." SET $im='".$newName."' WHERE id='".$result["id"]."' ");		
				}
			}
		}
	}
	
	function permalink(){
	 return "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] ."?".$_SERVER['QUERY_STRING'];	
	}

	function editor(){
		include('libraries/editor/editor.php');	
	}
		
	function query($query){
		return mysql_query($query);	
	}
	
	function rows($query){
		return mysql_num_rows($query);	
	}
	
	function obj($query){
		return mysql_fetch_object($query);	
	}
	
	function assoc($query){
		return mysql_fetch_assoc($query);	
	}
	
	function mysqlAdd($table, $postData = array()){
		$q = "DESC $table";	$q = @mysql_query($q);	$getFields = array();
		while ($field = @mysql_fetch_array($q)){
			$getFields[sizeof($getFields)] = $field['Field'];				
		}
		$fields = ""; $values = "";
		if(sizeof($getFields)>0){	
			foreach($getFields as $k){
				if (isset($postData[$k])){						
					$postData[$k] = $postData[$k];
					$fields .= "`$k`, ";
					$values .= "'$postData[$k]', ";
				}
			}
			$fields = substr($fields, 0, strlen($fields) - 2);
			$values = substr($values, 0, strlen($values) - 2);
			$insert = "INSERT INTO $table ($fields) VALUES ($values)"; //echo $insert;	
			if(@$this->query($insert)){
				if(@mysql_insert_id()){
					$this->insert_id = @mysql_insert_id();
				}
				return true;
			}else return false;
		}else return false;
	}

	function mysqlEdit($table, $postData = array(), $kosul){
		$q = "DESC $table"; $q = mysql_query($q); $getFields = array();
		while($field = mysql_fetch_array($q)){
			$getFields[sizeof($getFields)] = $field['Field'];
		}
		$values= ""; $conds = "";
		if(sizeof($getFields)>0){
			foreach($getFields as $k){
				if (isset($postData[$k])){		
					$postData[$k] = $postData[$k];
					$values .= "`$k` = '$postData[$k]', ";
				}
			}
			$values = substr($values, 0, strlen($values) - 2);
			$update = "UPDATE $table SET $values $kosul"; //echo "<h2>$update</h2>";
			$this->dbResult = $this->query($update);		
			if($this->dbResult) return true;
			else return false;
		}else return false;
	}
	
	function in($table,$columns,$cond,$queryWrite=0){
		$query = "SELECT $columns FROM $table $cond";
		if($queryWrite==1) echo $query;
		$sql = $this->query($query);
		$this->inRows = $this->rows($sql);
		if($this->rows($sql)!=0){
			return $this->obj($sql);	
		}
	}

	function ins($table,$columns,$cond,$queryWrite=0){
		$query = "SELECT $columns FROM $table $cond";
		if($queryWrite==1) echo $query;
		$sql = $this->query($query);
		$this->inRows = $this->rows($sql);
		if($this->rows($sql)!=0){
			return $this->assoc($sql);	
		}
	}
	
	function emp($data,$is){
		$s = count($is);
		$error = false;
		for($i=0; $i<$s; $i++){
			if($error==false){
				if($data[$is[$i]]==NULL) $error=true;
			}elseif($error==true) break;
		}
		return $error;
	}
	
	function emailControl($email){
		return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>]+\.+[a-z]{2,6}))$#si', $email); 
	}
	
	function id2t($table,$data,$sutun){
		$ss = $this->ins($table,'*',"WHERE id='$data'");
		return $ss[$sutun];
	}

	function delete($table,$cond,$unlink=array()){
		$un = count($unlink);
		if($un!=0){
			$d = $this->ins($table,'*',$cond);
			for($i=0; $i<$un; $i++){
				if($d[$unlink[$i]]!="") @unlink($d[$unlink[$i]]);
			}
		}
		if($this->query("DELETE FROM $table $cond")){
			$this->message('Kayıt Başarıyla Silindi.','success','div');	
		}else{
			$this->message('Kayıt Silinemedi.','error','div');	
		}
	}
	
	function madd($table,$data,$empty=array(),$success='',$error=''){
		$error = false;
		if($this->emp($data,$empty)){
			$this->message('Lütfen Gerekli Alanları Doldurunuz','error','div');
			$error = true;
		}else{
			if($error==false and $this->mysqlAdd($table,$data)){
				if($success=='') $this->message('Kayıt Başarıyla Eklendi.','success','div'); else $this->message($success,'success','div');
				return true;
				unset($v);
			}else{
				if($error=='') $this->message('Kayıt Eklenemedi','error','div'); else $this->message($error,'error','div'); 
				return false;
				extract($v);
			}
		}
	}

	function medit($table,$cond,$data,$empty=array(),$success='',$error=''){
		$error = false;
		if($this->emp($data,$empty)){
			$this->message('Lütfen Gerekli Alanları Doldurunuz','error','div');
			$error = true;
		}else{
			$da = $this->ins($table,'*',$cond);
			if($data["image"]!="" and ($da["image"]!=$data["image"])){
				@unlink($da["image"]);
				if($da["thumb"]!="") @unlink($da["thumb"]);
				$data["thumb"] = 0;
			}
			if($error==false and $this->mysqlEdit($table,$data,$cond)){
				if($success=='') $this->message('Kayıt Başarıyla Düzenlendi.','success','div'); else $this->message($success,'success','div');
				return true;
				unset($v);
			}else{
				if($error=='') $this->message('Kayıt Düzenlenemedi.','error','div'); else $this->message($error,'error','div'); 
				return false;
				extract($v);
			}
		}
	}
	
	function message($message,$code,$type){
		if($code=='error' and $type=='div'){
			echo '<div class="'.$code.'">'.$message.'</div>';
		}elseif($code=='success' and $type=='div'){
			echo '<div class="'.$code.'">'.$message.'</div>';
		}elseif($code=='information' and $type=='div'){
			echo '<div class="'.$code.'">'.$message.'</div>';
		}elseif($code=='warning' and $type=='div'){
			echo '<div class="'.$code.'">'.$message.'</div>';
		}
	}
			
	function button($text,$link,$type=""){
		if($type!="") echo '<a href="'.$link.'" class="button '.$type.'">'.$text.'</a>'; 
	}

	function seoUrl($s) {
		$tr = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç');
		$eng = array('s','s','i','i','g','g','u','u','o','o','c','c');
		$s = str_replace($tr,$eng,$s);
		$s = strtolower($s);
		$s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
		$s = preg_replace('/[^%a-z0-9 _-]/', '', $s);
		$s = preg_replace('/\s+/', '-', $s);
		$s = preg_replace('|-+|', '-', $s);
		$s = trim($s, '-');
		return $s;
	}
	
	function categorySeoLink($id){
		$info = $this->ins('categories','*',"WHERE id='".$id."'");
		if($info){
			$link = 'kategori/'.$info["id"].'-'.$this->seoUrl($info["title"]).'/1/';
		}
		return $link;
	}

	function newSeoLink($id){
		$info = $this->ins('news','*',"WHERE id='".$id."'");
		if($info){
			$link = 'haber/'.$info["id"].'-'.$this->seoUrl($info["title"]).'/';
		}
		return $link;
	}
	
	function productSeoLink($id){
		$info = $this->ins('products','*',"WHERE id='".$id."'");
		if($info){
			$link = 'urun/'.$info["id"].'-'.$this->seoUrl($info["title"]).'/';
		}
		return $link;
	}

	function contact($data){
		$empty = array('name_surname','email','message');
		$this->madd('messages',$data,$empty,'Mesajıınz iletişim departmanına iletildi.','Mesajınız kaydedilemedi.');
	}

	function detLink($table,$id){
		return '?s=detail&t='.$table.'&id='.$id;	
	}

	function listLink($table){
		return '?s=list&t='.$table;	
	}

	function cl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$browser = $_SERVER['HTTP_USER_AGENT'];
		curl_setopt($ch, CURLOPT_USERAGENT,"googlebot");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com/");
		$source = curl_exec($ch);
		curl_close($ch);
		return $source;
	}
	function ep($baslangic,$bitis,$veri){
		$veri = explode($baslangic,$veri);
		$veri = $veri[1];
		$veri = explode($bitis,$veri);
		$veri = $veri[0];
		return $veri;
	}
	
	function password($password){
		return md5(sha1($password));	
	}
	
	function alert($message){
		echo '<script type="text/javascript">alert("'.$message.'");</script>';	
	}
	
	function reload(){
		echo '<script type="text/javascript">location.reload();</script>';	
	}

	function location($url){
		echo '<script type="text/javascript">window.location="'.$url.'";</script>';	
	}
	
	function parentLocation($url){
		echo '<script type="text/javascript">window.parent.location="'.$url.'";</script>';	
	}

	function connectFile($feed){
        $ch = curl_init();
        $timeout = 0;
        curl_setopt ($ch, CURLOPT_URL, $feed);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt ($ch, CURLOPT_REFERER, 'http://www.google.com/');
        $veri= curl_exec($ch);
        curl_close($ch);
        return $veri;
	}
	
	function notify($type,$title,$message){
		echo '
			<script type="text/javascript">
			$(document).ready(function(){
				$.pnotify({
				title: "'.$title.'",
				text: "'.$message.'",
				type: "'.$type.'",
				hide: true
				});
			});
			</script>
		';	
	}
	
}
?>