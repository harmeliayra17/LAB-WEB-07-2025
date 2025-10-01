const { validateNumber, askUntilValid } = require('./errorHandling');
const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const dayList = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];

(async () => {
    try {
        const day = await askUntilValid(rl, "Masukkan hari: ", (ans) => {
            const norm = ans.trim().toLowerCase();
            if (!dayList.some(d => d.toLowerCase() === norm)) {
                throw new Error("Hari tidak valid. Coba lagi!");
            }
            return dayList.find(d => d.toLowerCase() === norm);
        });

        const futureDay = await askUntilValid(rl, "Masukkan hari yang akan datang: ", validateNumber);

        const index = dayList.findIndex(d => d.toLowerCase() === day.toLowerCase());
        const nextIndex = (index + (futureDay % dayList.length) + dayList.length) % dayList.length;
        console.log(`${futureDay} hari setelah ${day} adalah ${dayList[nextIndex]}`);
        } finally {
            rl.close();
        }
})();
