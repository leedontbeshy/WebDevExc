<html>
<head><meta http-equiv="content-type" charset="utf-8"></head>
<body>
<div id="container">
    <div id="banner"></div>
    <div id="menu"></div>
    <div id="lmenu"><?php include "lmenu.php"; ?></div>
    <div id="content"><?php include "content.php"; ?></div>
    <br style="clear:both;">
    <div id="footer"></div>
</div>
<style>
body{margin:0px;}
#container{width:1000px; margin:0px auto;}
#banner{height:150px; background-color:#39C;}
#menu{height:30px; background-color:red;}
#lmenu{height:400px; width:200px; background-color:#FC6; float:left; /*bỏ height*/}
#content{height:400px; width:800px; background-color:#9f3;float:left; /*bỏ height*/}
#footer{height:200px; background-color:#096;}
</style>
</body>
</html>
