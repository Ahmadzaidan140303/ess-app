<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="<?= base_url('logo-instansi.png') ?>">
  <title>Master Karyawan - ESS Admin</title>
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

    <!-- Alerts -->
    <?php if (session()->getFlashdata('success')) : ?>
      <div class="bg-emerald-500/20 border border-emerald-500/40 text-emerald-200 text-xs p-4 rounded-2xl mb-6">
        ✨ <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
      <div class="bg-rose-500/20 border border-rose-500/40 text-rose-200 text-xs p-4 rounded-2xl mb-6">
        ⚠️ <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <div class="mb-6">
      <h2 class="text-2xl font-extrabold tracking-tight">Manajemen Database Karyawan</h2>
      <p class="text-sm text-gray-400 mt-1">Otorisasi akun internal, kendali struktural jabatan, dan penugasan kode identitas kepegawaian.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

      <!-- SEKTOR KIRI: TABEL DAFTAR KARYAWAN (2 Kolom Grid) -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl lg:col-span-2 shadow-xl">
        <h3 class="text-md font-bold mb-4 text-gray-300">👥 Anggota Terdaftar</h3>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead>
              <tr class="border-b border-white/10 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                <th class="pb-3">Karyawan</th>
                <th class="pb-3">NIP / Jabatan</th>
                <th class="pb-3">Kontak / Akun</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
              <?php foreach ($daftar_karyawan as $k) : ?>
                <tr class="hover:bg-white/[0.01]">
                  <td class="py-4 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center font-bold text-white uppercase overflow-hidden">
                      <?php if ($k['foto'] && $k['foto'] !== 'default.png') : ?>
                        <img src="<?= base_url('uploads/profil/' . esc($k['foto'])) ?>" class="w-full h-full object-cover">
                      <?php else : ?>
                        <?= substr(esc($k['nama_lengkap']), 0, 1) ?>
                      <?php endif; ?>
                    </div>
                    <div>
                      <p class="font-bold text-gray-200"><?= esc($k['nama_lengkap']) ?></p>
                      <p class="text-[10px] text-gray-500">User ID: <?= $k['user_id'] ?></p>
                    </div>
                  </td>
                  <td class="py-4">
                    <p class="font-medium text-gray-300"><?= esc($k['nip']) ?></p>
                    <p class="text-xs text-rose-400 font-semibold"><?= esc($k['jabatan']) ?></p>
                  </td>
                  <td class="py-4 text-xs">
                    <p class="text-gray-300">📞 <?= esc($k['telepon']) ?></p>
                    <p class="text-gray-400 font-mono mt-0.5"><?= esc($k['email']) ?></p>
                  </td>
                  <td class="py-4 text-center">
                    <button type="button"
                      onclick="openEditModal(<?= htmlspecialchars(json_encode($k)) ?>)"
                      class="bg-amber-500/20 hover:bg-amber-500 text-amber-300 hover:text-black border border-amber-500/30 font-semibold py-1 px-3 rounded-xl text-xs transition">
                      ✏️ Edit
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- SEKTOR KANAN: FORM REGISTRASI KARYAWAN BARU (1 Kolom Grid) -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl shadow-xl">
        <h3 class="text-md font-bold mb-4 text-rose-300">➕ Registrasi Karyawan Baru</h3>

        <form action="<?= base_url('/admin/karyawan/store') ?>" method="POST" class="space-y-4 text-xs">
          <?= csrf_field() ?>

          <!-- Kredensial Akun -->
          <div class="border-b border-white/10 pb-3 mb-2">
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-3">1. Akses Log Masuk</p>
            <!-- <div class="space-y-3">
              <div>
                <label class="block text-gray-400 mb-1">Username Unik</label>
                <input type="text" name="username" placeholder="Contoh: zaidan_ahmad" required value="<?= old('username') ?>"
                  class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-rose-500">
              </div>
              <div> -->
            <label class="block text-gray-400 mb-1">Email Perusahaan</label>
            <input type="email" name="email" placeholder="karyawan@company.com" required value="<?= old('email') ?>"
              class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-rose-500">
          </div>
          <div>
            <label class="block text-gray-400 mb-1">Kata Sandi Awal</label>
            <input type="password" name="password" placeholder="Minimal 6 Karakter" required
              class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-rose-500">
          </div>
      </div>
    </div>

    <!-- Profil Biodata -->
    <div>
      <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-3">2. Identitas Struktur</p>
      <div class="space-y-3">
        <div>
          <label class="block text-gray-400 mb-1">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" placeholder="Nama tanpa singkatan" required value="<?= old('nama_lengkap') ?>"
            class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-rose-500">
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-gray-400 mb-1">NIP</label>
            <input type="text" name="nip" placeholder="Nomor Induk" required value="<?= old('nip') ?>"
              class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-rose-500">
          </div>
          <div>
            <label class="block text-gray-400 mb-1">Jabatan Resmi</label>
            <input type="text" name="jabatan" placeholder="Contoh: IT Support" required value="<?= old('jabatan') ?>"
              class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-rose-500">
          </div>
        </div>
        <div>
          <label class="block text-gray-400 mb-1">No. WhatsApp/Telepon (Opsional)</label>
          <input type="text" name="telepon" placeholder="0812xxxxx" value="<?= old('telepon') ?>"
            class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-rose-500">
        </div>
      </div>
    </div>

    <button type="submit" class="w-full bg-gradient-to-r from-rose-600 to-amber-600 hover:from-rose-500 hover:to-amber-500 font-bold py-2.5 px-4 rounded-xl transition shadow-lg shadow-rose-600/10 text-center mt-2">
      Simpan & Daftarkan Karyawan 👥
    </button>
    </form>
    </div>

    </div>

  </main>

  <!-- MODAL Edit Karyawan -->
  <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#11161d] border border-white/10 w-full max-w-md rounded-3xl p-6 shadow-2xl animate-fade-in text-xs">
      <div class="flex justify-between items-center mb-4 border-b border-white/10 pb-2">
        <h3 class="text-md font-bold text-amber-400">✏️ Ubah Data Karyawan</h3>
        <button onclick="closeEditModal()" class="text-gray-400 hover:text-white text-lg font-bold">&times;</button>
      </div>

      <form id="editForm" action="" method="POST" class="space-y-4">
        <?= csrf_field() ?>
        <input type="hidden" name="user_id" id="edit_user_id">

        <div>
          <label class="block text-gray-400 mb-1">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" id="edit_nama" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-amber-500">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-gray-400 mb-1">NIP</label>
            <input type="text" name="nip" id="edit_nip" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-amber-500">
          </div>
          <div>
            <label class="block text-gray-400 mb-1">Jabatan</label>
            <input type="text" name="jabatan" id="edit_jabatan" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-amber-500">
          </div>
        </div>

        <div>
          <label class="block text-gray-400 mb-1">Email Perusahaan</label>
          <input type="email" name="email" id="edit_email" required class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-amber-500">
        </div>

        <div>
          <label class="block text-gray-400 mb-1">No. Telepon / WhatsApp</label>
          <input type="text" name="telepon" id="edit_telepon" class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-amber-500">
        </div>

        <div>
          <label class="block text-gray-400 mb-1">Alamat Rumah</label>
          <textarea name="alamat" id="edit_alamat" rows="2" class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-amber-500"></textarea>
        </div>

        <div class="bg-amber-500/10 border border-amber-500/20 p-2 rounded-xl">
          <label class="block text-amber-300 font-semibold mb-0.5">Ubah Password (Opsional)</label>
          <input type="password" name="password" placeholder="Isi hanya jika ingin ganti password" class="w-full bg-black/40 border border-white/10 rounded-xl px-3 py-1.5 text-white focus:outline-none focus:border-amber-500 text-[11px]">
        </div>

        <div class="flex space-x-3 pt-2">
          <button type="button" onclick="closeEditModal()" class="w-1/3 bg-white/5 hover:bg-white/10 font-bold py-2.5 rounded-xl transition text-center text-gray-300">Batal</button>
          <button type="submit" class="w-2/3 bg-amber-500 hover:bg-amber-400 text-black font-bold py-2.5 rounded-xl transition shadow-lg shadow-amber-500/20 text-center">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Edit Karyawan -->
  <script>
    function openEditModal(karyawan) {
      // Set action form URL secara dinamis dengan ID Profil Karyawan
      document.getElementById('editForm').action = "<?= base_url('/admin/karyawan/update/') ?>/" + karyawan.id;

      // Isi field input modal dengan data dari baris tabel yang dipilih
      document.getElementById('edit_user_id').value = karyawan.user_id;
      document.getElementById('edit_nama').value = karyawan.nama_lengkap;
      document.getElementById('edit_nip').value = karyawan.nip;
      document.getElementById('edit_jabatan').value = karyawan.jabatan;
      document.getElementById('edit_email').value = karyawan.email;
      document.getElementById('edit_telepon').value = karyawan.telepon;
      document.getElementById('edit_alamat').value = karyawan.alamat;

      // Tampilkan modal dengan menghapus class 'hidden'
      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      // Sembunyikan kembali modal
      document.getElementById('editModal').classList.add('hidden');
    }
  </script>
</body>

</html>