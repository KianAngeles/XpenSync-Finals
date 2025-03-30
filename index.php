<head>
<?php include "includes/header.php"; ?>
</head>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./includes/css/styles.css" rel="stylesheet" type="text/css">

    <title>XpenSync</title>
</head>
<body>
<section class="wrapper">
      <div class="container">
        <div class="grid-cols-2">
          <div class="grid-item-1">
            <h1 class="main-heading">
              Welcome to <span>XpenSync.</span>
              <br />
              To Analysis your spend.
            </h1>
            <p class="info-text">
            Track your spending and manage expenses effortlessly from anywhere.
            </p>

            <div class="btn_wrapper">
                <a href="includes/login.php" button class="btn view_more_btn">
                  Start now<i class="ri-arrow-right-line"></i>
                </button></a>
              <a href ="includes/signup.php">
                  <button class="btn documentation_btn">Sign Up</button>
              </a>
              </div>
          </div>

          <div class="grid-item-2">
            <div class="team_img_wrapper">
              <img src="./images/hero-img.png" alt="team-img" />
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- Include Footer -->
    <?php include "includes/footer.php"; ?>

</body>
</html>
<style>
    html,body{height:100%;margin:0;padding:0;display:flex;flex-direction:column}.wrapper{flex-grow:1}.container{flex-grow:1}.container,.grid-cols-2{margin-bottom:0;padding-bottom:0}.header{background:#0d1b2a;padding:15px 0;box-shadow:0 2px 5px #ffffff1a}.nav{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;padding:0 20px}.logo h2{font-size:24px;color:#fff;font-weight:700;letter-spacing:1px;transition:.3s}.logo a{text-decoration:none}.logo h2:hover{color:#E8F9FF}.nav_menu{display:flex}.nav_menu_list{display:flex;gap:20px;list-style:none}.nav_menu_item{position:relative}.nav_menu_link{text-decoration:none;color:#fff;font-size:16px;font-weight:600;padding:8px 12px;transition:.3s}.nav_menu_link:hover{color:#E8F9FF}@media screen and (max-width: 767px){.grid-item-2{display:none}.logo{display:none}.nav_menu{display:flex;align-items:center;text-align:center;margin:0 auto}.nav_menu_list{gap:10px;margin-top:10px}.nav_menu_link{padding:10px;width:100%;border-radius:5px}.nav_menu_link:hover{background:#ffffff4d}}@media screen and (min-width: 1040px){.container{width:1040px;margin:0 auto}}@media screen and (max-width: 820px){.grid-item-2{width:70%}}@media screen and (max-width: 390px){.grid-item-1{display:flex;flex-direction:column}.btn_wrapper{display:flex;flex-direction:column}}
</style>
