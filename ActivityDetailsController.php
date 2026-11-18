<?php

require_once 'ActivityDetailsCRUD.php';

class ActivityDetailsController {
    private $activityDetailsCRUD;

    public function __construct() {
        $this->activityDetailsCRUD = new ActivityDetailsCRUD();
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $result = "";

            if (isset($_POST['create']) && isset($_POST['Id'])) {
                $activity = new Activity();
                $activity->Id = $_POST['Id'];
                $activity->user_id = $_POST['user_id'];
                $activity->start_date = $_POST['start_date'];
                $activity->end_date = $_POST['end_date'];
                $activity->Activity_Name = $_POST['Activity_Name'];
                $activity->attachment = $_POST['attachment'];
                $activity->Major = $_POST['Major'];

                $result = $this->activityDetailsCRUD->create($activity);
            } elseif (isset($_POST['update']) && isset($_POST['Id'])) {
                $activity = new Activity();
                $activity->Id = $_POST['Id'];
                $activity->user_id = $_POST['user_id'];
                $activity->start_date = $_POST['start_date'];
                $activity->end_date = $_POST['end_date'];
                $activity->Activity_Name = $_POST['Activity_Name'];
                $activity->attachment = $_POST['attachment'];
                $activity->Major = $_POST['Major'];

                $result = $this->activityDetailsCRUD->update($activity);
            } elseif (isset($_POST['delete']) && isset($_POST['Id'])) {
                $result = $this->activityDetailsCRUD->delete($_POST['Id']);
            } elseif (isset($_POST['feedback'])) {
                $feedback = new Feedback();
                $feedback->FullName = $_POST['FullName'];
                $feedback->email = $_POST['email'];
                $feedback->Instructor_id = $_POST['Instructor_id'];
                $feedback->Message = $_POST['message'];

                $result = $this->activityDetailsCRUD->feedback($feedback);
            }

            $section = isset($_POST['create']) ? 'new-entry'
                : (isset($_POST['update']) ? 'update'
                : (isset($_POST['delete']) ? 'remove'
                : (isset($_POST['feedback']) ? 'feedback' : 'overview')));
            $status = (stripos($result, 'error') === 0 || stripos($result, 'no record') === 0) ? 'error' : 'success';

            header('Location: activitydetails.php?status=' . $status . '&message=' . rawurlencode($result) . '#' . $section);
            exit;
        }
    }
}

$controller = new ActivityDetailsController();
$controller->handleRequest();
