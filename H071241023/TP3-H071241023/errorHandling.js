const readline = require('readline');

function validateNumber(input) {
    if (!/^\d+$/.test(input.trim())) {
        throw new Error("Input harus berupa angka.");
    }
    return Number(input);
}

function validateAlphabet(input) {
    if (!/^[a-zA-Z]+$/.test(input.trim())) {
        throw new Error("Input harus berupa huruf/abjad saja.");
    }
    return input.trim();
}

function askUntilValid(rl, question, validator) {
    return new Promise((resolve) => {
        const loop = () => {
        rl.question(question, (answer) => {
            try {
                resolve(validator(answer));
            } catch (err) {
                console.log(err.message + "\n");
                loop(); 
            }
            });
        };
        loop();
    });
}

module.exports = { validateNumber, validateAlphabet, askUntilValid, readline };
