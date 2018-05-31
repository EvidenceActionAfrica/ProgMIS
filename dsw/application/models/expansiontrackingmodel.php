<?php

class expansiontrackingmodel extends Database {

    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     * */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function getlsmTrackingdata() {

        $country_id = $_SESSION['country'];
        $query = "SELECT
            lsm_details.id,
            lsm_details.lsm_title,
            lsm_details.officials,
            lsm_details.location,
            lsm_details.meeting_date,
            lsm_details.meeting_time,
            lsm_tracking.status,
            lsm_tracking.next_meeting_date,
            lsm_tracking.no_of_villages,
            lsm_tracking.actual_no_of_people_present,
            lsm_tracking.estimated_reimbursement,
            lsm_tracking.actual_reimbursement,
            lsm_tracking.no_of_nominated_wps,
            lsm_tracking.no_of_eligible_wps,
            lsm_tracking.notes
            FROM lsm_details
            LEFT JOIN lsm_tracking ON lsm_details.id = lsm_tracking.lsm_details_id WHERE lsm_details.country = '$country_id'
        ";

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function updatelsmtracking($table, $data) {

        $lsm_details_id = $this->selectDB($table, $filds = array('lsm_details_id'), $params = array('lsm_details_id' => $data['lsm_details_id']));

        if (empty($lsm_details_id)) {
            $data = array(
                'id' => NULL,
                'lsm_details_id' => $data['lsm_details_id'],
                'status' => $data['status'],
                'next_meeting_date' => $data['next_meeting_date'],
                'no_of_villages' => $data['no_of_villages'],
                'actual_no_of_people_present' => $data['actual_no_of_people_present'],
                'estimated_reimbursement' => $data['estimated_reimbursement'],
                'actual_reimbursement' => $data['actual_reimbursement'],
                'no_of_nominated_wps' => $data['no_of_nominated_wps'],
                'no_of_eligible_wps' => $data['no_of_eligible_wps'],
                'notes' => $data['notes']
            );
            $this->insertdDB($table, $data);
        } else {
            $data = array(
                'status' => $data['status'],
                'next_meeting_date' => $data['next_meeting_date'],
                'no_of_villages' => $data['no_of_villages'],
                'actual_no_of_people_present' => $data['actual_no_of_people_present'],
                'estimated_reimbursement' => $data['estimated_reimbursement'],
                'actual_reimbursement' => $data['actual_reimbursement'],
                'no_of_nominated_wps' => $data['no_of_nominated_wps'],
                'no_of_eligible_wps' => $data['no_of_eligible_wps'],
                'notes' => $data['notes']
            );
            $this->updateDBparams($table, $data, $params = array('lsm_details_id' => $lsm_details_id[0]['lsm_details_id']));
        }
    }

}

?>