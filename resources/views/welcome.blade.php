<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS App – Aplikasi Kasir Modern</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800 font-sans">

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">POS App – Aplikasi Kasir Modern dan Sederhana</h1>
            <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto">
                Kelola transaksi penjualan Anda dengan cepat, aman, dan efisien menggunakan POS App. Cocok untuk toko
                retail, kedai kopi, apotek, warung, dan bisnis lainnya.
            </p>
            <div class="space-x-4">
                <a href="{{ route('login') }}"
                    class="inline-block bg-white text-indigo-700 hover:bg-indigo-100 font-semibold py-3 px-6 rounded-lg transition">
                    Masuk Sekarang
                </a>
            </div>
        </div>
    </section>

    {{-- Fitur Section --}}
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Kenapa Memilih POS App?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <h3 class="text-xl font-semibold mb-2">Mudah Digunakan</h3>
                    <p class="text-gray-600">Antarmuka sederhana dan responsif, siapa pun bisa langsung menggunakannya
                        tanpa pelatihan khusus.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <h3 class="text-xl font-semibold mb-2">Cepat & Aman</h3>
                    <p class="text-gray-600">Pencatatan transaksi real-time dan data disimpan dengan aman di server.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <h3 class="text-xl font-semibold mb-2">Manajemen Produk & Stok</h3>
                    <p class="text-gray-600">Tambah, ubah, dan pantau stok barang dengan mudah agar operasional tetap
                        lancar.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-8 text-center text-gray-500 text-sm bg-white border-t">
        2025 – Made with ☕ by <a href="https://irfanmg.com" class="text-indigo-600 hover:underline">irfanmg.com</a>
    </footer>

</body>

</html>
