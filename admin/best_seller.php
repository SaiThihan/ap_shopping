<?php
session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}
if ($_SESSION['role'] != 1) {
  header('Location: login.php');
}

// if ($_POST['search']) {
//   setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
// }else{
//   if (empty($_GET['pageno'])) {
//     unset($_COOKIE['search']); 
//     setcookie('search', null, -1, '/'); 
//   }
// }
?>


<?php include('header.php'); ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Best Seller Items (which are sold above 3)</h3>
              </div>
              <?php
                $currentDate = date('Y-m-d');
                $stmt = $pdo->prepare("SELECT * FROM sale_order_details GROUP BY product_id HAVING SUM(quantity) > 3 ORDER BY id DESC");
                $stmt->execute();
                $result = $stmt->fetchAll();
              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="d-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Product</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>

                       <?php  
                       $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                       $stmt->execute();
                       $result = $stmt->fetchAll();
                       
                       ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo escape($result[0]['name'])?></td>
                        </tr>
                    <?php
                      $i++;
                      }
                    }
                    ?>
                  </tbody>
                </table><br>
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include('footer.html')?>
  <script>
        $(document).ready(function () {
            $('#d-table').DataTable();
        });
    </script>