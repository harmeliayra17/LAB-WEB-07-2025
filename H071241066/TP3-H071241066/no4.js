const readline = require('readline');
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const target = Math.floor(Math.random() * 100) + 1;
let jumlahTebakan = 0;

function tanya() {
  rl.question('Masukkan salah satu angka 1-100: ', (input) => {
    const tebak = Number(input);
    if (isNaN(tebak) || tebak < 1 || tebak > 100) {
      console.log('Angka harus diantara 1-100.');
      return tanya();
    }

    jumlahTebakan++;
    if (tebak > target) {
      console.log('Terlalu tinggi! Coba lagi.');
      tanya();
    } else if (tebak < target) {
      console.log('Terlalu rendah! Coba lagi.');
      tanya();
    } else {
      console.log(`Selamat! Kamu berhasil menebak angka ${target} dengan benar.`);
      console.log(`Sebanyak ${jumlahTebakan}x percobaan.`);
      rl.close();
    }
  });
}

tanya();
