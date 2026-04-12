<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pdf to Audio Converter</title>

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- style.css -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

</head>

<body>
  <!-- ======= Starting of Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-lg-between">
      <h1 class="logo me-auto me-lg-0"><a href="index.php">Pdf To Audio<span></span></a></h1>

      <!-- ======= Starting of Navbar ======= -->
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About Us</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <li><a class="nav-link scrollto" href="#testimonials">Testimonials</a></li>        
          <li class="dropdown"><a><span>PDF Converters</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="Converter/PDF to Audio Book/PdfToAudio.html">PDF to AudioBook / Speech</a></li>
              <li><a href="Converter/TextToAudio/TextToAudio.html">Text to Speech / Audio</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="#contact">Contact Us</a></li>
          <?php if (isset($_SESSION['user_id'])): ?>
  <li class="dropdown">
    <a href="#"><span>👤 <?= htmlspecialchars($_SESSION['user_name']) ?></span> <i class="bi bi-chevron-down"></i></a>
    <ul>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </li>
<?php else: ?>
  <li><a href="login.php" class="nav-link">Login</a></li>
  <li><a href="register.php" class="getstarted scrollto">Register</a></li>
<?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav> <!-- End of Navbar -->

    </div>
  </header> <!-- End of Header -->

  <!-- ======= Main Section ======= -->
  <main id="main">
    <!-- ======= Starting of Cursor div ======= -->
    <div id="main-cursor"></div> <!-- End of Cursor div   -->

    <video src="bg-video.mp4" type="video/mp4" id="background-video" autoplay muted loop></video>
    <!-- ======= Page1 Section ======= -->
    <div id="page1">
      <!-- ======= Starting of Cursor div ======= -->
    <!--  <div id="cursor"></div>--> <!-- End of Cursor div   -->
      <div id="heading-container">
        <h2 id="head-text-convert" data-aos="fade-right" data-aos-delay="500">CONVERT </h2>
        <h2 id="head-text-your pdf to audio" data-aos="fade-right" data-aos-delay="500">YOUR PDF TO AUDIO</h2>
      </div>
    </div> <!-- End of Page1  -->

    <!-- ======= Page2 Section ======= -->
    <div id="page2">
      <section id="about" class="about">
        <div class="section-title container">
          <h2>About</h2>
          <p>About Us</p>
        </div>
        <div class="container" data-aos="fade-up">
          <div class="row">
            <div class="col-lg-6 " data-aos="fade-up" >
            </div>
            <div class="col-lg-9  content" data-aos="fade-right" >
              <h3>Our Mission</h3>
              <p class="fst-italic">
                Our mission is to empower individuals and businesses with the tools they need to harness the full potential of PDF files. We understand that PDFs are a ubiquitous and valuable document format, but they can sometimes be challenging to work with. That's why we've developed a range of services to convert, edit, and enhance your PDFs, helping you get the most out of your documents.
              </p>
              <h4>Why Choose Us?</h4>
              <ul>
                <li>
                  <i class="ri-check-double-line"></i>
                  <strong>Accuracy: </strong>Our state-of-the-art conversion algorithms ensure the highest accuracy in all our services.
                </li>
                <li>
                  <i class="ri-check-double-line"></i>
                  <strong>User-Friendly: </strong>Our platform is designed with simplicity in mind, making it accessible to both novices and experts.
                </li>
                <li>
                  <i class="ri-check-double-line"></i>
                  <strong>Fast Turnaround: </strong>We value your time. Our services are optimized for speed, delivering results swiftly.
                </li>
                <li>
                  <i class="ri-check-double-line"></i>
                  <strong>Customer Support: </strong>Our dedicated support team is here to assist you with any questions or concerns you may have.
                </li>
              </ul>
              <p>
                Welcome to PDFShift, your one-stop solution for all your PDF handling needs. At PDFShift, we're passionate about simplifying the way you interact with PDF documents, making them more accessible and versatile than ever before.
              </p>
            </div>
          </div>

        </div>
      </section><!-- End About Section -->
    </div> <!-- End of page2  -->

    <!-- ======= Page3 Section ======= -->
    <div id="page3">
      <!-- ======= Services Section ======= -->
      <section id="services" class="services">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
            <h2>Services</h2>
            <p>Check our Services</p>
          </div>

          <div class="row">
            <div class="col-lg-4 col-md-6  disable-cursor-div" data-aos="zoom-in" data-aos-delay="100">
              <div class="icon-box">
                <div class="icon"><i class="bx bxl-dribbble"></i></div>
                <h4><a href="Converter/TextToAudio/TextToAudio.html">Text-to-Audio Conversion</a></h4>
                <p> Our Text-to-Audio Conversion Service allows you to transform written content, such as articles, documents, or blog posts, into high-quality audio.</p>
              </div>
            </div>

            <div class="col-lg-4 col-md-6  disable-cursor-div" data-aos="zoom-in" data-aos-delay="200">
              <div class="icon-box">
                <div class="icon"><i class="bx bx-file"></i></div>
                <h4><a href="Converter/PDF to Audio Book/PdfToAudio.html">PDF to AudioBook</a></h4>
                <p>Convert PDFs into audio files (MP3, WAV, etc.), enabling users to listen to documents while on the go, enhancing accessibility.</p>
              </div>
            </div>



          </div>

        </div>
      </section><!-- End Services Section -->
    </div> <!-- End of page3  -->


