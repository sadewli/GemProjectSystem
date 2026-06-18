<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<SQL
SET FOREIGN_KEY_CHECKS=0;

-- 1. Certificate Labs Master Table (dropdown එකට)
CREATE TABLE IF NOT EXISTS tbl_certificate_labs (
    idtbl_certificate_labs  INT(11)      NOT NULL AUTO_INCREMENT,
    lab_name                VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci,  -- e.g. SSEF, GRS, GIA, Lotus
    status                  INT(11)      DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser              INT(11)      DEFAULT NULL,
    insertdatetime          DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updateuser              VARCHAR(50)  DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime          DATETIME     DEFAULT NULL,

    PRIMARY KEY (idtbl_certificate_labs),
    INDEX idx_insertuser (insertuser),

    CONSTRAINT fk_cert_labs_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT IGNORE INTO tbl_certificate_labs (idtbl_certificate_labs, lab_name, insertuser) VALUES
(1, 'GRS',   1),
(2, 'GIA',   1),
(3, 'SSEF',  1),
(4, 'Lotus', 1);

-- 2. Product Media (Photos, 360° View, Video)
CREATE TABLE IF NOT EXISTS tbl_product_media (
    idtbl_product_media  INT(11)      NOT NULL AUTO_INCREMENT,
    idtbl_products       INT(11)      NOT NULL,
    media_type           ENUM('photo','view360','video') NOT NULL,
    file_path            VARCHAR(500) NOT NULL COLLATE utf8mb4_general_ci,
    status               INT(11)      DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser           INT(11)      DEFAULT NULL,
    insertdatetime       DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updateuser           VARCHAR(50)  DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime       DATETIME     DEFAULT NULL,

    PRIMARY KEY (idtbl_product_media),
    INDEX idx_idtbl_products (idtbl_products),
    INDEX idx_insertuser     (insertuser),

    CONSTRAINT fk_media_products
        FOREIGN KEY (idtbl_products)
        REFERENCES tbl_products (idtbl_products),

    CONSTRAINT fk_media_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

-- 3. Certificates
CREATE TABLE IF NOT EXISTS tbl_product_certificates (
    idtbl_product_certificates  INT(11)       NOT NULL AUTO_INCREMENT,
    idtbl_products              INT(11)       NOT NULL,
    idtbl_certificate_labs      INT(11)       NOT NULL,   -- FK → tbl_certificate_labs (dropdown)
    report_number               VARCHAR(100)  DEFAULT NULL COLLATE utf8mb4_general_ci,
    certificate_url             VARCHAR(500)  DEFAULT NULL COLLATE utf8mb4_general_ci,
    file_path                   VARCHAR(500)  DEFAULT NULL COLLATE utf8mb4_general_ci,
    status                      INT(11)       DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                  INT(11)       DEFAULT NULL,
    insertdatetime              DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updateuser                  VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime              DATETIME      DEFAULT NULL,

    PRIMARY KEY (idtbl_product_certificates),
    INDEX idx_idtbl_products         (idtbl_products),
    INDEX idx_idtbl_certificate_labs (idtbl_certificate_labs),
    INDEX idx_insertuser             (insertuser),

    CONSTRAINT fk_cert_products
        FOREIGN KEY (idtbl_products)
        REFERENCES tbl_products (idtbl_products),

    CONSTRAINT fk_cert_labs
        FOREIGN KEY (idtbl_certificate_labs)
        REFERENCES tbl_certificate_labs (idtbl_certificate_labs),

    CONSTRAINT fk_cert_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

-- 4. Documents
CREATE TABLE IF NOT EXISTS tbl_product_documents (
    idtbl_product_documents  INT(11)       NOT NULL AUTO_INCREMENT,
    idtbl_products           INT(11)       NOT NULL,
    title                    VARCHAR(255)  NOT NULL COLLATE utf8mb4_general_ci,
    description              TEXT          DEFAULT NULL COLLATE utf8mb4_general_ci,
    file_path                VARCHAR(500)  DEFAULT NULL COLLATE utf8mb4_general_ci,
    status                   INT(11)       DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser               INT(11)       DEFAULT NULL,
    insertdatetime           DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updateuser               VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime           DATETIME      DEFAULT NULL,

    PRIMARY KEY (idtbl_product_documents),
    INDEX idx_idtbl_products (idtbl_products),
    INDEX idx_insertuser     (insertuser),

    CONSTRAINT fk_docs_products
        FOREIGN KEY (idtbl_products)
        REFERENCES tbl_products (idtbl_products),

    CONSTRAINT fk_docs_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

-- 5. Traceability Documents
CREATE TABLE IF NOT EXISTS tbl_product_traceability_docs (
    idtbl_product_traceability_docs  INT(11)       NOT NULL AUTO_INCREMENT,
    idtbl_products                   INT(11)       NOT NULL,
    title                            VARCHAR(255)  DEFAULT NULL COLLATE utf8mb4_general_ci,
    description                      TEXT          DEFAULT NULL COLLATE utf8mb4_general_ci,
    file_path                        VARCHAR(500)  DEFAULT NULL COLLATE utf8mb4_general_ci,
    status                           INT(11)       DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                       INT(11)       DEFAULT NULL,
    insertdatetime                   DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updateuser                       VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime                   DATETIME      DEFAULT NULL,

    PRIMARY KEY (idtbl_product_traceability_docs),
    INDEX idx_idtbl_products (idtbl_products),
    INDEX idx_insertuser     (insertuser),

    CONSTRAINT fk_trace_docs_products
        FOREIGN KEY (idtbl_products)
        REFERENCES tbl_products (idtbl_products),

    CONSTRAINT fk_trace_docs_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS=1;
SQL);
    }

    public function down(): void
    {
        DB::unprepared(<<<SQL
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS tbl_product_traceability_docs;
DROP TABLE IF EXISTS tbl_product_documents;
DROP TABLE IF EXISTS tbl_product_certificates;
DROP TABLE IF EXISTS tbl_product_media;
DROP TABLE IF EXISTS tbl_certificate_labs;
SET FOREIGN_KEY_CHECKS=1;
SQL);
    }
};
