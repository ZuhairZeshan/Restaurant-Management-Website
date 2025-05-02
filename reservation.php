<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation - DelightInn</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    

    <style>
        .bgrcolor {
            background-image: url(https://images.pexels.com/photos/326333/pexels-photo-326333.jpeg);
            background-position: center;
            background-size: cover;
            background-repeat: none;
        }

        .bgtable{
           background: #c31432 !important;  /* fallback for old browsers */
           background: -webkit-linear-gradient(to right, #240b36, #c31432) !important;  /* Chrome 10-25, Safari 5.1-6 */
           background: linear-gradient(to right, #240b36, #c31432) !important; /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
           color: white;
        }
        .bgimgtable{
            background-image: url(https://files.oaiusercontent.com/file-GzZmTCUPejBGpPoEvqUzD4?se=2024-12-03T07%3A49%3A45Z&sp=r&sv=2024-08-04&sr=b&rscc=max-age%3D604800%2C%20immutable%2C%20private&rscd=attachment%3B%20filename%3D2b3b65f7-a8b7-45a8-8230-1f2acab4812c.webp&sig=SqoSq%2BjxR9vPiFJshg0htxKoENq04T5rqiMJs9LJyLk%3D);
            background-position: center;
            background-size: cover;
            background-repeat: none;
        }

        .pdcard{
            padding-left: 90px;
            padding-right: 90px;
        }
        .bgtable thead,
        .bgtable tbody,
        .bgtable tr,
        .bgtable td {
            background: transparent !important;
            color: white;
        }

    </style>
    
</head>
<body>
    <?php include '_dbconnect.php'; ?>
    
    <!-- navbar start -->
    <div class="container-fluid sec-1">
        <div class='wrapper'>
            <?php include 'navbar.php'; ?>
        </div>
    </div>
    <!-- navbar end -->
    
    <section class="bgrcolor text-light" >
        <div class="row" style="min-height: 700px">
            <div class="col-12">
    <div class="container pt-5">
        <h1 class="text-center pb-4 fw-bold">Table Reservation Section</h1>
        <div class="mb-4">
        <h5 style="display: inline; margin-right: 5px;" class="fw-bolder">Select the table </h5>
        <h6 style="display: inline;">(Along with number of seats)</h6>
        </div>
        <div class="row text-dark ">
            <?php
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch available tables
            $result = $conn->query("SELECT * FROM tables WHERE is_occupied = FALSE");
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4'>
                        <div class='card mb-4'>
                            <div class='card-body text-center bgimgtable m-1 pdcard'>
                                <div class='text-light pb-2 mb-3 bg-dark'>
                                    <h5 class='card-titlet '>Table " . $row['Table_no'] . "</h5>
                                    <p class='card-text'>Seats: " . $row['seats'] . "</p>
                                </div>
                                <button class='btn btn-primary reserve-button ' data-id='" . $row['Id'] . "'>Reserve</button>
                            </div>
                        </div>
                    </div>";
            }
            ?>
        </div>

        <div id="reservation-form" class="mt-5" style="display:none;">
            <h2 class="text-center pb-3">Confirm Reservation</h2>
            <form id="form" method="POST" action="confirm_reserv.php">
                <input type="hidden" name="table_id" id="table_id">
                <div class="form-group">
                    <!-- <label for="customer_name">Name:</label> -->
                    <input type="text" class="form-control" name="customer_name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <!-- <label for="customer_email">Email:</label> -->
                    <input type="email" class="form-control" name="customer_email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <!-- <label for="reservation_time">Reservation Time:</label> -->
                    <input type="datetime-local" class="form-control" name="reservation_time" placeholder="Reservation Time" required>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-success">Confirm Reservation</button>
                </div>
            </form>
        </div>

        <h2 class="text-center mt-5" sty>Your Reservations</h2>
        <table class="bgtable table table-bordered mt-3 text-light">
            <thead>
                <tr>
                    <th>Table No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Reservation Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if the user is logged in
                if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                    echo "<script>window.location.href = '/Restaurant-Management-Website/index.php'</script>";
                    exit();
                }
                                    // Fetch user's reservations
                    $userId = $_SESSION['sno']; // Assuming user_id is stored in session
                    $reservations = $conn->query("SELECT r.*, t.Table_no FROM reservations r JOIN tables t ON r.table_id = t.Id WHERE r.user_id = '$userId'");

                    if ($reservations && $reservations->num_rows > 0) {
                        while ($reservation = $reservations->fetch_assoc()) {
                            // Determine the badge color based on the status
                            $badgeClass = '';
                            switch ($reservation['status']) {
                                case 'completed':
                                    $badgeClass = 'badge bg-success'; // Green badge for completed
                                    break;
                                case 'rejected':
                                    $badgeClass = 'badge bg-danger'; // Red badge for rejected
                                    break;
                                case 'approved':
                                    $badgeClass = 'badge bg-primary'; // Blue badge for approved
                                    break;
                                default:
                                    $badgeClass = 'badge bg-warning'; // Default badge for unknown status
                                    break;
                            }
                        
                            echo "<tr>
                                    <td>" . htmlspecialchars($reservation['Table_no'], ENT_QUOTES) . "</td>
                                    <td>" . htmlspecialchars($reservation['customer_name'], ENT_QUOTES) . "</td>
                                    <td>" . htmlspecialchars($reservation['customer_email'], ENT_QUOTES) . "</td>
                                    <td>" . htmlspecialchars($reservation['reservation_time'], ENT_QUOTES) . "</td>
                                    <td><span class='$badgeClass'>" . htmlspecialchars($reservation['status'], ENT_QUOTES) . "</span></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No reservations found.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $('.reserve-button').on('click', function() {
            const tableId = $(this).data('id');
            $('#table_id').val(tableId);
            $('#reservation-form').show();
        });
    </script>
    </div>
</div>
</section>
</body>
</html>