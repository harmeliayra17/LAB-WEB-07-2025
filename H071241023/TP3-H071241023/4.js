const { validateNumber, askUntilValid } = require('./errorHandling');
const readline = require('readline');

function getRandom(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min
}

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const MIN = 1
const MAX = 100
const angkaRandom = getRandom(1, 100)
let percobaan = 0;
    
    (async () => {
        try {
            while (true) {
                const tebakan = await askUntilValid(rl, "Masukkan salah satu dari angka 1 sampai 100: ", (ans) => {
                    const n = validateNumber(ans)
                    if (n < MIN || n > MAX) {
                        throw new Error(`Masukkan bilangan bulat antara ${MIN} - ${MAX}`)
                    }
                    return n
                })
                percobaan++
                if (tebakan > angkaRandom) {
                    console.log("Terlalu tinggi! Coba lagi.")
                } else if (tebakan < angkaRandom) {
                    console.log("Terlalu rendah! Coba lagi.")
                } else {
                    console.log("Selamat! kamu berhasil menebak angka ", angkaRandom, " dengan benar.")
                    console.log("Sebanyak ", percobaan, "x percobaan")
                    break
                }
            }
        } catch (e) {
            console.log("Terjadi kesalahan", e.message)
        } finally {
            rl.close()
        }
    })();

