<div style="padding: 0 0px">
    <div class="flash flash_success">
        <?php if ($this->Session->check('Message.flash'))
            echo $this->Session->flash(); ?>
    </div>
    <div id="messages">
        <?php
        // multiple messages
        $messages = $this->Session->read('Message.multiFlash');
        if ($messages) {
            echo "<div>";
            foreach ($messages as $k => $v) {
                echo $this->Session->flash('multiFlash.' . $k);
            }
            echo '</div>';
        }
        ?>
    </div>
</div>