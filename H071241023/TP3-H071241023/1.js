function countEvenNumber(start, end) {
    let evenNumber = []

    for (let num = start; num <= end; num++){
        if (num % 2 == 0) {
            evenNumber.push(num)
        }
    }
    return {
        count: evenNumber.length,
        numbers: evenNumber
    }
}

let result = countEvenNumber(3, 88)
console.log(result.count, result.numbers)
