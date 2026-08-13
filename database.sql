-- Buat database
CREATE DATABASE IF NOT EXISTS desa_jayapura;
USE desa_jayapura;

-- Tabel users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15),
    role ENUM('admin', 'warga', 'pelaku_umkm') DEFAULT 'warga',
    avatar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel umkm_categories
CREATE TABLE umkm_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) UNIQUE NOT NULL,
    icon VARCHAR(50),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel umkm
CREATE TABLE umkm (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    name VARCHAR(100) NOT NULL,
    category_id INT,
    subcategory VARCHAR(50),
    description TEXT,
    address VARCHAR(255),
    phone VARCHAR(15),
    whatsapp VARCHAR(15),
    image VARCHAR(255),
    rating DECIMAL(2,1) DEFAULT 0.0,
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES umkm_categories(id) ON DELETE SET NULL
);

-- Tabel favorites
CREATE TABLE favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    umkm_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_favorite (user_id, umkm_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (umkm_id) REFERENCES umkm(id) ON DELETE CASCADE
);

-- Tabel announcements
CREATE TABLE announcements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    category VARCHAR(50),
    image VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    is_urgent BOOLEAN DEFAULT FALSE,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Tabel surat
CREATE TABLE surat (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    jenis_surat VARCHAR(100) NOT NULL,
    keterangan TEXT,
    status ENUM('Menunggu', 'Diproses', 'Selesai', 'Ditolak') DEFAULT 'Menunggu',
    tanggal_pengajuan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel aspirasi
CREATE TABLE aspirasi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    pesan TEXT NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    status ENUM('Menunggu', 'Diproses', 'Selesai') DEFAULT 'Menunggu',
    tanggapan TEXT DEFAULT NULL,
    tanggal_kirim TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert sample data
INSERT INTO umkm_categories (name, slug, icon) VALUES
('Kuliner', 'kuliner', 'restaurant'),
('Kerajinan', 'kerajinan', 'palette'),
('Jasa', 'jasa', 'construction'),
('Pertanian', 'pertanian', 'eco');

-- Default admin (password: admin123)
INSERT INTO users (username, password, full_name, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator Desa', 'admin@jayapura.desa.id', 'admin');

-- Sample UMKM
INSERT INTO umkm (user_id, name, category_id, subcategory, description, address, phone, whatsapp, image, rating, is_featured) VALUES
(1, 'Sambal Mak Nyuss', 1, 'Pedas & Gurih', 'Sambal tradisional buatan rumah dengan resep turun-temurun.', 'Dusun I, Jayapura', '081234567890', '6281234567890', 'img/IMG_0791.JPG.jpeg', 4.8, TRUE),
(1, 'Mebel Jati Mandiri', 1, 'Perabot Kayu', 'Ahli pembuatan lemari, meja, dan kursi jati custom.', 'Dusun II, Jayapura', '081234567891', '6281234567891', 'img/IMG_0790.JPG.jpeg', 4.9, TRUE);

-- Sample announcements
INSERT INTO announcements (title, content, category, is_featured, is_urgent, created_by) VALUES
('Musyawarah Perencanaan Pembangunan Desa 2024', 'Seluruh warga diundang untuk hadir dan menyalurkan aspirasi pembangunan desa.', 'Penting', TRUE, TRUE, 1),
('Jadwal Posyandu & Imunisasi Balita', 'Posyandu balita akan dilaksanakan serentak di seluruh pos kesehatan desa.', 'Kesehatan', TRUE, FALSE, 1);