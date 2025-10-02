const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question('Masukkan harga barang: ', (hargaInput) => {
    rl.question('Masukkan jenis barang (elektronik, pakaian, makanan): ', (jenisInput) => {
        const harga = parseInt(hargaInput);
        const jenis = jenisInput.toLowerCase();
        let diskonPersen;

        if (isNaN(harga) || harga <= 0) {
            console.log("Error: Harga harus berupa angka yang lebih besar dari 0.");
            rl.close();
            return; 
        }

        if (jenis === 'elektronik') {
            diskonPersen = 10;
        } else if (jenis === 'pakaian') {
            diskonPersen = 20;
        } else if (jenis === 'makanan') {
            diskonPersen = 5;
        } 
        
        if (diskonPersen === undefined) {
            console.log("Error: Jenis barang tidak valid. Pilih dari elektronik, pakaian, atau makanan.");
            rl.close();
            return; 
        }

        const diskonJumlah = harga * (diskonPersen / 100);
        const hargaAkhir = harga - diskonJumlah;

        console.log("\n--- Hasil Perhitungan ---");
        console.log("Harga Awal: Rp " + harga);
        console.log("Diskon: " + diskonPersen + "%");
        console.log("Harga Akhir: Rp " + hargaAkhir);

        rl.close();
    });
});