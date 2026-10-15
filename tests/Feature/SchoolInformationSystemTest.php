<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Information;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SchoolInformationSystemTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $student;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Siapkan akun pengujian
        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@sekolah.sch.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->student = User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@sekolah.sch.id',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $this->category = Category::create([
            'name' => 'Akademik',
            'slug' => 'akademik',
            'description' => 'Info Akademik',
            'color' => 'indigo',
        ]);
    }

    /**
     * 1. Pengujian Baris Pertama File Routes Mengandung Komentar // penjelas
     */
    public function test_routes_file_has_explanatory_comment_on_first_line()
    {
        $firstLine = fgets(fopen(base_path('routes/web.php'), 'r'));
        $this->assertStringContainsString('// penjelas', $firstLine, 'Baris pertama file routes harus mengandung komentar // penjelas sesuai Persyaratan Ekstra.');
    }

    /**
     * 2. Pengujian Login Admin Mengarahkan ke Dashboard Admin
     */
    public function test_admin_login_redirects_to_admin_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'admin@sekolah.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);
    }

    /**
     * 3. Pengujian Login User Mengarahkan ke Halaman Informasi Siswa
     */
    public function test_user_login_redirects_to_user_informasi_page()
    {
        $response = $this->post('/login', [
            'email' => 'siswa@sekolah.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('user.informasi.index'));
        $this->assertAuthenticatedAs($this->student);
    }

    /**
     * 4. Pengujian User / Siswa Tidak Boleh Mengakses Halaman Admin
     */
    public function test_user_cannot_access_admin_dashboard_or_management()
    {
        // Login sebagai siswa
        $this->actingAs($this->student);

        // Akses dashboard admin harus ditolak
        $responseDashboard = $this->get('/admin/dashboard');
        $responseDashboard->assertRedirect(route('user.informasi.index'));
        $responseDashboard->assertSessionHas('error');

        // Akses kelola informasi admin harus ditolak
        $responseManage = $this->get('/admin/informations');
        $responseManage->assertRedirect(route('user.informasi.index'));
        $responseManage->assertSessionHas('error');
    }

    /**
     * 5. Pengujian CRUD Penuh oleh Admin
     */
    public function test_admin_can_perform_full_crud_on_information()
    {
        $this->actingAs($this->admin);

        // a. Create (Tambah Data)
        $storeResponse = $this->post(route('admin.informations.store'), [
            'title' => 'Pengumuman Ujian Kenaikan Kelas',
            'category_id' => $this->category->id,
            'published_date' => '2026-10-15',
            'excerpt' => 'Ringkasan jadwal ujian kenaikan kelas.',
            'content' => 'Isi lengkap jadwal ujian untuk semua siswa.',
            'is_active' => 1,
        ]);

        $storeResponse->assertRedirect(route('admin.informations.index'));
        $this->assertDatabaseHas('information', [
            'title' => 'Pengumuman Ujian Kenaikan Kelas',
            'is_active' => 1,
        ]);

        $info = Information::where('title', 'Pengumuman Ujian Kenaikan Kelas')->first();

        // b. Read (Detail Admin)
        $showResponse = $this->get(route('admin.informations.show', $info));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Pengumuman Ujian Kenaikan Kelas');

        // c. Update (Edit Data)
        $updateResponse = $this->put(route('admin.informations.update', $info), [
            'title' => 'Pengumuman Ujian Kenaikan Kelas (Revisi)',
            'category_id' => $this->category->id,
            'published_date' => '2026-10-16',
            'excerpt' => 'Ringkasan revisi jadwal ujian.',
            'content' => 'Isi lengkap revisi pengumuman.',
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect(route('admin.informations.index'));
        $this->assertDatabaseHas('information', [
            'id' => $info->id,
            'title' => 'Pengumuman Ujian Kenaikan Kelas (Revisi)',
        ]);

        // d. Delete (Hapus Data)
        $deleteResponse = $this->delete(route('admin.informations.destroy', $info));
        $deleteResponse->assertRedirect(route('admin.informations.index'));
        $this->assertDatabaseMissing('information', [
            'id' => $info->id,
        ]);
    }

    /**
     * 6. Pengujian Sinkronisasi Data dan Filter Status Aktif ke Halaman User
     */
    public function test_user_only_sees_active_information_and_not_deleted_or_draft()
    {
        // Buat satu info aktif dan satu info nonaktif (draft)
        $activeInfo = Information::create([
            'title' => 'Pengumuman Kegiatan OSIS Aktif',
            'slug' => 'pengumuman-kegiatan-osis-aktif',
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'excerpt' => 'Ringkasan info aktif',
            'content' => 'Konten lengkap info aktif',
            'is_active' => true,
            'published_date' => now()->toDateString(),
        ]);

        $draftInfo = Information::create([
            'title' => 'Draft Rahasia Internal Sekolah',
            'slug' => 'draft-rahasia-internal-sekolah',
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'excerpt' => 'Ringkasan info nonaktif',
            'content' => 'Konten lengkap info nonaktif',
            'is_active' => false,
            'published_date' => now()->toDateString(),
        ]);

        // Akses halaman informasi siswa
        $this->actingAs($this->student);
        $response = $this->get(route('user.informasi.index'));

        $response->assertStatus(200);
        $response->assertSee('Pengumuman Kegiatan OSIS Aktif');
        $response->assertDontSee('Draft Rahasia Internal Sekolah');

        // Detail info aktif dapat dibuka siswa
        $detailActive = $this->get(route('user.informasi.show', $activeInfo->slug));
        $detailActive->assertStatus(200);

        // Detail info draft/nonaktif harus 404 (tidak boleh bisa dibuka siswa)
        $detailDraft = $this->get(route('user.informasi.show', $draftInfo->slug));
        $detailDraft->assertStatus(404);
    }
}
