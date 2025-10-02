const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

const target = Math.floor(Math.random() * 100) + 1;
let attempts = 0;

function askGuess() {
  rl.question("Masukkan salah satu dari angka 1 sampai 100: ", (guessInput) => {
    let guess = parseInt(guessInput);

    if (isNaN(guess) || guess < 1 || guess > 100) {
      console.log("Input harus angka antara 1-100!");
      askGuess();
      return;
    }

    attempts++;

    if (guess > target) {
      console.log("Terlalu tinggi! Coba lagi.");
      askGuess();
    } else if (guess < target) {
      console.log("Terlalu rendah! Coba lagi.");
      askGuess();
    } else {
      console.log(
        `Selamat! Kamu berhasil menebak angka ${target} dengan benar.`
      );
      console.log(
        `Sebanyak ${attempts}x percobaan.`
    )
      rl.close();
    }
  });
}

askGuess();