<!-- ======= Page4 Section for Testimonials Section ======= -->
    <div id="page4"><!-- ======= Testimonials Section ======= -->
      <section id="testimonials" class="testimonials">
        <div class="container" data-aos="zoom-in">
          <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">

              <div class="swiper-slide">
                <div class="testimonial-item">
                  <h3>vaibhav</h3>
                  <!-- <h4>Ceo &amp; Founder</h4> -->
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    I absolutely love how your PDF to audio service has made my study sessions so much more accessible. It's an amazing tool for converting dense textbooks into engaging audio files. I can now multitask and absorb information on the go!
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                  <h3>sarthak</h3>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Your audio to text conversion service is a lifesaver for me as a journalist. It saves hours transcribing interviews. The accuracy is impressive, and the time I save is priceless.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                  <h3>Aaysha Kamble</h3>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    I'm amazed at how well your audio to text converter performs. It accurately transcribes my recorded meetings, making it a breeze to organize and refer back to discussions. Thank you for making work more efficient!.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                  <h3>Gajanan Wagh</h3>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Your text to audio service has brought my blog content to life. The range of voices and customizations is fantastic. It's given my readers a whole new way to enjoy my writing.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                  <h3>Prashant Borade</h3>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Your PDF to audio converter has been a game-changer for me. I use it to turn my work reports into audio files, making it easier to review and catch errors. It's a productivity booster
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->
            </div>
            <div class="swiper-pagination"></div>
          </div>

        </div>
      </section><!-- End Testimonials Section -->
    </div>

  
   
    

    

  </main> <!-- End of main Section  -->

  <!-- ======= Preloader ======= -->
 <div id="preloader"></div>
  <!-- End of Preloader  -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6" id="footer-info-parent">
            <div class="footer-info">
              <h3>Pdf to Audio</h3>
              <p>nashik <br>
                422 003, Maharashtra<br><br>
                <strong>Phone:</strong> +91 9607473987<br>
                <strong>Email:</strong> pdfshift@gmail.com<br>
              </p>
              <div class="social-links mt-3">
                <a  class="twitter"><i class="bx bxl-twitter"></i></a>
                <a  class="facebook"><i class="bx bxl-facebook"></i></a>
                <a  class="instagram"><i class="bx bxl-instagram"></i></a>
                <a  class="google-plus"><i class="bx bxl-skype"></i></a>
                <a  class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul id="userful-links-ul">
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#testimonials">Testimonials</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Services</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul id="our-services-ul">
              <li><i class="bx bx-chevron-right"></i> <a href="Converter/PDF to Audio Book/PdfToAudio.html">PDF-to-AudioBook (Speech)</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="Converter/TextToAudio/TextToAudio.html">Text-to-Audio Conversion</a></li>

            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <p>Subscribe our Newsletter for Latest Updates</p>
            <form action="newsLetter.php" method="post">
              <input type="email" name="email" required><input type="submit" value="Subscribe">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>PDFShift</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by pvg boys</a>
      </div>
    </div>
  </footer><!-- End Footer -->


  <!-- ======= Vendor JS Files ======= -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- ======= GSAP cdn ======= -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"
   integrity="sha512-16esztaSRplJROstbIIdwX3N97V1+pZvV33ABoG1H2OyTttBxEGkTsoIVsiP1iaTtM8b3+hu2kB6pQ4Clr5yug=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  <!-- ======= Scroll Trigger cdn ======= -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"
    integrity="sha512-Ic9xkERjyZ1xgJ5svx3y0u3xrvfT/uPkV99LBwe68xjy/mGtO+4eURHZBW2xW4SZbFrF1Tf090XqB+EVgXnVjw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  <!-- ======= Typed JS ======= -->
  <!--<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>-->

  <!-- ======= My Script ======= -->
  <script src="js/script.js"></script>
</body>

</html>