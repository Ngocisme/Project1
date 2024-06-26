<?php
ob_start();
include_once "../users/includes/header.php";
include_once "../../models/Mailer_model.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $sub = $_POST["sub"];
        $mess = $_POST["mess"];

        sendMail($email, $name, $sub, $mess);
        header('Location: http://localhost:8888/keitaizoneTemplate/views/users/contact.php?success=Successfully');
        exit();
    }
}
ob_end_flush();
?>

<!-- Contact Start -->
<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Contact
            Us</span></h2>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form bg-light p-30">
                <div id="success"></div>

                <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <div class="control-group">
                        <input type="text" class="form-control" name="name" placeholder="Your Name"
                            data-validation-required-message="Please enter your name" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="email" class="form-control" name="email" placeholder="Your Email"
                            data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="text" class="form-control" name="sub" placeholder="Subject"
                            data-validation-required-message="Please enter a subject" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea class="form-control" rows="8" name="mess" placeholder="Message"
                            data-validation-required-message="Please enter your message"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" name="submit">Send
                            Message
                        </button>
                        <p class='text-success'>
                            <?php
                            if (isset($_GET['success'])) {
                                echo $_GET['success'];
                            } ?>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <div class="bg-light p-30 mb-30">
                <iframe style="width: 100%; height: 250px;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <div class="bg-light p-30 mb-3">
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Công Viên Phần mềm Quang Trung Toà
                    nhà GenPacific, Lô 3 đường 16, Trung Mỹ Tây, Quận 12, Thành phố Hồ Chí Minh, Việt Nam</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>admin@gmail.com</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->


<?php

include_once "../users/includes/footer.php";

?>