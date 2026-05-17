<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - ESS Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Desain Background Mesh Gradient Abstrak & Halus */
    .mesh-gradient {
      background-color: #0d1117;
      background-image:
        radial-gradient(at 10% 20%, hsla(242, 61%, 15%, 1) 0px, transparent 50%),
        radial-gradient(at 90% 10%, hsla(292, 59%, 17%, 1) 0px, transparent 50%),
        radial-gradient(at 50% 80%, hsla(190, 68%, 14%, 1) 0px, transparent 50%);
    }
  </style>
</head>

<body class="mesh-gradient min-h-screen flex items-center justify-center p-4">

  <!-- Card Login Menggunakan Efek Glassmorphism (Kaca) -->
  <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl w-full max-w-md shadow-2xl">

    <!-- Header Text -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-extrabold text-white tracking-wider">ESS PORTAL</h1>
      <p class="text-sm text-gray-400 mt-1">Employee Self-Service System</p>
    </div>

    <!-- Alert Notifikasi Error -->
    <?php if (session()->getFlashdata('error')) : ?>
      <div class="bg-red-500/20 border border-red-500/50 text-red-200 text-sm p-3 rounded-xl mb-5 text-center">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <!-- Form Input -->
    <form action="<?= base_url('/login/process') ?>" method="POST" autocomplete="off">
      <?= csrf_field() ?> <!-- Fitur Keamanan Token CI 4 -->

      <!-- Input NIP -->
      <div class="mb-5">
        <label for="nip" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">NIP (Nomor Induk Pegawai)</label>
        <input type="text" id="nip" name="nip" required placeholder="Masukkan NIP Anda"
          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition duration-200">
      </div>

      <!-- Input Password -->
      <div class="mb-6">
        <label for="password" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Password</label>
        <input type="password" id="password" name="password" required placeholder="••••••••"
          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition duration-200">
      </div>

      <!-- Tombol Submit -->
      <button type="submit"
        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-3 px-4 rounded-xl transition duration-300 shadow-lg shadow-indigo-600/30 transform active:scale-[0.98]">
        Masuk ke Sistem
      </button>
    </form>

    <!-- Footer Card -->
    <div class="mt-8 text-center">
      <p class="text-xs text-gray-500">&copy; <?= date('Y') ?> - IT Department. All rights reserved.</p>
    </div>
  </div>

</body>

</html>