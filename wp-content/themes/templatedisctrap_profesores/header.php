<!DOCTYPE html>
<html lang="<?php echo $bloginfo = get_bloginfo( 'language' ); ?>">
<head>
    <meta charset="<?php echo $bloginfo = get_bloginfo( 'charset' ); ?>">
    <title><?php echo get_bloginfo( 'name' ); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" />
    <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php wp_enqueue_script("jquery"); ?>
    <?php wp_head(); ?>
</head>

<body>
<nav class="navbar navbar-default-mati navbar-fixed-top">
  <div class="container-fluid">
    <?php get_nav_bar_header(); ?>

    <div class="collapse navbar-collapse" id="menu-superior-sitio-disc">
      <ul class="nav navbar-nav">
          <?php get_marca_home(); ?>
          <?php get_main_menu(); ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
                <?php get_menu_conectar(); ?>
          </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="<?php echo apply_filters('disc_filtro_clase_titulo','jumbotron titulo');?>" >
    <?php dar_titulo_sitio(); ?>
</div>

<div class="<?php echo apply_filters('disc_filtro_clase_cuerpo', 'container'); ?>">
