<?php echo $html->docType(); ?>
<html>
<head>
    <?php echo $html->charset(); ?>
    <title>Ext.Direct for CakePHP</title>
    <?php
    echo $html->css('/js/ext/resources/css/ext-all.css');
    ?>
</head>
<body>
    <?php
    $combine->js(array(
       (Configure::read('debug') > 0 ? 'ext/adapter/ext/ext-base-debug.js' : 'ext/adapter/ext/ext-base.js'),
       (Configure::read('debug') > 0 ? 'ext/ext-all-debug.js' : 'ext/ext-all.js')
    ));
    ?>
    <?php echo $content_for_layout; ?>
    <?php echo $cakeDebug; ?>
</body>
</html>