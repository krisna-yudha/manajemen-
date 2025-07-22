<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangs = [
            [
                'kode_barang' => 'ELK001',
                'nama_barang' => 'Laptop Dell Inspiron 15',
                'deskripsi' => 'Laptop dengan spesifikasi Core i5, RAM 8GB, SSD 256GB',
                'kategori' => 'Elektronik',
                'stok' => 5,
                'stok_minimum' => 2,
                'kondisi' => 'baik',
                'lokasi_penyimpanan' => 'Rak A-01',
                'harga_sewa_per_hari' => 50000,
                'status' => 'tersedia'
            ],
            [
                'kode_barang' => 'ELK002',
                'nama_barang' => 'Proyektor Epson EB-X41',
                'deskripsi' => 'Proyektor dengan resolusi XGA, brightness 3600 lumens',
                'kategori' => 'Elektronik',
                'stok' => 3,
                'stok_minimum' => 1,
                'kondisi' => 'baik',
                'lokasi_penyimpanan' => 'Rak A-02',
                'harga_sewa_per_hari' => 75000,
                'status' => 'tersedia'
            ],
            [
                'kode_barang' => 'FUR001',
                'nama_barang' => 'Meja Kantor Executive',
                'deskripsi' => 'Meja kantor kayu mahoni ukuran 120x60cm',
                'kategori' => 'Furniture',
                'stok' => 10,
                'stok_minimum' => 3,
                'kondisi' => 'baik',
                'lokasi_penyimpanan' => 'Gudang B',
                'harga_sewa_per_hari' => 25000,
                'status' => 'tersedia'
            ],
            [
                'kode_barang' => 'FUR002',
                'nama_barang' => 'Kursi Kantor Ergonomis',
                'deskripsi' => 'Kursi kantor dengan sandaran punggung ergonomis',
                'kategori' => 'Furniture',
                'stok' => 15,
                'stok_minimum' => 5,
                'kondisi' => 'baik',
                'lokasi_penyimpanan' => 'Gudang B',
                'harga_sewa_per_hari' => 15000,
                'status' => 'tersedia'
            ],
            [
                'kode_barang' => 'KDR001',
                'nama_barang' => 'Mobil Avanza',
                'deskripsi' => 'Mobil Avanza 2020, 7 penumpang, manual',
                'kategori' => 'Kendaraan',
                'stok' => 2,
                'stok_minimum' => 1,
                'kondisi' => 'baik',
                'lokasi_penyimpanan' => 'Parkir Area A',
                'harga_sewa_per_hari' => 300000,
                'status' => 'tersedia'
            ],
            [
                'kode_barang' => 'PRL001',
                'nama_barang' => 'Generator 5000W',
                'deskripsi' => 'Generator listrik portable 5000 watt',
                'kategori' => 'Peralatan',
                'stok' => 3,
                'stok_minimum' => 1,
                'kondisi' => 'baik',
                'lokasi_penyimpanan' => 'Gudang C',
                'harga_sewa_per_hari' => 100000,
                'status' => 'tersedia'
            ],
            [
                'kode_barang' => 'PRL002',
                'nama_barang' => 'Sound System Portable',
                'deskripsi' => 'Sound system dengan microphone wireless',
                'kategori' => 'Peralatan',
                'stok' => 4,
                'stok_minimum' => 2,
                'kondisi' => 'baik',
                'lokasi_penyimpanan' => 'Rak C-01',
                'harga_sewa_per_hari' => 80000,
                'status' => 'tersedia'
            ],
            [
                'kode_barang' => 'ELK003',
                'nama_barang' => 'Camera DSLR Canon',
                'deskripsi' => 'Camera DSLR Canon EOS 800D dengan lensa kit',
                'kategori' => 'Elektronik',
                'stok' => 2,
                'stok_minimum' => 1,
                'kondisi' => 'baik',
                'lokasi_penyimpanan' => 'Rak A-03',
                'harga_sewa_per_hari' => 120000,
                'status' => 'tersedia'
            ]
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }

        $this->command->info('Sample barang created successfully!');
    }
}
