# Bebas Pustaka SLiMS

**Modifikator:** Erwan Setyo Budi ([erwans818@gmail.com](mailto:erwans818@gmail.com))  
**Asal Plugin:** Dimodifikasi dari [slims-bebas-pustaka](https://github.com/drajathasan/slims-bebas-pustaka)  

Plugin ini digunakan untuk mengelola fitur **Bebas Pustaka** pada **SLiMS** (Senayan Library Management System).  
Modifikasi ini menambahkan beberapa fitur baru untuk meningkatkan fungsionalitas.

---

## ➕ Fitur Tambahan

1. ✅ **Status Keanggotaan Menjadi Pending Otomatis**  
   Setelah surat dicetak, status `is_pending` pada tabel anggota akan diset otomatis ke `1`.

2. ✅ **Halaman Riwayat Bebas Pustaka**  
   Tersedia daftar siapa saja yang sudah menyelesaikan proses, lengkap dengan nomor surat dan waktu.

3. ✅ **Nomor Surat Reset Setiap Tahun**  
   Nomor surat akan kembali dari **1** saat memasuki tahun baru, namun tetap mempertahankan urutan dalam tahun berjalan.

4. ✅ **Penyimpanan UID (User ID)**  
   Mencatat pustakawan (admin) yang mencetak surat, disimpan dalam kolom `uid` pada tabel `bebas_pustaka_history`.

5. ✅ **Proteksi Duplikat Surat**  
   Jika surat untuk anggota sudah pernah dicetak, sistem akan otomatis mengambil nomor lama dan tidak membuat entri ganda.

---

## 🔧 **Cara Install**
1. **Unduh** plugin ini dari repository GitHub.
2. **Letakkan** folder plugin ini di dalam direktori **`slims-root/plugins/`**.
3. **Aktifkan** plugin melalui **Menu Sistem** → **Plugins**.

---

## Contoh Pengaturan

```html
Letter Number : PERPUS/B/{no}/{y}
Open State : Yang bertandatangan di bawah ini Kepala Unit Perpustakaan menerangkan bahwa:
Close State : 

<ol>
<li>Telah mengembalikan semua pinjaman buku</li>
<li>Telah mengumpulkan KTI/Skripsi/Tesis dalam bentuk hardcopy dan softcopy</li>
<li>Telah mengunggah secara mandiri KTI/Skripsi/Tesis ke Repository</li>
<li>Telah mengumpulkan KTI/Skripsi/Tesis</li>
</ol>

City : Semarang  
Librarian Position : Kepala Unit Perpustakaan  
Librarian : Erwan Setyo Budi  
Num ID : NIP 1937349349349375




## ⚙ **Cara Menggunakan**
- Setelah diaktifkan, plugin ini akan **mengubah status keanggotaan menjadi pending** secara otomatis saat surat bebas pustaka dicetak.
- Halaman daftar pengguna bebas pustaka dapat diakses melalui antarmuka SLiMS.

---

## 📩 **Kontak & Kontribusi**
Jika ada bug atau fitur yang ingin ditambahkan, silakan buat **issue** atau **pull request**.  
📧 Hubungi: [erwans818@gmail.com](mailto:erwans818@gmail.com)  

Terima kasih telah menggunakan **Bebas Pustaka SLiMS**! 🚀

## ScreenShoot

![image](https://github.com/user-attachments/assets/faacd040-251b-4c55-9fef-5b4724bfd713)

![image](https://github.com/user-attachments/assets/4d1134db-88c7-40ed-85ae-638d3d3308e2)


