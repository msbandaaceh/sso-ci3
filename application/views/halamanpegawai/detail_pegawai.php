<style>
    /* Samakan kontainer select2 (yang menggantikan <select>) dengan .form-select */
    .select2-container--default .select2-selection--single {
        display: block;
        width: 100%;
        height: calc(1.5em + .875rem + 2px);
        /* = 1.5em line-height + .4375rem pad-top + .4375rem pad-bottom + 2px border ≈ 40px (sama dengan .form-select) */
        padding: .4375rem 1.875rem .4375rem .875rem;
        font-size: .9375rem;
        font-weight: 400;
        line-height: 1.5;
        color: #697a8d;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23697a8d' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .875rem center;
        background-size: 16px 12px;
        border: 1px solid #d9dee3;
        border-radius: .375rem;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    /* Samakan teks pilihan yang tampil (rendered text) */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding: 0;
        padding-right: 0;
        line-height: 1.5;
        color: #697a8d;
        font-size: .9375rem;
        font-weight: 400;
    }

    /* Posisi panah default select2 (yang di kanan selection) disembunyikan,
       karena kita sudah pakai panah SVG dari .form-select di background */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        display: none;
    }

    /* Samakan warna saat focus (sama dengan .form-select:focus) */
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:hover {
        border-color: #696cff;
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(105, 108, 255, .1);
    }

    /* Placeholder (sama seperti .form-select) */
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #697a8d;
    }

    /* Samakan tinggi dropdown (option list) */
    .select2-container--default .select2-results__option {
        padding: .4375rem .875rem;
        font-size: .9375rem;
        color: #697a8d;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #e7e7ff;
        color: #697a8d;
    }

    /* Samakan searchbox di dalam dropdown (jika dropdownParent besar, min-height biar konsisten) */
    .select2-container--default .select2-dropdown {
        border-color: #d9dee3;
        border-radius: .375rem;
        box-shadow: 0 .25rem 1rem rgba(0, 0, 0, .08);
    }

    /* Samakan tampilan clear (x) yang muncul karena allowClear */
    .select2-container--default .select2-selection--single .select2-selection__clear {
        margin-right: 1.25rem;
        color: #697a8d;
        font-size: 1rem;
    }

    /* State invalid (untuk form validation jQuery validate) */
    .is-invalid+.select2-container--default .select2-selection--single {
        border-color: #ff5b5c;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23ff5b5c' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
    }

    .is-invalid+.select2-container--default .select2-selection--single:focus,
    .is-invalid+.select2-container--default.select2-container--open .select2-selection--single {
        border-color: #ff5b5c;
        box-shadow: 0 0 0 .25rem rgba(255, 91, 92, .1);
    }
