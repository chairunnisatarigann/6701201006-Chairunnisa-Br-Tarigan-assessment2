<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Jadwal CRUD</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

  <div class="container mt-4">
    <h2>Booking Jadwal CRUD</h2>

    <!-- Form for booking jadwal -->
    <form id="bookingForm">
      <div class="form-group">
        <label for="idPasien">Pasien ID:</label>
        <input type="number" class="form-control" id="idPasien" required>
      </div>
      <div class="form-group">
        <label for="idJadwal">Jadwal ID:</label>
        <input type="number" class="form-control" id="idJadwal" required>
      </div>
      <div class="form-group">
        <label for="tanggalBooking">Tanggal Booking:</label>
        <input type="date" class="form-control" id="tanggalBooking" required>
      </div>
      <button type="button" class="btn btn-primary" id="bookBtn">Book</button>

    </form>

    <!-- Table to display bookings -->
    <table class="table mt-4">
      <thead>
        <tr>
          <th>ID Booking</th>
          <th>ID Pasien</th>
          <th>ID Jadwal</th>
          <th>Tanggal Booking</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="bookingTableBody"></tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>
    // Function to add booking using AJAX
    function addBooking() {
      const idPasien = $('#idPasien').val();
      const idJadwal = $('#idJadwal').val();
      const tanggalBooking = $('#tanggalBooking').val();

      // Simple form validation
      if (!idPasien || !idJadwal || !tanggalBooking) {
        alert('Please fill in all fields');
        return;
      }

      // AJAX request to add booking
      $.ajax({
        url: 'crud.php', // Assuming your server-side script is named crud.php
        method: 'POST',
        data: {
          action: 'addBooking',
          idPasien: idPasien,
          idJadwal: idJadwal,
          tanggalBooking: tanggalBooking
        },
        success: function(response) {
          // Reload bookings after adding
          loadBookings();
          // Clear the form
          // $('#idPasien').val('');
          // $('#idJadwal').val('');
          // $('#tanggalBooking').val('');
          alert('Booking added successfully');
        },
        error: function(error) {
          console.error(error);
        }
      });
    }

    // Attach the addBooking function to the button click event using jQuery
    $('#bookBtn').click(addBooking);

    // Function to load bookings using AJAX
    function loadBookings() {
      // AJAX request to get bookings
      $.ajax({
        url: 'crud.php',
        method: 'GET',
        data: {
          action: 'getBookings'
        },
        success: function(response) {
          // Parse the JSON string into an array
          const bookings = JSON.parse(response);

          // Update the table body with new bookings
          const tableBody = $('#bookingTableBody');
          tableBody.empty();

          bookings.forEach(function(booking) {
            tableBody.append(`
                    <tr>
                        <td>${booking.id_booking}</td>
                        <td>${booking.id_pasien}</td>
                        <td>${booking.id_jadwal}</td>
                        <td>${booking.tanggal_booking}</td>
                        <td>
                            <button class="btn btn-warning" onclick="editBooking(${booking.id_booking})">Edit</button>
                            <button class="btn btn-danger" onclick="deleteBooking(${booking.id_booking})">Delete</button>
                        </td>
                    </tr>
                `);
          });
        },
        error: function(error) {
          console.error(error);
        }
      });
    }

    // Initial load of bookings
    loadBookings();

    // You can implement editBooking and deleteBooking functions similarly using AJAX
    function deleteBooking(idBooking) {
      if (confirm('Are you sure you want to delete this booking?')) {
        $.ajax({
          url: 'crud.php',
          method: 'POST',
          data: {
            action: 'deleteBooking',
            idBooking: idBooking
          },
          success: function(response) {
            loadBookings(); // Reload bookings after deletion
          },
          error: function(error) {
            console.error(error);
          }
        });
      }
    }
  </script>

</body>

</html>