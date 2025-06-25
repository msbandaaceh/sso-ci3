<script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
<script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
<script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
<script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

<script src="<?= site_url('assets/js/menu.js'); ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<!-- Select2 JS -->
<script src="<?= site_url('assets/libs/select2/js/select2.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/sweetalert2/js/sweetalert2.min.js') ?>"></script>

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
    var pegawai_plh = "<?= $this->session->userdata('pegawai_plh') ?>";
    if (pegawai_plh == '1') {
        infoPlh();
    }

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
</script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>