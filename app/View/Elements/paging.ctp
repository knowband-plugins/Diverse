<div class="span6" style="width: 25%;float:left;">
    <div id="DataTables_Table_0_info" class="dataTables_info paging_counter">
        <?php echo $this->Paginator->counter(array('format' => 'Page %page% of %pages%, showing %current% records out of %count% total')); ?>
    </div>
</div>
<div class="span6 paddingtop10" style="width: 70%; float: right">
    <div class=" paging_bootstrap paging" style="float: right;">
        <?php
        $options = array('before' => null, 'after' => null, 'first' => null, 'last' => null, 'separator' => "",);
        echo '<ul class="pagination" style="margin:0px;"><li class="first disabled">' . $this->Paginator->first(__('First', true), array(), null, array('class' => 'disabled')) . '</li>';
        echo '<li class="prev disabled">' . $this->Paginator->prev('← ' . __('Previous', true), array(), null, array('class' => 'disabled')) . '</li>';
        echo '<li>' . $this->Paginator->numbers($options) . '</li>';
        echo '<li class="next disabled">' . $this->Paginator->next(__('Next', true) . ' →', array(), null, array('class' => 'disabled')) . '</li>';
        echo '<li class="last disabled">' . $this->Paginator->last(__('Last', true), array(), null, array('class' => 'disabled')) . '</li></ul>';
        ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
