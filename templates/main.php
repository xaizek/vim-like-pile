<html>

<head>
    <title><?php echo $title; ?></title>
    <link href="<?php echo $webRoot; ?>/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="buttons">
        <div class="button">
            <a href="<?php echo $webRoot; ?>/about">about</a>
        </div>
        <div class="button">
            <a href="#search">search</a>
            <form id="search" action="<?php echo $webRoot; ?>/search"
                  method="get">
                <a href="#">search</a>
                <input type="search" name="q" placeholder="..."/>
            </form>
        </div>
    </div>
    <h1><a href="<?php echo $webRoot; ?>/"><?php echo $title; ?></a></h1>
    <div class="types">
        <span class="type <?php if ($type == 'apps') echo 'currentType'; ?>">
            <a href="<?php echo $webRoot; ?>/apps">Applications</a></span>
        <span class="type <?php if ($type == 'plugs') echo 'currentType'; ?>">
            <a href="<?php echo $webRoot; ?>/plugs">Plugins</a></span>
        <span class="type <?php if ($type == 'confs') echo 'currentType'; ?>">
            <a href="<?php echo $webRoot; ?>/confs">Configurable</a></span>
    </div>
    <div class="typeDescr">
        <?php echo $descr; ?>
    </div>
    <div>
        <?php echo $content; ?>
    </div>
</body>

</html>
