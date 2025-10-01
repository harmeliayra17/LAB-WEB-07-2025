const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const target = Math.floor(Math.random() * 100) + 1;
let percobaan = 0;

console.log("=== Permainan Tebak Angka ===");
console.log("Saya sudah memilih angka antara 1 sampai 100.");
console.log("Coba tebak!");

function tanyaTebakan() {
  rl.question("Masukkan tebakan kamu: ", (jawaban) => {
    const angka = Number(jawaban);

    if (isNaN(angka) || angka < 1 || angka > 100) {
      console.log("❌ Input harus angka 1–100. Coba lagi.");
      return tanyaTebakan();
    }

    percobaan++;

    if (angka > target) {
      console.log("Terlalu tinggi! Coba lagi.");
      tanyaTebakan();
    } else if (angka < target) {
      console.log("Terlalu rendah! Coba lagi.");
      tanyaTebakan();
    } else {
      console.log(`🎉 Selamat! Kamu menebak angka ${target} dengan benar.`);
      console.log(`Jumlah percobaan: ${percobaan}x`);
      rl.close();
    }
  });
}

tanyaTebakan();
