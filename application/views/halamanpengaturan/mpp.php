<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Data Petugas Mall
            Pelayanan Publik (MPP)</h4>

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
                            <a class="nav-link" href="<?= site_url('plh'); ?>" data-loader><i class="bx bx-bell me-1"></i>
                                Pengaturan Plh</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('app'); ?>" data-loader><i class="bx bx-wrench me-1"></i>
                                Pengaturan Aplikasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"><i class="bx bx-bell me-1"></i>
                                Pengaturan MPP</a>
                        </li>

                        <?php
                    }
                    ?>
                </ul>

                <div class="card mb-4">
                    <h5 class="card-header">Data Petugas MPP MS Banda Aceh</h5>
                    <div class="card-body">
                        <div class="card-title d-flex align-items-right">
                            <button type="button" class="btn btn-primary"
                                onclick="BukaModalMPP('<?php echo base64_encode($this->encryption->encrypt(-1)); ?>')"><i
                                    class="bx bx-plus me-1"></i>Tambah
                                Data</button>
                        </div>
                        <table id="tabelPetugasMPP" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NAMA PEGAWAI</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($mpp_data as $item) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td>
                                            <?= $item['nama']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($item['status'] == '0')
                                                echo 'Tidak Aktif';
                                            else
                                                echo 'Aktif';
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item"
                                                        onclick="BukaModalMPP('<?= base64_encode($this->encryption->encrypt($item['id'])) ?>')"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit Petugas</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>NAMA PEGAWAI</th>
                                    <th>STATUS</th>
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

    <!-- Modal Tambah/Edit Plh -->
    <div class="modal fade" id="mppModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="formPegawaiMPP" action="<?= site_url('simpan_mpp') ?>" class="modal-content"
                onsubmit="return showLoaderSweetalert2(this)">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul_"></h5>
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
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="status" class="form-label">STATUS PETUGAS</label><code> *</code>
                            <div id="status_"></div>
                        </div>
                    </div>

                    <label for="emailBackdrop" class="form-label"><code><i>* Wajib Diisi</i></code></label>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
</div>