function cariangkagenap(start, end) {
  let angkagenap = []; 
  
  for (let i = start; i <= end; i++) {
    if (i % 2 === 0) {
      angkagenap.push(i); 
    }
  }
  return angkagenap; 
}

const angkagenapDitemukan = cariangkagenap(2,100);

console.log(angkagenapDitemukan.length , angkagenapDitemukan);