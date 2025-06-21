<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row row-cols-1 row-cols-md-3 g-6 mb-12">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://hadir-in.ms-bandaaceh.local"><img class="card-img-top"
                            src="<?= site_url('assets/img/hadir-in.webp') ?>" alt="Card image cap"></a>
                    <div class="card-body text-center">
                        <div class="btn btn-primary">
                            <p class="card-text"><?= $hasil[0] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://paylink.local?sso_token=<?php echo urlencode($jwt); ?>"><img class="card-img-top"
                            src="<?= site_url('assets/img/paylink.webp') ?>" alt="Card image cap"></a>
                    <div class="card-body text-center">
                        <div class="btn btn-primary">
                            <p class="card-text"><?= $hasil[1] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://sias.local?sso_token=<?php echo urlencode($jwt); ?>"><img class="card-img-top"
                            src="<?= site_url('assets/img/sias.webp') ?>" alt="Card image cap"></a>
                    <div class="card-body text-center">
                        <div class="btn btn-primary">
                            <p class="card-text"><?= $hasil[2] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-6 mb-12">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://seudati.local?sso_token=<?php echo urlencode($jwt); ?>"><img class="card-img-top"
                            src="<?= site_url('assets/img/seudati.webp') ?>" alt="Card image cap"></a>
                    <div class="card-body text-center">
                        <div class="btn btn-primary">
                            <p class="card-text"><?= $hasil[3] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://agam.local?sso_token=<?php echo urlencode($jwt); ?>"><img class="card-img-top"
                            src="<?= site_url('assets/img/agam.webp') ?>" alt="Card image cap"></a>
                    <div class="card-body text-center">
                        <div class="btn btn-primary">
                            <p class="card-text"><?= $hasil[4] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://e-guest.local?sso_token=<?php echo urlencode($jwt); ?>"><img class="card-img-top"
                            src="<?= site_url('assets/img/e-guest.webp') ?>" alt="Card image cap"></a>
                    <div class="card-body text-center">
                        <div class="btn btn-primary">
                            <p class="card-text"><?= $hasil[5] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
<script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
<script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
<script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
<script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

<script src="<?= site_url('assets/js/menu.js'); ?>"></script>
<!-- endbuild -->

<!-- Main JS -->
<script src="<?= site_url('assets/js/main.js') ?>"></script>

<script>
    var pegawai_plh = "<?= $this->session->userdata('pegawai_plh') ?? ''; ?>";
    if (pegawai_plh === '1') {
        infoPlh();
    }
</script>

<!-- Page JS -->
<script src="<?= site_url('assets/js/sso.js') ?>"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>