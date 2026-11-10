<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function showLogin(): View
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:24', 'regex:/^[A-Za-z0-9_-]+$/'],
        ], [
            'username.required' => 'Nama pengguna wajib diisi.',
            'username.min' => 'Nama pengguna minimal 3 karakter.',
            'username.max' => 'Nama pengguna maksimal 24 karakter.',
            'username.regex' => 'Gunakan huruf, angka, garis bawah, atau strip.',
        ]);

        return redirect()->route('dashboard', [
            'username' => $validated['username'],
        ]);
    }

    public function dashboard(Request $request): View|RedirectResponse
    {
        $username = $this->username($request);

        if ($username === null) {
            return $this->guard();
        }

        $tanaman = $this->tanaman();

        return view('dashboard', [
            'username' => $username,
            'tanggal' => now()->locale('id')->translatedFormat('l, j F Y'),
            'statistik' => $this->statistik($tanaman),
            'jadwal' => $this->jadwal(),
            'aktivitas' => $this->aktivitas(),
            'panen' => $this->panen($tanaman),
        ]);
    }

    public function pengelolaan(Request $request): View|RedirectResponse
    {
        $username = $this->username($request);

        if ($username === null) {
            return $this->guard();
        }

        $tanaman = $this->tanaman();

        return view('pengelolaan', [
            'username' => $username,
            'tanaman' => $tanaman,
            'ringkasan' => $this->ringkasan($tanaman),
        ]);
    }

    public function profile(Request $request): View|RedirectResponse
    {
        $username = $this->username($request);

        if ($username === null) {
            return $this->guard();
        }

        return view('profile', [
            'username' => $username,
            'profil' => $this->profil($username),
        ]);
    }

    private function guard(): RedirectResponse
    {
        return redirect()
            ->route('login')
            ->with('error', 'Silakan masuk terlebih dahulu.');
    }

    private function username(Request $request): ?string
    {
        $username = $request->query('username');

        if (! is_string($username) || ! preg_match('/^[A-Za-z0-9_-]{3,24}$/', $username)) {
            return null;
        }

        return $username;
    }

    private function tanaman(): array
    {
        return [
            [
                'kode' => 'TW-01',
                'nama' => 'Selada Keriting',
                'kategori' => 'Sayuran daun',
                'media' => 'Rockwool',
                'rak' => 'A1',
                'umur' => 27,
                'status' => 'Siap panen',
                'estimasi' => '9 Nov 2026',
            ],
            [
                'kode' => 'TW-02',
                'nama' => 'Pakcoy',
                'kategori' => 'Sayuran daun',
                'media' => 'Rockwool',
                'rak' => 'A2',
                'umur' => 24,
                'status' => 'Siap panen',
                'estimasi' => '10 Nov 2026',
            ],
            [
                'kode' => 'TW-03',
                'nama' => 'Bayam Merah',
                'kategori' => 'Sayuran daun',
                'media' => 'Cocopeat',
                'rak' => 'A3',
                'umur' => 21,
                'status' => 'Tumbuh',
                'estimasi' => '15 Nov 2026',
            ],
            [
                'kode' => 'TW-04',
                'nama' => 'Kale Nero',
                'kategori' => 'Sayuran daun',
                'media' => 'Rockwool',
                'rak' => 'B1',
                'umur' => 34,
                'status' => 'Siap panen',
                'estimasi' => '8 Nov 2026',
            ],
            [
                'kode' => 'TW-05',
                'nama' => 'Tomat Cherry',
                'kategori' => 'Buah',
                'media' => 'Cocopeat',
                'rak' => 'B2',
                'umur' => 49,
                'status' => 'Perlu perhatian',
                'estimasi' => '20 Nov 2026',
            ],
            [
                'kode' => 'TW-06',
                'nama' => 'Cabai Rawit',
                'kategori' => 'Buah',
                'media' => 'Cocopeat',
                'rak' => 'B3',
                'umur' => 51,
                'status' => 'Tumbuh',
                'estimasi' => '25 Nov 2026',
            ],
            [
                'kode' => 'TW-07',
                'nama' => 'Mint',
                'kategori' => 'Herbal',
                'media' => 'Rockwool',
                'rak' => 'C1',
                'umur' => 17,
                'status' => 'Perlu perhatian',
                'estimasi' => '18 Nov 2026',
            ],
            [
                'kode' => 'TW-08',
                'nama' => 'Stroberi',
                'kategori' => 'Buah',
                'media' => 'Cocopeat',
                'rak' => 'C2',
                'umur' => 38,
                'status' => 'Tumbuh',
                'estimasi' => '30 Nov 2026',
            ],
        ];
    }

    private function statistik(array $tanaman): array
    {
        $total = count($tanaman);
        $siapPanen = $this->hitungStatus($tanaman, 'Siap panen');
        $perluPerhatian = $this->hitungStatus($tanaman, 'Perlu perhatian');
        $rak = count(array_unique(array_map(
            fn (array $item) => substr($item['rak'], 0, 1),
            $tanaman
        )));
        $rataRata = $total > 0
            ? (int) round(array_sum(array_column($tanaman, 'umur')) / $total)
            : 0;

        return [
            ['label' => 'Tanaman aktif', 'value' => $total, 'hint' => "di {$rak} rak"],
            ['label' => 'Siap panen', 'value' => $siapPanen, 'hint' => 'periksa minggu ini'],
            ['label' => 'Perlu perhatian', 'value' => $perluPerhatian, 'hint' => 'cek nutrisi dan cahaya'],
            ['label' => 'Rata-rata umur', 'value' => "{$rataRata} HST", 'hint' => 'hari setelah tanam'],
        ];
    }

    private function ringkasan(array $tanaman): array
    {
        return [
            'total' => count($tanaman),
            'siap_panen' => $this->hitungStatus($tanaman, 'Siap panen'),
            'perlu_perhatian' => $this->hitungStatus($tanaman, 'Perlu perhatian'),
        ];
    }

    private function hitungStatus(array $tanaman, string $status): int
    {
        return count(array_filter($tanaman, fn (array $item) => $item['status'] === $status));
    }

    private function jadwal(): array
    {
        return [
            ['waktu' => '07.00', 'kegiatan' => 'Cek pH dan ppm larutan nutrisi', 'lokasi' => 'Rak A'],
            ['waktu' => '09.30', 'kegiatan' => 'Panen Kale Nero (TW-04)', 'lokasi' => 'Rak B1'],
            ['waktu' => '15.30', 'kegiatan' => 'Tambah larutan nutrisi', 'lokasi' => 'Rak B'],
        ];
    }

    private function aktivitas(): array
    {
        return [
            ['teks' => 'Selada Keriting dipindah ke Rak A1', 'waktu' => '2 jam lalu'],
            ['teks' => 'pH larutan Rak B disesuaikan ke 6,2', 'waktu' => 'Kemarin'],
            ['teks' => 'Bayam Merah masuk tahap pembesaran', 'waktu' => '2 hari lalu'],
            ['teks' => 'Mint menunjukkan daun menguning', 'waktu' => '2 hari lalu'],
        ];
    }

    private function panen(array $tanaman): array
    {
        $siapPanen = array_values(array_filter(
            $tanaman,
            fn (array $item) => $item['status'] === 'Siap panen'
        ));

        usort($siapPanen, fn (array $a, array $b) => strtotime($a['estimasi']) <=> strtotime($b['estimasi']));

        return array_map(fn (array $item) => [
            'kode' => $item['kode'],
            'nama' => $item['nama'],
            'rak' => $item['rak'],
            'estimasi' => $item['estimasi'],
        ], $siapPanen);
    }

    private function profil(string $username): array
    {
        $tanaman = $this->tanaman();
        $statistik = $this->statistik($tanaman);

        return [
            'nama' => $username,
            'inisial' => strtoupper(substr($username, 0, 1)),
            'peran' => 'Pengelola kebun',
            'lokasi' => 'Rak A–C, halaman belakang',
            'bergabung' => 'Maret 2025',
            'bio' => 'Merawat delapan tanaman hidroponik di halaman belakang. '
                .'Fokus pada selada, pakcoy, dan kale, dengan catatan perawatan yang dirapikan setiap pagi.',
            'statistik' => [
                ['label' => $statistik[0]['label'], 'value' => $statistik[0]['value']],
                ['label' => $statistik[1]['label'], 'value' => $statistik[1]['value']],
                ['label' => $statistik[3]['label'], 'value' => $statistik[3]['value']],
            ],
            'preferensi' => [
                ['judul' => 'Pengecekan pagi', 'nilai' => '07.00'],
                ['judul' => 'Nutrisi', 'nilai' => 'AB Mix'],
                ['judul' => 'Pencatatan', 'nilai' => 'Manual'],
            ],
        ];
    }
}
