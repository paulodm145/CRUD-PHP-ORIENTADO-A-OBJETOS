<?php 
require('vendor/autoload.php');
use ClassesSistema\Database;
use ClassesSistema\Url;
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <title>Cadastro de Clientes</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  </head>
  <body style="min-height: 75rem; padding-top: 4.5rem;">
    <header>
    <div class="container" >
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <a class="navbar-brand" style="margin-left:5px" href="#">CRUD TESTE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URL::getBase(); ?>" id="nomeCliente">Início</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo URL::getBase(); ?>clientes" id="nomeCliente">Clientes</a>
            </li>
            </ul>
        </div>
        </nav>
    </div>
    <header>

      <div class="container" >

      <?php
        $modulo = Url::getURL( 0 );
 
        if( $modulo == null )
            $modulo = "home";
 
        if( file_exists( "modulos/" . $modulo . ".php" ) )
            require "modulos/" . $modulo . ".php";
        else
            require "modulos/404.php";
        ?>
      </div>


<script> const __PATH__ = '<?php echo URL::getBase(); ?>'; </script>
<script> const __BASEPATH__ = '<?php echo URL::getBase(); ?>'; </script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- SWEET ALERT -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></scrip

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

<script src="<?php echo URL::getBase(); ?>assets/js/bootstrap-dialog.js"></script>

<script src="<?php echo URL::getBase(); ?>assets/js/jquery.form.min.js"></script>
<script src="<?php echo URL::getBase(); ?>assets/js/jquery.blockUI.js"></script>

<!-- mascaras -->
<script src="<?php echo URL::getBase(); ?>assets/js/mascaras.js"></script>
<script src="<?php echo URL::getBase(); ?>assets/js/jquerymask.js"></script>
<script src="<?php echo URL::getBase(); ?>assets/js/jquery.maskMoney.min.js"></script>
<script src="<?php echo URL::getBase(); ?>assets/js/Common.js"></script>
<script>$('.money').mask('#.##0,00', {reverse: true});</script>
</body>
</html>