</style>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Detail Pegawai</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= site_url('daftar_pegawai') ?>">Daftar Pegawai</a>
                </li>
                <li class="breadcrumb-item active">Data Pegawai</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Detail Profil Pegawai</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="foto" class="form-label">FOTO PEGAWAI (PNG)</label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="<?= $foto ?>" alt="user-avatar" class="d-block rounded" height="180"
                                        width="120" id="uploadedAvatar" />
                                    <div class="button-wrapper">
                                        <label for="foto" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Unggah Foto Lain</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                        </label>

                                        <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">QR CODE KARTU PEGAWAI</label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <?php if (!empty($qrcode)): ?>
                                        <img src="<?= site_url($qrcode); ?>" alt="QR Code Pegawai" class="d-block rounded"
                                            height="180" width="180" id="uploadedQrCode" />
                                    <?php else: ?>
                                        <div class="d-block rounded bg-light d-flex align-items-center justify-content-center"
                                            height="180" width="180" id="uploadedQrCode"
                                            style="min-height:180px;min-width:180px;">
                                            <span class="text-muted">Belum dibuat</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="button-wrapper">
                                        <a href="javascript:;" onclick="generateQRCode('<?= $userid ?>')"
                                            class="btn btn-primary me-2 mb-4" tabindex="0" id="btnGenerateQr">
                                            <span class="d-none d-sm-block">Generate QR Code</span>
                                            <i class="bx bx-qrcode d-block d-sm-none"></i>
                                        </a>
                                        <?php if (!empty($qrcode)): ?>
                                            <a href="<?= site_url($qrcode); ?>" download class="btn btn-success me-2 mb-4"
                                                tabindex="0">
                                                <span class="d-none d-sm-block">Unduh QR Code</span>
                                                <i class="bx bx-download d-block d-sm-none"></i>
                                            </a>
                                        <?php endif; ?>
                                        <p class="text-muted mb-0">Scan QR Code akan menampilkan Kartu Pegawai. Jika
                                            Foto, Nama, Nip atau Jabatan tidak sesuai, silakan perbaiki data pegawai,
                                            lalu Generate ulang QR Code</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="formSimpanDetailPegawai" enctype="multipart/form-data">
                            <input hidden type="file" id="foto" name="foto" class="account-file-input"
                                accept="image/png" />
                            <div class="row">
                                <input class="form-control" type="hidden" id="id" name="id"
                                    value="<?= base64_encode($this->encryption->encrypt($id)) ?>" />

                                <div class="mb-3 col-md-6">
                                    <label for="nama_gelar" class="form-label">NAMA LENGKAP (DENGAN GELAR)</label>
                                    <input class="form-control" type="text" id="nama_gelar" name="nama_gelar"
                                        value="<?= $nama_gelar; ?>" autofocus autocomplete="off" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="nama" class="form-label">NAMA (TANPA GELAR)</label>
                                    <input class="form-control" type="text" name="nama" id="nama" value="<?= $nama ?>"
                                        autocomplete="off" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input class="form-control" type="text" id="nip" name="nip" value="<?= $nip; ?>"
                                        placeholder="NIP" readonly />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="jabatan" class="form-label">JABATAN</label>
                                    <?= $jabatan ?>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="nohp">NOMOR HANDPHONE</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">IDN </span>
                                        <input type="text" id="nohp" name="nohp" class="form-control"
                                            placeholder="Nomor Handphone" value="<?= $nohp; ?>" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="alamat" class="form-label">ALAMAT</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        placeholder="Alamat" value="<?= $alamat; ?>" autocomplete="off" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="jk" class="form-label">JENIS KELAMIN</label>
                                    <?= $jenis_kelamin ?>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="pangkat">PANGKAT | GOLONGAN</label>
                                    <?= $pangkat ?>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="jenis" class="form-label">JENIS PEGAWAI</label>
                                    <?= $jenis ?>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="tmt" class="form-label">TMT PEGAWAI</label>
                                    <input type="date" placeholder="Terhitung Mulai Tanggal Pegawai"
                                        class="form-control" id="tmt" name="tmt" value="<?= $tmt ?>">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="jenis" class="form-label">STATUS PEGAWAI</label>
                                    <?= $status ?>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                                <button type="reset" class="btn btn-outline-secondary">Batal</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
</div>

<script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
<script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
<script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
<script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

<script src="<?= site_url('assets/js/menu.js'); ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?= site_url('assets/libs/select2/js/select2.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/sweetalert2/js/sweetalert2.min.js') ?>"></script>

<!-- jquery-validation -->
<script src="<?= site_url('assets/libs/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/jquery-validation/additional-methods.min.js') ?>"></script>

<!-- Page JS -->
<script src="<?= site_url('assets/js/sso.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#jk, #jabatan, #pangkat, #jenis, #status').select2({
            width: '100%',
            allowClear: true,
        });
    });

    var info = "<?= $this->session->flashdata('info') ?? ''; ?>";
    var pesan = "<?= $this->session->flashdata('pesan') ?>"
    if (info === '1') {
        sukses(pesan);
    } else if (info === '2') {
        warning(pesan);
    } else if (info === '3') {
        gagal(pesan);
    }

    // Fungsi untuk menampilkan preview gambar
    function previewImage(input, imgElementId) {
        const file = input.files[0];
        const preview = document.getElementById(imgElementId);

        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src = event.target.result; // Set src ke hasil pembacaan
            }
            reader.readAsDataURL(file); // Baca file sebagai URL data
        }
    }

    // Event listener untuk foto pegawai
    document.getElementById('foto').addEventListener('change', function () {
        previewImage(this, 'uploadedAvatar'); // Menampilkan preview pada gambar pegawai
    });

    // Event listener untuk tombol generate QR Code
    function generateQRCode(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Generate QR Code untuk pegawai ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#696cff',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Generate',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'generate_qrcode_pegawai',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.pesan,
                                confirmButtonText: 'OK'
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            gagal('Gagal Generate QRCode.');
                        }
                    },
                    error: function () {
                        gagal('Terjadi kesalahan.');
                    }
                });
            }
        });
    }

    $(function () {
        $(document).off('submit', '#formSimpanDetailPegawai').on('submit', '#formSimpanDetailPegawai', function (e) {
            e.preventDefault();
            let form = this;
            let formData = new FormData(form);

            $.ajax({
                url: 'simpan_pegawai',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (res) {
                    if (res.success == '1') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.pesan,
                            confirmButtonText: 'OK'
                        }).then(function () {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: res.pesan,
                            icon: "error",
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function () {
                    notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
                }
            });
        });
    })
</script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>