<?php

class caumanagermodel extends Database {

    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function getHighestLevel($country_id) {
        $query = 'SELECT MIN(territory_level) AS min_territory_level FROM admin_territory WHERE country_id =' . $country_id . '';
        $min_territory_level = $this->selectDBraw($query)[0]['min_territory_level'];

        $query = 'SELECT id as highestlevel FROM admin_territory WHERE territory_level =' . $min_territory_level . ' AND country_id =' . $country_id . '';
        $data = $this->selectDBraw($query)[0]['highestlevel'];

        return $data;
    }

    public function getterritorryData() {
        $query = 'SELECT
                admin_territory.territory_level,
                admin_territory_level.territory_level AS territory_level_name,   
                admin_territory.territory_name,                     
                admin_countries.id as country
                FROM admin_territory
                JOIN admin_countries ON admin_countries.id = admin_territory.country_id
                JOIN admin_territory_level ON admin_territory_level.id = admin_territory.territory_level
                ORDER BY admin_territory.territory_level
            ';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getterritorryLevels() {
        $query = 'SELECT
                admin_territory_level.id,
                admin_territory_level.territory_level AS territory_level_name
                FROM admin_territory_level
                ORDER BY admin_territory_level.id
            ';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getCountries() {
        $query = 'SELECT
                admin_countries.id,
                admin_countries.country
                FROM admin_countries
                ORDER BY admin_countries.id
            ';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getSidebarTerritorries($country_id) {

        $query = 'SELECT id, territory_name, territory_level
                FROM admin_territory
                WHERE country_id = ' . $country_id . '
                ORDER BY territory_level asc
            ';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getTerritorryDetails($admin_territory_id, $country) {

        $query = 'SELECT
                territory_name, 
                territory_level
                FROM admin_territory
                WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $country . ' ORDER BY territory_level DESC
            ';
        $ancestors = $this->selectDBraw($query);

        $query = 'SELECT ';

        $i = 1;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ', ';
            $i++;
        }

        $query .= 't1.id, 
                t1.admin_territory_id, 
                t1.territory_parent AS territory_parent_id ';

        $query .= 'FROM admin_territory_details as t1 ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE t1.admin_territory_id = ' . $admin_territory_id . '';

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getTerritorryMeta($admin_territory_id, $country) {

        $data = array();

        $query = 'SELECT territory_name,territory_level FROM admin_territory WHERE id = ' . $admin_territory_id . ' AND country_id = ' . $country . '';
        $territorry = $this->selectDBraw($query);

        $data['territory_name'] = $territorry[0]['territory_name'];
        $data['territory_level'] = $territorry[0]['territory_level'];

        if ($territorry[0]['territory_level'] > 1) {
            $query = 'SELECT territory_name,territory_level FROM admin_territory WHERE territory_level < ' . ($territorry[0]["territory_level"]) . ' AND country_id = ' . $country . ' ORDER BY territory_level DESC LIMIT 1';
            $parent = $this->selectDBraw($query);

            if (!empty($parent)) {
                $data['parent_territory_name'] = $parent[0]['territory_name'];
                $data['parent_territory_level'] = $parent[0]['territory_level'];
            }
        }

        return $data;
    }

    public function getTerritorryParents($admin_territory_id, $country) {

        $query = 'SELECT territory_level FROM admin_territory WHERE id = ' . $admin_territory_id . '';
        $this_level = $this->selectDBraw($query)[0]['territory_level'];

        if ($this_level > 1) {

            $query = 'SELECT id FROM admin_territory WHERE country_id = ' . $country . ' AND territory_level < ' . $this_level . ' ORDER BY territory_level DESC LIMIT 1';
            $the_parent_id = $this->selectDBraw($query);

            if (!empty($the_parent_id)) {
                $the_parent_id = $this->selectDBraw($query)[0]['id'];
                $query = 'SELECT id, admin_territory_name FROM admin_territory_details WHERE admin_territory_id = ' . $the_parent_id . ' ORDER BY admin_territory_name ASC';
                $parents = $this->selectDBraw($query);
            } else {
                return null;
            }

            return $parents;
        } else {

            return null;
        }
    }

