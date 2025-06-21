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
    });
}