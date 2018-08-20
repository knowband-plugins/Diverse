<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Diverse');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $cakeDescription ?>:
			<?php echo $this->fetch('title'); ?>
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('animate', 'bootstrap', 'themify-icons', 'font-awesome.min', 'font', 'app', 'optimoid'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->script(array('jquery.min', 'optimoid'));
		?>
		<script type="text/javascript">
			var siteURL = '<?php echo $this->webroot; ?>'
		</script>
	</head>
	<body>
		<div id="container">
			<div class="app app-header">
                            <div class="w-full bg-dark m-b-md p-v-sm text-center">
                                <div class="center-block w-auto-xs">
                                    <span style="color: #fff;font-size: 36px;font-weight: bold;">Diverse</span>
                                    <?php // echo '<a href="'.Configure::read('OptimoidWebsiteUrl').'">'.$this->Html->image('mockingfish-logo.png', array('alt' => Configure::read('Logo'))).'</a>'; ?>
                                </div>
                            </div>
                            <?php echo $this->Session->flash(); ?>
                            <?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<?php // echo $this->element('sql_dump'); ?>
		<?php echo $this->Html->script(array('bootstrap', 'ui-load', 'ui-jp.config', 'ui-jp', 'ui-nav', 'ui-toggle')); ?>
	</body>
</html>
