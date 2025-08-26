<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Delete log if 'del' parameter is set
if(isset($_GET['del']))
{
    $id=intval($_GET['del']);
    $adn="DELETE FROM honeypot_logs WHERE id=?";
    $stmt= $mysqli->prepare($adn);
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();       
    echo "<script>alert('Log Deleted');</script>" ;
}
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Manage Logs</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include('includes/header.php');?>

    <div class="ts-main-content">
        <?php include('includes/sidebar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title" style="margin-top: 4%">Manage Logs</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">All Captured Logs</div>
                            <div class="panel-body">
                                <table id="zctb" class="display table table-striped table-bordered table-hover"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>IP Address</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Thread</th>
                                            <th>Log_time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>IP Address</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Thread</th>
                                            <th>Log_time </th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php    
                                        $aid=$_SESSION['id'];
                                        // Updated query to safely handle timestamp column
                                         $ret="SELECT id, ip_address, username_attempt AS username, password_attempt AS password, user_agent AS thread, created_at FROM honeypot_logs ORDER BY id DESC";
                                        $stmt= $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res=$stmt->get_result();
                                        $cnt=1;
                                        while($row=$res->fetch_assoc())
                                        {
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo htmlspecialchars($row['ip_address']); ?></td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                            <td><?php echo htmlspecialchars($row['password']); ?></td>
                                            <td><?php echo htmlspecialchars($row['thread']); ?></td>
                                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                            <td>
                                                <a href="honeypot_logs.php?del=<?php echo $row['id'];?>"
                                                    onclick="return confirm('Do you want to delete this log?');"><i
                                                        class="fa fa-close"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                            $cnt++;
                                        } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

    <!-- Initialize DataTables -->

</body>

</html>