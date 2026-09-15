# 🛒 FreshGrocer — Online Grocery Management System

[![Java](https://img.shields.io/badge/Language-Java-orange?style=for-the-badge&logo=java)](https://www.java.com/)
[![Maven](https://img.shields.io/badge/Build-Apache%20Maven-red?style=for-the-badge&logo=apachemaven)](https://maven.apache.org/)
[![PHP](https://img.shields.io/badge/Frontend-PHP-777BB4?style=for-the-badge&logo=php)](https://www.php.net/)
[![JaCoCo](https://img.shields.io/badge/Coverage-JaCoCo-green?style=for-the-badge)](#)
[![CI/CD](https://img.shields.io/badge/CI%2FCD-GitHub%20Actions-blue?style=for-the-badge&logo=githubactions)](https://github.com/)

> **Proyek Tugas Akhir Semester (UAS) — Kelompok 7**
> **FreshGrocer** adalah sistem pengelolaan pemesanan dan katalog produk bahan makanan segar (*online grocery*). Proyek ini menggabungkan *backend* berbasis **Java (Maven)** untuk pemrosesan logika bisnis & *order handler*, pengujian perangkat lunak komprehensif (Unit Test, Integration Test, & JaCoCo Code Coverage), *frontend* interaktif berbasis **PHP & JavaScript**, serta otomatisasi integrasi berkelanjutan (**GitHub Actions CI**).

---

## 🌟 Fitur Utama

1. **📦 Management & Order Handling (`OrderHandler.java`)**
   - Pemrosesan data pesanan (*orders*) dan katalog produk (*products*) menggunakan dataset JSON (`orders.json` & `products.json`).
   - Validasi dan pembersihan data (*data cleaning*) untuk memastikan integritas data transaksi.

2. **🧪 Software Testing & Quality Assurance**
   - **Unit Testing**: Pengujian logika independen pada kelas service (`UnitTest.java`, `OrderServiceTest.java`).
   - **Integration Testing**: Pengujian alur kerja end-to-end antara penanganan pesanan dan data layer (`IntegrationTest.java`).
   - **Code Coverage**: Analisis cakupan kode secara otomatis menggunakan **JaCoCo Plugin** yang menghasilkan laporan HTML/XML.

3. **💻 Interactive Frontend UI**
   - Dashboard web berbasis **PHP** (`frontend/index.php`) dan skrip antarmuka **JavaScript** (`frontend/assets/app.js`).
   - Menampilkan katalog produk, status pesanan, dan pemrosesan data belanja secara terintegrasi.

4. **⚙️ Automated CI/CD Pipeline**
   - Otomatisasi pengujian, kompilasi, dan pembuatan laporan coverage setiap kali ada *push* atau *pull request* melalui **GitHub Actions** (`.github/workflows/ci.yml`).

---

## 📁 Struktur Direktori Proyek

```text
UAS_Kelompok7-main/
├── .github/
│   └── workflows/
│       └── ci.yml                      # Workflow CI/CD GitHub Actions
├── data/
│   ├── orders.json                     # Raw dataset pesanan
│   ├── orders.clean.json               # Cleaned dataset pesanan
│   ├── products.json                   # Raw dataset katalog produk
│   └── products.clean.json             # Cleaned dataset katalog produk
├── frontend/
│   ├── assets/
│   │   └── app.js                      # Logika JavaScript interaktif frontend
│   └── index.php                       # Tampilan utama dashboard web FreshGrocer
├── src/
│   ├── main/
│   │   └── java/
│   │       ├── Main.class
│   │       └── com/freshgrocer/
│   │           └── OrderHandler.java   # Core backend business logic
│   └── test/
│       └── java/
│           └── com/freshgrocer/
│               ├── IntegrationTest.java # Suite pengujian integrasi
│               ├── OrderServiceTest.java # Suite pengujian service pesanan
│               └── UnitTest.java        # Suite pengujian unit
├── target/                             # Output kompilasi Maven & laporan JaCoCo
│   ├── classes/                        # File .class hasil kompilasi
│   ├── site/jacoco/                    # Laporan HTML Code Coverage JaCoCo
│   └── surefire-reports/               # Laporan hasil eksekusi tes JUnit
└── pom.xml                             # Konfigurasi Maven (Dependencies & Plugins)
