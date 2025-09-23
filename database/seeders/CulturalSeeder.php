<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cultural;
use App\Models\CulturalGallery;

class CulturalSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh update untuk 2 data itu
        Cultural::query()->update(['has_map' => 1]);
        Cultural::whereIn('id', [3,22])->update(['has_map' => 0]);

        // Data utama Semua Cultural
        $candi = Cultural::updateOrCreate(
            ['name' => 'Candi Cangkuang'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Desa Cangkuang, Kecamatan Leles, Garut',
            'image' => 'candi-cangkuang.jpg'
        ]);

        $domba = Cultural::updateOrCreate(
            ['name' => 'Adu Domba'],
            ['category' => 'Kesenian',
            'location' => 'Diseluruh penjuru kota Garut',
            'image' => 'dombagarut.jpg'
        ]);

        $makamgodog = Cultural::updateOrCreate(
            ['name' => 'Makam Keramat Godog'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Desa Godog, Kecaamatan Karangpawitan, Garut',
            'image' => 'makamgodog.jpg'
        ]);

        $makamnuryayi = Cultural::updateOrCreate(
            ['name' => 'Makam Bayinuryayi'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Desa Karangmulya, Kecamatan Karangpawitan, Garut',
            'image' => 'makamnuryayi.jpeg'
        ]);

        $makamcipancar = Cultural::updateOrCreate(
            ['name' => 'Makam Sunan Cipancar'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Kecamatan Balubur Limbangan, Garut',
            'image' => 'makamcipancar.jpg'
        ]);

        $makamremenggong = Cultural::updateOrCreate(
            ['name' => 'Makam Sunan Remenggong'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Kecamatan Limbangan, Garut',
            'image' => 'makamremenggong.jpg'
        ]);

        $makamarief = Cultural::updateOrCreate(
            ['name' => 'Makam Dalem Arief Muhammad'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Desa Cangkuang, Kecamatan Leles, Garut',
            'image' => 'makamarief.jpg'
        ]);

        $makamfatah = Cultural::updateOrCreate(
            ['name' => 'Makam Syech Fatah Rohmatulloh'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Kecamatan Samarang, Garut',
            'image' => 'makamfatah.jpg'
        ]);

        $makampapak = Cultural::updateOrCreate(
            ['name' => 'Makam Sunan Papak'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Desa Cinunuk, Kecamatan Wanaraja, Garut',
            'image' => 'makampapak.jpg'
        ]);

        $makamnagara = Cultural::updateOrCreate(
            ['name' => 'Makam Kuno Gunung Nagara'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Kecamatan Cisompet, Garut',
            'image' => 'makamnagara.jpg'
        ]);

        $situscimareme = Cultural::updateOrCreate(
            ['name' => 'Situs Cimareme'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Kecamatan Banyuresmi, Garut',
            'image' => 'situscimareme.jpg'
        ]);

        $masjidsyuro = Cultural::updateOrCreate(
            ['name' => 'Masjid Asy-Syuro Cipari'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Desa Cipari, Kecamatan Pangantikan, Garut',
            'image' => 'masjidsyuro.jpg'
        ]);

        $situsciburuy = Cultural::updateOrCreate(
            ['name' => 'Situs Kabuyutan Ciburuy'],
            ['category' => 'Bangunan Bersejarah, Wisata Budaya',
            'location' => 'Desa Ciburuy, Kecamatan Bayongbong, Garut',
            'image' => 'situsciburuy.jpg'
        ]);

        $kampungbali = Cultural::updateOrCreate(
            ['name' => 'Kampung Bali'],
            ['category' => 'Wisata Budaya',
            'location' => 'Desa Cibunar, Kecamatan Cibatu, Garut',
            'image' => 'kampungbali.jpg'
        ]);

        $kampungdukuh = Cultural::updateOrCreate(
            ['name' => 'Kampung Dukuh'],
            ['category' => 'Wisata Budaya',
            'location' => 'Kecamatan Cikelet, Garut',
            'image' => 'kampungdukuh.jpg'
        ]);

        $kampungpulo = Cultural::updateOrCreate(
            ['name' => 'Kampung Pulo'],
            ['category' => 'Wisata Budaya',
            'location' => 'Kecamatan Leles, Garut',
            'image' => 'kampungpulo.jpg'
        ]);

        $museumcangkuang = Cultural::updateOrCreate(
            ['name' => 'Museum Cangkuang'],
            ['category' => 'Museum',
            'location' => 'Desa Cangkuang, Kecamatan Leles, Garut',
            'image' => 'museumcangkuang.jpg'
        ]);

        $museumadiwijaya = Cultural::updateOrCreate(
            ['name' => 'Museum R.A.A. Adiwidjaja'],
            ['category' => 'Museum',
            'location' => 'Desa Jayaraga, Kecamatan Tarogong Kidul, Garut',
            'image' => 'museumadiwijaya.jpg'
        ]);

        $museumkencana = Cultural::updateOrCreate(
            ['name' => 'Museum Graha Liman Kencana'],
            ['category' => 'Museum',
            'location' => 'Desa Cibunar, Kecamatan Cibatu, Garut',
            'image' => 'museumkencana.jpg'
        ]);

        $museumcinunuk = Cultural::updateOrCreate(
            ['name' => 'Museum Cinunuk'],
            ['category' => 'Museum',
            'location' => 'Desa Cinunuk, Kecamatan Wanaraja, Garut',
            'image' => 'museumcinunuk.jpg'
        ]);

        $stasiuncibatu = Cultural::updateOrCreate(
            ['name' => 'Stasiun Kereta Api Cibatu'],
            ['category' => 'Bangunan Bersejarah',
            'location' => 'Kecamatan Cibatu, Garut',
            'image' => 'stasiuncibatu.jpg'
        ]);

        $batikgarut = Cultural::updateOrCreate(
            ['name' => 'Batik Garutan'],
            ['category' => 'Produk Seni & Tradisi',
            'location' => 'Diseluruh Kabupaten Garut',
            'image' => 'batikgarutan.jpg'
        ]);

        // Gallery untuk Batik Garutan
        CulturalGallery::firstOrCreate([
            'cultural_id' => $batikgarut->id,
            'image_path' => 'batikgarutan2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $batikgarut->id,
            'image_path' => 'batikgarutan3.jpg',
        ]);

        // Gallery untuk Stasiun Cibatu
        CulturalGallery::firstOrCreate([
            'cultural_id' => $stasiuncibatu->id,
            'image_path' => 'stasiuncibatu2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $stasiuncibatu->id,
            'image_path' => 'stasiuncibatu3.jpg',
        ]);

        // Gallery untuk Museum Cinunuk
        CulturalGallery::firstOrCreate([
            'cultural_id' => $museumcinunuk->id,
            'image_path' => 'museumcinunuk2.jpg',
        ]);

        // Gallery untuk Museum Graha Liman Kencana
        CulturalGallery::firstOrCreate([
            'cultural_id' => $museumkencana->id,
            'image_path' => 'museumkencana2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $museumkencana->id,
            'image_path' => 'museumkencana3.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $museumkencana->id,
            'image_path' => 'museumkencana4.jpg',
        ]);

         // Gallery untuk Museum Adiwijaya
        CulturalGallery::firstOrCreate([
            'cultural_id' => $museumadiwijaya->id,
            'image_path' => 'museumadiwijaya2.jpeg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $museumadiwijaya->id,
            'image_path' => 'museumadiwijaya3.jpg',
        ]);

        // Gallery untuk Museum Cangkuang
        CulturalGallery::firstOrCreate([
            'cultural_id' => $museumcangkuang->id,
            'image_path' => 'museumcangkuang2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $museumcangkuang->id,
            'image_path' => 'museumcangkuang3.jpg',
        ]);

        // Gallery untuk Kampung Pulo
        CulturalGallery::firstOrCreate([
            'cultural_id' => $kampungpulo->id,
            'image_path' => 'kampungpulo2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $kampungpulo->id,
            'image_path' => 'kampungpulo3.jpeg',
        ]);

        // Gallery untuk Kampung Dukuh
        CulturalGallery::firstOrCreate([
            'cultural_id' => $kampungdukuh->id,
            'image_path' => 'kampungdukuh2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $kampungdukuh->id,
            'image_path' => 'kampungdukuh3.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $kampungdukuh->id,
            'image_path' => 'kampungdukuh4.jpg',
        ]);

        // Gallery untuk Kampung Bali
        CulturalGallery::firstOrCreate([
            'cultural_id' => $kampungbali->id,
            'image_path' => 'kampungbali2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $kampungbali->id,
            'image_path' => 'kampungbali3.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $kampungbali->id,
            'image_path' => 'kampungbali4.jpg',
        ]);

        // Gallery untuk Situs Ciburuy
        CulturalGallery::firstOrCreate([
            'cultural_id' => $situsciburuy->id,
            'image_path' => 'situsciburuy2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $situsciburuy->id,
            'image_path' => 'situsciburuy3.jpeg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $situsciburuy->id,
            'image_path' => 'situsciburuy4.jpg',
        ]);

        // Gallery untuk Masjid Asy-Syuro Cipari
        CulturalGallery::firstOrCreate([
            'cultural_id' => $masjidsyuro->id,
            'image_path' => 'masjidsyuro2.jpeg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $masjidsyuro->id,
            'image_path' => 'masjidsyuro3.jpg',
        ]);

        // Gallery untuk Situs Cimareme
        CulturalGallery::firstOrCreate([
            'cultural_id' => $situscimareme->id,
            'image_path' => 'situscimareme2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $situscimareme->id,
            'image_path' => 'situscimareme3.png',
        ]);

        // Gallery untuk Makam Kuno Gunung Nagara
        CulturalGallery::firstOrCreate([
            'cultural_id' => $makamnagara->id,
            'image_path' => 'makamnagara2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $makamnagara->id,
            'image_path' => 'makamnagara3.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $makamnagara->id,
            'image_path' => 'makamnagara4.jpg',
        ]);

        // Gallery untuk Makam Papak
        CulturalGallery::firstOrCreate([
            'cultural_id' => $makampapak->id,
            'image_path' => 'makampapak2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $makampapak->id,
            'image_path' => 'makampapak3.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $makampapak->id,
            'image_path' => 'makampapak4.jpg',
        ]);

        // Gallery untuk Makam Fatah
        CulturalGallery::firstOrCreate([
            'cultural_id' => $makamfatah->id,
            'image_path' => 'makamfatah2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $makamfatah->id,
            'image_path' => 'makamfatah3.jpg',
        ]);

        // Gallery untuk Makam Dalem Arief Muhammad
        CulturalGallery::firstOrCreate([
            'cultural_id' => $makamarief->id,
            'image_path' => 'makamarief2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $makamarief->id,
            'image_path' => 'makamarief3.jpg',
        ]);

        // Tambahkan galeri untuk Candi
        CulturalGallery::firstOrCreate([
            'cultural_id' => $candi->id,
            'image_path' => 'candi2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
            'cultural_id' => $candi->id,
            'image_path' => 'candi3.jpg',
        ]);
        
        //Gallery untuk Adu Domba 
        CulturalGallery::firstOrCreate([
        'cultural_id' => $domba->id,
        'image_path' => 'domba2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
        'cultural_id' => $domba->id,
        'image_path' => 'domba3.jpeg',
        ]);

        // Gallery untuk Makam Godog
        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamgodog->id,
        'image_path' => 'makamgodog1.jpg',
        ]);

        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamgodog->id,
        'image_path' => 'makamgodog2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamgodog->id,
        'image_path' => 'makamgodog3.jpg',
        ]);

        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamgodog->id,
        'image_path' => 'makamgodog4.jpg',
        ]);

        // Gallery untuk Makam Bayinuryayi
        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamnuryayi->id,
        'image_path' => 'makamnuryayi2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamnuryayi->id,
        'image_path' => 'makamnuryayi3.jpg',
        ]);

        // Gallery untuk Makam Sunan Cipancar
        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamcipancar->id,
        'image_path' => 'makamcipancar2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamcipancar->id,
        'image_path' => 'makamcipancar3.jpg',
        ]);

         CulturalGallery::firstOrCreate([
        'cultural_id' => $makamcipancar->id,
        'image_path' => 'makamcipancar4.jpg',
        ]);

        // Gallery untuk Makam Sunan Remenggong
        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamremenggong->id,
        'image_path' => 'makamremenggong2.jpg',
        ]);

        CulturalGallery::firstOrCreate([
        'cultural_id' => $makamremenggong->id,
        'image_path' => 'makamremenggong3.jpg',
        ]);
    }
}
