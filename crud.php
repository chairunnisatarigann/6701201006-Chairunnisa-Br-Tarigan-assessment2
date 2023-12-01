<?php
// crud.php

$host     = 'localhost';
$user     = 'root'; // diisi dengan user database kalian biasanya // defaultnya bernama root jika kita belum  // merubahnya
$password = '';  //diisi dengan password database kalian biasanya
// defaultnya kosong
$db       = 'konsultasi_dokter'; //diisi dengan nama database kalian

$mysqli = mysqli_connect($host, $user, $password, $db) or die(mysqli_error());


// Function to add booking
function addBooking($idPasien, $idJadwal, $tanggalBooking)
{
    global $mysqli;
    $query = "INSERT INTO booking_jadwal (id_pasien, id_jadwal, tanggal_booking) VALUES ('$idPasien', '$idJadwal', '$tanggalBooking')";
    $mysqli->query($query);
}

// Function to get all bookings
function getBookings()
{
    global $mysqli;
    $bookings = [];
    $result = $mysqli->query("SELECT * FROM booking_jadwal");
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    return $bookings;
}

//delete booking
function deleteBooking($idBooking)
{
    global $mysqli;
    error_log('Deleting booking with ID: ' . $idBooking); // Log to PHP error log
    die('Deleting booking with ID: ' . $idBooking); // Output to browser

    $query = "DELETE FROM booking_jadwal WHERE id_booking = '$idBooking'";
    $mysqli->query($query);
}

// Check if the action is set and call the corresponding function
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'addBooking':
            addBooking($_POST['idPasien'], $_POST['idJadwal'], $_POST['tanggalBooking']);
            break;
    }
}

// Check if the action is set and return data accordingly
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'getBookings':
            echo json_encode(getBookings());
            break;
    }
}

$mysqli->close();
