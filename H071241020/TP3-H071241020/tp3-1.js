function countEvenNumbers(start, end) {
  if (typeof start !== "number" || typeof end !== "number") {
    throw new Error("Parameter harus berupa angka");
  }
  if (start > end) {
    throw new Error("Start tidak boleh lebih besar dari End");
  }

  const evenNumbers = []; 
  for (let i = start; i <= end; i++) {
    if (i % 2 === 0) {
      evenNumbers.push(i);
    }
  }

  return `${evenNumbers.length} [${evenNumbers.join(", ")}]`;
}

console.log(countEvenNumbers(3, 10)); 
console.log(countEvenNumbers(3, 5)); 
console.log(countEvenNumbers(7, 13)); 
