<script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
<script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
<script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
<script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

<script src="<?= site_url('assets/js/menu.js'); ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<!-- jquery-validation -->
<script src="<?= site_url('assets/libs/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/jquery-validation/additional-methods.min.js') ?>"></script>

<!-- DataTables  & Plugins -->
<script src="<?= site_url('assets/libs/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>

<script>
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

  document.getElementById('ttd').addEventListener('change', function () {
    previewImage(this, 'uploadedSignature'); // Menampilkan preview pada gambar pegawai
  });
</script>

<script>
  $(function () {
    $("#tabel_pegawai").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tabel_pegawai_wrapper .col-md-6:eq(0)');

    $("#btn-close").click(function () {
      var form = $('#formPegawai');

      // Reset field validation (hapus .is-invalid & error <span>)
      form.validate().resetForm();
    });
  });

  $(document).on("click", "#hapus", function () {
    var id = $(this).data('id');
    $('#hapusPegawai').attr('href', '<?= base_url() ?>hapus_pegawai/' + id);
  })

  $(document).ready(function () {
    $.validator.addMethod("valueNotEquals", function (value, element, arg) {
      return arg !== value;
    }, "Value must not equal arg.");

    $('#formPegawai').validate({
      rules: {
        passKon: {
          equalTo: "#pass",
          required: true
        },
        nama_gelar: {
          required: true,
          maxlength: 60
        },
        nama: {
          required: true,
          maxlength: 40
        },
        jabatan: {
          valueNotEquals: "0",
          remote: {
            url: '<?= site_url() ?>cek_jabatan',
            type: 'post',
            data: {
              jabatan: function () {
                return $('#jabatan').val();
              }
            }
          }
        },
        jenis: {
          valueNotEquals: "0"
        },
        pangkat: {
          valueNotEquals: "0"
        },
        nohp: {
          required: true,
          maxlength: 14,
          remote: {
            url: '<?= site_url() ?>cek_nohp',
            type: 'post',
            data: {
              nohp: function () {
                return $('#nohp').val();
              }
            }
          }
        },
        stat: {
          valueNotEquals: "2"
        }
      },
      messages: {
        nama_gelar: {
          required: "Nama (Dengan Gelar) tidak boleh kosong",
          maxlength: "Nama Gelar tidak boleh melebihi 60 karakter"
        },
        nama: {
          required: "Nama tidak boleh kosong",
          maxlength: "Nama Tanpa Gelar tidak boleh melebihi 40 karakter"
        },
        jabatan: {
          valueNotEquals: "Jabatan harus dipilih",
          remote: "Ada pegawai aktif yang menduduki jabatan yang anda pilih, silakan hubungi bagian kepegawaian"
        },
        jenis: {
          valueNotEquals: "Jenis Pegawai harus dipilih"
        },
        pangkat: {
          valueNotEquals: "Pangkat Golongan harus dipilih"
        },
        nohp: {
          required: "Nomor Handphone tidak boleh kosong",
          maxlength: "Nomor Handphone tidak boleh melebihi 14 karakter",
          remote: "Nomor Handphone sudah dipakai"
        },
        stat: {
          valueNotEquals: "Status keaktifan harus dipilih"
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

</script>

<script type="text/javascript">
  function BukaModal(id) {
    $.post('show_pegawai', {
      id: id
    }, function (response) {
      var json = jQuery.parseJSON(response);
      if (json.st == 1) {
        $("#judul").html("");
        $("#nip").val('');
        $("#nama_gelar").val('');
        $("#nama").val('');
        $("#alamat").val('');
        $("#id").val('');
        $("#ket").val('');
        $("#aktif_").html("");
        $("#jenis_").html("");
        $("#jabatan_").html("");
        $("#nohp").val('');
        $("#pangkat_").html("");
        $("#tmt").val('');
        $("#jk_").html('');
        $("#judul").append(json.judul);
        $("#nip").val(json.nip);
        $("#nama_gelar").val(json.nama_gelar);
        $("#nama").val(json.nama);
        $("#alamat").val(json.alamat);
        $("#ket").val(json.ket);
        $("#id").val(json.id);
        $("#nohp").val(json.nohp);
        $("#tmt").val(json.tmt);
        $("#aktif_").append(json.aktif);
        $("#jenis_").append(json.jenis);
        $("#jabatan_").append(json.jabatan);
        $("#pangkat_").append(json.pangkat);
        $("#jk_").append(json.jk);

        const preview = document.getElementById('uploadedAvatar');
        if (json.foto) {
          preview.src = '<?= site_url() ?>' + json.foto;
        } else {
          preview.src = '<?= site_url('assets/img/1.png') ?>';
        }

        const preview_ttd = document.getElementById('uploadedSignature');
        if (json.ttd) {
          preview_ttd.src = '<?= site_url() ?>' + json.ttd;
        } else {
          preview_ttd.src = '<?= site_url('assets/img/1.png') ?>';
        }
      } else if (json.st == 0) {
        pesan('PERINGATAN', json.msg, '');
        $('#table_pegawai').DataTable().ajax.reload();
      }
    });
  }
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

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>