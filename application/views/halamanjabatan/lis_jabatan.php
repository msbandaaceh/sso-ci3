<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-10">
                <h4 class="fw-bold py-3 mb-4">Register Jabatan</h4>
            </div>
            <div class="col-md-2" style="display: grid; place-items: end;">
                <button id="tambah"
                    onclick="ModalJabatan('<?php echo base64_encode($this->encryption->encrypt(-1)); ?>')"
                    class="btn btn-primary py-3 mb-4" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    Tambah Data
                </button>
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Bootstrap Table with Header - Footer -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabel_jabatan" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NAMA JABATAN</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($jabatan as $item) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no ?>
                                        </td>
                                        <td>
                                            <?= $item->nama_jabatan; ?>
                                        </td>
                                        <td>
                                            <?php $idEncrypt = str_replace('/', '___', $this->encryption->encrypt($item->id)); ?>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-target="#tambahModal"
                                                        onclick="ModalJabatan('<?= base64_encode($this->encryption->encrypt($item->id)) ?>')"
                                                        data-bs-toggle="modal"><i class="bx bx-edit-alt me-1"></i>
                                                        Edit</button>
                                                    <a class="dropdown-item" id="hapus" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal" data-id="<?= $idEncrypt; ?>"><i
                                                            class="bx bx-trash me-1"></i>
                                                        Hapus</a>
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
                                    <th>NAMA JABATAN</th>
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

<!-- Modal Tambah/Edit Jabatan -->
<div class="modal fade" id="tambahModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="formPegawai" action="<?= site_url('simpan_jabatan') ?>" class="modal-content">
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
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label><code> *</code>
                        <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control"
                            placeholder="Masukkan Nama Jabatan" autocomplete="off" />
                    </div>
                </div>
                <span class="form-label"><code><i>* Wajib Diisi</i></code></label>
            </div>

            <div class="modal-footer">
                <button type="submit" id="simpanPegawai" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Jabatan -->
<div class="modal fade" id="hapusModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formJabatan" class="modal-content">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">HAPUS DATA JABATAN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <blockquote class="blockquote mt-3">
                    <p>Apakah anda yakin akan menghapus data ini?</p>
                </blockquote>
            </div>

            <div class="modal-footer">
                <a id="hapusJabatan" class="btn btn-danger" role="button"><span class="badge bg-danger">Hapus</span></a>
            </div>
        </form>
    </div>
</div>