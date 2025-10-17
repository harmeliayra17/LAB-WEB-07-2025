function count(start, end) {

    if (typeof start !== "number" || typeof end !== "number") {
        console.log("Input harus berupa angka.");
        return;
    }

    const genap = [];

    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
            genap.push(i);
        }
    }

    console.log(genap.length, genap);
}

count(1, 10);