<?php
$sql = "SELECT * FROM winmap_enterprises ORDER BY id ASC";
$result = db_query($sql)->fetchAll();
?>

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <p class="text-center">
              <strong>Danh sách khách hàng</strong>
            </p>
            <table class="table table-bordered table-hover dataTable">
              <thead>
              <tr>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Domain Name</th>
                <th>Ngày tạo</th>
                <th style="text-align: center;">Sửa</th>
                <!--                <th style="text-align: center;">Xóa</th>-->
              </tr>
              </thead>
              <tbody>
              <?php if (!empty($result)): ?>
                <?php foreach ($result as $key => $value): ?>
                  <tr>
                    <td><?php print($value->name); ?></td>
                    <td><?php echo $value->phone;  ?></td>
                    <td><?php echo $value->email;  ?></td>
                    <td><?php echo $value->domain;  ?></td>
                    <td><?php print(date("d/m/Y",$value->created)); ?></td>
                    <td style="text-align: center;"><a style="color: black" href="<?php print('/admin/customer/'.$value->id.'/edit'); ?>"><i class="fa fa-edit"></i></a></td>
                    <!--                    <td style="text-align: center;"><a style="color: black" href="--><?php //print('/admin/hosting/'.$value->id.'/delete'); ?><!--"><i class="fa fa-trash"></i></a></td>-->
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              </tbody>
            </table>
            <!-- /.chart-responsive -->
          </div>
          <!-- /.col -->

          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- ./box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>


