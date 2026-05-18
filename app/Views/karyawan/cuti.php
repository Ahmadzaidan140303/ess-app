<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="<?= base_url('logo-instansi.png') ?>">
  <title>Permohonan Cuti - ESS Portal</title>
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

  <main class="container mx-auto mt-8 px-4 max-w-6xl pb-12">

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl h-fit">
        <h3 class="text-lg font-bold mb-4 bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">Formulir Pengajuan Cuti</h3>

        <form action="<?= base_url('/karyawan/cuti/store') ?>" method="POST">
          <?= csrf_field() ?>

          <div class="mb-4">
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Jenis Cuti</label>
            <select name="jenis_cuti" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500">
              <option value="tahunan" class="bg-[#161b22]">Cuti Tahunan</option>
              <option value="sakit" class="bg-[#161b22]">Cuti Sakit</option>
              <option value="melahirkan" class="bg-[#161b22]">Cuti Melahirkan</option>
              <option value="lainnya" class="bg-[#161b22]">Keperluan Mendesak</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500">
          </div>

          <div class="mb-4">
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500">
          </div>

          <div class="mb-5">
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Alasan Cuti</label>
            <textarea name="alasan" rows="4" required placeholder="Tuliskan alasan detail pengajuan cuti..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-purple-500"></textarea>
          </div>

          <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-3 px-4 rounded-xl transition duration-300 shadow-lg shadow-indigo-600/30">
            Kirim Permohonan
          </button>
        </form>
      </div>

      <div class="lg:col-span-2 bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl">
        <h3 class="text-lg font-bold mb-4 text-gray-200">Riwayat Pengajuan Cuti</h3>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="border-b border-white/10 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                <th class="pb-3">Jenis</th>
                <th class="pb-3">Durasi Tanggal</th>
                <th class="pb-3">Alasan</th>
                <th class="pb-3 text-center">Status</th>
              </tr>
            </thead>
            <tbody class="text-sm divide-y divide-white/5">
              <?php if (empty($riwayat_cuti)) : ?>
                <tr>
                  <td colspan="4" class="py-8 text-center text-gray-500">Belum ada riwayat pengajuan cuti.</td>
                </tr>
              <?php else : ?>
                <?php foreach ($riwayat_cuti as $c) : ?>
                  <tr>
                    <td class="py-4 font-medium capitalize text-purple-300"><?= esc($c['jenis_cuti']) ?></td>
                    <td class="py-4 text-xs text-gray-300">
                      <?= date('d M Y', strtotime($c['tanggal_mulai'])) ?> s/d <br>
                      <?= date('d M Y', strtotime($c['tanggal_selesai'])) ?>
                    </td>
                    <td class="py-4 text-xs text-gray-400 max-w-xs truncate" title="<?= esc($c['alasan']) ?>">
                      <?= esc($c['alasan']) ?>
                      <?php if (!empty($c['keterangan_admin'])) : ?>
                        <p class="text-[11px] text-red-400 italic mt-0.5">Note: <?= esc($c['keterangan_admin']) ?></p>
                      <?php endif; ?>
                    </td>
                    <td class="py-4 text-center">
                      <?php if ($c['status'] == 'pending') : ?>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-amber-500/20 text-amber-300 border border-amber-500/30">Pending</span>
                      <?php elseif ($c['status'] == 'disetujui') : ?>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Disetujui</span>
                      <?php else : ?>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-red-500/20 text-red-300 border border-red-500/30">Ditolak</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </main>

</body>

</html>