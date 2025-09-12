<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Pegawai</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            padding: 20px;
            background-image: url('dokumen/foto/bg-account.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .profile-card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #007bff;
            margin-bottom: 20px;
        }

        .profile-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .profile-nip,
        .profile-jabatan {
            font-size: 16px;
            margin-top: 6px;
            color: #555;
        }

        .badge {
            display: inline-block;
            background: #007bff;
            color: white;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            margin-top: 12px;
        }
    </style>
</head>

<body>
    <div class="profile-card">
        <?php if ($foto) {
            ?>
            <img src="<?= base_url($foto) ?>" alt="Foto Pegawai" />
            <?php
        } else {
            ?>
            <img src="<?= site_url('assets/sneat/img/avatars/1.png') ?>" alt="Foto Pegawai" />
        <?php } ?>
        <div class="profile-name"><?= $nama ?></div>
        <div class="profile-nip">NIP: <?= $nip ?></div>
        <div class="profile-jabatan"><?= $jabatan ?></div>
        <div class="badge">Profil Pegawai</div>
    </div>
</body>

</html>