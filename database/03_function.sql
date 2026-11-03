USE db_uts_2;

DROP FUNCTION IF EXISTS f_hitung_total_penjualan;

DELIMITER $$

CREATE FUNCTION f_hitung_total_penjualan(
    p_iduser INT
) 
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_total_omset INT DEFAULT 0;

    SELECT IFNULL(SUM(total_nilai), 0) INTO v_total_omset
    FROM penjualan
    WHERE iduser = p_iduser;

    RETURN v_total_omset;
END$$

DELIMITER ;