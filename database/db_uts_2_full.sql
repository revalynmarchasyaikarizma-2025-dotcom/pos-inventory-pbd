-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.0.30 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk db_uts_2
CREATE DATABASE IF NOT EXISTS `db_uts_2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_uts_2`;

-- membuang struktur untuk table db_uts_2.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `idbarang` int NOT NULL AUTO_INCREMENT,
  `jenis` char(1) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `idsatuan` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `harga` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idbarang`),
  KEY `idsatuan` (`idsatuan`),
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`idsatuan`) REFERENCES `satuan` (`idsatuan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.detail_penerimaan
CREATE TABLE IF NOT EXISTS `detail_penerimaan` (
  `iddetail_penerimaan` bigint NOT NULL AUTO_INCREMENT,
  `idpenerimaan` bigint NOT NULL,
  `barang_idbarang` int NOT NULL,
  `jumlah_terima` int NOT NULL DEFAULT '0',
  `harga_satuan_terima` int NOT NULL DEFAULT '0',
  `sub_total_terima` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`iddetail_penerimaan`),
  KEY `idpenerimaan` (`idpenerimaan`),
  KEY `barang_idbarang` (`barang_idbarang`),
  CONSTRAINT `detail_penerimaan_ibfk_1` FOREIGN KEY (`idpenerimaan`) REFERENCES `penerimaan` (`idpenerimaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detail_penerimaan_ibfk_2` FOREIGN KEY (`barang_idbarang`) REFERENCES `barang` (`idbarang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.detail_pengadaan
CREATE TABLE IF NOT EXISTS `detail_pengadaan` (
  `iddetail_pengadaan` bigint NOT NULL AUTO_INCREMENT,
  `harga_satuan` int NOT NULL DEFAULT '0',
  `jumlah` int NOT NULL DEFAULT '0',
  `sub_total` int NOT NULL DEFAULT '0',
  `idbarang` int NOT NULL,
  `idpengadaan` bigint NOT NULL,
  PRIMARY KEY (`iddetail_pengadaan`),
  KEY `idbarang` (`idbarang`),
  KEY `idpengadaan` (`idpengadaan`),
  CONSTRAINT `detail_pengadaan_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detail_pengadaan_ibfk_2` FOREIGN KEY (`idpengadaan`) REFERENCES `pengadaan` (`idpengadaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.detail_penjualan
CREATE TABLE IF NOT EXISTS `detail_penjualan` (
  `iddetail_penjualan` bigint NOT NULL AUTO_INCREMENT,
  `harga_satuan` int NOT NULL DEFAULT '0',
  `jumlah` int NOT NULL DEFAULT '0',
  `subtotal` int NOT NULL DEFAULT '0',
  `penjualan_idpenjualan` int NOT NULL,
  `idbarang` int NOT NULL,
  PRIMARY KEY (`iddetail_penjualan`),
  KEY `penjualan_idpenjualan` (`penjualan_idpenjualan`),
  KEY `idbarang` (`idbarang`),
  CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`penjualan_idpenjualan`) REFERENCES `penjualan` (`idpenjualan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.detail_retur
CREATE TABLE IF NOT EXISTS `detail_retur` (
  `iddetail_retur` int NOT NULL AUTO_INCREMENT,
  `jumlah` int NOT NULL DEFAULT '0',
  `alasan` varchar(200) NOT NULL,
  `idretur` bigint NOT NULL,
  `iddetail_penerimaan` bigint NOT NULL,
  PRIMARY KEY (`iddetail_retur`),
  KEY `idretur` (`idretur`),
  KEY `iddetail_penerimaan` (`iddetail_penerimaan`),
  CONSTRAINT `detail_retur_ibfk_1` FOREIGN KEY (`idretur`) REFERENCES `retur` (`idretur`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detail_retur_ibfk_2` FOREIGN KEY (`iddetail_penerimaan`) REFERENCES `detail_penerimaan` (`iddetail_penerimaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk function db_uts_2.f_hitung_total_penjualan
DELIMITER //
CREATE FUNCTION `f_hitung_total_penjualan`(
    p_iduser INT
) RETURNS int
    READS SQL DATA
    DETERMINISTIC
BEGIN
    DECLARE v_total_omset INT DEFAULT 0;

    -- Hitung jumlah total_nilai penjualan berdasarkan iduser (kasir)
    SELECT IFNULL(SUM(total_nilai), 0) INTO v_total_omset
    FROM penjualan
    WHERE iduser = p_iduser;

    RETURN v_total_omset;
END//
DELIMITER ;

-- membuang struktur untuk table db_uts_2.kartu_stok
CREATE TABLE IF NOT EXISTS `kartu_stok` (
  `idkartu_stok` bigint NOT NULL AUTO_INCREMENT,
  `jenis_transaksi` char(1) NOT NULL,
  `masuk` int NOT NULL DEFAULT '0',
  `keluar` int NOT NULL DEFAULT '0',
  `stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `idtransaksi` int NOT NULL,
  `idbarang` int NOT NULL,
  PRIMARY KEY (`idkartu_stok`),
  KEY `idbarang` (`idbarang`),
  CONSTRAINT `kartu_stok_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.margin_penjualan
CREATE TABLE IF NOT EXISTS `margin_penjualan` (
  `idmargin_penjualan` int NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `persen` double NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `iduser` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmargin_penjualan`),
  KEY `iduser` (`iduser`),
  CONSTRAINT `margin_penjualan_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.penerimaan
CREATE TABLE IF NOT EXISTS `penerimaan` (
  `idpenerimaan` bigint NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL,
  `idpengadaan` bigint NOT NULL,
  `iduser` int NOT NULL,
  PRIMARY KEY (`idpenerimaan`),
  KEY `idpengadaan` (`idpengadaan`),
  KEY `iduser` (`iduser`),
  CONSTRAINT `penerimaan_ibfk_1` FOREIGN KEY (`idpengadaan`) REFERENCES `pengadaan` (`idpengadaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penerimaan_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.pengadaan
CREATE TABLE IF NOT EXISTS `pengadaan` (
  `idpengadaan` bigint NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_iduser` int NOT NULL,
  `status` char(1) NOT NULL,
  `vendor_idvendor` int NOT NULL,
  `subtotal_nilai` int NOT NULL DEFAULT '0',
  `ppn` int NOT NULL DEFAULT '0',
  `total_nilai` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idpengadaan`),
  KEY `user_iduser` (`user_iduser`),
  KEY `vendor_idvendor` (`vendor_idvendor`),
  CONSTRAINT `pengadaan_ibfk_1` FOREIGN KEY (`user_iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pengadaan_ibfk_2` FOREIGN KEY (`vendor_idvendor`) REFERENCES `vendor` (`idvendor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.penjualan
CREATE TABLE IF NOT EXISTS `penjualan` (
  `idpenjualan` int NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subtotal_nilai` int NOT NULL DEFAULT '0',
  `ppn` int NOT NULL DEFAULT '0',
  `total_nilai` int NOT NULL DEFAULT '0',
  `iduser` int NOT NULL,
  `idmargin_penjualan` int NOT NULL,
  PRIMARY KEY (`idpenjualan`),
  KEY `iduser` (`iduser`),
  KEY `idmargin_penjualan` (`idmargin_penjualan`),
  CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`idmargin_penjualan`) REFERENCES `margin_penjualan` (`idmargin_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.retur
CREATE TABLE IF NOT EXISTS `retur` (
  `idretur` bigint NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `idpenerimaan` bigint NOT NULL,
  `iduser` int NOT NULL,
  PRIMARY KEY (`idretur`),
  KEY `idpenerimaan` (`idpenerimaan`),
  KEY `iduser` (`iduser`),
  CONSTRAINT `retur_ibfk_1` FOREIGN KEY (`idpenerimaan`) REFERENCES `penerimaan` (`idpenerimaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `retur_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.role
CREATE TABLE IF NOT EXISTS `role` (
  `idrole` int NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(100) NOT NULL,
  PRIMARY KEY (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.satuan
CREATE TABLE IF NOT EXISTS `satuan` (
  `idsatuan` int NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(45) NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`idsatuan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk procedure db_uts_2.sp_tambah_penjualan
DELIMITER //
CREATE PROCEDURE `sp_tambah_penjualan`(
    IN p_subtotal INT,
    IN p_iduser INT,
    IN p_idmargin INT
)
BEGIN
    DECLARE v_ppn INT;
    DECLARE v_total INT;

    -- Hitung PPN 11% dan Total Nilai Penjualan
    SET v_ppn = ROUND(p_subtotal * 0.11);
    SET v_total = p_subtotal + v_ppn;

    -- Masukkan data header transaksi penjualan baru
    INSERT INTO penjualan (created_at, subtotal_nilai, ppn, total_nilai, iduser, idmargin_penjualan)
    VALUES (NOW(), p_subtotal, v_ppn, v_total, p_iduser, p_idmargin);

    -- Tampilkan ID transaksi penjualan yang baru saja dibuat
    SELECT LAST_INSERT_ID() AS idpenjualan_baru;
END//
DELIMITER ;

-- membuang struktur untuk table db_uts_2.user
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `idrole` int NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `username` (`username`),
  KEY `idrole` (`idrole`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_uts_2.vendor
CREATE TABLE IF NOT EXISTS `vendor` (
  `idvendor` int NOT NULL AUTO_INCREMENT,
  `nama_vendor` varchar(100) NOT NULL,
  `badan_hukum` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`idvendor`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk view db_uts_2.view_detail_penerimaan
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_detail_penerimaan` (
	`iddetail_penerimaan` BIGINT(19) NOT NULL,
	`idpenerimaan` BIGINT(19) NOT NULL,
	`nama_barang` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`jumlah_terima` INT(10) NOT NULL,
	`harga_satuan_terima` INT(10) NOT NULL,
	`sub_total_terima` INT(10) NOT NULL
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_detail_pengadaan
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_detail_pengadaan` (
	`iddetail_pengadaan` BIGINT(19) NOT NULL,
	`idpengadaan` BIGINT(19) NOT NULL,
	`nama_barang` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`harga_satuan` INT(10) NOT NULL,
	`jumlah` INT(10) NOT NULL,
	`sub_total` INT(10) NOT NULL
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_detail_penjualan
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_detail_penjualan` (
	`iddetail_penjualan` BIGINT(19) NOT NULL,
	`idpenjualan` INT(10) NOT NULL,
	`nama_barang` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`harga_satuan` INT(10) NOT NULL,
	`jumlah` INT(10) NOT NULL,
	`subtotal` INT(10) NOT NULL
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_detail_retur
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_detail_retur` (
	`iddetail_retur` INT(10) NOT NULL,
	`idretur` BIGINT(19) NOT NULL,
	`iddetail_penerimaan` BIGINT(19) NOT NULL,
	`jumlah` INT(10) NOT NULL,
	`alasan` VARCHAR(200) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_kartu_stok
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_kartu_stok` (
	`idkartu_stok` BIGINT(19) NOT NULL,
	`created_at` TIMESTAMP NULL,
	`nama_barang` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`jenis_transaksi` CHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`masuk` INT(10) NOT NULL,
	`keluar` INT(10) NOT NULL,
	`stok_akhir` INT(10) NOT NULL,
	`idtransaksi` INT(10) NOT NULL
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_master_barang
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_master_barang` (
	`idbarang` INT(10) NOT NULL,
	`nama_barang` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`jenis` CHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`nama_satuan` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`harga` INT(10) NOT NULL,
	`status` TINYINT(3) NOT NULL
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_master_margin
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_master_margin` (
	`idmargin_penjualan` INT(10) NOT NULL,
	`persen` DOUBLE NOT NULL,
	`status` TINYINT(3) NOT NULL,
	`dibuat_oleh` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`created_at` TIMESTAMP NULL
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_master_role
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_master_role` (
	`idrole` INT(10) NOT NULL,
	`nama_role` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_master_satuan
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_master_satuan` (
	`idsatuan` INT(10) NOT NULL,
	`nama_satuan` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`status` TINYINT(3) NOT NULL
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_master_user
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_master_user` (
	`iduser` INT(10) NOT NULL,
	`username` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`nama_role` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_master_vendor
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_master_vendor` (
	`idvendor` INT(10) NOT NULL,
	`nama_vendor` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`badan_hukum` CHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`status` CHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_penerimaan
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_penerimaan` (
	`idpenerimaan` BIGINT(19) NOT NULL,
	`created_at` TIMESTAMP NULL,
	`idpengadaan` BIGINT(19) NOT NULL,
	`penerima` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`status` CHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_pengadaan
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_pengadaan` (
	`idpengadaan` BIGINT(19) NOT NULL,
	`timestamp` TIMESTAMP NULL,
	`nama_vendor` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`petugas` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`subtotal_nilai` INT(10) NOT NULL,
	`ppn` INT(10) NOT NULL,
	`total_nilai` INT(10) NOT NULL,
	`status` CHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_penjualan
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_penjualan` (
	`idpenjualan` INT(10) NOT NULL,
	`created_at` TIMESTAMP NULL,
	`kasir` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`margin_persen` DOUBLE NOT NULL,
	`subtotal_nilai` INT(10) NOT NULL,
	`ppn` INT(10) NOT NULL,
	`total_nilai` INT(10) NOT NULL
) ENGINE=MyISAM;

-- membuang struktur untuk view db_uts_2.view_retur
-- Membuat tabel sementara untuk menangani kesalahan ketergantungan VIEW
CREATE TABLE `view_retur` (
	`idretur` BIGINT(19) NOT NULL,
	`created_at` TIMESTAMP NULL,
	`idpenerimaan` BIGINT(19) NOT NULL,
	`petugas` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- membuang struktur untuk trigger db_uts_2.trg_penerimaan_kartu_stok
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_penerimaan_kartu_stok` AFTER INSERT ON `detail_penerimaan` FOR EACH ROW BEGIN
    DECLARE stok_terakhir INT DEFAULT 0;

    SELECT stock INTO stok_terakhir
    FROM kartu_stok
    WHERE idbarang = NEW.barang_idbarang
    ORDER BY idkartu_stok DESC LIMIT 1;

    IF stok_terakhir IS NULL THEN
        SET stok_terakhir = 0;
    END IF;

    INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang)
    VALUES ('M', NEW.jumlah_terima, 0, stok_terakhir + NEW.jumlah_terima, NEW.idpenerimaan, NEW.barang_idbarang);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- membuang struktur untuk view db_uts_2.view_detail_penerimaan
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_detail_penerimaan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_detail_penerimaan` AS select `dp`.`iddetail_penerimaan` AS `iddetail_penerimaan`,`dp`.`idpenerimaan` AS `idpenerimaan`,`b`.`nama` AS `nama_barang`,`dp`.`jumlah_terima` AS `jumlah_terima`,`dp`.`harga_satuan_terima` AS `harga_satuan_terima`,`dp`.`sub_total_terima` AS `sub_total_terima` from (`detail_penerimaan` `dp` join `barang` `b` on((`dp`.`barang_idbarang` = `b`.`idbarang`)));

-- membuang struktur untuk view db_uts_2.view_detail_pengadaan
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_detail_pengadaan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_detail_pengadaan` AS select `dp`.`iddetail_pengadaan` AS `iddetail_pengadaan`,`dp`.`idpengadaan` AS `idpengadaan`,`b`.`nama` AS `nama_barang`,`dp`.`harga_satuan` AS `harga_satuan`,`dp`.`jumlah` AS `jumlah`,`dp`.`sub_total` AS `sub_total` from (`detail_pengadaan` `dp` join `barang` `b` on((`dp`.`idbarang` = `b`.`idbarang`)));

-- membuang struktur untuk view db_uts_2.view_detail_penjualan
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_detail_penjualan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_detail_penjualan` AS select `dp`.`iddetail_penjualan` AS `iddetail_penjualan`,`dp`.`penjualan_idpenjualan` AS `idpenjualan`,`b`.`nama` AS `nama_barang`,`dp`.`harga_satuan` AS `harga_satuan`,`dp`.`jumlah` AS `jumlah`,`dp`.`subtotal` AS `subtotal` from (`detail_penjualan` `dp` join `barang` `b` on((`dp`.`idbarang` = `b`.`idbarang`)));

-- membuang struktur untuk view db_uts_2.view_detail_retur
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_detail_retur`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_detail_retur` AS select `dr`.`iddetail_retur` AS `iddetail_retur`,`dr`.`idretur` AS `idretur`,`dr`.`iddetail_penerimaan` AS `iddetail_penerimaan`,`dr`.`jumlah` AS `jumlah`,`dr`.`alasan` AS `alasan` from `detail_retur` `dr`;

-- membuang struktur untuk view db_uts_2.view_kartu_stok
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_kartu_stok`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_kartu_stok` AS select `ks`.`idkartu_stok` AS `idkartu_stok`,`ks`.`created_at` AS `created_at`,`b`.`nama` AS `nama_barang`,`ks`.`jenis_transaksi` AS `jenis_transaksi`,`ks`.`masuk` AS `masuk`,`ks`.`keluar` AS `keluar`,`ks`.`stock` AS `stok_akhir`,`ks`.`idtransaksi` AS `idtransaksi` from (`kartu_stok` `ks` join `barang` `b` on((`ks`.`idbarang` = `b`.`idbarang`)));

-- membuang struktur untuk view db_uts_2.view_master_barang
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_master_barang`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_master_barang` AS select `b`.`idbarang` AS `idbarang`,`b`.`nama` AS `nama_barang`,`b`.`jenis` AS `jenis`,`s`.`nama_satuan` AS `nama_satuan`,`b`.`harga` AS `harga`,`b`.`status` AS `status` from (`barang` `b` join `satuan` `s` on((`b`.`idsatuan` = `s`.`idsatuan`)));

-- membuang struktur untuk view db_uts_2.view_master_margin
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_master_margin`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_master_margin` AS select `m`.`idmargin_penjualan` AS `idmargin_penjualan`,`m`.`persen` AS `persen`,`m`.`status` AS `status`,`u`.`username` AS `dibuat_oleh`,`m`.`created_at` AS `created_at` from (`margin_penjualan` `m` join `user` `u` on((`m`.`iduser` = `u`.`iduser`)));

-- membuang struktur untuk view db_uts_2.view_master_role
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_master_role`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_master_role` AS select `role`.`idrole` AS `idrole`,`role`.`nama_role` AS `nama_role` from `role`;

-- membuang struktur untuk view db_uts_2.view_master_satuan
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_master_satuan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_master_satuan` AS select `satuan`.`idsatuan` AS `idsatuan`,`satuan`.`nama_satuan` AS `nama_satuan`,`satuan`.`status` AS `status` from `satuan`;

-- membuang struktur untuk view db_uts_2.view_master_user
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_master_user`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_master_user` AS select `u`.`iduser` AS `iduser`,`u`.`username` AS `username`,`r`.`nama_role` AS `nama_role` from (`user` `u` join `role` `r` on((`u`.`idrole` = `r`.`idrole`)));

-- membuang struktur untuk view db_uts_2.view_master_vendor
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_master_vendor`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_master_vendor` AS select `vendor`.`idvendor` AS `idvendor`,`vendor`.`nama_vendor` AS `nama_vendor`,`vendor`.`badan_hukum` AS `badan_hukum`,`vendor`.`status` AS `status` from `vendor`;

-- membuang struktur untuk view db_uts_2.view_penerimaan
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_penerimaan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_penerimaan` AS select `pen`.`idpenerimaan` AS `idpenerimaan`,`pen`.`created_at` AS `created_at`,`pen`.`idpengadaan` AS `idpengadaan`,`u`.`username` AS `penerima`,`pen`.`status` AS `status` from (`penerimaan` `pen` join `user` `u` on((`pen`.`iduser` = `u`.`iduser`)));

-- membuang struktur untuk view db_uts_2.view_pengadaan
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_pengadaan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_pengadaan` AS select `p`.`idpengadaan` AS `idpengadaan`,`p`.`timestamp` AS `timestamp`,`v`.`nama_vendor` AS `nama_vendor`,`u`.`username` AS `petugas`,`p`.`subtotal_nilai` AS `subtotal_nilai`,`p`.`ppn` AS `ppn`,`p`.`total_nilai` AS `total_nilai`,`p`.`status` AS `status` from ((`pengadaan` `p` join `vendor` `v` on((`p`.`vendor_idvendor` = `v`.`idvendor`))) join `user` `u` on((`p`.`user_iduser` = `u`.`iduser`)));

-- membuang struktur untuk view db_uts_2.view_penjualan
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_penjualan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_penjualan` AS select `pj`.`idpenjualan` AS `idpenjualan`,`pj`.`created_at` AS `created_at`,`u`.`username` AS `kasir`,`mp`.`persen` AS `margin_persen`,`pj`.`subtotal_nilai` AS `subtotal_nilai`,`pj`.`ppn` AS `ppn`,`pj`.`total_nilai` AS `total_nilai` from ((`penjualan` `pj` join `user` `u` on((`pj`.`iduser` = `u`.`iduser`))) join `margin_penjualan` `mp` on((`pj`.`idmargin_penjualan` = `mp`.`idmargin_penjualan`)));

-- membuang struktur untuk view db_uts_2.view_retur
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `view_retur`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_retur` AS select `r`.`idretur` AS `idretur`,`r`.`created_at` AS `created_at`,`r`.`idpenerimaan` AS `idpenerimaan`,`u`.`username` AS `petugas` from (`retur` `r` join `user` `u` on((`r`.`iduser` = `u`.`iduser`)));

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
