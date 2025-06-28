
# Sistem SSO (Single Sign-On) MS Banda Aceh

Sebuah server untuk manajemen shared login dan shared session antara beberapa aplikasi MS Banda Aceh, sehingga pegawai tidak perlu login berkali-kali untuk menggunakan aplikasi yang berbeda.


## Digunakan oleh

Proyek ini digunakan oleh:

- Mahkamah Syar'iyah Banda Aceh


## Fitur

- Shared cookie dan session dengan JWT
- CRUD dengan API
- Sistem Penunjukan Plh atau Plt
- Pengamanan CAPTCHA
- Terintegrasi dengan aplikasi Whatsapp Gateway untuk notifikasi


## Instalasi

Duplikasi proyek

```bash
  git clone https://github.com/msbandaaceh/sso-ci3.git
```

Masuk ke folder proyek

```bash
  cd sso-ci3
```

Install dependencies

```bash
  composer require firebase/php-jwt
```

Jalankan aplikasi melalui localhost/VPS/Shared Hosting

```bash
  localhost/sso-ci3
```    
## Environment Variables

Untuk menjalankan program ini, anda diharuskan mengisi beberapa variabel berikut di folder application/config

`config.php`
```bash
  $config['captcha'] //ambil dari API Key dari Google Captcha
  $config['encryption_key'] //buat key sendiri
  $config['sess_cookie_name'] //nama bebas

  $config['cookie_domain'] //sesuaikan dengan domain aplikasi di hosting

  //buat API key sendiri
  //API akan digunakan di aplikasi yang akan menggunakan session yang sama
  $config['jwt_key']
  $config['jwt_issuer'] //isi dengan domain aplikasi SSO
```

`database.php`
```bash
  //Sesuaikan dengan database SSO
  'hostname' => 'localhost',
  'username' => 'root',
  'password' => '',
  'database' => '',
```

