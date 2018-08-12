<?php /*
*    Pi-hole: A black hole for Internet advertisements
*    (c) 2017 Pi-hole, LLC (https://pi-hole.net)
*    Network-wide ad blocking via your own hardware.
*
*    This file is copyright under the latest version of the EUPL.
*    Please see LICENSE file for your rights under this license. */
    $indexpage = true;
    require "scripts/pi-hole/php/header.php";
    require_once("scripts/pi-hole/php/gravity.php");
?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-green" id="total_queries" title="only A + AAAA queries">
            <div class="inner">
                <p>Total queries (<span id="unique_clients">-</span> clients)</p>
                <h3 class="statistic"><span id="dns_queries_today">---</span></h3>
            </div>
            <div class="icon">
                <i class="ion ion-earth"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <p>Queries Blocked</p>
                <h3 class="statistic"><span id="ads_blocked_today">---</span></h3>
            </div>
            <div class="icon">
                <i class="ion ion-android-hand"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <p>Percent Blocked</p>
                <h3 class="statistic"><span id="ads_percentage_today">---</span></h3>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-red" title="<?php echo gravity_last_update(); ?>">
            <div class="inner">
                <p>Domains on Blocklist</p>
                <h3 class="statistic"><span id="domains_being_blocked">---</span></h3>
            </div>
            <div class="icon">
                <i class="ion ion-ios-list"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
</div>

<div class="row">
    <div class="col-md-12">
    <div class="box" id="queries-over-time">
        <div class="box-header with-border">
          <h3 class="box-title">Queries over last 24 hours</h3>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="queryOverTimeChart" width="800" height="140"></canvas>
          </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
</div>
<?php
  // If the user is logged in, then we show the more detailed index page.
  // Even if we would include them here anyhow, there would be nothing to
  // show since the API will respect the privacy of the user if he defines
  // a password
  if($auth){ ?>

<div class="row">
    <div class="col-md-12">
    <div class="box" id="clients">
        <div class="box-header with-border">
          <h3 class="box-title">Clients (over time)</h3>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="clientsChart" width="800" height="140" class="extratooltipcanvas"></canvas>
          </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-6">
    <div class="box" id="query-types-pie">
        <div class="box-header with-border">
          <h3 class="box-title">Query Types</h3>
        </div>
        <div class="box-body">
          <div class="float-left" style="width:50%">
            <canvas id="queryTypePieChart" width="120" height="120"></canvas>
          </div>
          <div class="float-left" style="width:50%">
            <div id="query-types-legend" class="chart-legend"></div>
          </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-12 col-lg-6">
    <div class="box" id="forward-destinations-pie">
        <div class="box-header with-border">
          <h3 class="box-title">Queries answered by</h3>
        </div>
        <div class="box-body">
          <div class="float-left" style="width:50%">
            <canvas id="forwardDestinationPieChart" width="120" height="120"></canvas>
          </div>
          <div class="float-left" style="width:50%">
            <div id="forward-destinations-legend" class="chart-legend"></div>
          </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
</div>
<?php
  // Determine if "Query Types (over time)" should be shown
  $queryTypesOverTime = false;
  if(isset($setupVars['DASHBOARD_SHOW_QUERY_TYPES_OVER_TIME']))
  {
    if($setupVars['DASHBOARD_SHOW_QUERY_TYPES_OVER_TIME'])
    {
        $queryTypesOverTime = true;
    }
  }

  // Determine if "Forward Destinations (over time)" should be shown
  $forwardDestsOverTime = false;
  if(isset($setupVars['DASHBOARD_SHOW_FORWARD_DESTS_OVER_TIME']))
  {
    if($setupVars['DASHBOARD_SHOW_FORWARD_DESTS_OVER_TIME'])
    {
        $forwardDestsOverTime = true;
    }
  }
?>
<?php if($forwardDestsOverTime || $queryTypesOverTime) { ?>
<div class="row">
<?php if($queryTypesOverTime) { ?>
    <div class="col-md-12 col-lg-6">
    <div class="box" id="query-types">
        <div class="box-header with-border">
          <h3 class="box-title">Query Types (over time)</h3>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="queryTypeChart" width="400" height="150"></canvas>
          </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
<?php } if($forwardDestsOverTime) { ?>
    <div class="col-md-12 col-lg-6">
    <div class="box" id="forward-destinations">
        <div class="box-header with-border">
          <h3 class="box-title">Forward Destinations (over time)</h3>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="forwardDestinationChart" width="400" height="150"></canvas>
          </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
<?php } ?>
</div>
<?php } ?>

<?php
if($boxedlayout)
{
  $tablelayout = "col-md-6";
}
else
{
  $tablelayout = "col-md-6 col-lg-6";
}
?>
<div class="row">
    <div class="<?php echo $tablelayout; ?>">
      <div class="box" id="domain-frequency">
        <div class="box-header with-border">
          <h3 class="box-title">Top Permitted Domains</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                    <th>Domain</th>
                    <th>Hits</th>
                    <th>Frequency</th>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="<?php echo $tablelayout; ?>">
      <div class="box" id="ad-frequency">
        <div class="box-header with-border">
          <h3 class="box-title">Top Blocked Domains</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                    <th>Domain</th>
                    <th>Hits</th>
                    <th>Frequency</th>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>
<div class="row">
    <!-- /.col -->
    <div class="<?php echo $tablelayout; ?>">
      <div class="box" id="client-frequency">
        <div class="box-header with-border">
          <h3 class="box-title">Top Clients (total)</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                    <th>Client</th>
                    <th>Requests</th>
                    <th>Frequency</th>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <!-- /.col -->
    <div class="<?php echo $tablelayout; ?>">
      <div class="box" id="client-frequency-blocked">
        <div class="box-header with-border">
          <h3 class="box-title">Top Clients (blocked only)</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                    <th>Client</th>
                    <th>Requests</th>
                    <th>Frequency</th>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<?php } ?>
<?php
    require "scripts/pi-hole/php/footer.php";
?>

<script src="scripts/pi-hole/js/index.js"></script>
