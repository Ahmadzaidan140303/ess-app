<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="<?= base_url('logo-instansi.png') ?>">
  <title>Slip Gaji Bulanan - ESS Portal</title>
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

    <div class="mb-6">
      <h2 class="text-2xl font-extrabold tracking-tight">Riwayat Slip Gaji</h2>
      <p class="text-sm text-gray-400 mt-1">Lihat komponen dan unduh berkas resmi slip gaji bulanan Anda.</p>
    </div>

    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl shadow-xl">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-white/10 text-xs font-semibold text-gray-400 uppercase tracking-wider">
              <th class="pb-3">Periode</th>
              <th class="pb-3 text-right">Gaji Pokok</th>
              <th class="pb-3 text-right">Tunjangan</th>
              <th class="pb-3 text-right">Potongan</th>
              <th class="pb-3 text-right">Total Diterima</th>
              <th class="pb-3 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-sm divide-y divide-white/5">
            <?php if (empty($riwayat_gaji)) : ?>
              <tr>
                <td colspan="6" class="py-8 text-center text-gray-500">Belum ada data slip gaji yang diterbitkan oleh HRD.</td>
              </tr>
            <?php else : ?>
              <?php foreach ($riwayat_gaji as $gaji) : ?>
                <tr class="hover:bg-white/[0.02] transition">
                  <td class="py-4 font-bold text-purple-300">
                    <?= esc($gaji['bulan']) ?> <?= esc($gaji['tahun']) ?>
                  </td>
                  <td class="py-4 text-right text-gray-300">
                    Rp <?= number_format($gaji['gaji_pokok'], 0, ',', '.') ?>
                  </td>
                  <td class="py-4 text-right text-emerald-400">
                    + Rp <?= number_format($gaji['tunjangan'], 0, ',', '.') ?>
                  </td>
                  <td class="py-4 text-right text-red-400">
                    - Rp <?= number_format($gaji['potongan'], 0, ',', '.') ?>
                  </td>
                  <td class="py-4 text-right font-extrabold text-indigo-300">
                    Rp <?= number_format($gaji['total_diterima'], 0, ',', '.') ?>
                  </td>
                  <td class="py-4 text-center">
                    <?php if (!empty($gaji['file_pdf'])) : ?>
                      <a href="<?= base_url('uploads/slip/' . $gaji['file_pdf']) ?>" target="_blank"
                        class="inline-block bg-purple-600/30 hover:bg-purple-600 border border-purple-500/40 px-3 py-1.5 rounded-xl text-xs font-semibold transition">
                        📥 Unduh PDF
                      </a>
                    <?php else : ?>
                      <span class="text-xs text-gray-500 italic">File tidak tersedia</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6 p-4 bg-indigo-950/30 border border-indigo-500/20 rounded-2xl flex items-start space-x-3">
      <span class="text-lg">💡</span>
      <p class="text-xs text-gray-400 leading-relaxed">
        <strong class="text-gray-300 block mb-0.5">Pemberitahuan:</strong>
        Slip gaji otomatis diterbitkan oleh bagian Finance & HRD setiap tanggal 25 setiap bulannya. Jika terdapat ketidaksesuaian nominal tunjangan atau potongan absen, silakan hubungi tim HRD korporat.
      </p>
    </div>

  </main>

</body>

</html>