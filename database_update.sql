SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS tbl_product_media_details;
DROP TABLE IF EXISTS tbl_product_media_master;
DROP TABLE IF EXISTS tbl_media_types;
DROP TABLE IF EXISTS tbl_product_certificates;
DROP TABLE IF EXISTS tbl_certificate_labs;
DROP TABLE IF EXISTS tbl_product_documents;
DROP TABLE IF EXISTS tbl_product_traceability_docs;

CREATE TABLE tbl_certificate_labs (
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

INSERT INTO tbl_certificate_labs (lab_name, insertuser) VALUES
('GRS',   1),
('GIA',   1),
('SSEF',  1),
('Lotus', 1);

CREATE TABLE tbl_media_types (
    idtbl_media_types   INT(11)      NOT NULL AUTO_INCREMENT,
    type_name           VARCHAR(50)  NOT NULL COLLATE utf8mb4_general_ci COMMENT 'photo, video, view360',
    status              INT(11)      DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser          INT(11)      DEFAULT NULL,
    insertdatetime      DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updateuser          VARCHAR(50)  DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime      DATETIME     DEFAULT NULL,

    PRIMARY KEY (idtbl_media_types),
    INDEX idx_insertuser (insertuser)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_media_types (type_name, insertuser) VALUES
('photo',   1),
('video',   1),
('view360', 1);

CREATE TABLE tbl_product_media_master (
    idtbl_product_media_master  INT(11)   NOT NULL AUTO_INCREMENT,
    idtbl_products              INT(11)   NOT NULL COMMENT 'Product reference',
    idtbl_media_types           INT(11)   NOT NULL COMMENT 'Media type reference',
    status                      INT(11)   DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                  INT(11)   DEFAULT NULL,
    insertdatetime              DATETIME  DEFAULT CURRENT_TIMESTAMP,
    updateuser                  VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime              DATETIME  DEFAULT NULL,

    PRIMARY KEY (idtbl_product_media_master),
    INDEX idx_idtbl_products    (idtbl_products),
    INDEX idx_idtbl_media_types (idtbl_media_types),
    INDEX idx_insertuser        (insertuser),

    CONSTRAINT fk_media_master_products
        FOREIGN KEY (idtbl_products)
        REFERENCES tbl_products (idtbl_products),

    CONSTRAINT fk_media_master_types
        FOREIGN KEY (idtbl_media_types)
        REFERENCES tbl_media_types (idtbl_media_types),

    CONSTRAINT fk_media_master_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;


CREATE TABLE tbl_product_media_details (
    idtbl_product_media_details  INT(11)       NOT NULL AUTO_INCREMENT,
    idtbl_product_media_master   INT(11)       NOT NULL COMMENT 'Master reference',
    file_name                    VARCHAR(255)  DEFAULT NULL COLLATE utf8mb4_general_ci COMMENT 'Original file name',
    file_path                    VARCHAR(500)  NOT NULL COLLATE utf8mb4_general_ci COMMENT 'Stored file path',
    file_size                    INT(11)       DEFAULT NULL COMMENT 'File size in bytes',
    is_primary                   INT(11)       DEFAULT 0 COMMENT '1=Primary, 0=Other',
    sort_order                   INT(11)       DEFAULT 0 COMMENT 'Display order',
    status                       INT(11)       DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                   INT(11)       DEFAULT NULL,
    insertdatetime               DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updateuser                   VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime               DATETIME      DEFAULT NULL,

    PRIMARY KEY (idtbl_product_media_details),
    INDEX idx_idtbl_product_media_master (idtbl_product_media_master),
    INDEX idx_insertuser                 (insertuser),

    CONSTRAINT fk_media_details_master
        FOREIGN KEY (idtbl_product_media_master)
        REFERENCES tbl_product_media_master (idtbl_product_media_master),

    CONSTRAINT fk_media_details_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

CREATE TABLE tbl_product_certificates (
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

CREATE TABLE tbl_product_documents (
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

CREATE TABLE tbl_product_traceability_docs (
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

SET FOREIGN_KEY_CHECKS = 1;
