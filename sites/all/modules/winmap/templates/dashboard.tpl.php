<?php
/**
 * Created by PhpStorm.
 * User: VDP
 * Date: 19/04/2017
 * Time: 11:06 PM
 */
?>


<?php


$query_new_node = new EntityFieldQuery();
$query_new_node->entityCondition('entity_type', 'node')
  ->entityCondition('bundle', array('winmap_adv', 'article', 'page'))
  ->propertyCondition('status', 1)
  ->propertyOrderBy('created', 'DESC')
  ->range(0, 30);

$new_node_result = $query_new_node->execute();
if (isset($new_node_result['node'])) {
  $new_node_nids = array_keys($new_node_result['node']);
  $new_nodes = entity_load('node', $new_node_nids);
}


$statistic_node_total = 0;
$statistic_nodes = array(
  'article' => array('title' => 'Bài viết', 'count' => 0, 'color'=>'progress-bar-aqua'),
  'page' => array('title' => 'Trang tĩnh', 'count' => 0, 'color'=>'progress-bar-red'),
  'winmap_adv' => array('title' => 'Quảng cáo', 'count' => 0, 'color'=>'progress-bar-yellow'),
);
$query_statistic_node = "SELECT COUNT(nid) AS total, type FROM {node} node WHERE type IN ('article','page','winmap_adv') GROUP BY type";
$query_statistic_node_results = db_query($query_statistic_node)->fetchAll();
foreach($query_statistic_node_results as $item){
  $statistic_nodes[$item->type]['count'] = $item->total;
  $statistic_node_total += $item->total;
}
if($statistic_node_total == 0) $statistic_node_total = 0.1;


?>

<!--<div class="row">-->
<!--    <div class="col-lg-3 col-xs-6">-->
<!--      -->
<!--        <div class="small-box bg-aqua">-->
<!--            <div class="inner">-->
<!--                <h3>150</h3>-->
<!--                <p>New Orders</p>-->
<!--            </div>-->
<!--            <div class="icon">-->
<!--                <i class="ion ion-bag"></i>-->
<!--            </div>-->
<!--            <a href="#" class="small-box-footer">More info <i-->
<!--                        class="fa fa-arrow-circle-right"></i></a>-->
<!--        </div>-->
<!--    </div>-->
<!--   -->
<!--    <div class="col-lg-3 col-xs-6">-->
<!--       -->
<!--        <div class="small-box bg-green">-->
<!--            <div class="inner">-->
<!--                <h3>53<sup style="font-size: 20px">%</sup></h3>-->
<!---->
<!--                <p>Bounce Rate</p>-->
<!--            </div>-->
<!--            <div class="icon">-->
<!--                <i class="ion ion-stats-bars"></i>-->
<!--            </div>-->
<!--            <a href="#" class="small-box-footer">More info <i-->
<!--                        class="fa fa-arrow-circle-right"></i></a>-->
<!--        </div>-->
<!--    </div>-->
<!--    -->
<!--    <div class="col-lg-3 col-xs-6">-->
<!--        -->
<!--        <div class="small-box bg-yellow">-->
<!--            <div class="inner">-->
<!--                <h3>44</h3>-->
<!---->
<!--                <p>User Registrations</p>-->
<!--            </div>-->
<!--            <div class="icon">-->
<!--                <i class="ion ion-person-add"></i>-->
<!--            </div>-->
<!--            <a href="#" class="small-box-footer">More info <i-->
<!--                        class="fa fa-arrow-circle-right"></i></a>-->
<!--        </div>-->
<!--    </div>-->
<!--   -->
<!--    <div class="col-lg-3 col-xs-6">-->
<!--        -->
<!--        <div class="small-box bg-red">-->
<!--            <div class="inner">-->
<!--                <h3>65</h3>-->
<!---->
<!--                <p>Unique Visitors</p>-->
<!--            </div>-->
<!--            <div class="icon">-->
<!--                <i class="ion ion-pie-graph"></i>-->
<!--            </div>-->
<!--            <a href="#" class="small-box-footer">More info <i-->
<!--                        class="fa fa-arrow-circle-right"></i></a>-->
<!--        </div>-->
<!--    </div>-->
<!--    -->
<!--</div>-->


<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                            <strong>Nội dung mới</strong>
                        </p>
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Kiểu</th>
                                <th>Nhày tạo</th>
                                <th style="text-align: center;">Sửa</th>
                                <th style="text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($new_nodes)): ?>
                            <?php foreach ($new_nodes as $key => $value): ?>
                            <tr>
                                <td><?php print($value->title); ?></td>
                                <td><?php  $node_types = node_type_get_types(); print($node_types[$value->type]->name);  ?></td>
                                <td><?php print(date("d/m/Y",$value->created)); ?></td>
                                <td style="text-align: center;"><a style="color: black" href="<?php print('/node/'.$value->nid.'/edit'); ?>"><i class="fa fa-edit"></i></a></td>
                                <td style="text-align: center;"><a style="color: black" href="<?php print('/node/'.$value->nid.'/delete'); ?>"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                            <strong>Thống kê</strong>
                        </p>

                      <?php foreach($statistic_nodes as $statistic_node):?>
                          <div class="progress-group">
                              <span class="progress-text"><?php echo $statistic_node['title']?></span>
                              <span class="progress-number"><b><?php echo $statistic_node['count']?></b>/<?php echo round($statistic_node_total)?></span>
                              <div class="progress sm">
                                  <div style="width: <?php echo round($statistic_node['count']*100/$statistic_node_total)?>%" class="progress-bar <?php print($statistic_node['color']); ?>"></div>
                              </div>
                          </div>
                      <?php endforeach;?>


                    </div>
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




