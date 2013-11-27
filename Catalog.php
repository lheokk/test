<?php

    class Catalog extends Model {

        const TABLE_CAT         = 'cat_category';
        const TABLE_ITEM        = 'cat_items';

        protected function  CreateTable()
        {
//            $this->db->query(
//                    "
//
//                 ");
//
//            $this->db->query(
//                    "
//
//                        ");
			
        }
        
        public function  __construct($id = NULL, $onlyShow = false)
        {
            global $g_databases;
            parent::__construct($g_databases->db, self::TABLE_ITEM, 'id', $id, $onlyShow);
        }

        public function Get_categories($category = null)
        {
            $res = $this->db->query(
                    "
                        SELECT
                            *, ?#.id AS ARRAY_KEY
                        FROM
                            ?#
                        {WHERE id = ?d}
                        ",
                    self::TABLE_CAT,
                    self::TABLE_CAT,
                    (is_null($category) ? DBSIMPLE_SKIP : $category)
                    );
            return (is_null($category)) ? $res : $res[$category];
        }

        public function New_category($name)
        {
            $data = array(
                'name' => trim($name)
            );
            
            $this->db->query(
                    "
                        INSERT INTO
                            ?# (?#)
                        VALUES
                            (?a)
                        ",
                    self::TABLE_CAT,
                    array_keys($data),
                    array_values($data)
                    );
        }

        public function Edit_category($name, $id)
        {
            $this->db->query(
                    "
                        UPDATE
                            ?#
                        SET
                            name = ?
                        WHERE
                            id = ?d
                        ",
                    self::TABLE_CAT,
                    trim($name),
                    intval($id)
                    );
        }

        public function Delete_category($id)
        {
            $this->db->query(
                    "
                        DELETE FROM
                            ?#
                        WHERE
                            id = ?d
                        ",
                    self::TABLE_CAT,
                    $id
                    );
        }

        public function Get_all_items($category = null)
        {
            $res = $this->db->query(
                    "
                        SELECT
                            *, ?#.id AS ARRAY_KEY
                        FROM
                            ?#
                        {WHERE caregory_id = ?d}
                        ORDER BY
                            time DESC
                        ",
                    self::TABLE_ITEM,
                    self::TABLE_ITEM,
                    (is_null($category)) ? DBSIMPLE_SKIP : $category
                    );
            return $res;
        }

    };

?>
