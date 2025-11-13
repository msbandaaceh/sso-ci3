<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2 text-center">Formulir Laporan Ticketing</h4>
                    <p class="mb-4 text-center">Silakan isi formulir di bawah ini untuk melaporkan error, bug, atau permintaan fitur</p>

                    <?php if ($this->session->flashdata('info')) { ?>
                        <div class="alert alert-<?= $this->session->flashdata('info') == '1' ? 'success' : ($this->session->flashdata('info') == '2' ? 'warning' : 'danger') ?> alert-dismissible" role="alert">
                            <?= $this->session->flashdata('pesan') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <form id="formTicketing" method="POST" action="<?= site_url('simpan_ticket') ?>" onsubmit="return showLoaderSweetalert2(this)">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        
                        <div class="mb-3">
                            <label for="nama_pelapor" class="form-label">Nama Pelapor <code>*</code></label>
                            <code><?php echo form_error('nama_pelapor'); ?></code>
                            <input type="text" class="form-control" id="nama_pelapor" name="nama_pelapor" 
                                placeholder="Masukkan nama Anda" required 
                                value="<?= set_value('nama_pelapor'); ?>" />
                        </div>

                        <div class="mb-3">
                            <label for="jenis_laporan" class="form-label">Jenis Laporan <code>*</code></label>
                            <code><?php echo form_error('jenis_laporan'); ?></code>
                            <select class="form-select" id="jenis_laporan" name="jenis_laporan" required>
                                <option value="">Pilih Jenis Laporan</option>
                                <optgroup label="Masalah Sistem">
                                    <option value="error" <?= set_select('jenis_laporan', 'error'); ?>>Error / Kesalahan Sistem</option>
                                    <option value="bug" <?= set_select('jenis_laporan', 'bug'); ?>>Bug / Kutu Program</option>
                                </optgroup>
                                <optgroup label="Masalah Infrastruktur TI">
                                    <option value="masalah_jaringan" <?= set_select('jenis_laporan', 'masalah_jaringan'); ?>>Masalah Jaringan</option>
                                    <option value="masalah_internet" <?= set_select('jenis_laporan', 'masalah_internet'); ?>>Masalah Internet / Koneksi</option>
                                    <option value="masalah_hardware" <?= set_select('jenis_laporan', 'masalah_hardware'); ?>>Masalah Hardware / Perangkat</option>
                                    <option value="masalah_printer" <?= set_select('jenis_laporan', 'masalah_printer'); ?>>Masalah Printer</option>
                                </optgroup>
                                <optgroup label="Masalah Aplikasi & Software">
                                    <option value="masalah_software" <?= set_select('jenis_laporan', 'masalah_software'); ?>>Masalah Software / Aplikasi</option>
                                    <option value="masalah_email" <?= set_select('jenis_laporan', 'masalah_email'); ?>>Masalah Email</option>
                                    <option value="masalah_akun" <?= set_select('jenis_laporan', 'masalah_akun'); ?>>Masalah Akun / Login</option>
                                </optgroup>
                                <optgroup label="Permintaan">
                                    <option value="permintaan_fitur" <?= set_select('jenis_laporan', 'permintaan_fitur'); ?>>Permintaan Fitur Baru</option>
                                    <option value="permintaan_akses" <?= set_select('jenis_laporan', 'permintaan_akses'); ?>>Permintaan Akses / Hak Akses</option>
                                </optgroup>
                                <optgroup label="Lainnya">
                                    <option value="lainnya" <?= set_select('jenis_laporan', 'lainnya'); ?>>Lainnya</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Laporan <code>*</code></label>
                            <code><?php echo form_error('deskripsi'); ?></code>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" 
                                placeholder="Jelaskan secara detail tentang laporan Anda (minimal 10 karakter)" required><?= set_value('deskripsi'); ?></textarea>
                            <small class="text-muted">Minimal 10 karakter. Jelaskan dengan detail agar tim dapat menindaklanjuti dengan baik.</small>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-send me-2"></i>
                                    Kirim Laporan
                                </span>
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="<?= site_url() ?>" class="btn btn-link">
                            <i class="bx bx-arrow-back me-1"></i>
                            Kembali ke Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#formTicketing').validate({
            rules: {
                nama_pelapor: {
                    required: true,
                    minlength: 3
                },
                jenis_laporan: {
                    required: true
                },
                deskripsi: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                nama_pelapor: {
                    required: "Nama pelapor tidak boleh kosong",
                    minlength: "Nama pelapor minimal 3 karakter"
                },
                jenis_laporan: {
                    required: "Jenis laporan harus dipilih"
                },
                deskripsi: {
                    required: "Deskripsi tidak boleh kosong",
                    minlength: "Deskripsi minimal 10 karakter"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

