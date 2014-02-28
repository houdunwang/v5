#本堂课讨论登录
##管理员(用数据库来记录)

###第7课（2.28）====
1. 不要使用记事本编辑代码（尤其你的代码是utf8）
2. 


---

管理员对像属性
ID	帐号		密码
1	admin		xxxx
2	root		xxxx

define('GROUP_PATH','Cms/');

Cms/App  (App是放置所有应用的目录)
Cms/App/V5 （v5应用只管理，后台登录，退出，界面显示）
通过v5应用登录后台
Cms/App/V5/Control/LoginControl.class.php/Login

http://localhost/v5/cms/index.php/V5/Login/login