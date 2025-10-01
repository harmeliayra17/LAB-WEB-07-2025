const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const days = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];

function hitungHari(hariAwal, jumlahHari) {
  const lowerDay = hariAwal.toLowerCase();

  const startIndex = days.indexOf(lowerDay);
  if (startIndex === -1) {
    throw new Error(
      "Hari tidak valid. Gunakan: Minggu, Senin, Selasa, Rabu, Kamis, Jumat, Sabtu."
    );
  }

  const nextIndex = (startIndex + jumlahHari) % 7;
  return days[nextIndex];
}

rl.question("Masukkan hari (Minggu/Senin/…/Sabtu): ", (hariInput) => {
  rl.question("Masukkan jumlah hari ke depan: ", (jumlahInput) => {
    const jumlahHari = Number(jumlahInput);

    if (isNaN(jumlahHari) || jumlahHari < 0) {
      console.log("❌ Jumlah hari harus berupa angka >= 0.");
      rl.close();
      return;
    }

    try {
      const hasil = hitungHari(hariInput, jumlahHari);
      console.log(
        `${jumlahHari} hari setelah ${hariInput} adalah ${hasil.charAt(0).toUpperCase() + hasil.slice(1)}`
      );
    } catch (err) {
      console.log("❌ " + err.message);
    }

    rl.close();
  });
});
