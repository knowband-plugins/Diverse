<?php $count = 1; 
?>
<div class="panel panel-default">
    <div class="panel-heading bg-white">
        <div class="pull-left text-2x">Differences</div>
        <div class="m-t-sm m-r pull-right">
            <button class="btn btn-info" id="exporttoexcel">Export Differences to CSV</button>
            <button style="display: none;" class="btn btn-info" id="downloadExcel" download onclick="window.location.href='DiverseReport.csv?v=<?php echo time(); ?>'">Export Differences to CSV</button>
        </div>
        <div class="pull-right" style="margin-top: 13px;margin-right: 10px;width:40px;">
            <i id="loader-spin-excel"  class="fa fa-spin fa-spinner text-success v-m" style="font-size: 21px;color:#000;display:none;"></i>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="panel panel-default" id="LEFTBOX">
                <div class="panel-heading bg-white">
                   MISSING Elements In RIGHT SIDE - <b>Total : <?php echo $new_data["count"]; ?></b>
                </div>
                <div class="panel-body">
                    <?php foreach ($new_data["data"] as $path => $data) {
                        $orginal_path = $path;
                        $path_array = explode('/',$path);
                        $path_last = end($path_array);
                        
                        $path = str_replace($path_last, '<b style="color:blue;">'.$path_last.'</b>', $path);
                        
                        ?>
                        <div class="markers" data="<?php echo $this->Test->getLineNumber($orginal_path,$left_data); ?>"><?php echo'<span style="color:#000;">'.$count. ')</span> (' . $path . ") : (" . $data . ')'; ?></div>
                    <?php $count++; } ?>
                </div>
            </div>
            <div class="panel panel-default" id="RIGHTBOX">
                <div class="panel-heading bg-white">
                   NEW Elements in RIGHT SIDE - <b>Total : <?php echo $removed_data["count"]; ?></b>
                    <!--<small class="text-muted">Individual form controls automatically receive some global styling. All textual &lt;input&gt;, &lt;textarea&gt;, and &lt;select&gt; elements with .form-control are set to width: 100%; by default. Wrap labels and controls in .form-group for optimum spacing.</small>-->
                </div>
                <div class="panel-body">
                    <?php foreach ($removed_data["data"] as $path => $data) { 
                        $orginal_path = $path;
                        $path_array = explode('/',$path);
                        $path_last = end($path_array);
                        
                        $path = str_replace($path_last, '<b style="color:blue;">'.$path_last.'</b>', $path);
                        ?>
                        <div class="markers" data="<?php echo $this->Test->getLineNumber($orginal_path,$right_data); ?>"><?php echo '<span style="color:#000;">'.$count. ')</span> (' . $path . ") : (" . $data . ')'; ?></div>
                    <?php $count++;  } ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default" id="VALUEBOX">
                <div class="panel-heading bg-white">
                    Mismatched Values - <b>Total : <?php echo $edited_data["count"]; ?></b>
                </div>
                <div class="panel-body">
                    <?php foreach ($edited_data["data"] as $path => $data) { //var_dump($data);
                        $orginal_path = $path;
                        $path_array = explode('/',$path);
                        $path_last = end($path_array);
                        
                        $path = str_replace($path_last, '<b style="color:blue;">'.$path_last.'</b>', $path);
                        ?>
                    <div class="markers" data-left="<?php echo $this->Test->getLineNumber($orginal_path,$left_data); ?>" data-right="<?php echo $this->Test->getLineNumber($orginal_path,$right_data); ?>"><?php echo '<span style="color:#000;">'.$count. ')</span> (' . $path . ") : (<span style=\"color:red\"> OLD value -". $data["oldvalue"]."</span>" ."<span style=\"color:green\"> NEW value -  ". $data["newvalue"]."</span>" . ')'; ?></div>
                    <?php $count++;  } ?>
                </div>
            </div>
        </div>
    </div>
</div>

