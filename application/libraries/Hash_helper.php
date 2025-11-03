<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Hash_helper - Modern Password Hashing Library
 * 
 * Library ini menyediakan fungsi untuk password hashing modern menggunakan
 * PHP password_hash() dan password_verify() dengan backward compatibility
 * untuk password MD5 yang sudah ada.
 */
class Hash_helper
{
    /**
     * Legacy MD5 hashing - DEPRECATED
     * Hanya untuk backward compatibility dengan user existing
     * JANGAN digunakan untuk password baru!
     * 
     * @deprecated Gunakan hash_password() untuk password baru
     * @param array $arrinput Array berisi code_activation dan password
     * @return string MD5 hash (32 karakter hex)
     */
    function arr2md5($arrinput)
    {
        $hasil = '';
        foreach ($arrinput as $val) {
            if ($hasil == '') {
                $hasil = md5($val);
            } else {
                $code = md5($val);
                for ($hit = 0; $hit < min(strlen($code), strlen($hasil)); $hit++) {
                    $hasil[$hit] = chr(ord($hasil[$hit]) ^ ord($code[$hit]));
                }
            }
        }
        return md5($hasil);
    }

    /**
     * Modern password hashing menggunakan PHP password_hash()
     * 
     * Algoritma yang digunakan:
     * - Argon2ID (PHP 7.2+) - Recommended untuk keamanan maksimal
     * - BCRYPT (PHP < 7.2) - Fallback jika Argon2ID tidak tersedia
     * 
     * @param string $password Password plain text
     * @return string Hashed password (siap untuk disimpan di database)
     */
    function hash_password($password)
    {
        // Cek apakah PHP mendukung Argon2ID (PHP 7.2+)
        if (defined('PASSWORD_ARGON2ID')) {
            // Argon2ID - Recommended (lebih aman dari BCRYPT)
            return password_hash($password, PASSWORD_ARGON2ID, [
                'memory_cost' => 65536,  // 64 MB memory
                'time_cost' => 4,        // 4 iterations
                'threads' => 3           // 3 threads
            ]);
        } else {
            // Fallback ke BCRYPT untuk PHP < 7.2
            // Cost factor 12 = 2^12 iterations = 4096 iterations
            return password_hash($password, PASSWORD_BCRYPT, [
                'cost' => 12
            ]);
        }
    }

    /**
     * Verify password menggunakan password_verify()
     * 
     * Fungsi ini support:
     * - Password modern (Argon2ID/BCRYPT) - menggunakan password_verify()
     * - Password legacy (MD5) - menggunakan arr2md5() untuk backward compatibility
     * 
     * @param string $password Password plain text dari user
     * @param string $code_activation Code activation dari database (untuk legacy MD5)
     * @param string $stored_hash Hash password yang tersimpan di database
     * @return bool True jika password cocok, False jika tidak
     */
    function verify_password($password, $code_activation, $stored_hash)
    {
        // Cek apakah stored_hash adalah hash modern (mulai dengan $2y$, $2a$, $argon2, dll)
        if (password_verify($password, $stored_hash)) {
            // Password modern (Argon2ID/BCRYPT)
            return true;
        }

        // Fallback: cek dengan metode lama (MD5) untuk backward compatibility
        // Hanya jika hash panjangnya 32 karakter (MD5 format)
        if (strlen($stored_hash) === 32 && ctype_xdigit($stored_hash)) {
            $legacy_hash = $this->arr2md5(array($code_activation, $password));
            if ($legacy_hash === $stored_hash) {
                // Password lama cocok, perlu di-rehash ke modern saat login
                return true;
            }
        }

        return false;
    }

    /**
     * Cek apakah password hash perlu di-rehash
     * 
     * Fungsi ini digunakan untuk auto-rehash saat login:
     * - Password MD5 (legacy) -> perlu rehash ke modern
     * - Password dengan algoritma deprecated -> perlu rehash
     * 
     * @param string $hash Hash password yang tersimpan di database
     * @return bool True jika perlu rehash, False jika sudah modern
     */
    function needs_rehash($hash)
    {
        // Jika hash adalah format lama (MD5, panjang 32 karakter hex)
        if (strlen($hash) === 32 && ctype_xdigit($hash)) {
            return true; // Perlu rehash ke modern
        }

        // Jika hash modern tapi algoritma sudah deprecated
        if (defined('PASSWORD_ARGON2ID')) {
            // Cek apakah hash perlu di-upgrade ke Argon2ID
            return password_needs_rehash($hash, PASSWORD_ARGON2ID, [
                'memory_cost' => 65536,
                'time_cost' => 4,
                'threads' => 3
            ]);
        } else {
            // Cek apakah hash perlu di-upgrade ke BCRYPT cost 12
            return password_needs_rehash($hash, PASSWORD_BCRYPT, [
                'cost' => 12
            ]);
        }
    }

    /**
     * Generate activation code untuk user baru
     * 
     * @return string Random activation code (32 karakter hex)
     */
    function generate_activation_code()
    {
        return bin2hex(random_bytes(16)); // 32 karakter hex
    }
}