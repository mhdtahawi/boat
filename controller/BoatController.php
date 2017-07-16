<?php


require("model/boat.php");

class BoatController
{

    private $model;

    function __construct($m)
    {
        $this->model = new Boat();
    }

    function create()
    {

        if (isset($_POST['submit'])) {
            $user_id = $_SESSION['userid'];
            $type = $_POST['type'] ??  null;
            $length = $_POST['length'] ??  null;
            $propulsion = $_POST['propulsion'] ??  null;


            if ($user_id && $type && $length && $propulsion) {


                $this->model->create($user_id, $type, $length, $propulsion);

                $_SESSION['message'] = "Boat created successfully";


            } else {
                $_SESSION['message'] = "Some parameters are missing";
            }

            header("Location: index.php");

        } else {

            $title = "Add boat";

            $type_list = $this->model->get_all_types();

            $propulsion_list = $this->model->get_all_propulsion();

            include("views/boat-create-form.php");

        }

    }

    function update()
    {

        if (isset($_POST['submit'])) {
            $user_id = $_SESSION['userid'];
            $boat_id = $_POST['boatid'] ??  null;
            $type = $_POST['type'] ??  null;
            $length = $_POST['length'] ??  null;
            $propulsion = $_POST['propulsion'] ??  null;


            if ($user_id && $boat_id && $type && $length && $propulsion) {

                try {
                    $this->model->update($user_id, $boat_id, $type, $length, $propulsion);
                    $_SESSION['message'] = "Boat edited successfully";

                } catch (mysqli_sql_exception $exception) {
                    $_SESSION['message'] = "Error updating the boat";

                } catch (AuthorizationException $exception) {

                    session_destroy();
                    header("Location: log-in.php");

                }


            } else {

                $_SESSION['message'] = "Error: Some parameters are missing";
            }

            header("Location: index.php");
        } else {

            $boat = $this->model->list_one($_SESSION['userid'], $_GET['boatid']);

            $title = "Update Boat";
            $boat_id = $_GET['boatid'];
            $length_val = $boat['length'];
            $type_val = $boat['type_name'];
            $propulsion_val = $boat['propulsion_name'];
            $type_list = $this->model->get_all_types();
            $propulsion_list = $this->model->get_all_propulsion();
            include("views/boat-create-form.php");
        }

    }


    function delete()
    {
        $user_id = $_SESSION['userid'];
        $boat_id = $_GET['boatid'] ??  null;
        if ($user_id && $boat_id) {

            try {
                $this->model->delete($user_id, $boat_id);

                $_SESSION['message'] = "Boat deleted successfully";


            } catch (AuthorizationException $exception) {

                $_SESSION['message'] = "You don't own this boat!";

            }

            $title = "Your boats";

            header("Location: index.php");

        } else {
            session_destroy();
            header("Location: log-in.php");
        }

    }


    function list_all()
    {
        $items_per_page = 5;
        $user_id = $_SESSION['userid'];

        $page = $_GET['page'] ??  1;
        $rows = $this->model->list_all($user_id, $page, $items_per_page);

        $count = $this->model->boat_count($user_id);


        $has_prev = ($page > 1);
        $has_next = ($page * $items_per_page < $count);


        $prev_link = "index.php?action=read&page=" . ($page - 1);
        $next_link = "index.php?action=read&page=" . ($page + 1);


        $title = "Your boats";

        include("views/list.php");

    }


}