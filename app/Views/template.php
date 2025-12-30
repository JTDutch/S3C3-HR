<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$title?></title>
  <script src="https://kit.fontawesome.com/60304f5951.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?=base_url('/assets/css/bootstrap.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('/assets/css/style.css')?>">
  <link rel="stylesheet" href="<?=base_url('/assets/css/select2.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('/assets/css/plugins/sweetalert/sweetalert2.css')?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <?php if(isset($assets['css'])){ echo load_css($assets['css']); } ?>
</head>
<body class="d-flex flex-column min-vh-100">

<div id="flash-data"
     data-success="<?= session()->getFlashdata('success') ?>"
     data-error="<?= session()->getFlashdata('error') ?>"
     style="display:none;"></div>


  <?php if(session()->get('account_id')):?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">HR Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2" href="/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  <?php endif;?>

<main class="flex-grow-1">
  <?=view($view)?>
</main>

  <!-- Scripts -->
  <script src="<?=base_url('/assets/js/jquery-3.6.3.js')?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="<?=base_url('/assets/js/toastr.js')?>"></script>
  <script src="<?=base_url('/assets/js/select2.min.js')?>"></script>
  <script src="<?=base_url('/assets/js/bootstrap.min.js')?>"></script>
  <script src="<?=base_url('/assets/js/main.js')?>"></script>
  <script src="<?=base_url('/assets/js/plugins/sweetalert/sweetalert2.js')?>"></script>
  <?php if(isset($assets['js'])){ echo load_js($assets['js']); } ?>

<footer class="bg-dark text-white py-4 mt-5">
  <!-- Desktop Footer -->
  <div class="container d-none d-lg-flex justify-content-center">

    <a href="#">
      <img src="<?= base_url('assets/img/hr_logo.svg') ?>" alt="Logo" style="height: 80px;">
    </a>

  </div>

  <!-- Copyright on Desktop Footer -->
  <div class="container d-none d-lg-flex justify-content-center ">
    <div>
      <small>&copy; <?= date('Y') ?> HR-Application. All rights reserved.</small>
    </div>
  </div>
</footer>

</body>
</html>
