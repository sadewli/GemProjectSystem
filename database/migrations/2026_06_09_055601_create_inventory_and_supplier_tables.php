<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared(<<<SQL
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS tbl_products (
    idtbl_products              INT(11)         NOT NULL AUTO_INCREMENT,

    -- Basic Information
    idtbl_product_types         INT(11)         NOT NULL COMMENT 'Category: Diamond/Gemstone etc',
    idtbl_sub_categories        INT(11)         DEFAULT NULL COMMENT 'Sub-category',
    idtbl_varieties             INT(11)         DEFAULT NULL COMMENT 'Variety',
    idtbl_colors                INT(11)         DEFAULT NULL COMMENT 'Color',
    idtbl_shapes                INT(11)         DEFAULT NULL COMMENT 'Shape',
    idtbl_cuts                  INT(11)         DEFAULT NULL COMMENT 'Cutting type',
    idtbl_treatments            INT(11)         DEFAULT NULL COMMENT 'Treatment',
    idtbl_origins               INT(11)         DEFAULT NULL COMMENT 'Origin',
    idtbl_color_grade           INT(11)         DEFAULT NULL COMMENT 'Color grade',
    idtbl_cuttinggrade          INT(11)         DEFAULT NULL COMMENT 'Cut grade',
    idtbl_clarity_grade         INT(11)         DEFAULT NULL COMMENT 'Clarity grade',
    idtbl_storage_locations     INT(11)         DEFAULT NULL COMMENT 'Storage location',
    idtbl_tray_box              INT(11)         DEFAULT NULL COMMENT 'Tray/Box',
    idtbl_ownership_type        INT(11)         DEFAULT NULL COMMENT 'Ownership type',

    -- SKU
    idtbl_skus                  INT(11)         NOT NULL COMMENT 'SKU prefix reference',
    sku_number                  VARCHAR(50)     NOT NULL COLLATE utf8mb4_general_ci COMMENT 'Full SKU e.g CPD7',

    -- Dimensions
    length_mm                   DECIMAL(10,2)   DEFAULT NULL COMMENT 'Length in mm',
    width_mm                    DECIMAL(10,2)   DEFAULT NULL COMMENT 'Width in mm',
    height_mm                   DECIMAL(10,2)   DEFAULT NULL COMMENT 'Height in mm',

    -- Product Summary & Description
    product_title               VARCHAR(255)    DEFAULT NULL COLLATE utf8mb4_general_ci COMMENT 'Product title',
    product_description         TEXT            DEFAULT NULL COLLATE utf8mb4_general_ci COMMENT 'Product description',

    -- Status & Audit
    status                      INT(11)         DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                  INT(11)         DEFAULT NULL,
    insertdatetime              DATETIME        DEFAULT CURRENT_TIMESTAMP,
    updateuser                  VARCHAR(50)     DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime              DATETIME        DEFAULT NULL,

    PRIMARY KEY (idtbl_products),
    UNIQUE KEY uk_sku_number (sku_number),

    INDEX idx_idtbl_product_types     (idtbl_product_types),
    INDEX idx_idtbl_sub_categories    (idtbl_sub_categories),
    INDEX idx_idtbl_varieties         (idtbl_varieties),
    INDEX idx_idtbl_colors            (idtbl_colors),
    INDEX idx_idtbl_shapes            (idtbl_shapes),
    INDEX idx_idtbl_cuts              (idtbl_cuts),
    INDEX idx_idtbl_treatments        (idtbl_treatments),
    INDEX idx_idtbl_origins           (idtbl_origins),
    INDEX idx_idtbl_color_grade       (idtbl_color_grade),
    INDEX idx_idtbl_cuttinggrade      (idtbl_cuttinggrade),
    INDEX idx_idtbl_clarity_grade     (idtbl_clarity_grade),
    INDEX idx_idtbl_storage_locations (idtbl_storage_locations),
    INDEX idx_idtbl_tray_box          (idtbl_tray_box),
    INDEX idx_idtbl_ownership_type    (idtbl_ownership_type),
    INDEX idx_idtbl_skus              (idtbl_skus),
    INDEX idx_insertuser              (insertuser),

    CONSTRAINT fk_products_product_types
        FOREIGN KEY (idtbl_product_types)
        REFERENCES tbl_product_types (idtbl_product_types),

    CONSTRAINT fk_products_sub_categories
        FOREIGN KEY (idtbl_sub_categories)
        REFERENCES tbl_sub_categories (idtbl_sub_categories),

    CONSTRAINT fk_products_varieties
        FOREIGN KEY (idtbl_varieties)
        REFERENCES tbl_varieties (idtbl_varieties),

    CONSTRAINT fk_products_colors
        FOREIGN KEY (idtbl_colors)
        REFERENCES tbl_colors (idtbl_colors),

    CONSTRAINT fk_products_shapes
        FOREIGN KEY (idtbl_shapes)
        REFERENCES tbl_shapes (idtbl_shapes),

    CONSTRAINT fk_products_cuts
        FOREIGN KEY (idtbl_cuts)
        REFERENCES tbl_cuts (idtbl_cuts),

    CONSTRAINT fk_products_treatments
        FOREIGN KEY (idtbl_treatments)
        REFERENCES tbl_treatments (idtbl_treatments),

    CONSTRAINT fk_products_origins
        FOREIGN KEY (idtbl_origins)
        REFERENCES tbl_origins (idtbl_origins),

    /* CONSTRAINT fk_products_color_grade
        FOREIGN KEY (idtbl_color_grade)
        REFERENCES tbl_color_grade (idtbl_color_grade), */

    CONSTRAINT fk_products_cuttinggrade
        FOREIGN KEY (idtbl_cuttinggrade)
        REFERENCES tbl_cuttinggrade (idtbl_cuttinggrade),

    CONSTRAINT fk_products_clarity_grade
        FOREIGN KEY (idtbl_clarity_grade)
        REFERENCES tbl_clarity_grade (idtbl_clarity_grade),

    CONSTRAINT fk_products_storage_locations
        FOREIGN KEY (idtbl_storage_locations)
        REFERENCES tbl_storage_locations (idtbl_storage_locations),

    CONSTRAINT fk_products_tray_box
        FOREIGN KEY (idtbl_tray_box)
        REFERENCES tbl_tray_box (idtbl_tray_box),

    /* CONSTRAINT fk_products_ownership_type
        FOREIGN KEY (idtbl_ownership_type)
        REFERENCES tbl_ownership_type (idtbl_ownership_type),

    CONSTRAINT fk_products_skus
        FOREIGN KEY (idtbl_skus)
        REFERENCES tbl_skus (idtbl_skus), */

    CONSTRAINT fk_products_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS tbl_suppliers (
    idtbl_suppliers         INT(11)       NOT NULL AUTO_INCREMENT,
    supplier_name           VARCHAR(255)  NOT NULL COLLATE utf8mb4_general_ci,
    contact_name            VARCHAR(255)  DEFAULT NULL COLLATE utf8mb4_general_ci,
    email                   VARCHAR(191)  DEFAULT NULL COLLATE utf8mb4_general_ci,
    phone                   VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_general_ci,
    address                 TEXT          DEFAULT NULL COLLATE utf8mb4_general_ci,
    country                 VARCHAR(100)  DEFAULT NULL COLLATE utf8mb4_general_ci,
    currency                VARCHAR(10)   DEFAULT NULL COLLATE utf8mb4_general_ci,
    status                  INT(11)       DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser              INT(11)       DEFAULT NULL,
    insertdatetime          DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updateuser              VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime          DATETIME      DEFAULT NULL,

    PRIMARY KEY (idtbl_suppliers),
    INDEX idx_insertuser (insertuser)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS tbl_product_purchasing (
    idtbl_product_purchasing    INT(11)       NOT NULL AUTO_INCREMENT,
    idtbl_products              INT(11)       NOT NULL COMMENT 'Product reference',
    idtbl_suppliers             INT(11)       DEFAULT NULL COMMENT 'Supplier reference',
    supplier_stone_ref          VARCHAR(100)  DEFAULT NULL COLLATE utf8mb4_general_ci COMMENT 'Supplier stone ref',
    date_of_purchase            DATE          DEFAULT NULL COMMENT 'Date of purchase',
    idtbl_ownership_type        INT(11)       DEFAULT NULL COMMENT 'Ownership type',
    status                      INT(11)       DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                  INT(11)       DEFAULT NULL,
    insertdatetime              DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updateuser                  VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime              DATETIME      DEFAULT NULL,

    PRIMARY KEY (idtbl_product_purchasing),
    INDEX idx_idtbl_products        (idtbl_products),
    INDEX idx_idtbl_suppliers       (idtbl_suppliers),
    INDEX idx_idtbl_ownership_type  (idtbl_ownership_type),
    INDEX idx_insertuser            (insertuser),

    CONSTRAINT fk_purchasing_products
        FOREIGN KEY (idtbl_products)
        REFERENCES tbl_products (idtbl_products),

    CONSTRAINT fk_purchasing_suppliers
        FOREIGN KEY (idtbl_suppliers)
        REFERENCES tbl_suppliers (idtbl_suppliers),

    /* CONSTRAINT fk_purchasing_ownership_type
        FOREIGN KEY (idtbl_ownership_type)
        REFERENCES tbl_ownership_type (idtbl_ownership_type), */

    CONSTRAINT fk_purchasing_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS tbl_partners_master (
    idtbl_partners_master       INT(11)       NOT NULL AUTO_INCREMENT,
    idtbl_product_purchasing    INT(11)       NOT NULL COMMENT 'Purchasing reference',
    idtbl_partners              INT(11)       NOT NULL COMMENT 'My Company reference',
    ownership_percentage        DECIMAL(5,2)  NOT NULL DEFAULT 0.00 COMMENT '% of ownership',
    profit_share_percentage     DECIMAL(5,2)  NOT NULL DEFAULT 0.00 COMMENT '% of profit share',
    status                      INT(11)       DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                  INT(11)       DEFAULT NULL,
    insertdatetime              DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updateuser                  VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime              DATETIME      DEFAULT NULL,

    PRIMARY KEY (idtbl_partners_master),
    INDEX idx_idtbl_product_purchasing (idtbl_product_purchasing),
    INDEX idx_idtbl_partners           (idtbl_partners),
    INDEX idx_insertuser               (insertuser),

    CONSTRAINT fk_partners_master_purchasing
        FOREIGN KEY (idtbl_product_purchasing)
        REFERENCES tbl_product_purchasing (idtbl_product_purchasing),

    /* CONSTRAINT fk_partners_master_partners
        FOREIGN KEY (idtbl_partners)
        REFERENCES tbl_partners (idtbl_partners), */

    CONSTRAINT fk_partners_master_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS tbl_partners_details (
    idtbl_partners_details      INT(11)       NOT NULL AUTO_INCREMENT,
    idtbl_partners_master       INT(11)       NOT NULL COMMENT 'Master reference',
    idtbl_partners              INT(11)       NOT NULL COMMENT 'Other company reference',
    ownership_percentage        DECIMAL(5,2)  NOT NULL DEFAULT 0.00 COMMENT '% of ownership',
    profit_share_percentage     DECIMAL(5,2)  NOT NULL DEFAULT 0.00 COMMENT '% of profit share',
    status                      INT(11)       DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                  INT(11)       DEFAULT NULL,
    insertdatetime              DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updateuser                  VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime              DATETIME      DEFAULT NULL,

    PRIMARY KEY (idtbl_partners_details),
    INDEX idx_idtbl_partners_master (idtbl_partners_master),
    INDEX idx_idtbl_partners        (idtbl_partners),
    INDEX idx_insertuser            (insertuser),

    CONSTRAINT fk_partners_details_master
        FOREIGN KEY (idtbl_partners_master)
        REFERENCES tbl_partners_master (idtbl_partners_master),

    /* CONSTRAINT fk_partners_details_partners
        FOREIGN KEY (idtbl_partners)
        REFERENCES tbl_partners (idtbl_partners), */

    CONSTRAINT fk_partners_details_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS tbl_weight_units (
    idtbl_weight_units      INT(11)       NOT NULL AUTO_INCREMENT,
    unit_name               VARCHAR(50)   NOT NULL COLLATE utf8mb4_general_ci COMMENT 'e.g ct, g, pcs',
    status                  INT(11)       DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser              INT(11)       DEFAULT NULL,
    insertdatetime          DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updateuser              VARCHAR(50)   DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime          DATETIME      DEFAULT NULL,

    PRIMARY KEY (idtbl_weight_units),
    INDEX idx_insertuser (insertuser)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT IGNORE INTO tbl_weight_units (idtbl_weight_units, unit_name, insertuser) VALUES
(1, 'ct',  1),
(2, 'g',   1),
(3, 'kg',  1),
(4, 'pcs', 1);

CREATE TABLE IF NOT EXISTS tbl_product_pricing (
    idtbl_product_pricing       INT(11)         NOT NULL AUTO_INCREMENT,
    idtbl_products              INT(11)         NOT NULL COMMENT 'Product reference',

    -- Selling unit
    selling_unit                INT(11)         DEFAULT 1 COMMENT '1=Weight, 2=Quantity',

    -- Weight
    weight                      DECIMAL(10,4)   DEFAULT NULL COMMENT 'Weight value e.g 1.2',
    idtbl_weight_units          INT(11)         DEFAULT NULL COMMENT 'Weight unit e.g ct',
    avg_weight_per_piece        DECIMAL(10,4)   DEFAULT NULL COMMENT 'Average weight per piece',

    -- Quantity
    quantity                    INT(11)         DEFAULT NULL COMMENT 'Quantity',

    -- Cost
    cost_per_unit               DECIMAL(15,2)   DEFAULT NULL COMMENT 'Cost per unit',
    total_cost                  DECIMAL(15,2)   DEFAULT NULL COMMENT 'Total cost',

    -- My Cost
    my_cost_per_unit            DECIMAL(15,2)   DEFAULT NULL COMMENT 'My cost per unit',
    my_total_cost               DECIMAL(15,2)   DEFAULT NULL COMMENT 'My total cost',

    -- Wholesale price
    wholesale_price_per_unit    DECIMAL(15,2)   DEFAULT NULL COMMENT 'Wholesale price per unit',
    wholesale_total_price       DECIMAL(15,2)   DEFAULT NULL COMMENT 'Total wholesale price',

    -- Retail price
    retail_price_per_unit       DECIMAL(15,2)   DEFAULT NULL COMMENT 'Retail price per unit',
    retail_total_price          DECIMAL(15,2)   DEFAULT NULL COMMENT 'Total retail price',

    -- Matrix price
    matrix_price_per_unit       DECIMAL(15,2)   DEFAULT NULL COMMENT 'Matrix price per unit',
    matrix_total_price          DECIMAL(15,2)   DEFAULT NULL COMMENT 'Total matrix price',

    -- Document default price
    document_default_price      ENUM('Wholesale','Retail','Matrix') NOT NULL DEFAULT 'Retail'
                                COMMENT 'Auto-populate price on Memo/Invoice',

    status                      INT(11)         DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                  INT(11)         DEFAULT NULL,
    insertdatetime              DATETIME        DEFAULT CURRENT_TIMESTAMP,
    updateuser                  VARCHAR(50)     DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime              DATETIME        DEFAULT NULL,

    PRIMARY KEY (idtbl_product_pricing),
    INDEX idx_idtbl_products     (idtbl_products),
    INDEX idx_idtbl_weight_units (idtbl_weight_units),
    INDEX idx_insertuser         (insertuser),

    CONSTRAINT fk_pricing_products
        FOREIGN KEY (idtbl_products)
        REFERENCES tbl_products (idtbl_products),

    CONSTRAINT fk_pricing_weight_units
        FOREIGN KEY (idtbl_weight_units)
        REFERENCES tbl_weight_units (idtbl_weight_units),

    CONSTRAINT fk_pricing_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS tbl_product_custom_pricing (
    idtbl_product_custom_pricing INT(11)        NOT NULL AUTO_INCREMENT,
    idtbl_product_pricing        INT(11)        NOT NULL COMMENT 'Pricing reference',
    price_label                  VARCHAR(100)   NOT NULL COLLATE utf8mb4_general_ci COMMENT 'Custom price name',
    price_per_unit               DECIMAL(15,2)  DEFAULT NULL COMMENT 'Custom price per unit',
    total_price                  DECIMAL(15,2)  DEFAULT NULL COMMENT 'Custom total price',
    status                       INT(11)        DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
    insertuser                   INT(11)        DEFAULT NULL,
    insertdatetime               DATETIME       DEFAULT CURRENT_TIMESTAMP,
    updateuser                   VARCHAR(50)    DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime               DATETIME       DEFAULT NULL,

    PRIMARY KEY (idtbl_product_custom_pricing),
    INDEX idx_idtbl_product_pricing (idtbl_product_pricing),
    INDEX idx_insertuser            (insertuser),

    CONSTRAINT fk_custom_pricing_pricing
        FOREIGN KEY (idtbl_product_pricing)
        REFERENCES tbl_product_pricing (idtbl_product_pricing),

    CONSTRAINT fk_custom_pricing_user
        FOREIGN KEY (insertuser)
        REFERENCES tbl_user (idtbl_user)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS=1;
SQL
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared(<<<SQL
DROP TABLE IF EXISTS tbl_product_custom_pricing;
DROP TABLE IF EXISTS tbl_product_pricing;
DROP TABLE IF EXISTS tbl_weight_units;
DROP TABLE IF EXISTS tbl_partners_details;
DROP TABLE IF EXISTS tbl_partners_master;
DROP TABLE IF EXISTS tbl_product_purchasing;
DROP TABLE IF EXISTS tbl_suppliers;
DROP TABLE IF EXISTS tbl_products;
SQL
        );
    }
};
