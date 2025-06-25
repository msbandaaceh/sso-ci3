<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Data Pejabat Pelaksana
            Harian (Plh)</h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <?php
                    echo $plh;
                    echo $plt;
                    if ($userid != '1') {
                        if ($plh != '1') {
                            if ($plt != '1') {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url('profil'); ?>" data-loader><i
                                            class="bx bx-user me-1"></i>
                                        Data Pegawai</a>
                                </li>
                            <?php }
                        }
                    }

                    if ($plh != '1') {
                        if ($plt != '1') {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('user'); ?>" data-loader><i class="bx bx-bell me-1"></i>
                                    Data User</a>
                            </li>
                        <?php
                        }
                    }

                    if (in_array($role, ['super', 'admin_satker', 'validator_kepeg_satker'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link active"><i class="bx bx-bell me-1"></i>
                                Pengaturan Plh</a>
                        </li>
                        <?php
                    }

                    if (in_array($role, ['super', 'admin_satker', 'validator_kepeg_satker'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('app'); ?>" data-loader><i class="bx bx-wrench me-1"></i>
                                Pengaturan Aplikasi</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>

                <div class="card mb-4">
                    <h5 class="card-header">Data Pelaksana Harian (Plh) Pejabat MS Banda Aceh</h5>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NAMA JABATAN PLH</th>
                                    <th>NAMA PEGAWAI</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $plh_no = 1;
                                foreach ($plh_data as $item) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $plh_no ?>
                                        </td>
                                        <td>
                                            <?= $item->nama; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($item->pegawai_id) {
                                                echo '<span class="badge rounded-pill bg-primary">' . $item->nama_pegawai . '</span>';
                                            } else {
                                                echo '<span class="badge rounded-pill bg-secondary">Belum Ada Plh</span>';
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
                                                    <button class="dropdown-item"
                                                        onclick="BukaModalPlh('<?= base64_encode($this->encryption->encrypt($item->id)) ?>')"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit Plh</button>
                                                    <a class="dropdown-item" id="hapus" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#hapusPPlh" data-id="<?= $idEncrypt; ?>"
                                                        data-loader><i class="bx bx-trash me-1"></i> Hapus Plh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $plh_no++;
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>NAMA JABATAN PLH</th>
                                    <th>NAMA PEGAWAI</th>
                                    <th>AKSI</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->

    <!-- Modal Hapus Pejabat Plh -->
    <div class="modal fade" id="hapusPPlh" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" id="formPengguna" class="modal-content" onsubmit="return showLoaderSweetalert2(this)">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">HAPUS DATA PLH</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="dropdown-divider"></div>
                <div class="modal-body">
                    <blockquote class="blockquote mt-3">
                        <p>Apakah anda yakin akan menghapus data Plh?</p>
                    </blockquote>
                </div>

                <div class="modal-footer">
                    <a id="hapusPlh" class="btn btn-danger" role="button"><span class="badge bg-danger">Hapus</span></a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah/Edit Plh -->
    <div class="modal fade" id="tambahModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="formPegawai" action="<?= site_url('simpan_plh') ?>" class="modal-content"
                onsubmit="return showLoaderSweetalert2(this)">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="dropdown-divider"></div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" class="form-control" />
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="pegawai" class="form-label">PILIH PEGAWAI</label><code> *</code>
                            <div id="pegawai_"></div>
                        </div>
                    </div>

                    <label for="emailBackdrop" class="form-label"><code><i>* Wajib Diisi</i></code></label>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="simpanPegawai" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
</div>