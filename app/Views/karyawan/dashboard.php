<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Karyawan - ESS Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .mesh-gradient {
      background-color: #0d1117;
      background-image:
        radial-gradient(at 0% 0%, hsla(242, 61%, 15%, 1) 0px, transparent 50%),
        radial-gradient(at 100% 0%, hsla(292, 59%, 17%, 1) 0px, transparent 50%),
        radial-gradient(at 50% 100%, hsla(190, 68%, 14%, 1) 0px, transparent 50%);
    }
  </style>
</head>

<body class="mesh-gradient min-h-screen text-white font-sans">

  <!-- NAVBAR -->
  <nav class="bg-white/5 backdrop-blur-xl border-b border-white/10 px-6 py-4 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <span class="text-2xl font-black tracking-wider bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">ESS PORTAL</span>
      </div>
      <div class="flex items-center space-x-4">
        <div class="text-right hidden sm:block">
          <p class="text-sm font-bold"><?= esc($nama) ?></p>
          <p class="text-xs text-gray-400"><?= esc($jabatan) ?></p>
        </div>
        <a href="<?= base_url('/logout') ?>" class="bg-red-500/20 hover:bg-red-500/40 border border-red-500/50 text-red-200 px-4 py-2 rounded-xl text-xs font-semibold transition duration-200">
          Keluar
        </a>
      </div>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="container mx-auto mt-8 px-4 max-w-6xl">

    <!-- Notifikasi Sukses Login -->
    <?php if (session()->getFlashdata('success')) : ?>
      <div class="bg-emerald-500/20 border border-emerald-500/40 text-emerald-200 text-sm p-4 rounded-2xl mb-6 flex items-center space-x-2">
        <span>✨</span> <span><?= session()->getFlashdata('success') ?></span>
      </div>
    <?php endif; ?>

    <!-- WELCOME CARD / DATA PRIBADI (Fitur 3) -->
    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 sm:p-8 rounded-3xl mb-8 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
      <div class="w-20 h-20 bg-gradient-to-tr from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center text-3xl font-bold shadow-lg shadow-purple-500/20">
        👤
      </div>
      <div class="text-center sm:text-left flex-1">
        <h2 class="text-2xl font-extrabold tracking-tight">Selamat Datang, <?= esc($nama) ?>!</h2>
        <p class="text-gray-400 text-sm mt-1">NIP: <?= esc($nip) ?> • Jabatan: <span class="text-purple-400 font-medium"><?= esc($jabatan) ?></span></p>
      </div>
      <div>
        <a href="#" class="bg-white/10 hover:bg-white/20 border border-white/10 px-5 py-2.5 rounded-xl text-xs font-medium transition duration-200 block text-center">
          Lihat Profil Lengkap
        </a>
      </div>
    </div>

    <!-- PENGUMUMAN PERUSAHAAN (Fitur 4) -->
    <div class="bg-gradient-to-r from-purple-900/40 to-indigo-900/40 backdrop-blur-xl border border-purple-500/20 p-6 rounded-3xl mb-8">
      <div class="flex items-center space-x-2 mb-3">
        <span class="text-xl">📢</span>
        <h3 class="text-lg font-bold text-purple-300">Pengumuman Internal</h3>
      </div>
      <p class="text-sm text-gray-300 leading-relaxed">
        Halo Tim IT! Mulai minggu depan, kita akan mengimplementasikan standarisasi sistem ESS berbasis CodeIgniter 4 ini ke server *staging*. Harap semua data uji coba dan migrasi diselesaikan tepat waktu. Terima kasih!
      </p>
      <span class="text-[10px] bg-purple-500/30 text-purple-200 px-2 py-1 rounded-md mt-4 inline-block font-medium">Diposting: Baru saja</span>
    </div>

    <!-- MENU GRID FITUR UTAMA -->
    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4 px-1">Layanan Mandiri Karyawan</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

      <!-- Fitur 1: Slip Gaji -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl hover:border-purple-500/40 transition group">
        <div class="text-3xl mb-4 bg-white/5 w-12 h-12 flex items-center justify-center rounded-2xl group-hover:bg-purple-500/20 transition">💵</div>
        <h4 class="text-lg font-bold mb-1">Slip Gaji Bulanan</h4>
        <p class="text-xs text-gray-400 mb-6 leading-relaxed">Akses berkas rincian gaji, tunjangan, dan potongan Anda secara transparan.</p>
        <a href="#" class="inline-flex items-center text-xs font-bold text-purple-400 hover:text-purple-300 transition">
          Buka Riwayat Gaji <span class="ml-1 group-hover:translate-x-1 transition transform">&rarr;</span>
        </a>
      </div>

      <!-- Fitur 2: Pengajuan Cuti -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl hover:border-indigo-500/40 transition group">
        <div class="text-3xl mb-4 bg-white/5 w-12 h-12 flex items-center justify-center rounded-2xl group-hover:bg-indigo-500/20 transition">📅</div>
        <h4 class="text-lg font-bold mb-1">Permohonan Cuti</h4>
        <p class="text-xs text-gray-400 mb-6 leading-relaxed">Ajukan cuti tahunan, sakit, atau keperluan mendesak dengan approval otomatis.</p>
        <a href="#" class="inline-flex items-center text-xs font-bold text-indigo-400 hover:text-indigo-300 transition">
          Form Pengajuan <span class="ml-1 group-hover:translate-x-1 transition transform">&rarr;</span>
        </a>
      </div>

      <!-- Fitur 5: Download Surat -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl hover:border-emerald-500/40 transition group">
        <div class="text-3xl mb-4 bg-white/5 w-12 h-12 flex items-center justify-center rounded-2xl group-hover:bg-emerald-500/20 transition">📄</div>
        <h4 class="text-lg font-bold mb-1">Unduh Dokumen Resmi</h4>
        <p class="text-xs text-gray-400 mb-6 leading-relaxed">Unduh Surat Keterangan Kerja, paklaring, atau berkas administrasi lainnya.</p>
        <a href="#" class="inline-flex items-center text-xs font-bold text-emerald-400 hover:text-emerald-300 transition">
          Lihat Berkas <span class="ml-1 group-hover:translate-x-1 transition transform">&rarr;</span>
        </a>
      </div>

    </div>
  </main>

</body>

</html>