USE db_uts_2;

DROP TRIGGER IF EXISTS trg_penerimaan_kartu_stok;

DELIMITER $$

CREATE TRIGGER trg_penerimaan_kartu_stok
AFTER INSERT ON detail_penerimaan
FOR EACH ROW
BEGIN
    INSERT INTO kartu_stok (
        jenis_transaksi, 
        masuk, 
        keluar, 
        stock, 
        created_at, 
        idbarang, 
        idpenerimaan
    )
    VALUES (
        'Penerimaan', 
        NEW.jumlah_terima, 
        0, 
        NEW.jumlah_terima, 
        NOW(), 
        NEW.idbarang, 
        NEW.idpenerimaan
    );
END$$

DELIMITER ;