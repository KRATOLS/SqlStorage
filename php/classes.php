<?php
    class Connect {
        private $dsn;
        private $db_config;
        public function __construct($db_config) {
            $this->db_config = $db_config;
            $this->dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']};";
        }
        public function setConnect() {
            try {
                return new PDO($this->dsn, $this->db_config['user'], $this->db_config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            } catch(PDOException $error) {
                die($error->getMessage());
            }
        }
    }
    
    abstract class Table {
        public function getTableInner($data) {
            $table_inner = "";
            foreach($data as $item) {
                $table_inner .= "<tr>";
                foreach($item as $record) {
                    $table_inner .= "<td>$record</td>";
                }
                $table_inner .= "</tr>";
            }
            return $table_inner;
        }
    }

    class QueriesTable extends Table {
        private $attributes;
        private $data;
        public function __construct($data, $attributes) {
            $this->data = $data;
            $this->attributes = $attributes;
        }
        private function getHeader() {
            $header = "<tr>";
            foreach($this->attributes as $item) {
                $header .= "<th>$item</th>";
            }
            return $header .= "</tr>";
        }
        public function getTable() {
            return $this->getHeader() . parent::getTableInner($this->data);
        }
    }

    class QueryResultTable extends Table {
        private $cols;
        private $cols_num;
        private $data;
        public function __construct($data){
            $this->cols = array_keys($data[0]);
            $this->cols_num = count($this->cols);
            $this->data = $data;
        }   
        private function getHeader() {
            $header = "
                <tr>
                    <th colspan='$this->cols_num'>Результат запроса</th>
                </tr>
                <tr class='subtitles'>
            ";
            foreach($this->cols as $col_name) {
                $header .= "<td>$col_name</td>";
            }
            return $header .= "</tr>";
        }
        public function getTable() {
            return $this->getHeader() . parent::getTableInner($this->data);
        }
    }

    class Select {
        private $default_option;
        private $data;
        public function __construct($data, $default_opt) {
            $this->default_option = $default_opt;
            $this->data = $data;
        }
        private function getHeader() {
            return "<option id='0' class='title' disabled selected name='option'>$this->default_option</option>";
        }
        public function getSelect() {
            $queries = "";
            for($i=0; $i < count($this->data); $i++) {
                $id = $i + 1;
                $queries .= "<option id=$id class='select-query__opt' data-query_id='{$this->data[$i]['id']}'>{$this->data[$i]['name']}</option>";
            }
            return $this->getHeader() . $queries;
        }
    }
?>