<?php
    $csave = isset($_POST['csave']) ? $_POST['csave'] : '';
    $cip = isset($_POST['cip']) ? $_POST['cip'] : '';
    $ckey = isset($_POST['ckey']) ? $_POST['ckey'] : '';
    if ($csave == "csave"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET client_ip='$cip' WHERE id='1'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE settings SET client_key='$ckey' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $ssave = isset($_POST['ssave']) ? $_POST['ssave'] : '';
    $skey = isset($_POST['skey']) ? $_POST['skey'] : '';
    if ($ssave == "ssave"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET server_key='$skey' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }



$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$cip=$a["client_ip"];
$ckey=$a["client_key"];
$skey=$a["server_key"];

}


?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Client</h3>
</div>
<div class="panel-body">

<form action="" method="post" class="form-horizontal">
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">IP/Hostname</label>  
  <div class="col-md-4">
  <input id="textinput" name="cip" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $cip; ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Key</label>  
  <div class="col-md-4">
  <input id="textinput" name="ckey" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $ckey; ?>">
     <input type="hidden" name="csave" value="csave" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
  </div>
</div>

</fieldset>
</form>


</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Server</h3>
</div>
<div class="panel-body">

<form action="" method="post" class="form-horizontal">
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Key</label>  
  <div class="col-md-4">
  <input id="textinput" name="skey" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $skey; ?>">
     <input type="hidden" name="ssave" value="ssave" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
  </div>
</div>

</fieldset>
</form>


</div>
</div>