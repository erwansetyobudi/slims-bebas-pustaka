# Bebas Pustaka SLiMS

**Modifikator:** Erwan Setyo Budi ([erwans818@gmail.com](mailto:erwans818@gmail.com))  
**Asal Plugin:** Dimodifikasi dari [slims-bebas-pustaka](https://github.com/drajathasan/slims-bebas-pustaka)  

Plugin ini digunakan untuk mengelola fitur **Bebas Pustaka** pada **SLiMS** (Senayan Library Management System).  
Modifikasi ini menambahkan beberapa fitur baru untuk meningkatkan fungsionalitas.

---

## ✨ **Fitur Tambahan**
1. **Merubah Status Keanggotaan Menjadi Pending**  
   - Setelah **surat bebas pustaka dicetak**, status anggota akan otomatis berubah menjadi **pending** (`is_pending = 1`).
   
2. **Penambahan Halaman Daftar Pengguna yang Sudah Melakukan Bebas Pustaka**  
   - Menampilkan daftar anggota yang telah menyelesaikan proses bebas pustaka.

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


