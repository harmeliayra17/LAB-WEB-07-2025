const readline = require("readline");
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

const days = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];
const cap = (w) => w[0].toUpperCase() + w.slice(1);

rl.question("Masukkan hari: ", (hari) => {
  const index = days.indexOf(hari.toLowerCase());
  if (index === -1) return rl.close(console.log("Nama hari tidak valid!"));

  rl.question("Masukkan jumlah hari ke depan: ", (n) => {
    n = parseInt(n);
    if (isNaN(n)) return rl.close(console.log("Jumlah hari harus berupa angka!"));

    const result = days[(index + n) % 7];
    console.log(`${n} hari setelah ${cap(days[index])} adalah ${cap(result)}`);
    rl.close();
  });
});
