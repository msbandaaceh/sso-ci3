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
  $(document).ready(function () {
    $.validator.addMethod("valueNotEquals", function (value, element, arg) {
      return arg !== value;
    }, "Value must not equal arg.");
  });

  $(function () {
    $("#tabel_user").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tabel_user_wrapper .col-md-6:eq(0)');

    $("#btn-close").click(function () {
      var form = $('#formUser');

      // Reset field validation (hapus .is-invalid & error <span>)
      form.validate().resetForm();
    });

    $('#formUser').validate({
      rules: {
        password: {
          required: true,
        },
        email: {
          required: true,
          email: true
        },
        passKonfirm: {
          equalTo: "#password"
        },
        pegawai: {
          valueNotEquals: "0"
        },
        blok: {
          valueNotEquals: "2"
        }
      },
      messages: {
        password: {
          required: "Password Harus Diisi"
        },
        email: {
          required: "Email harus diisi",
          email: "Masukkan Email yang valid"
        },
        passKonfirm: {
          equalTo: "Password Tidak Sesuai"
        },
        pegawai: {
          valueNotEquals: "Pegawai harus dipilih"
        },
        blok: {
          valueNotEquals: "Status blokir harus dipilih"
        }
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
    $('#hapusPengguna').attr('href', 'hapus_user/' + id);
  })

  $(document).on("click", "#reset", function () {
    var id = $(this).data('id');
    $('#resetPengguna').attr('href', 'reset_perangkat/' + id);
  })

  //Merubah Username Pegawai dengan NIP ketika memilih pegawai
  function TampilUsername() {
    var id_pegawai = $('#pegawai').val();
    $.post('get_nip', {
      id: id_pegawai
    }, function (response) {
      var json = jQuery.parseJSON(response);
      if (json.st == 1) {
        if (json.nip != "") {
          $("#username").val(json.nip);
        } else {
          $("#username").removeAttr('readonly');
        }
      } else if (json.st == 0) {
        pesan('PERINGATAN', json.msg, '');
        $('#table_suratkeluar').DataTable().ajax.reload();
      }
    });
  }
</script>

<script type="text/javascript">
  function BukaModal(id) {
    $.post('show_user', {
      id: id
    }, function (response) {
      var json = jQuery.parseJSON(response);
      if (json.st == 1) {
        $("#judul").html("");
        $("#id").val('');
        $("#pegawai_").html('');
        $("#username").val('');
        $('#password').val('');
        $('#passKonfirm').val('');
        $("#email").val('');
        $("#blok_").html("");
        $("#atasan_").html("");

        $("#judul").append(json.judul);
        $("#id").val(json.id);
        $("#pegawai_").append(json.pegawai);
        $("#username").val(json.username);
        $('#password').val(json.password);
        $('#passKonfirm').val(json.password);
        $("#email").val(json.email);
        $("#blok_").append(json.blok);
        $("#atasan_").append(json.atasan);
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
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>