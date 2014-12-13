<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script type ='text/javascript'>
        baseUrl = '<?php echo Yii::app()->request->getBaseUrl(true); ?>';
    </script>

	<?php 
        Yii::app()->bootstrap->register(); 
        Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
    ?>
    <?php
		$baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl.'/js/custom.js');
        $cs->registerCssFile($baseUrl.'/css/bootstrap-overwrite.css');
        $cs->registerCssFile($baseUrl.'/css/bootstrap-overwrite-new.css');
        $cs->registerCssFile($baseUrl.'/css/glyphicons/bootstrap.icon-large.min.css');
        $cs->registerCssFile($baseUrl.'/css/TimeCircles.css');
    ?>

</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'type'=>'inverse',
    'collapse' => true,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index')),
                //array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'Users', 'url'=>  Yii::app()->createAbsoluteUrl("/user/index"), 'active' => (Yii::app()->getController()->getId() == 'user' && (Yii::app()->getController()->getAction()->getId() == 'index' || Yii::app()->getController()->getAction()->getId() == 'admin' )), 'visible' => Yii::app()->user->checkAccess('user.index')),
                array('label'=>'Mail Groups', 'url'=>  Yii::app()->createAbsoluteUrl("/mailgroups/index"), 'active' => (Yii::app()->getController()->getId() == 'mailgroups'), 'visible' => Yii::app()->user->checkAccess('mailgroups.index')),
                array('label'=>'Notifications', 'url'=>  Yii::app()->createAbsoluteUrl("/notifications/email"), 'active' => (Yii::app()->getController()->getId() == 'notifications'), 'visible' => Yii::app()->user->checkAccess('notifications.index')),
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Contact', 'url'=>array('/site/contact')),
                array('label'=>'Forgot Password', 'url'=>array('/site/forgotpassword'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->getName().')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ),
    ),
)); ?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by e-Planner. All Rights Reserved.
	</div><!-- footer -->

</div><!-- page -->

<div class="go-loading">
    <?php
        echo CHtml::image(Yii::app()->baseUrl.'/images/go-loading.gif', 'Loading...', array('class' => 'go-loading-image'));
    ?>
</div>

<script type="text/javascript">
var CUrl;
function CViewForm()
{
$('#content_header').html(CHeader);

    <?php echo CHtml::ajax(array(
            'url'=>  "js:CUrl",
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            { //alert(data.div);
                if (data.status == 'failure')
                {
                    $('#CView div.modal-body').html(data.div);
                    $('#CView div.modal-body form').submit(CViewForm);
                }
                else
                {
                   $('#CView div.modal-body').html(data.div);
                   setTimeout(\"$('#CView').modal('hide') \",2000);
                   $.fn.yiiGridView.update('client-grid');
                }

            } ",
            ))?>;
    return false;

}
</script>
<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'CView')); 
?>
<div class="modal-header">
<a class="close" data-dismiss="modal">&times;</a>
<h4 id="content_header"></h4>
</div>
<div class="modal-body">
</div>    
<?php $this->endWidget(); ?>

</body>
</html>