    public function getParentSiblings($id) {

        $query = 'SELECT admin_territory_id FROM admin_territory_details WHERE id < ' . $id . '';
        $actualId = $this->selectDBraw($query);
        $parentQuery = 'SELECT id FROM admin_territory WHERE id <= ' . $actualId[0]['admin_territory_id'] . ' AND country=' . $_SESSION['country'];
        $parents = $this->selectDBraw($parentQuery);
        $actualParent = sizeof($parents) - 1;
        $parent_admin_territory_id = $parents[$actualParent]['id'];

        //$parent_admin_territory_id = $this->selectDBraw($query)[0]['admin_territory_id'];

        $query = 'SELECT id, admin_territory_name FROM admin_territory_details WHERE admin_territory_id = ' . $parent_admin_territory_id . '';
        $parent_siblings = $this->selectDBraw($query);

        return $parent_siblings;
    }

    public function geteditData($id) {

        $query = 'SELECT 
            t1.id,
            t1.admin_territory_name,
            t2.admin_territory_name as parent_admin_territory_name
            FROM admin_territory_details as t1
            LEFT JOIN admin_territory_details as t2 ON t1.territory_parent = t2.id
            WHERE t1.id = ' . $id . '';

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function addTerritorry($data) {

        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $data['name_territory'] . ' added';
        $description = $data['name_territory'] . ' name is ' . $data['admin_territory_name'];
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        array_shift($data);
        $this->insertdDB('admin_territory_details', $data);
        $this->insertdDB('admin_log_record', $insertData);
    }

    public function editTerritorry($data, $params) {

        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $data['name_territory'] . ' edited';
        $description = $data['name_territory'] . ' name is ' . $data['admin_territory_name'];
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        array_shift($data);

        $this->updateDBparams('admin_territory_details', $data, $params);
        $this->insertdDB('admin_log_record', $insertData);
    }

    public function delTerritorry($id) {

        $query = 'SELECT id FROM admin_territory_details WHERE territory_parent = ' . $id . '';
        $ter_child1 = $this->selectDBraw($query);

        foreach ($ter_child1 as $idArr => $value) {

            $del_id1 = $value['id'];
            $query = 'SELECT id FROM admin_territory_details WHERE territory_parent = ' . $del_id1 . '';
            $ter_child2 = $this->selectDBraw($query);

            foreach ($ter_child2 as $idArr => $value) {
                $del_id2 = $value['id'];
                $query = 'SELECT id FROM admin_territory_details WHERE territory_parent = ' . $del_id2 . '';
                $ter_child3 = $this->selectDBraw($query);

                foreach ($ter_child3 as $idArr => $value) {
                    $del_id3 = $value['id'];
                    $query = 'SELECT id FROM admin_territory_details WHERE territory_parent = ' . $del_id3 . '';
                    $ter_child4 = $this->selectDBraw($query);

                    foreach ($ter_child4 as $idArr => $value) {
                        $del_id4 = $value['id'];
                        $query = 'SELECT id FROM admin_territory_details WHERE territory_parent = ' . $del_id4 . '';
                        $ter_child5 = $this->selectDBraw($query);

                        foreach ($ter_child5 as $idArr => $value) {
                            $del_id5 = $value['id'];
                            $query = 'SELECT id FROM admin_territory_details WHERE territory_parent = ' . $del_id5 . '';
                            $ter_child6 = $this->selectDBraw($query);

                            foreach ($ter_child6 as $idArr => $value) {
                                $del_id6 = $value['id'];
                                $query = 'SELECT id FROM admin_territory_details WHERE territory_parent = ' . $del_id6 . '';
                                $ter_child7 = $this->selectDBraw($query);

                                foreach ($ter_child7 as $idArr => $value) {
                                    $del_id7 = $value['id'];
                                    $query = 'SELECT id FROM admin_territory_details WHERE territory_parent = ' . $del_id7 . '';
                                    $ter_child8 = $this->selectDBraw($query);

                                    foreach ($ter_child8 as $idArr => $value) {
                                        $del_id8 = $value['id'];
                                        $query = 'SELECT id FROM admin_territory_details WHERE territory_parent = ' . $del_id8 . '';
                                        $ter_child9 = $this->selectDBraw($query);

                                        foreach ($ter_child9 as $idArr => $value) {
                                            $del_id9 = $value['id'];
                                            $this->deleteDB('admin_territory_details', $del_id9);
                                        }
                                        $this->deleteDB('admin_territory_details', $del_id8);
                                    }
                                    $this->deleteDB('admin_territory_details', $del_id7);
                                }
                                $this->deleteDB('admin_territory_details', $del_id6);
                            }
                            $this->deleteDB('admin_territory_details', $del_id5);
                        }
                        $this->deleteDB('admin_territory_details', $del_id4);
                    }
                    $this->deleteDB('admin_territory_details', $del_id3);
                }
                $this->deleteDB('admin_territory_details', $del_id2);
            }
            $this->deleteDB('admin_territory_details', $del_id1);
        }
        $query = 'SELECT id, admin_territory_id, admin_territory_name FROM admin_territory_details';        
        $ter_arr_id = $this->selectDBraw($query);

        foreach ($ter_arr_id as $idArr => $value) {

            $admin_territory_id = $value['admin_territory_id'];
            $admin_territory_name = $value['admin_territory_name'];
            $query = 'SELECT territory_name FROM admin_territory WHERE territory_level = ' . $admin_territory_id . '';
            $ter_arr = $this->selectDBraw($query);
            $territory_name = $ter_arr[0]['territory_name'];
            $country = $_SESSION["country"];
            $user_name = $_SESSION["full_name"];
            $email = $_SESSION["email"];
            $action = $territory_name . ' deleted';
            $description = $territory_name . ' name is ' . $admin_territory_name;

            $insertData = array(
                'id' => '',
                'country' => $country,
                'user_name' => $user_name,
                'email' => $email,
                'action' => $action,
                'description' => $description
            );

            $this->insertdDB('admin_log_record', $insertData);
        }
        $this->deleteDB('admin_territory_details', $id); 
    }

    public function importTerritorryDetails($data) {

        $highestlevel = $this->getHighestLevel($_SESSION['country']);
        $territories = $this->getSidebarTerritorries($_SESSION['country']);

        foreach ($data as $key => $datum) {

            foreach ($datum as $key_1 => $value) {

                if (empty($value)) {
                    continue 2;
                } else {
                    $admin_territory_id = $territories[$key_1]['id'];
                    $admin_territory_name = $value;

                    if ($admin_territory_id == $highestlevel) {
                        $territory_parent = 0;
                    } else {
                        $territory_parent = $lastID;
                    }

                    $insertData = array(
                        'id' => '',
                        'admin_territory_id' => $admin_territory_id,
                        'admin_territory_name' => $admin_territory_name,
                        'territory_parent' => $territory_parent
                    );

                    $theID = $this->selectDB('admin_territory_details', array('id'), array('admin_territory_id' => $admin_territory_id, 'admin_territory_name' => $admin_territory_name));
                    $count = $this->count();

                    if ($count != 0) {
                        $lastID = $theID[0]['id'];
                        continue;
                    } else {
                        $this->insertdDB('admin_territory_details', $insertData);
                        $lastID = $this->lastId();
                    }
                }
            }
        }
        
            $country = $_SESSION["country"];
            $user_name = $_SESSION["full_name"];
            $email = $_SESSION["email"];
            $action = 'territory data imported';
            $description = 'no description';

            $insertData = array(
                'id' => '',
                'country' => $country,
                'user_name' => $user_name,
                'email' => $email,
                'action' => $action,
                'description' => $description
            );

            $this->insertdDB('admin_log_record', $insertData);
    }

}

?>