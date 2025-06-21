<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <h4 class="fw-bold py-3 mb-4">Register Daftar Pegawai</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Bootstrap Table with Header - Footer -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <h4 class="card-title">

                            </h4>
                            <div class="dropdown">
                                <button class="btn btn-primary p-3" type="button" id="cardOpt3"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-bookmark-plus"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a id="tambah" class="dropdown-item" href="javascript:void(0);"
                                        data-bs-toggle="modal" data-bs-target="#tambahModal"
                                        onclick="BukaModal('<?php echo base64_encode($this->encryption->encrypt(-1)); ?>')">Tambah
                                        Pegawai</a>
                                    <a class="dropdown-item" href="<?= site_url('daftar_jabatan') ?>">Daftar Jabatan</a>
                                    <a class="dropdown-item" href="<?= site_url('daftar_pangkat') ?>">Daftar Pangkat</a>
                                </div>
                            </div>
                        </div>
                        <table id="tabel_pegawai" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>NAMA</th>
                                    <th>GOLONGAN/PANGKAT</th>
                                    <th>JABATAN</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pegawai as $item) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no ?>
                                        </td>
                                        <td>
                                            <?= $item->nip; ?>
                                        </td>
                                        <td>
                                            <?= $item->nama; ?>
                                        </td>
                                        <td>
                                            <?= $item->golongan; ?> |
                                            <?= $item->pangkat; ?>
                                        </td>
                                        <td>
                                            <?= $item->nama_jabatan; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($item->status_pegawai == "1") {
                                                ?> <span class="badge bg-label-success me-1">Aktif</span>
                                                <?php
                                            } else {
                                                ?> <span class="badge bg-label-warning me-1">Non Aktif</span>
                                                <?php
                                            }
                                            ?>
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
                                                        onclick="BukaModal('<?= base64_encode($this->encryption->encrypt($item->id)) ?>')"
                                                        data-bs-toggle="modal"><i class="bx bx-edit-alt me-1"></i>
                                                        EDIT</button>
                                                    <a class="dropdown-item" id="hapus" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal" data-id="<?= $idEncrypt; ?>"><i
                                                            class="bx bx-trash me-1"></i>
                                                        HAPUS</a>
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
                                    <th>NIP</th>
                                    <th>NAMA</th>
                                    <th>GOLONGAN/PANGKAT</th>
                                    <th>JABATAN</th>
                                    <th>STATUS</th>
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

<!-- Modal Tambah/Edit Pegawai -->
<div class="modal fade" id="tambahModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="formPegawai" action="<?= site_url('simpan_pegawai') ?>" class="modal-content"
            enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="judul"></h5>
                <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <input hidden type="text" name="id" id="id" class="form-control" />
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" placeholder="Masukkan NIP"
                                autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="jabatan" class="form-label">JABATAN</label><code> *</code>
                            <div id="jabatan_"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="nama_gelar" class="form-label">NAMA (DENGAN GELAR)</label><code> *</code>
                            <input type="text" id="nama_gelar" class="form-control" placeholder="Nama Dengan Gelar"
                                name="nama_gelar" value="<?php echo set_value('nama_gelar'); ?>" autocomplete="off" />
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="alamat" class="form-label">ALAMAT</label>
                            <input type="text" id="alamat" class="form-control" placeholder="Alamat" name="alamat"
                                autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="nama" class="form-label">NAMA (TANPA GELAR)</label><code> *</code>
                            <input type="text" id="nama" class="form-control" placeholder="Nama Tanpa Gelar" name="nama"
                                autocomplete="off" />
                        </div>

                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="ket" class="form-label">KETERANGAN</label>
                            <input type="text" id="ket" class="form-control" name="ket" placeholder="Keterangan"
                                autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="pangkat" class="form-label">PANGKAT | GOLONGAN</label><code> *</code>
                            <div id="pangkat_"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="nohp" class="form-label">NOMOR HANDPHONE</label><code> *</code>
                            <input type="text" id="nohp" class="form-control" name="nohp" placeholder="Nomor Handphone"
                                autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="aktif" class="form-label">STATUS PEGAWAI</label><code> *</code>
                            <div id="aktif_"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="jenis" class="form-label">JENIS PEGAWAI</label><code> *</code>
                            <div id="jenis_"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="tmt" class="form-label">TMT PEGAWAI</label>
                            <input type="date" placeholder="Terhitung Mulai Tanggal Pegawai" class="form-control"
                                id="tmt" name="tmt">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="jenis" class="form-label">JENIS KELAMIN</label>
                            <div id="jk_"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="foto" class="form-label">FOTO</label>
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img alt="user-avatar" class="d-block rounded" height="180" width="120"
                                    id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="foto" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Pilih Foto</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                    </label>

                                    <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                </div>
                            </div>
                            <input hidden type="file" id="foto" name="foto" class="account-file-input"
                                accept="image/png" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="ttd" class="form-label">TANDA TANGAN</label>
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img alt="user-avatar" class="d-block rounded" height="180" width="120"
                                    id="uploadedSignature" />
                                <div class="button-wrapper">
                                    <label for="ttd" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Pilih Tanda Tangan</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                    </label>

                                    <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                </div>
                            </div>
                            <input hidden type="file" id="ttd" name="ttd" class="account-file-input"
                                accept="image/png" />
                        </div>
                    </div>
                </div>
                <label class="form-label"><code><i>* Wajib Diisi</i></code></label>
            </div>

            <div class="modal-footer">
                <button type="submit" id="simpanPegawai" class="btn btn-primary">SIMPAN</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Pegawai -->
<div class="modal fade" id="hapusModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formPegawai" class="modal-content">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">HAPUS DATA PEGAWAI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <blockquote class="blockquote mt-3">
                    <p>Apakah anda yakin akan menghapus data ini?</p>
                </blockquote>
            </div>

            <div class="modal-footer">
                <a id="hapusPegawai" class="btn btn-danger" role="button"><span class="badge bg-danger">Hapus</span></a>
            </div>
        </form>
    </div>
</div>