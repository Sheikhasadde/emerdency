<?php
    $db = dbConnect();
    $sql = "SELECT Review.text, Review.rating, Appointment.start_date, Patient.first_name FROM `Review` 
                INNER JOIN Appointment ON Appointment.id = Review.id 
                INNER JOIN Patient ON Patient.id = Appointment.patient_id
                WHERE Review.status = 1 ORDER BY `Appointment`.`start_date` DESC";

    $reviews = $db->query($sql);

?>
<section class="main-wrapper">
    <main class="container">
        <div class="row">
            <div class="col-12">
                <h1>Reviews</h1>
            </div>
        </div>
        <div class="row">
            <ul class='appointmentlist'>
                <?php
                    while ($row = mysqli_fetch_assoc($reviews)){
                        ?>
                            <li class='col-12'>
                                <?php
                                    $dateStr = strtotime($row["start_date"]);
                                    $date = date('jS F Y',$dateStr);
                                ?>
                                <span class="name">
                                    <p><?php echo $row['first_name']; ?></p>
                                </span>
                                <span class="date"><?php echo $date; ?></span>
                                <span class="rate">
                                    <img src="/images/review-tooth-orange.png" />
                                    <img src="/images/review-tooth-orange.png" />
                                    <img src="/images/review-tooth-orange.png" />
                                    <img src="/images/review-tooth-orange.png" />
                                    <img src="/images/review-tooth-orange.png" />
                                </span>
                                <span class="review-text">
                                    <p><?php echo str_replace(array('<br />', '<br>'), '', $row["text"]); ?></p>
                                </span>
                            </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    </main>
</section>