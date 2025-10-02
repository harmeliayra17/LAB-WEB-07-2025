const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const angkaRahasia = Math.floor(Math.random() * 100) + 1;
let percobaan = 1;

console.log("Saya telah memilih sebuah angka rahasia antara 1 dan 100.");

function mulaiTebak() {
    rl.question(`Masukkan tebakanmu: `, (input) => {
        const tebakan = parseInt(input);

        
        if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
            console.log("Error: Masukkan angka yang valid antara 1 dan 100.");
            mulaiTebak(); 
            return;
        }

        if (tebakan === angkaRahasia) {
            console.log(`Selamat! Kamu berhasil menebak angka ${angkaRahasia}.`);
            rl.close();
        } else {
            const petunjuk = tebakan > angkaRahasia ? "Terlalu tinggi!" : "Terlalu rendah!";
            console.log(petunjuk);
            mulaiTebak(); 
        }
    });
}

mulaiTebak();