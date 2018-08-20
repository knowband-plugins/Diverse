<!-- header -->
<header id="header" class="app-header navbar bg-dark lt" role="menu">
    <!-- navbar header -->
    <div class="navbar-header box-shadow-inset bg-dark lt">
        <button class="pull-right visible-xs" ui-toggle="show" target=".navbar-collapse">
            <i class="ti-settings"></i>
        </button>
        <button class="pull-right visible-xs" ui-toggle="show" target=".app-aside-top">
            <i class="ti-menu"></i>
        </button>
        <a class="navbar-brand" href="<?php echo $this->Html->Url(array("controller" => "dashboard", "action" => "index")); ?>">
            <span style="color: #fff;font-size: 23px;font-weight: bold;">Diverse: <?php echo $subtitle; ?></span>
            <?php // echo $this->Html->image('logo.png', array('alt' => Configure::read('Logo'))); ?>
            <span class="hidden-folded text-white"><?php echo Configure::read('Logo'); ?><sup class="text-xs font-thin"><?php echo Configure::read('Version'); ?></sup></span>
        </a>
    </div>
    <div class="navbar-collapse hidden-xs">
        <ul class="nav navbar-nav navbar-left">
            <li class="">
                    <?php // echo $this->Html->link("Heatmap", array("controller" => "dashboard"), array("class" => "text-white")); ?>
            </li>

            <li class="">
                <?php // echo $this->Html->link("A/B Testing", array("controller" => "ab", "action" => "index"), array("class" => "text-white")); ?>
            </li>
        </ul>
		<?php if(isset($jsondiff)) { ?>
        <ul class="nav navbar-nav navbar-right m-r-n">
            <div class="btn-group m-b pull-left m-t-sm" style="margin-right:50px;">
                    <div class="checkbox" style="margin: 0px;">
                      <label >
                        <input  id="enablefilter" style="width: 17px;height: 17px;top:-1px;" type="checkbox" value="">
                        <i></i>
                        <span style="color:#fff;font-weight: bold;font-size: 16px;">Enable Filter Array</span>
                      </label>
                    </div>
                    
                    <input type="hidden" value="0" name="filterarray" id="filterarray" />
                </div>
            <li class="pull-right">
                
                <div class="pull-left" style="margin-top: 13px;margin-right: 10px;width:40px;">
                    <i id="loader-spin"  class="fa fa-spin fa-spinner text-success v-m" style="font-size: 21px;color:#fff;display:none;"></i>
                </div>
                <div class="m-t-sm m-r pull-left">
                    <button class="btn w-xs btn-danger" id="compare">Compare</button>
                </div>
            </li>
        </ul>
		<?php } ?>
        <!-- / navbar right -->

    </div>
    <!-- / navbar collapse -->
</header>
<script>
    $("#enablefilter").on("click",function(){
        if($(this).is(":checked")){
            $("#filterarray").val("1");
        }else{
            $("#filterarray").val("0");
        }
    });
</script>

<!-- / header -->
