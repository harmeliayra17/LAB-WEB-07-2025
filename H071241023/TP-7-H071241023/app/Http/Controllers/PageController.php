<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home(){
        return view('home');
    }

    public function destinasi(){
        $destinasi = [
            [
                'title' => 'Tangkuban Perahu',
                'text' => 'Sebuah Gunung berapi yang masih aktif di sekitar Kota Bandung
                terkenal karena kawahnya yang indah dan mudah diakses dari Kota',
                'images' => [
                    'images/destinasi/tangkubanPerahu.jpg',
                    'images/destinasi/tangkubanPerahu1.jpeg',
                    'images/destinasi/tangkubanPerahu2.jpeg',
                    'images/destinasi/tangkubanPerahu3.jpeg',
                ],
            ],
            [
                'title' => 'Jalan Braga',
                'text' => 'Jalan bersejarah di pusat kota Bandung yang dipenuhi kafe, butik, bangunan kolonial',
                'images' => [
                    'images/destinasi/jalanBraga.jpg',
                    'images/destinasi/jalanBraga1.jpeg',
                    'images/destinasi/jalanBraga2.jpeg',
                    'images/destinasi/jalanBraga3.jpeg',
                ]
            ],
            [
                'title' => 'Kawah Putih',
                'text' => 'Danau kawah berwarna toska yang berada di Ciwidey, 
                menjadi lokasi wisata alam yang sangat fotogenik. ',
                'images' => [
                    'images/destinasi/kawahPutih.jpeg',
                    'images/destinasi/kawahPutih1.jpg',
                    'images/destinasi/kawahPutih2.jpeg',
                    'images/destinasi/kawahPutih3.jpeg',
                ],
            ],
        ];
        return view('destinasi', compact('destinasi'));
    }

    public function kuliner(){
        $kuliner = [
            [
                'title' => 'Batagor',
                'text' => 'Batagor atau bakso tahu goreng, merupakan salah satu ikon kuliner Bandung, tahu dan bakso digoreng, disajikan dengan saus kacang dan perasan jeruk limau.',
                'image' => 'images/kuliner/batagor.jpg'
            ],
            [
                'title' => 'Mie Kocok Bandung',
                'text' => 'Mie Kocok adalah mie kuning dengan kuah kaldu sapi kental, potongan kikil, tauge, dan seledri salah satu ikon kuliner Bandung.',
                'image' => 'images/kuliner/mieKocok.jpg'
            ],
            [
                'title' => 'Seblak',
                'text' => 'Seblak adalah makanan khas Sunda dan Bandung yang berbahan kerupuk basah, dimasak dengan bumbu pedas-gurih dan sering ditambah sosis, bakso, makaroni, serta telur.',
                'image' => 'images/kuliner/seblak.jpg'
            ],
            [
                'title' => 'Lotek',
                'text' => 'Lotek adalah salad sayur khas Jawa Barat yang mirip gado-gado, terdiri dari sayuran rebus seperti kangkung, labu, tauge, kacang panjang, disiram dengan saus kacang yang kental dan bercita rasa khas Bandung.',
                'image' => 'images/kuliner/lotek.jpg'
            ],
            [
                'title' => 'Surabi',
                'text' => 'Surabi adalah pancake tradisional Sunda yang terbuat dari tepung beras atau ketan, dimasak di cetakan khusus dan sering disajikan dengan topping manis seperti kinca, keju, atau oncom—menjadi kudapan sore khas Bandung.',
                'image' => 'images/kuliner/surabi.jpg'
            ],
            [
                'title' => 'Karedok',
                'text' => 'Karedok adalah sayuran mentah seperti kol, kacang panjang, taoge, dan daun kemangi yang disiram saus kacang pedas-manis khas Sunda—makanan tradisional yang segar dari Bandung Raya.',
                'image' => 'images/kuliner/karedok.jpg'
            ],
            [
                'title' => 'Colenak',
                'text' => 'Colenak adalah singkatan dari “dicocol enak”—makanan khas Bandung berbahan tape singkong panggang, disajikan bersama parutan kelapa dan gula merah cair sebagai cocolannya.',
                'image' => 'images/kuliner/colenak.jpg'
            ]
        ];
        return view('kuliner', compact('kuliner'));
    }

    public function galeri(){
        $galeri = [
            ['image' => 'images/galeri/galeri1.jpeg',     'title' => 'Gedung Sate',                   'text' => 'Gedung sate, sebuah gedung ikonik di Kota Bandung'],
            ['image' => 'images/galeri/galeri2.jpeg',     'title' => 'Dilan',                         'text' => 'Anak tongkrongan Bandung di tahun 90an'],
            ['image' => 'images/galeri/galeri3.png',      'title' => 'Masjid Al-Jabbar',              'text' => 'Haters bilang ini editan'],
            ['image' => 'images/galeri/galeri4.jpeg',     'title' => 'Rumah Milea',                   'text' => 'Are u there, Milea?'],
            ['image' => 'images/galeri/galeri5.jpeg',     'title' => 'Jalanan Kota',                  'text' => 'Spot foto cocok buat anak streetwear'],
            ['image' => 'images/galeri/galeri6.jpeg',     'title' => 'Tangkuban Perahu',              'text' => 'Gunung aktif dengan kawah menawan'],
            ['image' => 'images/galeri/galeri7.jpeg',     'title' => 'Dilan lagi',                    'text' => 'Dan yap dilan lagi'],
            ['image' => 'images/galeri/galeri8.jpeg',     'title' => 'The Great Asia Africa',         'text' => 'Mayan ngasih makan ig'],
            ['image' => 'images/galeri/galeri9.jpeg',     'title' => 'Sunset di jalan Braga',         'text' => 'Nyore sambil ngopi, asoy nih'],
            ['image' => 'images/galeri/galeri10.jpeg',    'title' => 'Dilan dan Milea',               'text' => 'Cita-cita kamu apa? pilot hehehe'],
            ['image' => 'images/galeri/galeri11.jpeg',    'title' => 'Kebun Binatang Bandung',        'text' => 'Aneka satwa liar dan non liar'],
            ['image' => 'images/galeri/galeri12.jpeg',    'title' => 'KAI Bandung',                   'text' => 'Naik kereta api tut tut tut'],
            ['image' => 'images/galeri/galeri13.jpeg',    'title' => 'Art Street',                    'text' => 'Pelukis jalanan pun gak kalah saing cess'],
            ['image' => 'images/galeri/galeri14.jpeg',    'title' => 'Geng Motor Barudak Bandung',    'text' => 'P info. Tak parani'],
            ['image' => 'images/galeri/galeri15.jpeg',    'title' => 'Pinisi Resto',                  'text' => 'Resto ala berlayar di kapal titanik'],
            ['image' => 'images/galeri/galeri16.jpeg',    'title' => 'Museum Geologi',                'text' => 'Yang suka hal-hal berbau batuan wajib kesini'],
            ['image' => 'images/galeri/galeri17.jpeg',    'title' => 'Kafe Ruang Lapang ',            'text' => 'Gass nongki'],
            ['image' => 'images/galeri/galeri18.jpeg',    'title' => 'Cikahuripan Green Canyon',      'text' => 'Ciptaan Tuhan emang MashaAllah'],
            ['image' => 'images/galeri/galeri19.jpeg',    'title' => 'The Great Asia Africa',         'text' => 'Mayan ngasih makan ig part 2'],
            ['image' => 'images/galeri/galeri20.jpeg',    'title' => 'Alun-Alun Bandung',             'text' => 'Weekend tiba, alun-alun w/ fams'],
        ];
        return view('galeri', compact('galeri'));
    }

    public function kontak(){
        return view('kontak');
    }
}
