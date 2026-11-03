USE db_uts_2;

-- Contoh View
CREATE OR REPLACE VIEW view_penjualan AS
SELECT p.idpenjualan, p.created_at, p.total_nilai, u.nama AS kasir
FROM penjualan p
JOIN user u ON p.iduser = u.iduser;

-- (Tambahkan 14 view lainnya milikmu di bawah sini)