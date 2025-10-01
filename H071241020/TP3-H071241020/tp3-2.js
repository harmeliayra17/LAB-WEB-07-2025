const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

function hitungDiskon(harga, jenis) {
  const diskonMap = {
    elektronik: 0.10,
    pakaian: 0.20,
    makanan: 0.05
  };

  const jenisLower = jenis.toLowerCase();
  const persenDiskon = diskonMap[jenisLower] || 0;
  const potongan = harga * persenDiskon;
  const hargaAkhir = harga - potongan;

  return { persenDiskon, potongan, hargaAkhir };
}

rl.question("Masukkan harga barang: ", (hargaInput) => {
  const harga = Number(hargaInput);

  if (isNaN(harga) || harga <= 0) {
    console.log("❌ Harga harus berupa angka positif.");
    rl.close();
    return;
  }

  rl.question(
    "Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ",
    (jenisInput) => {
      const { persenDiskon, potongan, hargaAkhir } =
        hitungDiskon(harga, jenisInput);

      console.log("\n=== Rincian Harga ===");
      console.log(`Harga awal        : Rp ${harga}`);
      console.log(`Jenis barang      : ${jenisInput}`);
      console.log(`Diskon            : ${persenDiskon * 100}%`);
      console.log(`Potongan harga    : Rp ${potongan}`);
      console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);

      rl.close();
    }
  );
});
