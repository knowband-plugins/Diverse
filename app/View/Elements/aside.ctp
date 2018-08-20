<!-- aside -->
<aside id="aside" class="app-aside-top hidden-xs">
	<div class="app-aside-inner">
		<div class="app-aside-body">
			<nav ui-nav>
				<ul class="nav nav-md">
                                        <?php
                                        if('Ab') {
                                                if ($this->params['controller'] == 'dashboard' || $this->params['action'] == 'index') {
						$active = 'active';
					}
					else{
						$active = '';
					}
					?>
                                                <li class="<?php echo ($this->params['controller'] == 'reporting')?'active':''; ?>">
                                                        <?php echo $this->Html->link("Statistics", array("controller" => "reporting", "action" => "index")); ?>
                                                </li>
                                                <li class="<?php echo ($this->params['controller'] == 'question')?'active':''; ?>">
                                                        <?php echo $this->Html->link("Add Question", array("controller" => "question", "action" => "add")); ?>
                                                </li>
<!--                                                <li class="<?php // echo ($this->params['controller'] == 'users')?'active':'';  ?>">
                                                        <?php // echo $this->Html->link("Users", array("controller" => "users", "action" => "all")); ?>
                                                </li>
                                                
                                                <li class="<?php // echo ($this->params['controller'] == 'tags')?'active':'';  ?>">
                                                        <?php // echo $this->Html->link("Tags", array("controller" => "tags", "action" => "index")); ?>
                                                </li>
                                                
                                                <li class="<?php // echo ($this->params['controller'] == 'settings')?'active':'';  ?>">
                                                        <?php // echo $this->Html->link("Settings", array("controller" => "settings", "action" => "index")); ?>
                                                </li>
                                                <li class="">
                                                    <a target="_blank" href="https://www.mockingfish.com/support">Support</a>
                                                </li>-->
                                        <?php
                                        } ?>
				</ul>
			</nav>
		</div>
	</div>
</aside>
<!-- / aside -->

<!-- Service Message -->
<?php if(isset($service_message) && !empty($service_message)){ ?>
        <div class="alert-danger p-sm package-alert"><i class="fa fa-warning"></i> <?php echo $service_message; ?></div>
<?php } ?>
<!-- / Service Message -->

<!-- Snippet not installed message -->
<?php if(isset($snippet_message) && !empty($snippet_message)){ ?>
        <div class="alert-danger p-sm package-alert"><i class="fa fa-warning"></i> <?php echo $snippet_message; ?></div>
<?php } ?>
<!-- / Snippet not installed message -->