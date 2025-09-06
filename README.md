# LAB-WEB-07-2025
Repositori untuk pengumpulan Tugas Praktikum Lab Web Programming 2025  
Program Studi Sistem Informasi - Universitas Hasanuddin

---

## Aturan Pengumpulan

**Catatan:**  
- Teks yang dibungkus `< >` harus diganti sesuai instruksi.  
- Contoh: `mkdir <NIM>` → `mkdir H071221001`.

---

### 1. Fork Repository
1. Buka repositori ini di GitHub.  
2. Klik tombol **Fork** di kanan atas.  
3. Repository hasil fork akan muncul di akun GitHub kalian.

---

### 2. Clone Repository Hasil Fork
Jalankan perintah berikut di terminal atau Git Bash:

```bash
git clone <url-repositori-hasil-fork>
````

Contoh:

```bash
git clone https://github.com/username/LAB-WEB-07-2025.git
```

---

### 3. Masuk ke Folder Repository

```bash
cd LAB-WEB-07-2025
```

---

### 4. Buat Folder Sesuai NIM

Buat folder dengan format:

```bash
mkdir <NIM>
```

Contoh:

```bash
mkdir H071221001
```

---

### 5. Tambahkan File Tugas

* Setiap tugas per minggu dikumpulkan dalam **satu folder** dengan format:

  ```
  TP<tugas keberapa>-<NIM>
  ```

  Contoh:

  ```
  TP1-H071221001/
      ├── index.html
      └── style.css
  TP2-H071221001/
      ├── tugas2.html
      └── style2.css
  ```

* Folder ini diletakkan di dalam folder NIM masing-masing:

  ```
  LAB-WEB-07-2025/
  ├── H071221001/
  │   ├── TP1-H071221001/
  │   └── TP2-H071221001/
  └── H071221002/
      ├── TP1-H071221002/
      └── TP2-H071221002/
  ```

---

### 6. Add, Commit, dan Push

Setelah menambahkan atau memperbarui file tugas:

```bash
git add .
git commit -m "<pesan commit>"
git push origin main
```

---

## Aturan Commit Message

Gunakan format **Conventional Commits** agar pesan commit lebih rapi dan konsisten.

**Struktur:**

```
<type>(<scope>): <deskripsi singkat>
```

**Jenis commit yang digunakan:**

* `feat` : menambahkan tugas/fitur baru
* `fix` : memperbaiki error atau typo pada tugas
* `docs` : mengubah dokumentasi (README, aturan, dsb.)
* `refactor` : merapikan kode tanpa mengubah fungsi
* `style` : perubahan gaya atau format kode (indentasi, spasi, dsb.)
* `chore` : perubahan lain yang tidak memengaruhi kode utama

**Contoh commit message:**

* `feat: menambahkan TP1-H071221001`
* `fix: memperbaiki typo pada TP2-H071221002`

---

## Pull Request

1. Buka repository hasil fork di akun GitHub kalian.
2. Klik tombol **Contribute** → pilih **Open Pull Request**.
3. **Judul PR wajib mengikuti format:**

```
TP<tugas keberapa>-<NIM>
```

Contoh:

```
TP1-H071221001
TP2-H071221002
```

4. Deskripsi PR harus mencantumkan daftar file yang ditambahkan atau diperbarui di folder TP masing-masing.
5. Klik **Create Pull Request**.

---