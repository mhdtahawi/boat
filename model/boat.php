<?php


class Boat
{
    private $connection = NULL;

    public function __construct()
    {
        $this->connection = include('db.php');
    }

    public function create($user_id, $type, $length, $propulsion)
    {

        $query = $this->connection->prepare("INSERT INTO boats (type_id, length  , propulsion_id) values (?, ?, ?)");
        $query->bind_param('idi', $this->get_type_id($type), $length, $this->get_propulsion_id($propulsion));
        $query->execute();
        $boat_id = $query->insert_id;


        $query = $this->connection->prepare("INSERT INTO users_boats  values (?, ?)");
        $query->bind_param('ii', $user_id, $boat_id);
        $query->execute();
        $query->close();
    }

    private function get_type_id($type)
    {
        $query = $this->connection->prepare("SELECT id from boat_types where type_name = ?");
        $query->bind_param('s', $type);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        $type_id = $row["id"];
        $query->close();

        return $type_id;


    }

    private function get_propulsion_id($propulsion)
    {

        $query = $this->connection->prepare("SELECT id from boat_propulsion where propulsion_name= ?");
        $query->bind_param('s', $propulsion);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        $propulsion_id = $row["id"];
        $query->free_result();

        return $propulsion_id;
    }

    public function list_all($user_id, $page, $items_per_page)
    {


        $offset = ($page - 1) * $items_per_page;


        $query = $this->connection->prepare("SELECT b.id, bp.propulsion_name, bt.type_name , b.length FROM 
                                                boats AS b INNER JOIN users_boats AS ub on b.id = ub.boat_id 
                                                inner join boat_types as bt on b.type_id = bt.id
                                                inner join boat_propulsion as bp on b.propulsion_id = bp.id
                                                where ub.user_id = ?
                                                LIMIT $offset, $items_per_page");

        $query->bind_param('i', $user_id);
        $query->execute();
        $rows = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        return $rows;


    }

    public function list_one($user_id, $boat_id)
    {


        if ($this->is_owner($user_id, $boat_id)) {

            $query = $this->connection->prepare("SELECT b.id, bp.propulsion_name, bt.type_name , b.length FROM 
                                                boats AS b INNER JOIN users_boats AS ub on b.id = ub.boat_id 
                                                inner join boat_types as bt on b.type_id = bt.id
                                                inner join boat_propulsion as bp on b.propulsion_id = bp.id
                                                
                                                where ub.user_id = ? AND  b.id = ?");
            $query->bind_param('ii', $user_id, $boat_id);
            $query->execute();


            $rows = $query->get_result()->fetch_assoc();
            $query->close();

            return $rows;

        } else {

            throw new AuthorizationException();
        }


    }


    // maybe get_all_ functions better be static

    private function is_owner($user_id, $boat_id)
    {
        $query = $this->connection->prepare("SELECT * FROM users_boats where user_id = ? AND boat_id = ?");
        $query->bind_param('ii', $user_id, $boat_id);


        $query->execute();
        $query->store_result();

        return $query->num_rows > 0;
    }

    public function update($user_id, $boat_id, $type, $length, $propulsion)
    {

        if ($this->is_owner($user_id, $boat_id)) {


            // get type id
            $type_id = $this->get_type_id($type);

            // get propulsion id
            $propulsion_id = $this->get_propulsion_id($propulsion);


            $query = $this->connection->prepare("UPDATE boats SET type_id = ? , length = ? , propulsion_id = ? where id = ?");
            $query->bind_param('idii', $type_id, $length, $propulsion_id, $boat_id);
            try {

                $query->execute();


            } catch (mysqli_sql_exception $exception) {
                throw $exception; // handle in the controller
            }

        } else {

            throw new AuthorizationException();
        }


    }

    public function delete($user_id, $boat_id)
    {
        if ($this->is_owner($user_id, $boat_id)) {

            $query = $this->connection->prepare("DELETE FROM users_boats where user_id = ? AND boat_id = ?");
            $query->bind_param('ii', $user_id, $boat_id);
            $query->execute();


            $query = $this->connection->prepare("DELETE FROM boats where id = ?");
            $query->bind_param('i', $boat_id);
            $query->execute();
            $query->close();
        } else {

            throw new AuthorizationException();
        }
    }

public function get_all_types()
    {

        $var = $this->connection->query("SELECT type_name from boat_types");
        $res = array();

        while ($x = $var->fetch_array()) {
            $res[] = $x["type_name"];
        }

        return $res;
    }

    public function get_all_propulsion()
    {

        $var = $this->connection->query("SELECT propulsion_name from boat_propulsion");
        $res = array();

        while ($x = $var->fetch_array()) {
            $res[] = $x["propulsion_name"];
        }

        return $res;
    }

    public function boat_count($user_id)
    {
        $query = $this->connection->prepare("SELECT count(*) as count FROM users_boats where user_id = ?");
        $query->bind_param('i', $user_id);


        $query->execute();
        $res = $query->get_result()->fetch_assoc();


        return $res["count"];
    }
}


