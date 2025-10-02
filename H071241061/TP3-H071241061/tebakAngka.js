const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const target = Math.floor(Math.random() * 100) + 1;
let attempts = 0;

function tanya() {
  rl.question('Masukkan salah satu angka 1–100: ', (input) => {
    const guess = Number(input);
    if (isNaN(guess) || guess < 1 || guess > 100) {
      console.log('Harus angka antara 1–100.');
      return tanya();
    }

    attempts++;
    if (guess > target) {
      console.log('Terlalu tinggi! Coba lagi.');
      tanya();
    } else if (guess < target) {
      console.log('Terlalu rendah! Coba lagi.');
      tanya();
    } else {
      console.log(`Selamat! Kamu berhasil menebak angka ${target} dengan benar.`);
      console.log(`Sebanyak ${attempts}x percobaan.`);
      rl.close();
    }
  });
}

tanya();
