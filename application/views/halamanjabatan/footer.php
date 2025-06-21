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
  $(function () {
    $("#tabel_jabatan").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tabel_jabatan_wrapper .col-md-6:eq(0)');
  });

  $(document).on("click", "#hapus", function () {
    var id = $(this).data('id');
    $('#hapusJabatan').attr('href', 'hapus_jabatan/' + id);
  });
</script>

<script type="text/javascript">
  function ModalJabatan(id) {
    $.post('show_jabatan', {
      id: id
    }, function (response) {
      var json = jQuery.parseJSON(response);
      if (json.st == 1) {
        $("#judul").html("");
        $("#id").val('');
        $("#nama_jabatan").val('');
        $("#judul").append(json.judul);
        $("#id").val(json.id);
        $("#nama_jabatan").val(json.nama_jabatan);
      } else if (json.st == 0) {
        pesan('PERINGATAN', json.msg, '');
        $('#table_pegawai').DataTable().ajax.reload();
      }
    });
  }

</script>

<!-- Page JS -->
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