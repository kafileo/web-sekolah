<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Information;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Akun Pengguna untuk Pengujian Role Admin dan User
        $admin = User::create([
            'name' => 'Administrator Sekolah',
            'email' => 'admin@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'Siswa Pengujian (Budi Santoso)',
            'email' => 'siswa@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 2. Seed Kategori Informasi
        $catAkademik = Category::create([
            'name' => 'Akademik',
            'slug' => 'akademik',
            'description' => 'Informasi terkait kalender pendidikan, pembelajaran, kurikulum, dan tugas sekolah.',
            'color' => 'indigo',
        ]);

        $catKesiswaan = Category::create([
            'name' => 'Kesiswaan',
            'slug' => 'kesiswaan',
            'description' => 'Pengumuman tata tertib, seragam, OSIS, dan kegiatan pembinaan karakter siswa.',
            'color' => 'emerald',
        ]);

        $catEkskul = Category::create([
            'name' => 'Ekstrakurikuler',
            'slug' => 'ekstrakurikuler',
            'description' => 'Jadwal latihan, seleksi keanggotaan, dan agenda kegiatan klub atau ekstrakurikuler.',
            'color' => 'sky',
        ]);

        $catUjian = Category::create([
            'name' => 'Pengumuman Ujian',
            'slug' => 'pengumuman-ujian',
            'description' => 'Tata tertib ujian, jadwal pelaksanaan asesmen sumatif, dan pembagian ruang ujian.',
            'color' => 'amber',
        ]);

        $catPrestasi = Category::create([
            'name' => 'Prestasi & Apresiasi',
            'slug' => 'prestasi-apresiasi',
            'description' => 'Kabar gembira pencapaian membanggakan siswa di tingkat regional maupun nasional.',
            'color' => 'rose',
        ]);

        // 3. Seed Informasi / Pengumuman Sekolah
        Information::create([
            'title' => 'Jadwal Pelaksanaan Asesmen Sumatif Akhir Semester (ASAS) Ganjil',
            'slug' => Str::slug('Jadwal Pelaksanaan Asesmen Sumatif Akhir Semester (ASAS) Ganjil'),
            'category_id' => $catUjian->id,
            'user_id' => $admin->id,
            'excerpt' => 'Diberitahukan kepada seluruh siswa bahwa pelaksanaan ASAS Ganjil akan dimulai pekan depan. Harap melengkapi kartu peserta ujian.',
            'content' => "Yth. Seluruh Siswa-Siswi dan Bapak/Ibu Wali Murid,\n\nSehubungan dengan berakhirnya kegiatan pembelajaran Semester Ganjil Tahun Ajaran 2026/2027, pihak sekolah akan menyelenggarakan kegiatan Asesmen Sumatif Akhir Semester (ASAS) dengan ketentuan sebagai berikut:\n\n1. Pelaksanaan Ujian: Dimulai hari Senin sampai Jumat pukul 07.30 - 12.00 WIB.\n2. Seluruh siswa wajib hadir 15 menit sebelum ujian dimulai dengan mengenakan seragam lengkap sesuai tata tertib.\n3. Siswa wajib mencetak Kartu Peserta Ujian melalui ruang piket atau portal ini.\n4. Dilarang membawa alat komunikasi atau gadget elektronik ke dalam ruang ujian kecuali diperintahkan oleh pengawas.\n\nDemikian pengumuman ini disampaikan untuk menjadi perhatian bersama. Persiapkan diri Anda dengan maksimal dan junjung tinggi kejujuran akademik.",
            'is_active' => true,
            'published_date' => now()->toDateString(),
            'views_count' => 142,
        ]);

        Information::create([
            'title' => 'Peringatan Hari Pendidikan: Seluruh Siswa Wajib Mengenakan Pakaian Adat Daerah',
            'slug' => Str::slug('Peringatan Hari Pendidikan Seluruh Siswa Wajib Mengenakan Pakaian Adat Daerah'),
            'category_id' => $catKesiswaan->id,
            'user_id' => $admin->id,
            'excerpt' => 'Dalam rangka memperingati Hari Pendidikan Nasional, sekolah akan menyelenggarakan upacara bendera khusus dan lomba kebudayaan nusantara.',
            'content' => "Halo Sahabat Pelajar!\n\nUntuk menyemarakkan peringatan Hari Pendidikan Nasional, sekolah akan menggelar rangkaian kegiatan istimewa pada hari Kamis mendatang:\n\n- Upacara Bendera Kebudayaan pukul 07.00 WIB di lapangan utama.\n- Seluruh siswa, guru, dan staf dianjurkan mengenakan pakaian adat nusantara yang sopan dan rapi.\n- Parade kostum budaya dan lomba cerdas cermat kebangsaan antarkelas perwakilan OSIS.\n\nMari kita rawat kebhinekaan dan tumbuhkan semangat belajar sepanjang hayat!",
            'is_active' => true,
            'published_date' => now()->subDays(2)->toDateString(),
            'views_count' => 89,
        ]);

        Information::create([
            'title' => 'Pendaftaran Terbuka Ekstrakurikuler Robotika dan Pemrograman Web',
            'slug' => Str::slug('Pendaftaran Terbuka Ekstrakurikuler Robotika dan Pemrograman Web'),
            'category_id' => $catEkskul->id,
            'user_id' => $admin->id,
            'excerpt' => 'Bagi siswa yang berminat pada bidang teknologi, IoT, dan web development, pendaftaran gelombang kedua telah resmi dibuka.',
            'content' => "Salam Inovasi!\n\nKlub Sains & Komputer Sekolah membuka kesempatan bagi siswa kelas X dan XI untuk bergabung dalam divisi Robotika & Web Development.\n\nFasilitas yang disediakan:\n1. Lab komputer berstandar industri dengan akses internet serat optik kecepatan tinggi.\n2. Modul IoT (Arduino, ESP32, sensor pack) untuk eksperimen praktis.\n3. Pembina bersertifikasi nasional dan bimbingan lomba tingkat provinsi hingga nasional.\n\nPendaftaran dibuka hingga akhir pekan ini melalui laboratorium komputer 2 sepulang sekolah.",
            'is_active' => true,
            'published_date' => now()->subDays(4)->toDateString(),
            'views_count' => 110,
        ]);

        Information::create([
            'title' => 'Kabar Membanggakan: Tim Debat Bahasa Inggris Meraih Juara 1 Tingkat Nasional',
            'slug' => Str::slug('Kabar Membanggakan Tim Debat Bahasa Inggris Meraih Juara 1 Tingkat Nasional'),
            'category_id' => $catPrestasi->id,
            'user_id' => $admin->id,
            'excerpt' => 'Apresiasi setinggi-tingginya kepada ananda Amanda Putri dan tim yang sukses mengharumkan nama sekolah dalam kompetisi National Debate Championship.',
            'content' => "Alhamdulillah dan puji syukur ke hadirat Tuhan Yang Maha Esa!\n\nKeluarga besar sekolah mengucapkan selamat dan apresiasi setinggi-tingginya kepada:\n\n1. Amanda Putri (Kelas XI-MIPA 1)\n2. Muhammad Rayhan (Kelas XI-IPS 2)\n3. Siti Nurhaliza (Kelas X-1)\n\nYang telah berhasil meraih JUARA 1 (Gold Medal) pada kompetisi National High School Debate Championship 2026 yang berlangsung di Jakarta.\n\nSemoga prestasi gemilang ini memotivasi seluruh peserta didik untuk terus mengasah potensi, berprestasi, dan menjunjung sportivitas.",
            'is_active' => true,
            'published_date' => now()->subDays(6)->toDateString(),
            'views_count' => 230,
        ]);

        Information::create([
            'title' => 'Sosialisasi Program Bimbingan Karir & Seleksi Masuk Perguruan Tinggi',
            'slug' => Str::slug('Sosialisasi Program Bimbingan Karir dan Seleksi Masuk Perguruan Tinggi'),
            'category_id' => $catAkademik->id,
            'user_id' => $admin->id,
            'excerpt' => 'Unit Bimbingan Konseling menyelenggarakan webinar dan konsultasi penjurusan PTN & PTS impian khusus kelas XII.',
            'content' => "Kepada seluruh siswa kelas XII,\n\nMemasuki masa penentuan masa depan studi lanjut, unit Guru Bimbingan dan Konseling (BK) mengadakan program pemetaan minat bakat dan tryout seleksi nasional berbasis tes (SNBT).\n\nJadwal konsultasi tatap muka dimulai hari Selasa depan di ruang BK. Silakan menyusun daftar prioritas jurusan dan perguruan tinggi yang dituju untuk dibahas bersama guru pembimbing.",
            'is_active' => true,
            'published_date' => now()->subDays(8)->toDateString(),
            'views_count' => 75,
        ]);

        // 4. Data Informasi Nonaktif (Untuk membuktikan pengujian bahwa data nonaktif TIDAK muncul di halaman user)
        Information::create([
            'title' => '[DRAFT PENGUJIAN] Evaluasi Internal Pengelolaan Fasilitas Olahraga',
            'slug' => Str::slug('DRAFT PENGUJIAN Evaluasi Internal Pengelolaan Fasilitas Olahraga'),
            'category_id' => $catKesiswaan->id,
            'user_id' => $admin->id,
            'excerpt' => 'Dokumen uji coba yang dinonaktifkan oleh admin. Hanya tampil di dashboard pengelola admin, tidak boleh muncul pada halaman user.',
            'content' => "Informasi ini berstatus NONAKTIF (is_active = 0). Tujuan pengujian adalah membuktikan bahwa sistem melakukan filter ketat sehingga siswa tidak dapat melihat pengumuman yang belum dipublikasikan atau berstatus draft.",
            'is_active' => false,
            'published_date' => now()->toDateString(),
            'views_count' => 5,
        ]);
    }
}
