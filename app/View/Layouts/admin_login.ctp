<?php
/**
 *
 * PHP 5
 *
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
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

 
?>
<!DOCTYPE html>
<html>
<head>
	
	<title>
	
		<?php echo "Admin Login"; ?>
	</title>
	<?php
		echo $this->Html->css('admin/style.css');
		echo $this->Html->script('admin/lib.js');
		echo $this->Html->script('admin/jquery.easing.1.3.js');
		echo $this->Html->script('admin/custom.js');
		echo $this->Html->script('jquery-1.10.2');
		echo $this->Html->css('validationEngine.jquery');
		echo $this->Html->script('jquery.validationEngine');
		echo $this->Html->script('jquery.validationEngine-en');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
</head>
<body>
	<div id="container">
		<div id="header">
			
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
