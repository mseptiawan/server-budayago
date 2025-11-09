<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Culture;

class CultureSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = 3; // gunakan ID admin1, bisa juga 4 untuk admin2

        $cultures = [
            // -----------------------------
            // Kategori Tarian
            // -----------------------------
            [
                'title' => 'Gending Sriwijaya',
                'category' => 'tarian',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Tari Gending Sriwijaya melambangkan kejayaan Sriwijaya dan sambutan hangat khas Palembang.',
                'long_description' => 'Tari Gending Sriwijaya adalah tari tradisional yang berasal dari Palembang, Sumatera Selatan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Tanggai',
                'category' => 'tarian',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Tari Tanggai melambangkan kelembutan, keanggunan, dan keramahan wanita Palembang.',
                'long_description' => 'Tari Tanggai merupakan tari penyambutan khas Palembang, Sumatera Selatan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Putri Bekhusek',
                'category' => 'tarian',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'OKU',
                'short_description' => 'Tari Putri Bekhusek menggambarkan keceriaan gadis Palembang yang sedang bermain.',
                'long_description' => 'Tari Putri Bekhusek adalah tari tradisional yang berasal dari Kabupaten Ogan Komering Ulu (OKU), Sumatera Selatan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Tepak Keraton',
                'category' => 'tarian',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Tari Tepak Keraton mencerminkan keanggunan dan kewibawaan budaya istana Palembang.',
                'long_description' => 'Tari Tepak Keraton merupakan tari tradisional dari Palembang, Sumatera Selatan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],

            // -----------------------------
            // Kategori Kuliner
            // -----------------------------
            [
                'title' => 'Pempek',
                'category' => 'kuliner',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Pempek Palembang terbuat dari ikan dan sagu, disajikan dengan kuah cuko khas asam pedas.',
                'long_description' => 'Pempek Palembang adalah makanan khas dari kota Palembang, Sumatera Selatan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Tekwan',
                'category' => 'kuliner',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Tekwan Palembang adalah sup ikan khas dengan soun, jamur, dan kuah kaldu gurih.',
                'long_description' => 'Tekwan adalah salah satu kuliner khas Palembang, Sumatera Selatan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Model',
                'category' => 'kuliner',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Model Palembang adalah pempek isi tahu yang disajikan dengan kuah kaldu udang gurih.',
                'long_description' => 'Model Palembang adalah salah satu makanan khas Sumatera Selatan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Burgo',
                'category' => 'kuliner',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Burgo Palembang berupa gulungan tepung beras tipis disiram kuah santan gurih.',
                'long_description' => 'Burgo adalah makanan khas Palembang, Sumatera Selatan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],

            // -----------------------------
            // Kategori Busana Adat
            // -----------------------------
            [
                'title' => 'Aesan Gede',
                'category' => 'busana adat',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Aesan Gede adalah busana kebesaran Palembang berwarna emas yang melambangkan kemewahan dan kejayaan Sriwijaya.',
                'long_description' => 'Aesan Gede digunakan dalam upacara pernikahan dan acara kerajaan Palembang...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Aesan Paksangko',
                'category' => 'busana adat',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Aesan Paksangko adalah busana adat Palembang bernuansa merah dan emas yang melambangkan keanggunan serta kelembutan wanita.',
                'long_description' => 'Aesan Paksangko digunakan dalam berbagai upacara adat...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Songket',
                'category' => 'busana adat',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Songket Palembang adalah kain tenun tradisional berbenang emas yang melambangkan kemewahan dan status kebangsawanan.',
                'long_description' => 'Songket Palembang dibuat secara tradisional...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Besemah',
                'category' => 'busana adat',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Pagar Alam',
                'short_description' => 'Busana Besemah berciri sederhana dan anggun, memadukan songket dengan hiasan kepala bunga.',
                'long_description' => 'Besemah dipakai untuk acara adat tertentu...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],

            // -----------------------------
            // Kategori Upacara Adat
            // -----------------------------
            [
                'title' => 'Pernikahan Palembang',
                'category' => 'upacara adat',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Pernikahan Palembang berlangsung megah dengan adat Aesan Gede, melambangkan kemuliaan dan kehormatan keluarga.',
                'long_description' => 'Pernikahan Palembang menggunakan Aesan Gede dan prosesi adat lengkap...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Sedekah Sungai',
                'category' => 'upacara adat',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Sedekah Sungai Palembang adalah tradisi syukuran masyarakat atas rezeki dan keselamatan dari sungai.',
                'long_description' => 'Sedekah Sungai dilakukan setiap tahun untuk memohon keselamatan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Ngobeng',
                'category' => 'upacara adat',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Ngobeng Palembang adalah tradisi makan bersama dalam acara adat sebagai simbol kebersamaan dan gotong royong.',
                'long_description' => 'Ngobeng biasanya dilakukan saat acara adat...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Tepung Tawar',
                'category' => 'upacara adat',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Tepung Tawar Palembang adalah ritual penyucian dan doa restu untuk keselamatan serta keberkahan.',
                'long_description' => 'Tepung Tawar digunakan untuk membersihkan dan mendoakan rumah...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],

            // -----------------------------
            // Kategori Arsitektur
            // -----------------------------
            [
                'title' => 'Rumah Limas',
                'category' => 'arsitektur',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Rumah panggung Palembang dengan atap limas dan ruang berundak filosofis.',
                'long_description' => 'Rumah Limas memiliki desain khas panggung dengan atap limas...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Rumah Ulu',
                'category' => 'arsitektur',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'OKU',
                'short_description' => 'Rumah kayu bertiang tanah khas Uluan simbol kebersamaan dan adat marga.',
                'long_description' => 'Rumah Ulu dibuat dengan kayu dan tiang tanah khas daerah Uluan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Rumah Cara Gudang',
                'category' => 'arsitektur',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Rumah panggung sederhana Palembang berbentuk pelana panjang, fungsional dan ekonomis.',
                'long_description' => 'Rumah Cara Gudang merupakan rumah panggung sederhana...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Rumah Rakit',
                'category' => 'arsitektur',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Rumah terapung di Sungai Musi Palembang, simbol adaptasi hidup masyarakat air.',
                'long_description' => 'Rumah Rakit dibangun di atas sungai sebagai tempat tinggal...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],

            // -----------------------------
            // Kategori Seni Tradisional
            // -----------------------------
            [
                'title' => 'Putri Bekhusek',
                'category' => 'seni tradisional',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Tari pergaulan khas Palembang yang melambangkan keceriaan, keanggunan.',
                'long_description' => 'Tari Putri Bekhusek sebagai tarian pergaulan...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Kain Songket',
                'category' => 'seni tradisional',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Kain tenun berbenang emas simbol kemewahan dan kebesaran budaya Palembang.',
                'long_description' => 'Songket digunakan dalam berbagai acara adat...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Dek Sangke',
                'category' => 'seni tradisional',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Palembang',
                'short_description' => 'Lagu Dek Sangke menggambarkan kisah pilu gadis Palembang yang difitnah.',
                'long_description' => 'Lagu Dek Sangke sarat pesan moral tentang kejujuran...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Alat Musik Genggong',
                'category' => 'seni tradisional',
                'province' => 'Sumatera Selatan',
                'city_or_regency' => 'Pagar Alam',
                'short_description' => 'Alat musik bambu tradisional Uluan dimainkan lewat getaran di mulut.',
                'long_description' => 'Genggong digunakan untuk hiburan dan upacara adat...',
                'image_file' => null,
                'video_file' => null,
                'virtual_tour_file' => null,
                'user_id' => $adminId,
            ],
        ];

        foreach ($cultures as $culture) {
            Culture::create($culture);
        }
    }
}
