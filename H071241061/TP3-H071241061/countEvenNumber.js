function countEvenNumbers(start, end) {
  const evenNumbers = [];
  for (let i = start; i <= end; i++) {
    if (i % 2 === 0) evenNumbers.push(i);
  }
  console.log(`${evenNumbers.length} [${evenNumbers.join(', ')}]`);
  return evenNumbers.length;
}
countEvenNumbers(17, 97);