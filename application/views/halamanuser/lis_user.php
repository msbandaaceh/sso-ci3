<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <h4 class="fw-bold py-3 mb-4">Register Daftar User</h4>
            </div>
            <div class="col-md-4">
                <div style="display: grid; place-items: end;">
                    <button type="button" class="btn btn-primary py-3 mb-4"
                        onclick="BukaModal('<?php echo base64_encode($this->encryption->encrypt(-1)); ?>')"
                        data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah
                        Data</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Bootstrap Table with Header - Footer -->
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabel_user" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NAMA</th>
                                    <th>USERNAME</th>
                                    <th>EMAIL</th>
                                    <th>BLOKIR</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($user as $item) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no ?>
                                        </td>
                                        <td>
                                            <?= $item->fullname; ?>
                                        </td>
                                        <td>
                                            <?= $item->username; ?>
                                        </td>
                                        <td>
                                            <?= $item->email; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($item->block == "0") {
                                                ?> <span class="badge bg-label-success me-1">Tidak</span>
                                                <?php
                                            } else {
                                                ?> <span class="badge bg-label-warning me-1">Ya</span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php $idEncrypt = str_replace('/', '___', $this->encryption->encrypt($item->userid)); ?>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-target="#tambahModal"
                                                        data-bs-toggle="modal"
                                                        onclick="BukaModal('<?= base64_encode($this->encryption->encrypt($item->userid)) ?>')"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</button>
                                                    <a class="dropdown-item" id="hapus" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal" data-id="<?= $idEncrypt; ?>"><i
                                                            class="bx bx-trash me-1"></i> Hapus</a>
                                                    <a class="dropdown-item" id="reset" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#resetModal" data-id="<?= $idEncrypt; ?>"><i
                                                            class="bx bx-trash me-1"></i> Reset Perangkat Presensi</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>NAMA</th>
                                    <th>USERNAME</th>
                                    <th>EMAIL</th>
                                    <th>BLOKIR</th>
                                    <th>AKSI</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- Bootstrap Table with Header - Footer -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit User -->
<div class="modal fade" id="tambahModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="formUser" action="<?= site_url('simpan_user') ?>" class="modal-content">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="judul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <input hidden type="text" name="id" id="id" class="form-control" />
                <div class="row g-2">
                    <div class="col mb-3">
                        <div class="form-group">
                            <label for="pegawai" class="form-label">PEGAWAI</label><code> *</code>
                            <div id="pegawai_"><select id='pegawai'></select></div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">USERNAME</label>
                            <input type="text" id="username" autocomplete="off" class="form-control"
                                placeholder="Username" name="username" readonly />
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">PASSWORD</label><code> *</code>
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" autocomplete="off" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="passKonfirm" class="form-label">KONFIRMASI PASSWORD</label><code> *</code>
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <input type="password" id="passKonfirm" class="form-control" name="passKonfirm"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" autocomplete="off" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="form-group">
                            <label for="atasan" class="form-label">ATASAN LANGSUNG</label>
                            <div id="atasan_"></div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">E-MAIL</label><code> *</code>
                            <input type="email" id="email" class="form-control" autocomplete="off"
                                placeholder="Alamat E-Mail" name="email" />
                        </div>
                        <div class="form-group">
                            <label for="blok" class="form-label">BLOKIR PENGGUNA</label><code> *</code>
                            <div id="blok_"></div>
                        </div>
                    </div>
                </div>

                <h4 class="form-label"><code><i>* Wajib Diisi</i></code></h4>
            </div>

            <div class="modal-footer">
                <button type="submit" id="simpanPegawai" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Pegawai -->
<div class="modal fade" id="hapusModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formPengguna" class="modal-content">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">HAPUS DATA PENGGUNA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <blockquote class="blockquote mt-3">
                    <p>Apakah anda yakin akan menghapus data ini?</p>
                </blockquote>
            </div>

            <div class="modal-footer">
                <a id="hapusPengguna" class="btn btn-danger" role="button"><span
                        class="badge bg-danger">Hapus</span></a>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reset Perangkat User -->
<div class="modal fade" id="resetModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formReset" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">RESET DATA PERANGKAT PENGGUNA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <blockquote class="blockquote mt-3">
                    <p>Apakah anda yakin akan mereset data perangkat user ini?</p>
                </blockquote>
            </div>

            <div class="modal-footer">
                <a id="resetPengguna" class="btn btn-danger" role="button"><span
                        class="badge bg-danger">Reset</span></a>
            </div>
        </form>
    </div>
</div>