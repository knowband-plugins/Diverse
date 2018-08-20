<?php
/**
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 */
$this->layout = "login";
?>
<div class="bg-warning bg-big">
  <div class="text-center m-b-lg">
    <h1 class="text-shadow no-margin text-white text-4x p-v-lg">
      <span class="text-2x font-bold m-t-lg block">404</span>
    </h1>
    <h2 class="h1 m-v-lg text-black">OOPS!</h2>
    <p class="h4 m-v-lg text-u-c font-bold text-black">Sorry! the page you are looking for doesn't exist.</p>
    <div class="p-v-lg">
      <a href="<?php echo $this->Html->url('/'); ?>" class="btn btn-black text-u-c font-bold">Go to the home page</a>
    </div>
  </div>
</div>

<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
