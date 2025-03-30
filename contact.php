<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/header.php"; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./includes/css/styles.css" rel="stylesheet" type="text/css">
    <title>Contact Us</title>
</head>

<style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:"Inter",sans-serif}.hero{background:#506690;color:#fff;text-align:center;padding:70px 20px}.hero h1{font-size:42px;font-weight:700;margin-bottom:10px;animation:fadeIn 1.5s ease-in-out}.hero p{font-size:18px;max-width:800px;margin:0 auto;animation:fadeIn 2s ease-in-out}:root{--primary-color:#C5BAFF;--link-color:#506690;--btn-hover-color:#C4D9FF;--lg-heading:#161c2d;--text-content:#869ab8;--fixed-header-height:4.5rem}.close_btn,.toggle_btn{display:none!important}body{background:#161c2d;font-family:"Inter",sans-serif;color:#fff;text-align:center}.contact-container{display:flex;flex-direction:column;align-items:center;padding:50px 20px}.contact-header{font-size:42px;font-weight:700;margin-bottom:20px;animation:fadeIn 1.5s ease-in-out}.contact-description{font-size:18px;max-width:700px;margin-bottom:30px;opacity:.9;animation:fadeIn 2s ease-in-out}.contact-grid{display:flex;flex-wrap:wrap;justify-content:center;gap:20px;max-width:1000px}.contact-card{background:#ffffff26;backdrop-filter:blur(12px);padding:25px;border-radius:12px;width:320px;box-shadow:0 10px 20px #0000004d;transition:transform .3s ease-in-out;text-align:center}.contact-card:hover{transform:scale(1.05)}.contact-card h2{font-size:22px;margin-bottom:10px}.contact-card p{font-size:16px;margin-bottom:5px}.email-link{text-decoration:none;color:#C5BAFF;font-weight:700;transition:color .3s}.email-link:hover{color:#fff}.contact-form{background:#fff3;backdrop-filter:blur(15px);padding:30px;border-radius:12px;box-shadow:0 10px 20px #0003;max-width:1000px;width:100%;margin-top:40px}.contact-form h2{margin-bottom:20px}.contact-form input,.contact-form textarea{width:100%;padding:12px;margin:10px 0;border:1px solid #ffffff4d;border-radius:8px;font-size:16px;background:#ffffff1a;color:#fff}.contact-form input::placeholder,.contact-form textarea::placeholder{color:#ffffffb3}.contact-form button{width:100%;padding:12px;border:none;background-color:#fff;color:#000;font-size:18px;border-radius:8px;cursor:pointer;transition:.3s}.contact-form button:hover{background:var(--primary-color);transform:scale(1.05)}@keyframes fadeIn{0%{opacity:0;transform:translateY(-10px)}100%{opacity:1;transform:translateY(0)}}#kian{font-size:15.5px}.header{background:#0d1b2a;padding:15px 0;box-shadow:0 2px 5px #0000001a}.nav{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;padding:0 20px}.logo h2{font-size:24px;color:#fff;font-weight:700;letter-spacing:1px;transition:.3s}.logo a{text-decoration:none}.logo h2:hover{color:#E8F9FF}.nav_menu{display:flex}.nav_menu_list{display:flex;gap:20px;list-style:none}.nav_menu_item{position:relative}.nav_menu_link{text-decoration:none;color:#fff;font-size:16px;font-weight:600;padding:8px 12px;transition:.3s}.nav_menu_link:hover{color:#E8F9FF}@media screen and (max-width: 767px){.grid-item-2{display:none}.logo{display:none}.nav_menu{display:flex;align-items:center;text-align:center;margin:0 auto}.nav_menu_list{gap:10px;margin-top:10px}.nav_menu_link{padding:10px;width:100%;border-radius:5px}.nav_menu_link:hover{background:#ffffff4d}}@media screen and (min-width: 1040px){.container{width:1040px;margin:0 auto}}
</style>
<body>
    <div class="contact-container">
        <h1 class="contact-header">Contact Us</h1>
        <p class="contact-description">
            Have questions or want to get in touch? Reach out to us via email or fill out the form below!
        </p>

        <div class="contact-grid">
            <div class="contact-card">
                <h2>Kris Dane Madlambayan</h2>
                <p>📧 <a class="email-link" href="mailto:krisdane1234@gmail.com">krisdane1234@gmail.com</a></p>
            </div>
            <div class="contact-card">
                <h2>Wilson Yaochingco</h2>
                <p>📧 <a class="email-link" href="mailto:wilsonyao72@gmail.com">wilsonyao72@gmail.com</a></p>
            </div>
            <div class="contact-card">
                <h2>Kian Charles Angeles</h2>
                <p id="kian">📧 <a class="email-link" href="mailto:Angeleskiancharles@gmail.com">Angeleskiancharles@gmail.com</a></p>
            </div>
        </div>

        <!-- Contact Form (Preserved CSS, Inserted New Form) -->
        <div class="contact-form">
            <h2>Send Us a Message</h2>
            <form id="contactForm">
                <input type="hidden" name="access_key" value="86a2b75a-0fbc-4c91-aa06-7e7b40eeb317">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Type your message here..." rows="5" required></textarea>
                <button type="submit">Send Message</button>
            </form>
            <p id="formResponse" style="color: white; margin-top: 10px;"></p>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>

    <!-- Include JavaScript for Form Submission -->
    <script src="contact.js"></script>
</body>
</html>
