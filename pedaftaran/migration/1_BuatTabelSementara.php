<?php

class BuatTabelSementara {
    function up() {
        $db = \SLiMS\DB::getInstance();
        $db->query("CREATE TABLE IF NOT EXISTS `tabel_sementara` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `hp` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    function down() {
        // $db = \SLiMS\DB::getInstance();
        // $db->query("DROP TABLE IF EXISTS `tabel_sementara`;");
    }
}