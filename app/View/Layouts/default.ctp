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
		echo $this->Html->css(array('animate', 'bootstrap', 'themify-icons', 'font-awesome.min', 'font', 'editor', 'jquery-ui', 'slider','app','optimoid','jquery.datetimepicker','BootSideMenu','select2.min', 'pick-a-color-1.2.3.min','jquery.gritter'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->script(array('jquery.min', 'bootstrap-slider', 'js-cookie',));
		echo $this->fetch('script');
		?>
		<script type="text/javascript">
			var siteURL = '<?php echo $this->webroot; ?>'
		</script>
	</head>
	<body>
		<div id="container">
			<div class="app app-header">
				<?php echo $this->element('header'); ?>
				<div id="content" class="app-content" role="main">
					<div class='page-overlay'></div>
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
				</div>
				<?php 
//                                    echo $this->element('footer'); 
                                ?>
			</div>
		</div>
            
		<?php echo $this->element('sql_dump'); ?>
		<?php echo $this->Html->script(array('bootstrap','bootstrap-datetimepicker', 'ui-load', 'ui-jp.config', 'ui-jp', 'ui-nav', 'ui-toggle')); ?>
	
	</body>

<script type="text/javascript">
	
        $("#add_user_button").click(function(e) {
                e.preventDefault();
                $('#add-user-modal').modal()  ;
                $('#myModalLabel').html("Add User");
                $("#password_row").show();
                $("#update_user").hide();
                $("#save_user").show();
                $('#add-user-modal').modal('show');
        });
        $("#add_tag_button").click(function(e) {
                e.preventDefault();
                $('#add-tag-modal').modal()  ;
                $('#myModalLabelTag').html("Add Tag");
                $("#update_tag").hide();
                $("#save_tag").show();
                $('#add-tag-modal').modal('show');
        });
        $('.add-user-modal-close').click(function() {        
            $('#add-user-modal').modal('toggle');
        });
        $(document).on('show.bs.modal', '.modal', function () {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
        $("#save_user").click(function(e) {
            e.preventDefault();
            var error = validateSignupData(true);
            if(!error){
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->Url(array('controller' => 'users', 'action' => 'adduser')); ?>",
                    data: $('#UserAllForm').serialize(),
                    dataType:'json',
                    success: function(json){
                        if(json['success_redirect']){
                            gritter_success('User added successfully!' , true);
                            $('#add-user-modal').modal('toggle');
                        }else if(json['error']){
                            for(var key in json['error']){
                                if(json["error"].hasOwnProperty(key)){
                                    $('input[name="data[User]['+ key +']"]').next('span').html(json['error'][key]);
                                }
                            }                        
                            gritter_danger('User not added. Please check the details carefully!');
                        }
                    }
                }); 
            }else{
                gritter_danger('User not added. Please check the details carefully!');
            }          
        });
        $("#update_user").click(function(e) {
            e.preventDefault();
            var error = validateUpdateData(true);
            if(!error){
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->Url(array('controller' => 'users', 'action' => 'edituser')); ?>",
                    data: $('#UserAllForm').serialize(),
                    dataType:'json',
                    success: function(json){
                        if(json['success_redirect']){
                            gritter_success('User updated successfully!' ,true);
                            $('#add-user-modal').modal('toggle');
                        }else if(json['error']){
                            for(var key in json['error']){
                                if(json["error"].hasOwnProperty(key)){
                                    $('input[name="data[User]['+ key +']"]').next('span').html(json['error'][key]);
                                }
                            }                        
                            gritter_danger('User not updated. Please check the details carefully!');
                        }
                    }
                }); 
            }else{
                gritter_danger('User not added. Please check the details carefully!');
            }          
        });
        function validateSignupData(showMessage){
            var error = false;
            var ele = $('#UserUsFirstName');
            removeHasErrorClass(ele);
            $('span.error-message', ele.closest('div')).html('');
            if ($.trim(ele.val()) == "") {
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("First Name cannot be left empty.");
                }
            }
            else if (ele.val().length > 50){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("First Name can have maximum of 50 characters.");
                }
            }
            var ele = $('#UserUsLastName');
            removeHasErrorClass(ele);
            $('span.error-message', ele.closest('div')).html('');
            if ($.trim(ele.val()) == "") {
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Last Name cannot be left empty.");
                }
            }
            else if (ele.val().length > 50){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Last Name can have maximum of 50 characters");
                }
            }
            var ele = $('#UserUsEmail');
            removeHasErrorClass(ele);
            $('span.error-message', ele.closest('div')).html('');
            if ($.trim(ele.val()) == "") {
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Email cannot be left empty!");
                }
            } else if ($.trim(ele.val()) != "" && !validateEmail($.trim(ele.val()))){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Not a valid email.");
                }
            } else if (ele.val().length > 100){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Email can have maximum of 100 characters");
                }
            }
            var ele = $('#UserUsPassword');
            removeHasErrorClass(ele);
            $('span.error-message',ele.closest('div')).html('');
            if($.trim(ele.val()) == ""){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Password cannot be left empty!");
                }
            } else if(ele.val().length < 6){
                error = true;
                addHasErrorClass(ele);
                if(showMessage){
                    $('span.error-message',ele.closest('div')).html("Please enter password with atleast 6 characters.");
                }
            }
            var ele = $('#UserUsRole');
            removeHasErrorClass(ele);
            $('span.error-message',ele.closest('div')).html('');
            if($.trim(ele.val()) == ""){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Please select a role");
                }
            } 
            
            return error;
        }
        function validateUpdateData(showMessage){
            var error = false;
            var ele = $('#UserUsFirstName');
            removeHasErrorClass(ele);
            $('span.error-message', ele.closest('div')).html('');
            if ($.trim(ele.val()) == "") {
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("First Name cannot be left empty.");
                }
            }
            else if (ele.val().length > 50){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("First Name can have maximum of 50 characters.");
                }
            }
            var ele = $('#UserUsLastName');
            removeHasErrorClass(ele);
            $('span.error-message', ele.closest('div')).html('');
            if ($.trim(ele.val()) == "") {
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Last Name cannot be left empty.");
                }
            }
            else if (ele.val().length > 50){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Last Name can have maximum of 50 characters");
                }
            }
            var ele = $('#UserUsEmail');
            removeHasErrorClass(ele);
            $('span.error-message', ele.closest('div')).html('');
            if ($.trim(ele.val()) == "") {
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Email cannot be left empty!");
                }
            } else if ($.trim(ele.val()) != "" && !validateEmail($.trim(ele.val()))){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Not a valid email.");
                }
            } else if (ele.val().length > 100){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Email can have maximum of 100 characters");
                }
            }
            
            var ele = $('#UserUsRole');
            removeHasErrorClass(ele);
            $('span.error-message',ele.closest('div')).html('');
            if($.trim(ele.val()) == ""){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Please select a role");
                }
            } 
            
            return error;
        }
        function addHasErrorClass(ele){
            ele.closest('div').addClass('has-error');           
        }
        function removeHasErrorClass(ele){           
                ele.closest('div').removeClass('has-error');
                $( ".client-error-message" ).remove();
        }
        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+d.toUTCString();
            var path = "path=/";
            document.cookie = cname + "=" + cvalue + "; " + expires + ";" + path;
        }
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
            }
            return "";
        }
        function validateTagData(showMessage){
            var error = false;
            var ele = $('#TagTag');
            removeHasErrorClass(ele);
            $('span.error-message', ele.closest('div')).html('');
            if ($.trim(ele.val()) == "") {
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Tag cannot be left empty.");
                }
            }
            else if (ele.val().length > 50){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Tag can have maximum of 50 characters.");
                }
            }
            
            
            var ele = $('#TagTagUsers');
            removeHasErrorClass(ele);
            $('span.error-message',ele.closest('div')).html('');
            if($.trim(ele.val()) == ""){
                error = true;
                addHasErrorClass(ele);
                if (showMessage) {
                    $('span.error-message', ele.closest('div')).html("Please select a user");
                }
            } 
            
            return error;
        }
        $("#save_tag").click(function(e) {
            e.preventDefault();
            var error = false;//validateTagData(true);
            if(!error){
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->Url(array('controller' => 'tags', 'action' => 'addtag')); ?>",
                    data: $('#TagIndexForm').serialize(),
                    dataType:'json',
                    success: function(json){
                        if(json['success_redirect']){
                            gritter_success('Tag added successfully!' , true);
                            $('#add-tag-modal').modal('toggle');
                        }else if(json['error']){
                            for(var key in json['error']){
                                if(json["error"].hasOwnProperty(key)){
                                    $('input[name="data[Tag]['+ key +']"]').next('span').html(json['error'][key]);
                                }
                            }                        
                            gritter_danger('Tag not added. Please check the details carefully!');
                        }
                    }
                }); 
            }else{
                gritter_danger('Tag not added. Please check the details carefully!');
            }          
        });
        $("#update_tag").click(function(e) {
            e.preventDefault();
            var error = validateTagData(true);
            if(!error){
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->Url(array('controller' => 'tags', 'action' => 'edittag')); ?>",
                    data: $('#TagIndexForm').serialize(),
                    dataType:'json',
                    success: function(json){
                        if(json['success_redirect']){
                            gritter_success('Tag updated successfully!' , true);
                            $('#add-tag-modal').modal('toggle');
                        }else if(json['error']){
                            for(var key in json['error']){
                                if(json["error"].hasOwnProperty(key)){
                                    $('input[name="data[Tag]['+ key +']"]').next('span').html(json['error'][key]);
                                }
                            }                        
                            gritter_danger('Tag not updated. Please check the details carefully!');
                        }
                    }
                }); 
            }else{
                gritter_danger('Tag not added. Please check the details carefully!');
            }          
        });
        jQuery('[data-toggle="tooltip"]').tooltip();
</script>
</html>
