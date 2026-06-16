<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<SQL
SET FOREIGN_KEY_CHECKS=0;

-- ─────────────────────────────────────────────
-- Production Types lookup
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS tbl_production_types (
    idtbl_production_types  INT(11)      NOT NULL AUTO_INCREMENT,
    type_name               VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci COMMENT 'e.g Re-assortment, Cutting',
    type_value              VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci COMMENT 'slug value e.g re-assortment',
    status                  INT(11)      DEFAULT 1 COMMENT '1=Active, 0=Inactive',
    insertuser              INT(11)      DEFAULT NULL,
    insertdatetime          DATETIME     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idtbl_production_types),
    UNIQUE KEY uk_type_value (type_value)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT IGNORE INTO tbl_production_types (idtbl_production_types, type_name, type_value) VALUES
(1, 'Re-assortment',   're-assortment'),
(2, 'Cutting',         'cutting'),
(3, 'Re-cutting',      're-cutting'),
(4, 'Product transfer','product-transfer'),
(5, 'Treatment',       'treatment');

-- ─────────────────────────────────────────────
-- Main Production Sheet header table
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS tbl_production_sheets (
    idtbl_production_sheets     INT(11)         NOT NULL AUTO_INCREMENT,

    -- Sheet identification
    sheet_number                VARCHAR(50)     DEFAULT NULL COLLATE utf8mb4_general_ci COMMENT 'Auto-generated sheet number e.g PS-0001',
    idtbl_production_types      INT(11)         NOT NULL COMMENT 'Production type FK',
    production_category         VARCHAR(50)     DEFAULT NULL COLLATE utf8mb4_general_ci COMMENT 'gemstones / rough / diamond',
    template                    VARCHAR(50)     DEFAULT 'default' COLLATE utf8mb4_general_ci,
    reference                   VARCHAR(100)    DEFAULT NULL COLLATE utf8mb4_general_ci,

    -- Dates
    due_date                    DATE            DEFAULT NULL,
    closed_date                 DATE            DEFAULT NULL,

    -- Creator
    creator_id                  INT(11)         DEFAULT NULL COMMENT 'User who created the sheet',

    -- Quantities & weights
    original_quantity           INT(11)         DEFAULT NULL,
    original_weight             DECIMAL(15,4)   DEFAULT NULL,
    weight_unit                 VARCHAR(10)     DEFAULT 'ct' COLLATE utf8mb4_general_ci,
    original_total_cost         DECIMAL(15,2)   DEFAULT NULL,
    currency                    VARCHAR(10)     DEFAULT 'VEF' COLLATE utf8mb4_general_ci,

    -- Costing
    cost_per_unit               DECIMAL(15,2)   DEFAULT NULL,
    total_cost                  DECIMAL(15,2)   DEFAULT NULL,
    my_cost_per_unit            DECIMAL(15,2)   DEFAULT NULL,
    my_total_cost               DECIMAL(15,2)   DEFAULT NULL,

    -- Output
    expected_output_weight      DECIMAL(15,4)   DEFAULT NULL,
    output_weight_unit          VARCHAR(10)     DEFAULT 'ct' COLLATE utf8mb4_general_ci,
    expected_output_quantity    INT(11)         DEFAULT NULL,
    loss_percent                DECIMAL(8,4)    DEFAULT NULL,
    loss_weight                 DECIMAL(15,4)   DEFAULT NULL,

    -- Discrepancy
    discrepancy_reason          VARCHAR(50)     DEFAULT NULL COLLATE utf8mb4_general_ci,
    notes                       TEXT            DEFAULT NULL COLLATE utf8mb4_general_ci,

    -- Status: draft / in_production / completed / deleted
    status                      VARCHAR(20)     DEFAULT 'draft' COLLATE utf8mb4_general_ci,

    -- Audit
    insertuser                  INT(11)         DEFAULT NULL,
    insertdatetime              DATETIME        DEFAULT CURRENT_TIMESTAMP,
    updateuser                  VARCHAR(50)     DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    updatedatetime              DATETIME        DEFAULT NULL,

    PRIMARY KEY (idtbl_production_sheets),
    UNIQUE KEY uk_sheet_number (sheet_number),
    INDEX idx_idtbl_production_types (idtbl_production_types),
    INDEX idx_creator_id             (creator_id),
    INDEX idx_insertuser             (insertuser),
    INDEX idx_status                 (status),

    CONSTRAINT fk_ps_production_types
        FOREIGN KEY (idtbl_production_types)
        REFERENCES tbl_production_types (idtbl_production_types)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

-- ─────────────────────────────────────────────
-- Production Sheet Items
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS tbl_production_sheet_items (
    idtbl_production_sheet_items INT(11)        NOT NULL AUTO_INCREMENT,
    idtbl_production_sheets      INT(11)        NOT NULL COMMENT 'Parent sheet',
    idtbl_products               INT(11)        DEFAULT NULL COMMENT 'Product / SKU ref',
    sku_number                   VARCHAR(50)    DEFAULT NULL COLLATE utf8mb4_general_ci COMMENT 'Snapshot SKU at time of entry',
    description                  VARCHAR(255)   DEFAULT NULL COLLATE utf8mb4_general_ci,
    quantity                     INT(11)        DEFAULT NULL,
    weight                       DECIMAL(15,4)  DEFAULT NULL,
    weight_unit                  VARCHAR(10)    DEFAULT 'ct' COLLATE utf8mb4_general_ci,
    cost                         DECIMAL(15,2)  DEFAULT NULL,
    status                       INT(11)        DEFAULT 1 COMMENT '1=Active, 0=Removed',
    insertuser                   INT(11)        DEFAULT NULL,
    insertdatetime               DATETIME       DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (idtbl_production_sheet_items),
    INDEX idx_idtbl_production_sheets (idtbl_production_sheets),
    INDEX idx_idtbl_products          (idtbl_products),

    CONSTRAINT fk_psi_sheet
        FOREIGN KEY (idtbl_production_sheets)
        REFERENCES tbl_production_sheets (idtbl_production_sheets)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

-- ─────────────────────────────────────────────
-- Production Sheet History log
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS tbl_production_sheet_history (
    idtbl_production_sheet_history INT(11)      NOT NULL AUTO_INCREMENT,
    idtbl_production_sheets        INT(11)      NOT NULL,
    action_date                    DATE         DEFAULT (CURRENT_DATE),
    action_time                    TIME         DEFAULT (CURRENT_TIME),
    action_user                    INT(11)      DEFAULT NULL,
    action                         VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_general_ci,
    note                           TEXT         DEFAULT NULL COLLATE utf8mb4_general_ci,
    insertdatetime                 DATETIME     DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (idtbl_production_sheet_history),
    INDEX idx_idtbl_production_sheets (idtbl_production_sheets),

    CONSTRAINT fk_psh_sheet
        FOREIGN KEY (idtbl_production_sheets)
        REFERENCES tbl_production_sheets (idtbl_production_sheets)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS=1;
SQL
        );
    }

    public function down(): void
    {
        DB::unprepared(<<<SQL
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS tbl_production_sheet_history;
DROP TABLE IF EXISTS tbl_production_sheet_items;
DROP TABLE IF EXISTS tbl_production_sheets;
DROP TABLE IF EXISTS tbl_production_types;
SET FOREIGN_KEY_CHECKS=1;
SQL
        );
    }
};
