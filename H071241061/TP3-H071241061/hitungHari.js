const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const days = ['minggu','senin','selasa','rabu','kamis','jumat','sabtu'];

rl.question('Masukkan hari: ', (hariInput) => {
  const startDay = hariInput.trim().toLowerCase();
  const index = days.indexOf(startDay);
  if (index === -1) {
    console.log('Nama hari tidak valid.');
    return rl.close();
  }

  rl.question('Masukkan jumlah hari ke depan: ', (jumlahInput) => {
    const jumlah = Number(jumlahInput);
    if (isNaN(jumlah) || jumlah < 0) {
      console.log('Jumlah hari harus berupa angka >= 0.');
      return rl.close();
    }

    const newIndex = (index + (jumlah % 7)) % 7;
    console.log(`${jumlah} hari setelah ${startDay} adalah ${days[newIndex]}`);
    rl.close();
  });
});
