                <!-- /Register -->
                <div class="mt-3">
                    <div class="text-center">Copyright © 2024 All Right Reserved. Powered by Bagian
                        Teknologi Informasi</div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
    <script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
    <script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

    <script src="<?= site_url('assets/js/menu.js') ?>"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?= site_url('assets/js/main.js') ?>"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="<?= site_url('assets/js/sso.js') ?>"></script>
    <script src="<?= site_url('assets/libs/sweetalert2/js/sweetalert2.min.js') ?>"></script>
    <script src="<?= site_url('assets/libs/jquery-validation/jquery.validate.min.js') ?>"></script>
    <script src="<?= site_url('assets/libs/jquery-validation/additional-methods.min.js') ?>"></script>

    <script>
        var info = "<?= $this->session->flashdata('info') ?? ''; ?>";
        var pesan = "<?= $this->session->flashdata('pesan') ?? ''; ?>";
        if (info === '1') {
            sukses(pesan);
        } else if (info === '2') {
            warning(pesan);
        } else if (info === '3') {
            gagal(pesan);
        }
    </script>
</body>

</html>

