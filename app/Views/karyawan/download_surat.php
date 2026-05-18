<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="<?= base_url('logo-instansi.png') ?>">
  <title>Download Surat - ESS Portal</title>
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
        <a href="<?= base_url('/karyawan/dashboard') ?>" class="text-2xl font-black tracking-wider bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">ESS PORTAL</a>
      </div>
      <div class="flex items-center space-x-4">
        <a href="<?= base_url('/karyawan/dashboard') ?>" class="text-xs font-semibold text-gray-400 hover:text-white transition">Kembali ke Dashboard</a>
      </div>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="container mx-auto mt-8 px-4 max-w-5xl pb-12">

    <!-- Alerts -->
    <?php if (session()->getFlashdata('error')) : ?>
      <div class="bg-red-500/20 border border-red-500/40 text-red-200 text-sm p-4 rounded-2xl mb-6">
        ⚠️ <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <div class="mb-8">
      <h2 class="text-2xl font-extrabold tracking-tight">Pusat Unduh Dokumen</h2>
      <p class="text-sm text-gray-400 mt-1">Unduh draf, template, dan berkas administrasi resmi internal perusahaan.</p>
    </div>

    <!-- GRID DAFTAR SURAT -->
    <?php if (empty($daftar_surat)) : ?>
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-12 rounded-3xl text-center text-gray-500">
        📁 Belum ada dokumen administrasi yang diunggah oleh Admin.
      </div>
    <?php else : ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($daftar_surat as $surat) : ?>
          <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl flex items-start space-x-4 hover:border-purple-500/30 transition duration-300">
            <div class="text-3xl p-3 bg-white/5 rounded-2xl text-purple-400">
              📄
            </div>
            <div class="flex-1 min-w-0">
              <span class="text-[10px] bg-purple-500/20 text-purple-300 px-2.5 py-0.5 rounded-full font-semibold uppercase tracking-wider">
                <?= esc($surat['kategori']) ?>
              </span>
              <h3 class="text-lg font-bold text-white mt-2 truncate"><?= esc($surat['nama_surat']) ?></h3>
              <p class="text-xs text-gray-400 mt-1 mb-4 leading-relaxed line-clamp-2"><?= esc($surat['deskripsi']) ?></p>

              <a href="<?= base_url('/karyawan/download-surat/proses/' . $surat['id']) ?>"
                class="inline-flex items-center text-xs font-bold text-indigo-400 hover:text-indigo-300 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 px-4 py-2 rounded-xl transition">
                📥 Unduh Berkas
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </main>

</body>

</html>