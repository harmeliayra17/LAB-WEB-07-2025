const readline = require("readline");
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

const diskonMap = { elektronik: 0.1, pakaian: 0.2, makanan: 0.05, lainnya: 0 };

rl.question("Masukkan harga barang: ", (hargaInput) => {
  const harga = parseFloat(hargaInput);
  if (isNaN(harga)) return rl.close(console.log("Input harga harus berupa angka!"));

  rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenis) => {
    jenis = jenis.toLowerCase();
    if (!(jenis in diskonMap)) return rl.close(console.log("Ketik lainnya woi!"));

    const diskon = diskonMap[jenis];
    const hargaAkhir = harga - harga * diskon;

    console.log(`Harga awal: Rp ${harga}`);
    console.log(`Diskon: ${diskon * 100}%`);
    console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);

    rl.close();
  });
});