<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Karyawan - ESS Portal</title>
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

  <main class="container mx-auto mt-8 px-4 max-w-5xl pb-12">

    <?php if (session()->getFlashdata('success')) : ?>
      <div class="bg-emerald-500/20 border border-emerald-500/40 text-emerald-200 text-sm p-4 rounded-2xl mb-6">
        ✨ <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
      <div class="bg-red-500/20 border border-red-500/40 text-red-200 text-sm p-4 rounded-2xl mb-6">
        ⚠️ <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl flex flex-col items-center text-center h-fit">
        <div class="relative w-32 h-32 mb-4 group">
          <img src="<?= base_url('uploads/profil/' . esc($foto)) ?>" alt="Foto Profil"
            class="w-full h-full object-cover rounded-2xl border-2 border-purple-500/30 shadow-lg">
        </div>

        <h3 class="font-bold text-lg"><?= esc($profil['nama_lengkap']) ?></h3>
        <p class="text-xs text-purple-400 font-medium mt-0.5"><?= esc($profil['jabatan']) ?></p>
        <p class="text-[11px] text-gray-500 mt-1">NIP: <?= esc($nip) ?></p>

        <form action="<?= base_url('/karyawan/profil/upload') ?>" method="POST" enctype="multipart/form-data" class="w-full mt-6 pt-6 border-t border-white/10">
          <?= csrf_field() ?>
          <label class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2 text-left">Ganti Foto Profil</label>
          <input type="file" name="foto_profil" required
            class="w-full text-xs text-gray-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-600/20 file:text-purple-300 hover:file:bg-purple-600/40 file:cursor-pointer mb-3">
          <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-semibold py-2 px-3 rounded-xl text-xs transition duration-200 shadow-md">
            Unggah Gambar
          </button>
        </form>
      </div>

      <div class="md:col-span-2 bg-white/5 backdrop-blur-xl border border-white/10 p-6 sm:p-8 rounded-3xl">
        <h3 class="text-lg font-bold mb-6 bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">Data Pribadi Karyawan</h3>

        <div class="space-y-4 text-sm">
          <div class="grid grid-cols-3 py-2 border-b border-white/5">
            <span class="text-gray-400 font-medium">Nama Lengkap</span>
            <span class="col-span-2 font-semibold text-gray-200"><?= esc($profil['nama_lengkap']) ?></span>
          </div>
          <div class="grid grid-cols-3 py-2 border-b border-white/5">
            <span class="text-gray-400 font-medium">Jabatan Saat Ini</span>
            <span class="col-span-2 font-semibold text-purple-300"><?= esc($profil['jabatan']) ?></span>
          </div>
          <div class="grid grid-cols-3 py-2 border-b border-white/5">
            <span class="text-gray-400 font-medium">Tempat, Tgl Lahir</span>
            <span class="col-span-2 text-gray-300">
              <?= esc($profil['tempat_lahir']) ?>, <?= date('d F Y', strtotime($profil['tanggal_lahir'])) ?>
            </span>
          </div>
          <div class="grid grid-cols-3 py-2 border-b border-white/5">
            <span class="text-gray-400 font-medium">Jenis Kelamin</span>
            <span class="col-span-2 text-gray-300"><?= $profil['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
          </div>
          <div class="grid grid-cols-3 py-2 border-b border-white/5">
            <span class="text-gray-400 font-medium">No. Telepon</span>
            <span class="col-span-2 text-gray-300"><?= esc($profil['telepon']) ?></span>
          </div>
          <div class="grid grid-cols-3 py-2">
            <span class="text-gray-400 font-medium">Alamat Tinggal</span>
            <span class="col-span-2 text-gray-300 leading-relaxed"><?= esc($profil['alamat']) ?></span>
          </div>
        </div>
      </div>

    </div>
  </main>

</body>

</html>