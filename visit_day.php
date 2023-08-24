<?php

    function establishConnection() {
        $servername = "localhost";
        $username = "binh5341_kursus";
        $password = "mylove123!@#";
        $dbname = "binh5341_kursus";
        // $port = "3307";
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }
    
        return $conn;
    }

    // Fungsi Store Procedure
    function insertOrUpdateData($conn) {
        $insertSql = "CALL InsertOrUpdateData()";
        $conn->query($insertSql);
    }

    // Fungsi Get One Week
    function getCountOneWeek($conn) {
        $sql = "select coalesce(sum(visit_count), 0) weeks  from visited_day WHERE YEARWEEK(visit_date)=YEARWEEK(NOW())";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["weeks"];
        } else {
            return "-";
        }
    }

    // Fungsi Get Todaay
    function getCountToday($conn) {
        $sql = "select case when exists(select visit_count from visited_day WHERE cast(visit_date as date) = curdate() limit 1) ";
        $sql .= "then (select visit_count from visited_day WHERE cast(visit_date as date) = curdate() limit 1) else 0 ";
        $sql .= "end today";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["today"];
        } else {
            return "-";
        }
    }

    // Fungsi Get Yesterday
    function getCountYesterday($conn) {
        $sql = "select case when exists(select visit_count  from visited_day WHERE cast(visit_date as date) = subdate(curdate(), 1)) ";
        $sql .= "then (select visit_count  from visited_day WHERE cast(visit_date as date) = subdate(curdate(), 1)) else 0 ";
        $sql .= "end yesterday";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["yesterday"];
        } else {
            return "-";
        }
    }

    $conn = establishConnection();

    if(isset($_POST['action']) && $_POST['action'] == 'call_procedure') {
        insertOrUpdateData($conn);
    }

    if(isset($_POST['action']) && $_POST['action'] == 'select_oneweek') {
        $counterWeek = getCountOneWeek($conn);
        echo $counterWeek;
    }

    if(isset($_POST['action']) && $_POST['action'] == 'select_today') {
        $today = getCountToday($conn);
        echo $today;
    }

    if(isset($_POST['action']) && $_POST['action'] == 'select_yesterday') {
        $yesterday = getCountYesterday($conn);
        echo $yesterday;
    }




    $conn->close();
?>