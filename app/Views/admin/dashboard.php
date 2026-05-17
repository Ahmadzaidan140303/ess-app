<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - ESS Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .mesh-admin {
      background-color: #0b0f14;
      background-image:
        radial-gradient(at 0% 0%, hsla(340, 65%, 14%, 1) 0px, transparent 50%),
        radial-gradient(at 100% 0%, hsla(220, 55%, 13%, 1) 0px, transparent 50%),
        radial-gradient(at 50% 100%, hsla(355, 60%, 12%, 1) 0px, transparent 50%);
    }
  </style>
</head>

<body class="mesh-admin min-h-screen text-white font-sans">

  <!-- NAVBAR -->
  <nav class="bg-white/5 backdrop-blur-xl border-b border-white/10 px-6 py-4 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <span class="text-2xl font-black tracking-wider bg-gradient-to-r from-rose-400 to-amber-400 bg-clip-text text-transparent">ESS ADMIN</span>
        <span class="text-[10px] bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded-md font-bold tracking-widest uppercase">Console</span>
      </div>
      <div class="flex items-center space-x-4">
        <div class="text-right hidden sm:block">
          <p class="text-xs font-bold text-gray-200"><?= esc($nama_admin) ?></p>
          <p class="text-[10px] text-rose-400 font-semibold">Super Administrator</p>
        </div>
        <a href="<?= base_url('/logout') ?>" class="bg-rose-600/20 hover:bg-rose-600 border border-rose-500/30 px-4 py-2 rounded-xl text-xs font-semibold transition">
          Keluar
        </a>
      </div>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="container mx-auto mt-8 px-4 max-w-6xl pb-12">

    <!-- WELCOME BANNER -->
    <div class="bg-gradient-to-r from-rose-950/40 to-amber-950/20 backdrop-blur-xl border border-white/10 p-6 sm:p-8 rounded-3xl mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, Admin Master 👋</h1>
        <p class="text-xs sm:text-sm text-gray-400 mt-1">Panel kendali pusat manajemen data operasional karyawan dan verifikasi berkas.</p>
      </div>
    </div>

    <!-- STATS COUNTER GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
      <!-- Total Karyawan -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-2xl flex justify-between items-center">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Karyawan</p>
          <h3 class="text-3xl font-black mt-2 text-white"><?= $total_karyawan ?> <span class="text-xs font-normal text-gray-500">orang</span></h3>
        </div>
        <div class="text-3xl p-3 bg-white/5 rounded-xl text-rose-400">👥</div>
      </div>
      <!-- Cuti Menunggu Persetujuan -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-2xl flex justify-between items-center">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Butuh Approval Cuti</p>
          <h3 class="text-3xl font-black mt-2 <?= $cuti_pending > 0 ? 'text-amber-400' : 'text-gray-400' ?>"><?= $cuti_pending ?> <span class="text-xs font-normal text-gray-500">kasus</span></h3>
        </div>
        <div class="text-3xl p-3 bg-white/5 rounded-xl text-amber-400">⏳</div>
      </div>
      <!-- Total Dokumen Resmi -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-2xl flex justify-between items-center">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dokumen Internal</p>
          <h3 class="text-3xl font-black mt-2 text-white"><?= $total_dokumen ?> <span class="text-xs font-normal text-gray-500">berkas</span></h3>
        </div>
        <div class="text-3xl p-3 bg-white/5 rounded-xl text-indigo-400">📁</div>
      </div>
    </div>

    <!-- MANAGEMENT MENU GRID -->
    <h2 class="text-lg font-bold mb-4 tracking-tight text-gray-300">Modul Administrasi Eksekutif</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

      <!-- Menu 1: Kelola Karyawan -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl flex flex-col justify-between group hover:border-rose-500/30 transition duration-300">
        <div>
          <div class="text-2xl mb-4">🗂️</div>
          <h3 class="text-lg font-bold text-white">Master Data Karyawan</h3>
          <p class="text-xs text-gray-400 mt-1 leading-relaxed">Tambah karyawan baru, edit penempatan jabatan, ubah besaran gaji pokok, atau nonaktifkan akun.</p>
        </div>
        <a href="#" class="mt-6 inline-flex items-center text-xs font-bold text-rose-400 hover:text-rose-300 transition">
          Buka Manajemen Karyawan <span class="ml-1 group-hover:translate-x-1 transition transform">&rarr;</span>
        </a>
      </div>

      <!-- Menu 2: Approval Cuti -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl flex flex-col justify-between group hover:border-amber-500/30 transition duration-300">
        <div>
          <div class="text-2xl mb-4">📅</div>
          <h3 class="text-lg font-bold text-white">Persetujuan Cuti</h3>
          <p class="text-xs text-gray-400 mt-1 leading-relaxed">Periksa alasan pengajuan cuti dari seluruh divisi, lalu setujui atau tolak pengajuan secara langsung.</p>
        </div>
        <a href="<?= base_url('/admin/cuti') ?>" class="mt-6 inline-flex items-center text-xs font-bold text-amber-400 hover:text-amber-300 transition">
          Periksa Pengajuan Cuti <span class="ml-1 group-hover:translate-x-1 transition transform">&rarr;</span>
        </a>
      </div>

      <!-- Menu 3: Upload Slip Gaji & Surat -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl flex flex-col justify-between group hover:border-indigo-500/30 transition duration-300">
        <div>
          <div class="text-2xl mb-4">💵</div>
          <h3 class="text-lg font-bold text-white">Distribusi Slip & Dokumen</h3>
          <p class="text-xs text-gray-400 mt-1 leading-relaxed">Unggah berkas PDF slip gaji bulanan karyawan atau perbarui master template draf surat resmi perusahaan.</p>
        </div>
        <a href="#" class="mt-6 inline-flex items-center text-xs font-bold text-indigo-400 hover:text-indigo-300 transition">
          Kelola Distribusi Berkas <span class="ml-1 group-hover:translate-x-1 transition transform">&rarr;</span>
        </a>
      </div>

    </div>

    <!-- RECENT ACTIVITY TABLE (5 Cuti Terakhir) -->
    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl">
      <h3 class="text-md font-bold mb-4 text-gray-300 flex items-center">
        <span class="mr-2">🔔</span> Pengajuan Cuti Terkini
      </h3>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs sm:text-sm">
          <thead>
            <tr class="border-b border-white/10 text-gray-400 font-semibold uppercase tracking-wider">
              <th class="pb-3">Nama Karyawan</th>
              <th class="pb-3">Jenis Cuti</th>
              <th class="pb-3">Durasi</th>
              <th class="pb-3">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <?php if (empty($cuti_terbaru)) : ?>
              <tr>
                <td colspan="4" class="py-4 text-center text-gray-500">Belum ada aktivitas pengajuan cuti masuk.</td>
              </tr>
            <?php else : ?>
              <?php foreach ($cuti_terbaru as $c) : ?>
                <tr class="hover:bg-white/[0.01]">
                  <td class="py-3 font-semibold text-gray-200"><?= esc($c['nama_lengkap']) ?></td>
                  <td class="py-3 text-gray-400 capitalize"><?= esc($c['jenis_cuti']) ?></td>
                  <td class="py-3 text-gray-300">
                    <?= date('d/m', strtotime($c['tanggal_mulai'])) ?> - <?= date('d/m', strtotime($c['tanggal_selesai'])) ?>
                  </td>
                  <td class="py-3">
                    <?php if (strtolower($c['status']) === 'pending') : ?>
                      <span class="bg-amber-500/20 text-amber-300 px-2 py-0.5 rounded-md font-medium text-xs border border-amber-500/30">⏳ Pending</span>
                    <?php elseif (strtolower($c['status']) === 'disetujui') : ?>
                      <span class="bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded-md font-medium text-xs border border-emerald-500/30">✅ Disetujui</span>
                    <?php else: ?>
                      <span class="bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded-md font-medium text-xs border border-rose-500/30">❌ Ditolak</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>

</body>

</html>