<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-10">
                <h4 class="fw-bold py-3 mb-4">Kalender Cuti dan Izin Keluar Pegawai</h4>
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12">

                <!-- Bootstrap Table with Header - Footer -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-header">
                        <h6 class="mb-0">Legenda</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="badge" style="background-color: #28a745; padding: 8px 15px;">Cuti
                                    Tahunan</span>
                                <span class="badge" style="background-color: #dc3545; padding: 8px 15px;">Cuti
                                    Sakit</span>
                                <span class="badge" style="background-color: #ffc107; padding: 8px 15px;">Cuti
                                    Melahirkan</span>
                                <span class="badge" style="background-color: #17a2b8; padding: 8px 15px;">Cuti
                                    Besar</span>
                                <span class="badge" style="background-color: #6f42c1; padding: 8px 15px;">Cuti Alasan
                                    Penting</span>
                                <span class="badge" style="background-color: #6c757d; padding: 8px 15px;">Cuti di Luar
                                    Tanggungan Negara</span>
                                <span class="badge" style="background-color: #fd7e14; padding: 8px 15px;">Izin
                                    Keluar</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- Bootstrap Table with Header - Footer -->
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="kalenderCuti"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="<?= site_url('assets/plugins/fullcalendar/css/main.css') ?>" rel="stylesheet" />

<style>
    .fc-day-today {
        background-color: #fff3cd !important;
        border: 2px solid #ffc107 !important;
    }

    .fc-day-today .fc-daygrid-day-number {
        background-color: #ffc107;
        color: #000;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 3px;
        position: relative;
    }

    .fc-day-today .fc-daygrid-day-number::after {
        content: " (Hari Ini)";
        font-size: 0.75em;
        font-weight: normal;
    }

    .fc-daygrid-bg-tr .fc-daygrid-day-frame,
    .fc-daygrid-day-bg {
        cursor: default;
    }

    .fc-daygrid-day-events {
        min-height: 0;
    }

    .fc-daygrid-bg-event {
        cursor: default !important;
    }

    .fc-daygrid-bg-event:hover {
        cursor: default !important;
    }

    /* Weekend styling */
    #kalenderCuti .fc-daygrid-day.fc-day-sat .fc-daygrid-day-number,
    #kalenderCuti .fc-daygrid-day.fc-day-sun .fc-daygrid-day-number {
        color: #dc3545 !important;
        font-weight: bold !important;
    }

    #kalenderCuti .fc-daygrid-day.fc-day-sat,
    #kalenderCuti .fc-daygrid-day.fc-day-sun {
        background-color: #fff0f0 !important;
    }
</style>

<script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
<script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
<script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
<script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

<script src="<?= site_url('assets/js/menu.js'); ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
 <script src="<?= site_url('assets/plugins/fullcalendar/js/main.js') ?>"></script>
<script src="<?= site_url('assets/libs/sweetalert2/js/sweetalert2.min.js') ?>"></script>

<!-- jquery-validation -->
<script src="<?= site_url('assets/libs/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/jquery-validation/additional-methods.min.js') ?>"></script>

<script>

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

    $(document).ready(function () {
        var calendarEl = document.getElementById('kalenderCuti');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            firstDay: 1,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: function (fetchInfo, successCallback, failureCallback) {
                console.log(fetchInfo);
                $.ajax({
                    url: 'get_cuti_kalender',
                    method: 'GET',
                    data: {
                        start: fetchInfo.startStr,
                        end: fetchInfo.endStr
                    },
                    success: function (response) {
                        var events = JSON.parse(response);
                        console.log(events);
                        successCallback(events);
                    },
                    error: function () {
                        failureCallback();
                    }
                });
            },
            eventClick: function (info) {
                var event = info.event;
                var extendedProps = event.extendedProps;
                var title;
                if (extendedProps.tipe == 'izin_keluar') {
                    title = 'Detail Izin Keluar';
                } else if (extendedProps.tipe == 'cuti') {
                    title = 'Detail Cuti';
                } else {
                    title = 'Detail Hari Libur';
                }
                var htmlContent = '';

                if (extendedProps.tipe === 'izin_keluar') {
                    // Format untuk Izin Keluar
                    var tanggal = event.start.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    var jamMulai = event.start.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                    var jamAkhir = event.end.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });

                    htmlContent = `
                        <div class="text-start">
                            <p><strong>Nama:</strong> ${extendedProps.nama}</p>
                            <p><strong>Jenis:</strong> ${extendedProps.jenis}</p>
                            <p><strong>Tanggal:</strong> ${tanggal}</p>
                            <p><strong>Jam Mulai:</strong> ${jamMulai}</p>
                            <p><strong>Jam Akhir:</strong> ${jamAkhir}</p>
                            <p><strong>Alasan:</strong> ${extendedProps.alasan || '-'}</p>
                        </div>
                    `;
                } else if (extendedProps.tipe === 'cuti') {
                    // Format untuk Cuti
                    htmlContent = `
                        <div class="text-start">
                            <p><strong>Nama:</strong> ${extendedProps.nama}</p>
                            <p><strong>Jenis Cuti:</strong> ${extendedProps.jenis}</p>
                            <p><strong>Nomor Cuti:</strong> ${extendedProps.nomor_cuti || '-'}</p>
                            <p><strong>Tanggal Mulai:</strong> ${event.start.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                            <p><strong>Tanggal Selesai:</strong> ${new Date(event.end.getTime() - 86400000).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                            <p><strong>Alasan:</strong> ${extendedProps.alasan || '-'}</p>
                        </div>
                    `;
                } else {
                    // Format untuk Hari Libur
                    htmlContent = `
                        <div class="text-start">
                            <p><strong>Tanggal:</strong> ${event.start.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                            <p><strong>Keterangan:</strong> ${extendedProps.keterangan || '-'}</p>
                        </div>
                    `;
                }

                Swal.fire({
                    title: title,
                    html: htmlContent,
                    icon: 'info',
                    confirmButtonText: 'Tutup',
                    width: '600px'
                });
            },
            datesSet: function () {
                // Apply weekend classes after calendar renders
                setTimeout(function () {
                    var container = document.getElementById('kalenderCuti');
                    if (!container) return;
                    var days = container.querySelectorAll('.fc-daygrid-day[data-date]');
                    days.forEach(function (el) {
                        el.classList.remove('fc-day-sat', 'fc-day-sun');
                        var date = new Date(el.getAttribute('data-date'));
                        if (date.getDay() === 0) el.classList.add('fc-day-sun');
                        if (date.getDay() === 6) el.classList.add('fc-day-sat');
                    });
                }, 0);
            },
            eventDisplay: 'block',
            dayMaxEvents: 3,
            moreLinkClick: 'popover'
        });

        calendar.render();

        // Apply weekend classes on initial render
        setTimeout(function () {
            var container = document.getElementById('kalenderCuti');
            if (!container) return;
            var days = container.querySelectorAll('.fc-daygrid-day[data-date]');
            days.forEach(function (el) {
                el.classList.remove('fc-day-sat', 'fc-day-sun');
                var date = new Date(el.getAttribute('data-date'));
                if (date.getDay() === 0) el.classList.add('fc-day-sun');
                if (date.getDay() === 6) el.classList.add('fc-day-sat');
            });
        }, 0);
    });
</script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>