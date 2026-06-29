<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Kalender Peminjaman</h1>
    <div class="bg-white rounded-xl border border-base-200 p-4">
        <div id="calendar"></div>
    </div>
</div>

<link href="<?= base_url('assets/css/vendor/fullcalendar.min.css') ?>" rel="stylesheet">
<script src="<?= base_url('assets/js/fullcalendar.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,listWeek' },
        events: '<?= base_url('kalender/events') ?>',
        height: 'auto',
        buttonText: { today: 'Hari Ini', month: 'Bulan', week: 'Minggu', list: 'Daftar' },
        noEventsContent: 'Tidak ada peminjaman',
    });
    calendar.render();
});
</script>
<?= $this->endSection() ?>
