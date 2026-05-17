<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Cuti Karyawan - ESS Admin</title>
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

  <nav class="bg-white/5 backdrop-blur-xl border-b border-white/10 px-6 py-4 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <a href="<?= base_url('/admin/dashboard') ?>" class="text-2xl font-black tracking-wider bg-gradient-to-r from-rose-400 to-amber-400 bg-clip-text text-transparent">ESS ADMIN</a>
      </div>
      <div class="flex items-center space-x-4">
        <a href="<?= base_url('/admin/dashboard') ?>" class="text-xs font-semibold text-gray-400 hover:text-white transition">Kembali ke Kontrol Panel</a>
      </div>
    </div>
  </nav>

  <main class="container mx-auto mt-8 px-4 max-w-6xl pb-12">

    <?php if (session()->getFlashdata('success')) : ?>
      <div class="bg-emerald-500/20 border border-emerald-500/40 text-emerald-200 text-sm p-4 rounded-2xl mb-6">
        ✨ <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <div class="mb-6">
      <h2 class="text-2xl font-extrabold tracking-tight">Daftar Permohonan Cuti Karyawan</h2>
      <p class="text-sm text-gray-400 mt-1">Tinjau, setujui, atau berikan catatan penolakan terhadap pengajuan cuti masuk.</p>
    </div>

    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl shadow-xl">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-white/10 text-xs font-semibold text-gray-400 uppercase tracking-wider">
              <th class="pb-3">Karyawan</th>
              <th class="pb-3">Jenis</th>
              <th class="pb-3">Rentang Tanggal</th>
              <th class="pb-3">Alasan Karyawan</th>
              <th class="pb-3 text-center">Status</th>
              <th class="pb-3 text-center">Tindakan / Log</th>
            </tr>
          </thead>
          <tbody class="text-sm divide-y divide-white/5ada">
            <?php if (empty($daftar_cuti)) : ?>
              <tr>
                <td colspan="6" class="py-8 text-center text-gray-500">Belum ada riwayat pengajuan cuti masuk dari karyawan.</td>
              </tr>
            <?php else : ?>
              <?php foreach ($daftar_cuti as $c) : ?>
                <tr class="hover:bg-white/[0.01] transition">
                  <td class="py-4">
                    <p class="font-bold text-gray-200"><?= esc($c['nama_lengkap']) ?></p>
                    <p class="text-xs text-gray-400"><?= esc($c['jabatan']) ?></p>
                  </td>
                  <td class="py-4 font-medium capitalize text-amber-300"><?= esc($c['jenis_cuti']) ?></td>
                  <td class="py-4 text-xs text-gray-300">
                    <?= date('d M Y', strtotime($c['tanggal_mulai'])) ?> <br> s/d <br>
                    <?= date('d M Y', strtotime($c['tanggal_selesai'])) ?>
                  </td>
                  <td class="py-4 text-xs text-gray-400 max-w-xs whitespace-normal leading-relaxed">
                    <?= esc($c['alasan']) ?>
                  </td>
                  <td class="py-4 text-center">
                    <?php if ($c['status'] === 'pending') : ?>
                      <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-amber-500/20 text-amber-300 border border-amber-500/30">Pending</span>
                    <?php elseif ($c['status'] === 'disetujui') : ?>
                      <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Disetujui</span>
                    <?php else : ?>
                      <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-rose-500/20 text-rose-300 border border-rose-500/30">Ditolak</span>
                    <?php endif; ?>
                  </td>
                  <td class="py-4 text-center">
                    <?php if ($c['status'] === 'pending') : ?>
                      <div class="flex items-center justify-center space-x-2">
                        <a href="<?= base_url('/admin/cuti/approve/' . $c['id']) ?>"
                          class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-1.5 px-3 rounded-xl text-xs transition shadow-md shadow-emerald-600/20">
                          ✓ Setujui
                        </a>

                        <form action="<?= base_url('/admin/cuti/reject/' . $c['id']) ?>" method="POST" class="inline flex items-center space-x-1">
                          <?= csrf_field() ?>
                          <input type="text" name="keterangan_admin" placeholder="Alasan tolak..." required
                            class="bg-black/40 border border-white/10 rounded-xl px-2 py-1 text-xs text-white focus:outline-none focus:border-rose-500 w-28 placeholder-gray-600">
                          <button type="submit" class="bg-rose-600 hover:bg-rose-500 text-white font-bold py-1.5 px-2 rounded-xl text-xs transition">
                            ✕
                          </button>
                        </form>
                      </div>
                    <?php else : ?>
                      <p class="text-xs text-gray-500 italic max-w-xs mx-auto">
                        <?= esc($c['keterangan_admin']) ?>
                      </p>
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