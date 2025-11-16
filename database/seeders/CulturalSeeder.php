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
            'description' => 'Situs Candi Cangkuang terletak di Desa Cangkuang, Kecamatan Leles, Kabupaten Garut. Candi ini menjadi satu-satunya peninggalan bercorak Hindu di wilayah Garut dan salah satu yang tertua di Jawa Barat. Lokasinya unik karena berada di tengah Situ Cangkuang, sebuah danau alami yang menambah daya tarik wisata sejarah sekaligus alam.',
            'history' => 'Candi Cangkuang diperkirakan dibangun pada abad ke-8 Masehi sebagai tempat pemujaan Dewa Siwa. Penemuan candi ini pada tahun 1966 menjadi tonggak penting dalam sejarah arkeologi Indonesia, karena memperlihatkan pengaruh Hindu di Tatar Sunda. Di sekitar candi juga ditemukan makam Embah Dalem Arief Muhammad, seorang ulama penyebar Islam di daerah tersebut, sehingga situs ini memperlihatkan peralihan budaya Hindu ke Islam di Garut.',
            'nowaday' => 'Candi Cangkuang kini menjadi destinasi wisata andalan Kabupaten Garut. Akses menuju lokasi harus menyeberangi Situ Cangkuang dengan rakit bambu, yang justru menambah pengalaman unik bagi wisatawan. Area candi terawat baik, dilengkapi dengan museum kecil yang menyimpan artefak hasil ekskavasi.',
            'cult_now' => 'Warga sekitar masih menjaga tradisi ziarah ke makam Embah Dalem Arief Muhammad yang berada di kompleks situs. Selain itu, masyarakat setempat sering mengadakan kegiatan budaya seperti helaran atau doa bersama di sekitar candi dan situ. Kehidupan adat di Kampung Pulo yang masih mempertahankan tradisi Sunda Islami juga menjadi bagian tak terpisahkan dari kawasan ini.',
            'location' => 'Desa Cangkuang, Kecamatan Leles, Garut',
            'image' => 'candi-cangkuang.jpg'
        ]);

        $domba = Cultural::updateOrCreate(
            ['name' => 'Adu Domba'],
            ['category' => 'Kesenian',
            'description' => 'Adu Domba Garut adalah seni ketangkasan yang mempertandingkan dua ekor domba jantan Garut dalam satu arena. Penilaian tidak hanya didasarkan pada kekuatan domba, tetapi juga pada keindahan tanduk, kesehatan, dan keberaniannya. Acara ini sering diiringi dengan musik pencak silat dan sorak-sorai penonton.',
            'history' => 'Tradisi ini berawal sekitar abad ke-18, diperkenalkan oleh Bupati Garut saat itu, Raden Adipati Aria Wiratanudatar VI. Beliau terkesan dengan kekuatan dan ketangkasan domba-domba dari daerah Limbangan. Awalnya, adu domba diadakan sebagai hiburan dan seleksi bibit unggul. Seiring waktu, tradisi ini berkembang menjadi bagian dari perayaan hari besar dan acara syukuran.',
            'nowaday' => 'Adu Domba Garut masih sangat populer hingga kini. Himpunan Peternak Domba dan Kambing Indonesia (HPDKI) secara rutin menyelenggarakan kontes ketangkasan domba di berbagai tingkatan, dari lokal hingga nasional. Meskipun ada beberapa kontroversi terkait kesejahteraan hewan, para peternak dan komunitas terus berupaya menerapkan aturan yang lebih manusiawi dalam setiap pertandingannya. Tradisi ini menjadi ikon agrowisata Garut.',
            'cult_now' => 'Adu Domba bukan sekadar tontonan, tetapi juga ajang silaturahmi antar peternak dan komunitas. Terdapat ikatan sosial yang kuat di antara para pemilik domba. Sebelum pertandingan, seringkali diadakan ritual khusus seperti memandikan domba dengan air kembang dan memberikan doa-doa. Kemenangan dalam kontes adu domba membawa prestise dan kebanggaan bagi pemiliknya, serta meningkatkan nilai jual domba tersebut.',
            'location' => 'Diseluruh penjuru kota Garut',
            'image' => 'dombagarut.jpg'
        ]);

        $makamgodog = Cultural::updateOrCreate(
            ['name' => 'Makam Keramat Godog'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Makam Keramat Godog adalah salah satu pusat wisata religi paling terkenal di Kabupaten Garut. Terletak di Desa Lebak Agung, Kecamatan Karangpawitan, kompleks makam ini berada di perbukitan dengan suasana yang asri dan sejuk. Di sekitar area makam terdapat mushola, pendopo, dan kios-kios yang dikelola warga untuk memenuhi kebutuhan para peziarah. Keindahan alam sekitarnya menambah kekhidmatan suasana ziarah, menjadikan perjalanan ke Godog tidak hanya bernilai spiritual tetapi juga menyenangkan.',
            'history' => 'Makam ini diyakini sebagai tempat peristirahatan Prabu Kiansantang atau Sunan Rohmat Suci, putra Prabu Siliwangi dari Kerajaan Pajajaran. Kiansantang dikenal sebagai tokoh Pajajaran yang akhirnya memeluk Islam setelah berguru kepada Sunan Gunung Jati di Cirebon. Ia kemudian menjadi penyebar agama Islam di Tatar Sunda. Setelah wafat, jasadnya dimakamkan di Godog, dan sejak saat itu tempat ini menjadi tujuan ziarah serta simbol Islamisasi di wilayah Priangan.',
            'nowaday' => 'Hingga kini, Makam Keramat Godog masih ramai dikunjungi peziarah dari berbagai daerah. Saat peringatan Maulid Nabi, kawasan ini menjadi sangat meriah dengan adanya haul besar-besaran yang diisi dengan pengajian, doa bersama, hingga tabligh akbar. Pemerintah daerah turut mendukung dengan memperbaiki akses jalan, menyediakan area parkir, serta merawat fasilitas umum. Meski semakin ramai, kesakralan makam tetap terjaga dengan baik.',
            'cult_now' => 'Masyarakat sekitar masih menjunjung tradisi doa bersama, pembacaan tahlil, dan tabur bunga di makam ini. Ada keyakinan bahwa berziarah ke Godog dapat membawa berkah, keselamatan, dan ketenangan. Selain itu, haul tahunan Prabu Kiansantang selalu menjadi momen silaturahmi dan gotong royong warga, yang mempererat ikatan sosial dan religius masyarakat setempat.',
            'location' => 'Desa Godog, Kecaamatan Karangpawitan, Garut',
            'image' => 'makamgodog.jpg'
        ]);

        $makamnuryayi = Cultural::updateOrCreate(
            ['name' => 'Makam Bayinuryayi'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Makam Baninuryayi adalah salah satu situs religi yang cukup dikenal masyarakat Garut, meski tidak sebesar Makam Godog. Letaknya berada di wilayah pedesaan yang masih alami, menjadikannya tempat yang tenang untuk berziarah dan berdoa.',
            'history' => 'Baninuryayi diyakini sebagai seorang ulama yang berperan dalam penyebaran Islam di daerah Garut. Kiprahnya dikenal melalui tradisi lisan masyarakat sekitar yang meyakini beliau sebagai sosok panutan dalam kehidupan spiritual dan sosial. Sejak wafatnya, makam ini menjadi salah satu titik penting dalam sejarah Islam lokal.',
            'nowaday' => 'Saat ini makam Baninuryayi tetap dijaga kesakralannya oleh masyarakat setempat. Akses jalan sudah lebih baik, meski suasananya masih sederhana. Para peziarah yang datang biasanya dari warga sekitar dan peziarah dari luar yang sedang melakukan perjalanan religi.',
            'cult_now' => 'Masyarakat sekitar rutin mengadakan doa bersama, terutama pada peringatan hari-hari besar Islam. Tradisi tabur bunga, pembacaan yasin, serta tahlilan keluarga masih dipertahankan hingga kini. Bagi warga sekitar, makam ini adalah simbol penghormatan kepada ulama yang berjasa dalam kehidupan beragama mereka.',
            'location' => 'Desa Karangmulya, Kecamatan Karangpawitan, Garut',
            'image' => 'makamnuryayi.jpeg'
        ]);

        $makamcipancar = Cultural::updateOrCreate(
            ['name' => 'Makam Sunan Cipancar'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Makam Sunan Cipancar terletak di kawasan Balubur Limbangan, Kabupaten Garut. Lokasinya berada di perbukitan yang sejuk dengan suasana tenang, dikelilingi pepohonan rindang yang memberikan nuansa sakral. Tempat ini dikenal sebagai salah satu situs religi yang banyak didatangi peziarah dari berbagai daerah untuk mencari berkah sekaligus mengenang jasa para wali yang pernah menyebarkan agama Islam di wilayah Garut.',
            'history' => 'Sunan Cipancar diyakini sebagai salah satu tokoh penyebar Islam pada masa awal berkembangnya agama Islam di Tatar Priangan. Beliau dikenal sebagai ulama karismatik yang berdakwah di wilayah Limbangan dan sekitarnya. Tradisi lisan masyarakat menyebutkan bahwa Sunan Cipancar merupakan bagian dari jaringan wali yang memiliki pengaruh besar dalam proses islamisasi Garut, terutama dalam mengajarkan akidah dan syariat Islam kepada masyarakat pedesaan. Makam beliau kemudian dijadikan pusat ziarah sebagai bentuk penghormatan atas perjuangannya.',
            'nowaday' => 'Masyarakat sekitar masih menjaga tradisi ziarah ke Makam Sunan Cipancar, terutama pada hari-hari besar Islam seperti Maulid Nabi atau menjelang bulan Ramadan. Sebelum berziarah, biasanya pengunjung melakukan ritual doa bersama yang dipimpin tokoh agama setempat. Selain itu, ada tradisi masyarakat Balubur Limbangan untuk mengadakan nyekar (tabur bunga) serta mengaji bersama di area makam sebagai bentuk penghormatan dan doa. Tradisi ini juga menjadi sarana silaturahmi antarwarga.',
            'cult_now' => 'Saat ini, kompleks Makam Sunan Cipancar terawat dengan baik. Akses jalan menuju lokasi cukup mudah dijangkau, meskipun sebagian masih berupa jalan desa. Pemerintah daerah bersama warga sekitar telah melakukan beberapa perbaikan seperti penyediaan tempat parkir, jalan setapak, dan area istirahat bagi para peziarah. Setiap minggunya, makam ini ramai dikunjungi, baik oleh masyarakat lokal maupun dari luar Garut. Selain menjadi pusat ziarah, Makam Sunan Cipancar juga kerap dijadikan destinasi wisata religi yang memperkaya khazanah budaya dan sejarah Garut.',
            'location' => 'Kecamatan Balubur Limbangan, Garut',
            'image' => 'makamcipancar.jpg'
        ]);

        $makamremenggong = Cultural::updateOrCreate(
            ['name' => 'Makam Sunan Remenggong'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Makam Sunan Remenggong merupakan salah satu makam keramat di Garut yang masih dijaga masyarakat setempat. Lokasinya berada di pedesaan dengan suasana yang tenang dan alami, cocok sebagai tempat ziarah.',
            'history' => 'Sunan Remenggong dipercaya sebagai salah satu tokoh penyebar Islam di Tatar Sunda. Kisahnya diwariskan secara turun-temurun oleh masyarakat sekitar yang menganggap beliau sebagai guru spiritual. Makam ini menjadi simbol penghormatan atas dedikasi beliau dalam menyebarkan ajaran Islam.',
            'nowaday' => 'Makam masih terawat meski sederhana, dengan kunjungan peziarah yang stabil setiap tahunnya. Pada waktu tertentu, terutama bulan Maulid dan bulan-bulan besar Islam, peziarah datang lebih banyak untuk berdoa bersama.',
            'cult_now' => 'Ziarah di makam ini dilakukan dengan tradisi doa, tahlilan, serta tabur bunga. Masyarakat juga rutin mengadakan pengajian di sekitar makam, menjadikan tempat ini sebagai pusat silaturahmi dan kebersamaan warga.',
            'location' => 'Kecamatan Limbangan, Garut',
            'image' => 'makamremenggong.jpg'
        ]);

        $makamarief = Cultural::updateOrCreate(
            ['name' => 'Makam Dalem Arief Muhammad'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Makam Dalem Arief Muhammad adalah salah satu makam tokoh penting di Garut yang dihormati karena kiprahnya dalam bidang agama dan kepemimpinan.',
            'history' => 'Dalem Arief Muhammad dikenal sebagai tokoh yang berjasa dalam penyebaran ajaran Islam di Garut. Selain perannya sebagai pemimpin spiritual, ia juga dianggap sebagai figur yang membimbing masyarakat dalam kehidupan sosial.',
            'nowaday' => 'Lokasi makam ini masih ramai didatangi oleh peziarah, terutama pada peringatan hari-hari besar Islam. Akses menuju makam cukup baik dan dijaga oleh masyarakat sekitar.',
            'cult_now' => 'Tradisi haul masih dilaksanakan secara rutin dengan doa bersama dan pengajian. Masyarakat percaya berziarah ke makam ini dapat membawa keberkahan dalam kehidupan mereka.',
            'location' => 'Desa Cangkuang, Kecamatan Leles, Garut',
            'image' => 'makamarief.jpg'
        ]);

        $makamfatah = Cultural::updateOrCreate(
            ['name' => 'Makam Syech Fatah Rohmatulloh'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Makam ini menjadi salah satu pusat ziarah di Garut, dikenal karena keberadaan Syech Fatah Rohmatulloh yang dihormati sebagai ulama penyebar Islam.',
            'history' => 'Syech Fatah Rohmatulloh adalah tokoh ulama yang perannya sangat penting dalam penyebaran agama Islam di Garut dan sekitarnya. Warga setempat menaruh hormat tinggi padanya, sehingga makamnya menjadi tempat yang ramai diziarahi.',
            'nowaday' => 'Makam ini terawat dengan baik, dikelilingi pepohonan yang membuat suasana tenang. Peziarah datang tidak hanya dari Garut, tetapi juga dari luar daerah.',
            'cult_now' => 'Ritual ziarah biasanya diiringi doa bersama, tahlilan, dan tabur bunga. Tradisi haul juga rutin dilaksanakan setiap tahunnya.',
            'location' => 'Kecamatan Samarang, Garut',
            'image' => 'makamfatah.jpg'
        ]);

        $makampapak = Cultural::updateOrCreate(
            ['name' => 'Makam Sunan Papak'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Makam Sunan Papak terletak di salah satu wilayah pedesaan Garut. Tempat ini memiliki nilai spiritual tinggi dan dihormati masyarakat sebagai bagian dari sejarah Islam di daerah tersebut.',
            'history' => 'Sunan Papak diyakini sebagai tokoh yang memiliki pengaruh dalam penyebaran Islam. Namanya disebut dalam tradisi lisan masyarakat sebagai salah satu guru agama yang membimbing warga menuju kehidupan Islami.',
            'nowaday' => 'Makam dijaga kesakralannya oleh masyarakat sekitar. Meski tidak sebesar Godog, makam ini tetap ramai dikunjungi, terutama oleh warga yang memiliki ikatan sejarah atau spiritual dengan tokoh tersebut.',
            'cult_now' => 'Masyarakat rutin melakukan doa bersama, haul tahunan, serta pengajian di area makam. Ziarah keluarga dengan membawa bunga dan doa menjadi tradisi yang terus dijaga.',
            'location' => 'Desa Cinunuk, Kecamatan Wanaraja, Garut',
            'image' => 'makampapak.jpg'
        ]);

        $makamnagara = Cultural::updateOrCreate(
            ['name' => 'Makam Kuno Gunung Nagara'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Makam Kuno Gunung Nagara merupakan kompleks makam yang memiliki nilai sejarah tinggi. Lokasinya berada di daerah perbukitan, memberikan suasana sakral dan alami.',
            'history' => 'Kompleks ini diyakini sebagai tempat pemakaman tokoh-tokoh penting dari masa kerajaan atau ulama terdahulu. Makam-makam kuno tersebut menjadi bukti jejak sejarah peradaban dan agama di wilayah Garut.',
            'nowaday' => 'Makam masih terjaga dengan baik, meski sebagian sudah mengalami pelapukan karena usianya yang sangat tua. Pemerintah daerah dan masyarakat berupaya merawat area ini sebagai bagian dari cagar budaya.',
            'cult_now' => 'Ziarah ke makam kuno biasanya dilakukan pada hari-hari tertentu. Masyarakat sekitar masih menjaga tradisi doa dan tabur bunga, sekaligus menghormati leluhur yang dimakamkan di sini.',
            'location' => 'Kecamatan Cisompet, Garut',
            'image' => 'makamnagara.jpg'
        ]);

        $situscimareme = Cultural::updateOrCreate(
            ['name' => 'Situs Cimareme'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Situs Cimareme berada di kawasan Kecamatan Banyuresmi, Kabupaten Garut. Situs ini dikenal sebagai salah satu peninggalan arkeologi yang menyimpan nilai sejarah penting tentang peradaban masyarakat Sunda masa lalu. Lokasinya berada di daerah perbukitan yang tenang, sehingga sering dijadikan tempat penelitian maupun kunjungan wisata sejarah.',
            'history' => 'Situs Cimareme diyakini merupakan tempat pemujaan masyarakat Hindu-Buddha sebelum Islam berkembang di Tatar Sunda. Beberapa struktur batu dan susunan megalitik yang ditemukan menjadi bukti adanya aktivitas religius dan sosial pada masa itu. Penelitian arkeologi mencatat bahwa situs ini berhubungan dengan tradisi megalitik yang berkembang di Jawa Barat sekitar abad ke-8 hingga ke-10.',
            'nowaday' => 'Situs Cimareme masih terjaga meskipun tidak seramai destinasi wisata populer lain di Garut. Pemerintah daerah bersama Balai Arkeologi telah melakukan beberapa upaya pelestarian, seperti pemasangan papan informasi dan penataan area. Para pengunjung yang datang biasanya adalah pelajar, peneliti, serta peziarah budaya yang ingin memahami sejarah Sunda kuno.',
            'cult_now' => 'Masyarakat sekitar masih menghormati Situs Cimareme sebagai tempat yang dianggap keramat. Pada waktu-waktu tertentu, seperti menjelang bulan Maulid atau setelah panen, ada tradisi masyarakat untuk melakukan doa bersama di sekitar situs. Hal ini dilakukan sebagai bentuk syukur sekaligus penghormatan pada leluhur.',
            'location' => 'Kecamatan Banyuresmi, Garut',
            'image' => 'situscimareme.jpg'
        ]);

        $masjidsyuro = Cultural::updateOrCreate(
            ['name' => 'Masjid Asy-Syuro Cipari'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Masjid Asy-Syuro Cipari terletak di Desa Sukahurip, Kecamatan Pangatikan, Kabupaten Garut. Masjid ini merupakan salah satu masjid bersejarah dengan arsitektur tradisional yang sederhana namun penuh makna. Bangunan masjid dikelilingi lingkungan pedesaan yang asri dan tenang.',
            'history' => 'Masjid ini diyakini sudah berdiri sejak abad ke-17 dan menjadi salah satu pusat syiar Islam di wilayah Garut. Nama "Asy-Syuro" merujuk pada tradisi musyawarah yang dijunjung tinggi oleh masyarakat. Masjid ini juga tercatat sebagai tempat berkumpulnya ulama dan tokoh masyarakat dalam mengambil keputusan penting pada masa kolonial.',
            'nowaday' => 'Masjid Asy-Syuro Cipari tetap difungsikan sebagai tempat ibadah aktif. Renovasi dilakukan secara berkala tanpa menghilangkan bentuk aslinya yang khas. Pengunjung dapat melihat perpaduan arsitektur Sunda kuno dengan sentuhan Islam yang kental.',
            'cult_now' => 'Di masjid ini sering digelar acara keagamaan yang melibatkan masyarakat setempat, seperti pengajian rutin, tabligh akbar, hingga peringatan Maulid Nabi. Masyarakat masih menjaga tradisi musyawarah desa di sekitar masjid, sesuai dengan nama yang disandangnya.',
            'location' => 'Desa Cipari, Kecamatan Pangantikan, Garut',
            'image' => 'masjidsyuro.jpg'
        ]);

        $situsciburuy = Cultural::updateOrCreate(
            ['name' => 'Situs Kabuyutan Ciburuy'],
            ['category' => 'Bangunan Bersejarah, Wisata Budaya',
            'description' => 'Situs Kabuyutan Ciburuy berada di Kecamatan Bayongbong, Garut, dan terkenal sebagai salah satu pusat naskah kuno Sunda. Lokasinya berada di perbukitan dengan suasana yang sunyi, sehingga cocok dijadikan tempat refleksi budaya.',
            'history' => 'Kabuyutan adalah sebutan untuk tempat penyimpanan naskah dan benda suci pada masa Hindu-Buddha maupun Islam awal. Di Ciburuy tersimpan banyak naskah lontar yang memuat berbagai ilmu pengetahuan, agama, hukum, hingga sastra Sunda kuno. Naskah-naskah ini menjadi bukti kekayaan intelektual masyarakat Sunda pada masa lalu.',
            'nowaday' => 'Situs ini telah mendapat perhatian dari para peneliti, filolog, dan pemerhati budaya. Beberapa naskah sudah diamankan untuk kepentingan pelestarian, sementara kawasan situs dijaga agar tetap lestari. Pemerintah daerah bersama komunitas budaya Sunda kerap mengadakan kegiatan literasi dan seminar di kawasan ini.',
            'cult_now' => 'Warga sekitar menganggap Kabuyutan Ciburuy sebagai tempat yang sangat sakral. Pada waktu tertentu, mereka melakukan ritual penghormatan leluhur berupa doa bersama. Tradisi menjaga kelestarian naskah juga diwariskan secara turun-temurun, sehingga masyarakat setempat merasa ikut bertanggung jawab melestarikan warisan budaya ini.',
            'location' => 'Desa Ciburuy, Kecamatan Bayongbong, Garut',
            'image' => 'situsciburuy.jpg'
        ]);

        $kampungbali = Cultural::updateOrCreate(
            ['name' => 'Kampung Bali'],
            ['category' => 'Wisata Budaya',
            'description' => 'Kampung Bali terletak di Kecamatan Cibatu, Kabupaten Garut. Meskipun namanya "Bali", kampung ini bukan berasal dari Pulau Bali, melainkan julukan karena keunikan adat istiadat serta keindahan alamnya. Kampung Bali dikenal dengan lingkungan pedesaan yang masih asri, dikelilingi area persawahan dan perbukitan hijau yang menenangkan.',
            'history' => 'Nama Kampung Bali diyakini muncul sejak masa kolonial Belanda, ketika beberapa pendatang dari luar daerah memperkenalkan gaya hidup dan tradisi berbeda dari masyarakat lokal. Seiring waktu, sebutan itu melekat hingga sekarang. Walaupun tidak ada hubungan langsung dengan budaya Bali di Pulau Bali, masyarakat Kampung Bali tetap menjaga kearifan lokal Sunda yang kuat.',
            'nowaday' => 'Kampung Bali kini menjadi salah satu tujuan wisata budaya di Garut. Banyak pengunjung datang untuk merasakan suasana pedesaan tradisional dengan rumah-rumah panggung, sawah yang hijau, serta kehidupan masyarakat yang masih menjaga kesederhanaan. Infrastruktur dasar sudah tersedia, namun tetap mempertahankan nuansa alami.',
            'cult_now' => 'Masyarakat Kampung Bali masih menjunjung tinggi gotong royong dan adat Sunda. Upacara tradisi seperti sedekah bumi, syukuran panen, dan doa bersama rutin dilaksanakan. Seni pertunjukan tradisional seperti pencak silat dan degung kerap ditampilkan saat ada acara kampung.',
            'location' => 'Desa Cibunar, Kecamatan Cibatu, Garut',
            'image' => 'kampungbali.jpg'
        ]);

        $kampungdukuh = Cultural::updateOrCreate(
            ['name' => 'Kampung Dukuh'],
            ['category' => 'Wisata Budaya',
            'description' => 'Kampung Dukuh berada di Desa Ciroyom, Kecamatan Cikelet, Kabupaten Garut. Kampung ini dikenal luas sebagai salah satu kampung adat yang masih memegang teguh tradisi leluhur Sunda. Lokasinya berada di pedalaman yang dikelilingi hutan lebat, menjadikan suasana kampung ini sakral dan penuh nilai spiritual.',
            'history' => 'Menurut tradisi lisan, Kampung Dukuh sudah berdiri sejak ratusan tahun lalu sebagai pusat ajaran agama Islam dan kearifan Sunda. Kampung ini dipimpin oleh seorang kuncen atau sesepuh yang menjaga adat. Keberadaannya menjadi simbol bahwa masyarakat Sunda mampu mempertahankan identitas budaya meski zaman terus berubah.',
            'nowaday' => 'Kampung Dukuh masih sangat terjaga keasliannya. Rumah-rumah warga dibuat dari kayu dan bambu, serta masyarakatnya hidup sederhana dengan mengandalkan pertanian dan hasil hutan. Akses menuju kampung ini tidak mudah, tetapi justru membuatnya tetap otentik sebagai kampung adat. Wisatawan yang datang biasanya tertarik dengan kehidupan tradisional yang nyaris tanpa pengaruh modernisasi.',
            'cult_now' => 'Warga Kampung Dukuh menjalankan aturan adat yang ketat, termasuk larangan membangun rumah dengan bahan modern. Mereka juga memegang teguh tradisi syukuran panen, doa bersama, serta menjaga hubungan harmonis dengan alam. Kehidupan masyarakat sangat religius, dengan pengajian dan dzikir menjadi kegiatan utama.',
            'location' => 'Desa Ciroyom, Kecamatan Cikelet, Garut',
            'image' => 'kampungdukuh.jpg'
        ]);

        $kampungpulo = Cultural::updateOrCreate(
            ['name' => 'Kampung Pulo'],
            ['category' => 'Wisata Budaya',
            'description' => 'Kampung Pulo terletak di tengah Situ Cangkuang, Desa Cangkuang, Kecamatan Leles, Garut. Kampung ini unik karena hanya terdiri dari enam rumah panggung tradisional yang dihuni oleh enam kepala keluarga. Letaknya yang berada di pulau kecil membuat suasana kampung ini berbeda dengan kampung adat lainnya.',
            'history' => 'Kampung Pulo diyakini sudah ada sejak abad ke-17. Menurut cerita, kampung ini didirikan oleh keturunan Embah Dalem Arief Muhammad, ulama penyebar Islam di wilayah Cangkuang. Jumlah rumah yang tetap enam melambangkan anak-anak beliau, dan hingga kini aturan tersebut dijaga ketat sebagai simbol keseimbangan.',
            'nowaday' => 'Kampung Pulo menjadi destinasi wisata budaya yang terkenal di Garut. Wisatawan yang mengunjungi Candi Cangkuang otomatis juga berkunjung ke kampung ini. Keaslian bangunan, aturan jumlah rumah, dan kehidupan sederhana masyarakatnya menjadi daya tarik utama. Walaupun banyak dikunjungi wisatawan, warga tetap menjaga adat dan tidak tergoda modernisasi.',
            'cult_now' => 'Tradisi Islam sangat kental di Kampung Pulo, dipadukan dengan adat Sunda. Warga masih melaksanakan tradisi ngalokat cai (ritual menjaga air), syukuran panen, serta peringatan Maulid Nabi. Mereka juga menjunjung tinggi aturan adat, seperti larangan memelihara hewan besar atau membangun rumah baru di luar enam rumah yang ada.',
            'location' => 'Kecamatan Leles, Garut',
            'image' => 'kampungpulo.jpg'
        ]);

        $museumcangkuang = Cultural::updateOrCreate(
            ['name' => 'Museum Cangkuang'],
            ['category' => 'Museum',
            'description' => 'Museum Cangkuang terletak di kompleks wisata Candi Cangkuang, Desa Cangkuang, Kecamatan Leles, Garut. Bangunan museum berbentuk rumah tradisional Sunda dan menyimpan berbagai artefak hasil ekskavasi dari Candi Cangkuang serta peninggalan sejarah lainnya. Letaknya yang berdampingan dengan candi dan Kampung Pulo membuat museum ini menjadi bagian penting dari wisata sejarah di Garut.',
            'history' => 'Museum ini dibangun setelah penemuan kembali Candi Cangkuang pada tahun 1966. Para peneliti arkeologi merasa perlu adanya tempat penyimpanan dan dokumentasi benda-benda bersejarah yang ditemukan, seperti arca Siwa, nisan kuno, keramik, serta naskah kuno. Sejak saat itu, museum menjadi pusat informasi tentang peralihan budaya Hindu ke Islam di Garut.',
            'nowaday' => 'Museum Cangkuang dikelola dengan baik dan menjadi tujuan utama wisatawan yang datang ke kawasan situ. Koleksi di dalamnya tersusun rapi dengan penjelasan singkat agar mudah dipahami pengunjung. Selain wisatawan umum, banyak pelajar dan mahasiswa berkunjung untuk tujuan edukasi.',
            'cult_now' => 'Keberadaan museum ini turut memperkuat identitas budaya masyarakat sekitar. Warga setempat ikut menjaga kelestarian situs dan mendukung tradisi ziarah ke makam Embah Dalem Arief Muhammad, sehingga museum menjadi bagian dari warisan sejarah yang hidup berdampingan dengan masyarakat.',
            'location' => 'Desa Cangkuang, Kecamatan Leles, Garut',
            'image' => 'museumcangkuang.jpg'
        ]);

        $museumadiwijaya = Cultural::updateOrCreate(
            ['name' => 'Museum R.A.A. Adiwidjaja'],
            ['category' => 'Museum',
            'description' => 'Museum R.A.A. Adiwidjaja berada di pusat Kota Garut, tepatnya di kompleks alun-alun. Museum ini menyimpan koleksi benda-benda peninggalan Bupati Garut pertama, Raden Adipati Aria Adiwidjaja, yang menjabat pada abad ke-19. Bangunan museum sendiri adalah rumah dinas bupati yang dialihfungsikan.',
            'history' => 'R.A.A. Adiwidjaja merupakan tokoh penting dalam sejarah Garut, terutama setelah pemindahan pusat pemerintahan dari Limbangan ke Garut pada tahun 1813. Untuk mengenang jasa-jasanya, rumah dinas beliau kemudian dijadikan museum yang menyimpan benda pribadi, dokumen sejarah, serta artefak kolonial.',
            'nowaday' => 'Museum ini berfungsi sebagai sarana edukasi sejarah lokal Garut. Koleksinya cukup beragam, mulai dari pakaian tradisional, alat rumah tangga kuno, hingga arsip pemerintahan. Walaupun belum sebesar museum nasional, museum ini tetap menarik minat pengunjung, terutama pelajar yang ingin mengenal sejarah daerahnya.',
            'cult_now' => 'Bagi masyarakat Garut, museum ini menjadi simbol penghormatan terhadap leluhur dan pemimpin yang berjasa. Setiap peringatan hari jadi Garut, museum ini biasanya ramai dikunjungi sebagai bagian dari rangkaian acara budaya.',
            'location' => 'Desa Jayaraga, Kecamatan Tarogong Kidul, Garut',
            'image' => 'museumadiwijaya.jpg'
        ]);

        $museumkencana = Cultural::updateOrCreate(
            ['name' => 'Museum Graha Liman Kencana'],
            ['category' => 'Museum',
            'description' => 'Museum Graha Liman Kencana berada di kawasan Cibatu, Kabupaten Garut. Museum ini menampilkan koleksi benda-benda kuno, kendaraan tradisional, serta peninggalan sejarah lokal yang berkaitan dengan budaya Sunda. Nama "Liman Kencana" merujuk pada kereta kuda tradisional yang dahulu digunakan oleh bangsawan.',
            'history' => 'Museum ini didirikan oleh keluarga keturunan bangsawan Garut sebagai bentuk pelestarian warisan budaya. Koleksi utama berupa kereta kuda berlapis hiasan tradisional yang dahulu digunakan dalam upacara resmi pemerintahan. Selain itu, terdapat pula senjata tradisional, gamelan, dan perabot antik.',
            'nowaday' => 'Museum Graha Liman Kencana menjadi salah satu destinasi wisata budaya yang cukup diminati. Koleksinya dirawat dengan baik, dan suasana bangunan masih mempertahankan nuansa klasik. Beberapa sekolah sering menjadikan museum ini sebagai tujuan studi lapangan.',
            'cult_now' => 'Masyarakat sekitar menghargai keberadaan museum ini sebagai pengingat kejayaan budaya Sunda. Pada momen tertentu, seperti acara adat atau festival budaya, beberapa koleksi museum turut dipamerkan ke publik untuk memperkenalkan tradisi kepada generasi muda.',
            'location' => 'Desa Cibunar, Kecamatan Cibatu, Garut',
            'image' => 'museumkencana.jpg'
        ]);

        $museumcinunuk = Cultural::updateOrCreate(
            ['name' => 'Museum Cinunuk'],
            ['category' => 'Museum',
            'description' => 'Museum Cinunuk berada di Kecamatan Wanaraja, Garut. Museum ini berdiri di lingkungan pesantren dan menyimpan berbagai koleksi benda peninggalan sejarah Islam serta budaya Sunda. Suasananya khas pedesaan yang tenang, sehingga memberi kesan religius sekaligus edukatif.',
            'history' => 'Museum Cinunuk didirikan sebagai upaya pelestarian warisan sejarah Islam di Garut. Koleksinya meliputi naskah kuno, kitab klasik, alat ibadah, serta peninggalan tokoh-tokoh agama setempat. Museum ini juga merekam jejak penyebaran Islam di Garut melalui dokumentasi peninggalan pesantren.',
            'nowaday' => 'Museum Cinunuk berfungsi sebagai pusat pembelajaran sejarah Islam lokal. Banyak mahasiswa, peneliti, dan santri datang untuk meneliti koleksi naskah serta mendalami peran pesantren dalam perkembangan masyarakat Sunda. Walaupun sederhana, museum ini memiliki nilai budaya dan edukasi yang tinggi.',
            'cult_now' => 'Masyarakat setempat melihat museum ini bukan sekadar tempat penyimpanan benda kuno, tetapi juga bagian dari tradisi keilmuan pesantren. Kegiatan pengajian, haul ulama, dan acara keagamaan sering dikaitkan dengan keberadaan museum, menjadikannya pusat spiritual sekaligus budaya.',
            'location' => 'Desa Cinunuk, Kecamatan Wanaraja, Garut',
            'image' => 'museumcinunuk.jpg'
        ]);

        $stasiuncibatu = Cultural::updateOrCreate(
            ['name' => 'Stasiun Kereta Api Cibatu'],
            ['category' => 'Bangunan Bersejarah',
            'description' => 'Stasiun Kereta Api Cibatu terletak di Kecamatan Cibatu, Kabupaten Garut. Stasiun ini merupakan salah satu stasiun tertua di Jawa Barat yang berdiri sejak zaman kolonial Belanda. Letaknya strategis di jalur Bandung–Cibatu–Garut–Tasikmalaya, sehingga pada masanya menjadi pusat aktivitas transportasi penting di Priangan Timur. Arsitektur bangunan stasiun masih mempertahankan gaya kolonial klasik dengan atap tinggi dan dinding tebal, memberikan kesan bersejarah yang kuat.',
            'history' => 'Stasiun Cibatu resmi beroperasi pada tahun 1889 ketika Staatsspoorwegen (SS) membangun jalur kereta api di Priangan. Cibatu menjadi simpul utama yang menghubungkan Bandung dengan Garut dan Tasikmalaya. Pada masa kolonial, stasiun ini ramai digunakan untuk mengangkut hasil bumi seperti kopi, teh, dan kina dari perkebunan di Garut. Jalur kereta Cibatu–Garut sempat berhenti beroperasi pada 1983, namun akhirnya direaktivasi dan kembali beroperasi pada tahun 2022, menandai kebangkitan sejarah transportasi kereta api Garut.',
            'nowaday' => 'Kini, Stasiun Cibatu melayani perjalanan kereta api ke berbagai kota, termasuk Bandung dan Garut. Bangunannya telah dipugar, tetapi tetap mempertahankan keaslian desain kolonialnya. Suasana stasiun terasa klasik sekaligus modern, dengan fasilitas yang lebih baik bagi penumpang. Stasiun ini juga menjadi daya tarik wisatawan yang tertarik dengan sejarah perkeretaapian Indonesia.',
            'cult_now' => 'Bagi masyarakat Garut dan sekitarnya, Stasiun Cibatu bukan sekadar tempat transit, melainkan bagian dari identitas sejarah lokal. Banyak kisah masyarakat tentang kejayaan masa lalu stasiun ini, yang masih hidup hingga sekarang. Kembalinya jalur kereta Garut–Cibatu membawa kebanggaan tersendiri bagi warga, sekaligus membuka peluang ekonomi melalui sektor pariwisata dan perdagangan.',
            'location' => 'Kecamatan Cibatu, Garut',
            'image' => 'stasiuncibatu.jpg'
        ]);

        $batikgarut = Cultural::updateOrCreate(
            ['name' => 'Batik Garutan'],
            ['category' => 'Produk Seni & Tradisi',
            'description' => 'Batik Garutan adalah produk batik tradisional yang dihasilkan oleh pengrajin Garut dan menjadi identitas budaya lokal. Proses pembuatannya melibatkan keahlian turun-temurun yang diwariskan dari generasi ke generasi.',
            'history' => 'Batik Garutan telah dikenal sejak zaman dahulu sebagai kerajinan tradisional Garut. Pola dan motif batik Garutan terinspirasi dari alam sekitar, kehidupan sehari-hari masyarakat, serta nilai-nilai budaya Sunda yang kaya.',
            'nowaday' => 'Hingga saat ini, batik Garutan masih diproduksi oleh pengrajin lokal dengan tetap mempertahankan teknik dan kualitas tradisional. Batik Garutan dapat ditemukan di berbagai pasar tradisional dan toko souvenir di Garut.',
            'cult_now' => 'Batik Garutan bukan hanya sekadar produk komersial, tetapi juga simbol warisan budaya yang dibanggakan masyarakat Garut. Pengrajin batik masih mempertahankan tradisi dan teknik pembuatan, sekaligus menciptakan inovasi baru yang tetap menghormati nilai-nilai tradisional.',
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
