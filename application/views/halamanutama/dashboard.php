<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row mt-sm-4 mt-3">
            <div class="col-12">
                <div class="card bg-warning text-center text-white mb-3">
                    <div class="card-header">
                        <div class="card-image">
                            <img src="<?= $this->session->userdata('foto'); ?>"
                                class="w-px-90 h-px-150 rounded-circle" />
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-white">Assalamu'alaikum, Saleum Teuka</h4>
                        <h3 class="card-title text-white"><?= $this->session->userdata('fullname') ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-6 mb-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
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

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://paylink.ms-bandaaceh.local"><img class="card-img-top"
                            src="<?= site_url('assets/img/paylink.webp') ?>" alt="Card image cap"></a>
                    <div class="card-body text-center">
                        <div class="btn btn-primary">
                            <p class="card-text"><?= $hasil[1] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://sias.ms-bandaaceh.local"><img class="card-img-top"
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
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://seudati.ms-bandaaceh.local"><img class="card-img-top"
                            src="<?= site_url('assets/img/seudati.webp') ?>" alt="Card image cap"></a>
                    <div class="card-body text-center">
                        <div class="btn btn-primary">
                            <p class="card-text"><?= $hasil[3] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://agam.ms-bandaaceh.local"><img class="card-img-top"
                            src="<?= site_url('assets/img/agam.webp') ?>" alt="Card image cap"></a>
                    <div class="card-body text-center">
                        <div class="btn btn-primary">
                            <p class="card-text"><?= $hasil[4] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                <div class="card h-100">
                    <a href="http://e-guest.ms-bandaaceh.local"><img class="card-img-top"
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

<script src="<?= site_url('assets/libs/sweetalert2/js/sweetalert2.min.js') ?>"></script>

<!-- Vendors JS -->
<!-- jquery-validation -->
<script src="<?= site_url('assets/libs/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/jquery-validation/additional-methods.min.js') ?>"></script>

<!-- Main JS -->
<script src="<?= site_url('assets/js/main.js') ?>"></script>

<?php if ($page == 'app') { ?>
    <!-- Moment Plugin Js -->
    <script src="<?= site_url('assets/libs/momentjs/moment.js') ?>"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script
        src="<?= site_url('assets/libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?> "></script>
    <script>
        $('.timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            date: false
        });
    </script>
<?php } ?>

<script>
    $(function () {
        $('#formUser').validate({
            rules: {
                passKonfirm: {
                    equalTo: "#password"
                },
            },
            messages: {
                passKonfirm: {
                    equalTo: "Password Tidak Sesuai"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    $(document).on("click", "#hapus", function () {
        var id = $(this).data('id');
        $('#hapusPlh').attr('href', '<?= base_url() ?>hapus_plh/' + id);
    })
</script>

<!-- Page JS -->
<script src="<?= site_url('assets/js/sso.js') ?>"></script>
<script>
    var info = "<?= $this->session->flashdata('info') ?? ''; ?>";
    var pesan = "<?= $this->session->flashdata('pesan') ?>"
    if (info === '1') {
        sukses(pesan);
    } else if (info === '2') {
        warning(pesan);
    } else if (info === '3') {
        gagal(pesan);
    }

    var pegawai_plh = "<?= $this->session->flashdata('pegawai_plh') ?>";
    if (pegawai_plh == '1') {
        infoPlh();
    }
</script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>