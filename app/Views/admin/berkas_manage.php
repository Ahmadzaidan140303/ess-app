<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="<?= base_url('logo-instansi.png') ?>">
  <title>Distribusi Berkas - ESS Admin</title>
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
      <span class="text-2xl font-black tracking-wider bg-gradient-to-r from-rose-400 to-amber-400 bg-clip-text text-transparent">ESS ADMIN</span>
      <a href="<?= base_url('/admin/dashboard') ?>" class="text-xs font-semibold text-gray-400 hover:text-white transition">Kembali ke Kontrol Panel</a>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="container mx-auto mt-8 px-4 max-w-6xl pb-12">

    <div class="mb-8">
      <h2 class="text-2xl font-extrabold tracking-tight">Pusat Distribusi Finansial & Dokumen</h2>
      <p class="text-sm text-gray-400 mt-1">Unggah komponen berkas slip pendapatan bulanan atau perbarui draf surat legal korporat.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

      <!-- SEKTOR 1: PENERBITAN SLIP GAJI BULANAN -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl flex flex-col justify-between">
        <div>
          <h3 class="text-lg font-bold mb-4 text-rose-300 flex items-center">💵 Upload Slip Gaji Karyawan</h3>

          <?php if (session()->getFlashdata('success_slip')) : ?>
            <p class="text-xs text-emerald-400 mb-3 font-semibold">✨ <?= session()->getFlashdata('success_slip') ?></p>
          <?php endif; ?>
          <?php if (session()->getFlashdata('error_slip')) : ?>
            <p class="text-xs text-rose-400 mb-3 font-semibold">⚠️ <?= session()->getFlashdata('error_slip') ?></p>
          <?php endif; ?>

          <form action="<?= base_url('/admin/berkas/upload-slip') ?>" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            <?= csrf_field() ?>
            <div>
              <label class="block text-gray-400 mb-1 font-medium">Pilih Karyawan Penerima</label>
              <select name="user_id" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2.5 text-white focus:outline-none focus:border-rose-500">
                <option value="">-- Pilih Anggota Karyawan --</option>
                <?php foreach ($daftar_karyawan as $k) : ?>
                  <option value="<?= $k['user_id'] ?>"><?= esc($k['nama_lengkap']) ?> (NIP: <?= esc($k['user_id']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-400 mb-1 font-medium">Periode Bulan</label>
                <select name="bulan" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2.5 text-white focus:outline-none focus:border-rose-500">
                  <option value="Januari">Januari</option>
                  <option value="Februari">Februari</option>
                  <option value="Maret">Maret</option>
                  <option value="April">April</option>
                  <option value="Mei">Mei</option>
                  <option value="Juni">Juni</option>
                  <option value="Juli">Juli</option>
                  <option value="Agustus">Agustus</option>
                  <option value="September">September</option>
                  <option value="Oktober">Oktober</option>
                  <option value="November">November</option>
                  <option value="Desember">Desember</option>
                </select>
              </div>
              <div>
                <label class="block text-gray-400 mb-1 font-medium">Tahun</label>
                <input type="number" name="tahun" value="2026" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2.5 text-white focus:outline-none focus:border-rose-500">
              </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
              <div>
                <label class="block text-gray-400 mb-1 font-medium">Gaji Pokok (Rp)</label>
                <input type="number" name="gaji_pokok" placeholder="5000000" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2.5 text-white focus:outline-none focus:border-rose-500">
              </div>
              <div>
                <label class="block text-gray-400 mb-1 font-medium">Tunjangan (Rp)</label>
                <input type="number" name="tunjangan" placeholder="0" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2.5 text-white focus:outline-none focus:border-rose-500">
              </div>
              <div>
                <label class="block text-gray-400 mb-1 font-medium">Potongan (Rp)</label>
                <input type="number" name="potongan" placeholder="0" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2.5 text-white focus:outline-none focus:border-rose-500">
              </div>
            </div>
            <div>
              <label class="block text-gray-400 mb-1 font-medium">Berkas Slip Resmi (Format .PDF)</label>
              <input type="file" name="file_pdf" required class="w-full text-xs text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-600/20 file:text-rose-300 hover:file:bg-rose-600/40 file:cursor-pointer">
            </div>
            <button type="submit" class="w-full bg-rose-600 hover:bg-rose-500 font-bold py-3 px-4 rounded-xl transition shadow-lg shadow-rose-600/20 text-center block">
              Rilis Slip Gaji 🚀
            </button>
          </form>
        </div>
      </div>

      <!-- SEKTOR 2: UPLOAD TEMPLATE SURAT RESMI -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl flex flex-col justify-between">
        <div>
          <h3 class="text-lg font-bold mb-4 text-indigo-300 flex items-center">📁 Perbarui Dokumen Perusahaan</h3>

          <?php if (session()->getFlashdata('success_dokumen')) : ?>
            <p class="text-xs text-emerald-400 mb-3 font-semibold">✨ <?= session()->getFlashdata('success_dokumen') ?></p>
          <?php endif; ?>
          <?php if (session()->getFlashdata('error_dokumen')) : ?>
            <p class="text-xs text-rose-400 mb-3 font-semibold">⚠️ <?= session()->getFlashdata('error_dokumen') ?></p>
          <?php endif; ?>

          <form action="<?= base_url('/admin/berkas/upload-dokumen') ?>" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            <?= csrf_field() ?>
            <div>
              <label class="block text-gray-400 mb-1 font-medium">Nama Surat / Template</label>
              <input type="text" name="nama_surat" placeholder="Contoh: Surat Pernyataan Aktif Bekerja" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2.5 text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-400 mb-1 font-medium">Kategori Kearsipan</label>
                <input type="text" name="kategori" placeholder="HRD / Legal / K3" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2.5 text-white focus:outline-none focus:border-indigo-500">
              </div>
              <div>
                <label class="block text-gray-400 mb-1 font-medium">File Dokumen (.PDF / .Docx)</label>
                <input type="file" name="nama_file" required class="w-full text-xs text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-600/20 file:text-indigo-300 hover:file:bg-indigo-600/40 file:cursor-pointer">
              </div>
            </div>
            <div>
              <label class="block text-gray-400 mb-1 font-medium">Deskripsi Singkat Penggunaan Surat</label>
              <textarea name="deskripsi" rows="3" placeholder="Tuliskan tujuan fungsional dari surat ini untuk panduan karyawan..." required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2.5 text-white focus:outline-none focus:border-indigo-500 leading-relaxed"></textarea>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 font-bold py-3 px-4 rounded-xl transition shadow-lg shadow-indigo-600/20 text-center block">
              Sebarkan Dokumen Baru 📦
            </button>
          </form>
        </div>
      </div>

    </div>
  </main>

</body>

</html>