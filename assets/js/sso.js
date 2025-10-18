function infoPlh() {
    Swal.fire({
        title: "Ada Pegawai Yang Ditunjuk Sebagai Plh/Plt Jabatan Anda",
        html: "Apakah Anda Akan Menghapus Status Plh/Plt dari Pegawai Tersebut?",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#8EC165",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Tidak!"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Mohon Tunggu...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.post('hapus_plh_js', function (response) {
                var json = jQuery.parseJSON(response);
                if (json.st == 1) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Anda sudah menghapus status Plh/Plt Pegawai dari Jabatan Anda",
                        icon: "success",
                        confirmButtonColor: "#8EC165",
                        confirmButtonText: "Oke"
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "info",
                        title: "Perhatian!",
                        text: "Anda Gagal menghapus status Plh/Plt Jabatan Anda, Silakan Ulangi Lagi. Anda akan dikembalikan ke halaman Login setelah beberapa Detik",
                        timer: 10000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "keluar";
                    });
                }
            });
        } else {
            Swal.fire({
                icon: "info",
                title: "Perhatian!",
                text: "Anda Tidak menghapus status Plh/Plt Jabatan Anda, Silakan Ulangi Lagi. Anda akan dikembalikan ke halaman Login setelah beberapa Detik",
                timer: 10000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "keluar";
            });
        }
    });
}

function sukses(pesan) {
    Swal.fire({
        title: "Berhasil",
        text: pesan,
        icon: "success"
    });
}

function warning(pesan) {
    Swal.fire({
        title: "Perhatian",
        text: pesan,
        icon: "warning"
    });
}

function gagal(pesan) {
    Swal.fire({
        title: "Error",
        text: pesan,
        icon: "error"
    });
}

function BukaModalPlh(id) {
    $.post('edit_plh', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#judul").html("");
            $("#id").val('');
            $("#pegawai_").html('');

            $("#judul").append(json.judul);
            $("#id").val(json.id);
            $("#pegawai_").append(json.pegawai);
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }

        $("#plhModal").modal('show');

        $("#pegawai").select2({
            width: '100%',
            dropdownParent: $('#formPegawaiPlh'),
        });
    });
}

function BukaModalMPP(id) {
    $.post('edit_mpp', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $("#judul_").html("");
            $("#id").val('');
            $("#pegawai_").html('');
            $("#status_").html('');

            $("#judul_").append(json.judul);
            $("#id").val(json.id);
            $("#pegawai_").append(json.pegawai);
            
            $("#status_").append(json.status);
        } else if (json.st == 0) {
            pesan('PERINGATAN', json.msg, '');
            $('#table_pegawai').DataTable().ajax.reload();
        }

        $("#mppModal").modal('show');

        $("#pegawai").select2({
            width: '100%',
            dropdownParent: $('#mppModal')
        });
    });
}

function showLoaderSweetalert2(form) {
    const isInsideModal = $(form).closest('#plhModal').length > 0;

    // Jika form ini berasal dari modal, tutup modal terlebih dahulu
    if (isInsideModal) {
        $('#plhModal').modal('hide');
    }

    Swal.fire({
        title: 'Memproses...',
        html: 'Mohon tunggu, sedang proses.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Tunggu sebentar agar loader terlihat (opsional)
    setTimeout(() => {
        form.submit(); // submit manual
    }, 800); // bisa kamu ubah, misalnya 500ms

    return false; // cegah submit langsung
}

$(document).on('click', 'a[data-loader]', function (e) {
    e.preventDefault(); // cegah pindah langsung

    const href = $(this).attr('href');

    Swal.fire({
        title: 'Mohon Tunggu...',
        html: 'Sedang memuat halaman.',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    setTimeout(() => {
        window.location.href = href;
    }, 500);
});