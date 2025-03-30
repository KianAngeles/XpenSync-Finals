<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/header.php"; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./includes/css/styles.css" rel="stylesheet" type="text/css">
    <title>About Us | XpenSync</title>
</head>
<style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:"Inter",sans-serif}:root{--primary-color:#C5BAFF;--link-color:#506690;--btn-hover-color:#C4D9FF;--lg-heading:#161c2d;--text-content:#869ab8;--fixed-header-height:4.5rem}body{background-color:#f4f4f4;color:#333}.hero{background:#506690;color:#fff;text-align:center;padding:70px 20px}.hero h1{font-size:42px;font-weight:700;margin-bottom:10px;animation:fadeIn 1.5s ease-in-out}.hero p{font-size:18px;max-width:800px;margin:0 auto;animation:fadeIn 2s ease-in-out}.about-container{max-width:1000px;margin:50px auto;padding:30px;background:#506690;border-radius:10px;box-shadow:0 0 20px #0000001a}.about-container h2{text-align:center;font-size:30px;color:#fff;margin-bottom:20px}.about-content{display:flex;align-items:center;gap:20px}.about-text{flex:1;font-size:16px;line-height:1.6;padding:20px}.about-text p{flex:1;font-size:17px;line-height:1.6;color:#fff;font-weight:700}.about-image{flex:1;text-align:center}.about-image img{width:100%;max-width:400px;border-radius:10px;box-shadow:0 4px 10px #0003}.features{text-align:center;padding:60px 20px;background:#f9f9f9}.features h2{font-size:30px;color:#506690;margin-bottom:30px}.feature-list{display:flex;justify-content:center;gap:25px}.feature{background:#fff;padding:25px;border-radius:10px;width:300px;text-align:center;box-shadow:0 0 10px #0000001a;transition:.3s}.feature:hover{transform:translateY(-5px);box-shadow:0 5px 15px #0003}@keyframes fadeIn{from{opacity:0;transform:translateY(-20px)}to{opacity:1;transform:translateY(0)}}@media (max-width: 768px){.about-content{flex-direction:column}}footer{width:100%;background-color:var(--primary-color);height:12px;margin-top:8rem}.header{background:#0d1b2a;padding:15px 0;box-shadow:0 2px 5px #0000001a}.nav{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;padding:0 20px}.logo h2{font-size:24px;color:#fff;font-weight:700;letter-spacing:1px;transition:.3s}.logo a{text-decoration:none}.logo h2:hover{color:#E8F9FF}.nav_menu{display:flex}.nav_menu_list{display:flex;gap:20px;list-style:none}.nav_menu_item{position:relative}.nav_menu_link{text-decoration:none;color:#fff;font-size:16px;font-weight:600;padding:8px 12px;transition:.3s}.nav_menu_link:hover{color:#E8F9FF}@media screen and (max-width: 767px){.grid-item-2{display:none}.logo{display:none}.nav_menu{display:flex;align-items:center;text-align:center;margin:0 auto}.nav_menu_list{gap:10px;margin-top:10px}.nav_menu_link{padding:10px;width:100%;border-radius:5px}.nav_menu_link:hover{background:#ffffff4d}}@media screen and (min-width: 1040px){.container{width:1040px;margin:0 auto}}
</style>
<body>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to XpenSync</h1>
        <p>Where budgeting becomes simple, smart, and stress-free.</p>
    </div>

    <!-- About Us Section -->
    <div class="about-container">
        <h2>About Us</h2>
        <div class="about-content">
            <div class="about-text">
                <p>We are a group of college students who understand the struggles of managing money firsthand.</p>
                <p>That’s when we had an idea—why not build a budgeting tool that works for students and young professionals?</p>
            </div>
            <div class="about-image">
                <img src="images/about-pic.png" alt="XpenSync Team">
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features">
        <h2>Why Choose XpenSync?</h2>
        <div class="feature-list">
            <div class="feature"><h3>Easy to Use</h3></div>
            <div class="feature"><h3>Smart Budgeting</h3></div>
            <div class="feature"><h3>Secure & Private</h3></div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>
</body>
</html>
