const readline = require('readline');
const { validateNumber, validateAlphabet, askUntilValid } = require('./errorHandling')

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

(async () => {
    try {
        const price = await askUntilValid(rl, 'Masukkan harga barang: ', validateNumber)
        
        let type
        while (true) {
            type = await askUntilValid(rl, 'Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ', validateAlphabet);
            
            type = type.toLowerCase();
            if (["elektronik", "pakaian", "makanan", "lainnya"].includes(type)) {
                break;
            } else {
                console.log("Input barang tidak valid, coba lagi. \n")
            }
        }
        let discount = 0
        let priceDiscount = 0
        
        if (type === "elektronik") {
            discount = 0.10
            priceDiscount = price * discount
        } else if (type === "pakaian") {
            discount = 0.20
            priceDiscount = price * discount
        } else if (type === "makanan") {
            discount = 0.05
            priceDiscount = price * discount
        } else if (type === "lainnya") {
            discount = 0
            console.log("gak ada diskon")
        } 
        
        console.log("\nHarga awal: Rp " + price)
        console.log("Diskon: " + discount * 100 + "%")
        console.log("Harga setelah diskon: Rp " + (price - priceDiscount))
    } finally {
        rl.close();
    }
})();