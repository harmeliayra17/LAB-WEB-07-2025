const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const nama_hari = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];

rl.question('Masukkan nama hari ini: ', (hariIniInput) => {
    rl.question('Masukkan jumlah hari yang akan datang: ', (jumlahHariInput) => {
        const hariIni = hariIniInput.toLowerCase();
        const jumlahHari = parseInt(jumlahHariInput);
        
        const indexHariIni = nama_hari.indexOf(hariIni);
        if (indexHariIni === -1) {
            console.log("Error: Nama hari tidak valid.");
            rl.close();
            return; 
        }

        if (isNaN(jumlahHari) || jumlahHari < 0) {
            console.log("Error: Jumlah hari harus berupa angka positif.");
            rl.close();
            return; 
        }

        const indexNanti = (indexHariIni + jumlahHari) % 7;
        const namaHariNanti = nama_hari[indexNanti];
        
        const outputNamaHari = namaHariNanti.charAt(0).toUpperCase() + namaHariNanti.slice(1);
        console.log(`\n${jumlahHari} hari setelah hari ${hariIniInput} adalah hari ${outputNamaHari}.`);
        
        rl.close();
    });
});