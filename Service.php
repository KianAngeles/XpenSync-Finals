<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/header.php"; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./includes/css/styles.css" rel="stylesheet" type="text/css">
    <title>Service</title>
</head>

<style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:"Inter",sans-serif}.hero{background:#506690;color:#fff;text-align:center;padding:70px 20px}.hero h1{font-size:42px;font-weight:700;margin-bottom:10px;animation:fadeIn 1.5s ease-in-out}.hero p{font-size:18px;max-width:800px;margin:0 auto;animation:fadeIn 2s ease-in-out}:root{--primary-color:#C5BAFF;--link-color:#506690;--btn-hover-color:#C4D9FF;--lg-heading:#161c2d;--text-content:#869ab8;--fixed-header-height:4.5rem}footer{width:100%;background-color:var(--primary-color);height:12px;margin-top:8rem}.close_btn,.toggle_btn{display:none!important}.cta-btn{display:inline-block;margin-top:30px;padding:12px 20px;font-size:18px;color:#fff;background:#007BFF;border-radius:8px;text-decoration:none;font-weight:700;transition:.3s ease-in-out}.cta-btn:hover{background:#0056b3;transform:scale(1.05)}.steps-section{max-width:900px;margin:50px auto;padding:40px;background:linear-gradient(135deg,#506690,#788aad);border-radius:12px;box-shadow:0 5px 15px #0003;text-align:center;color:#fff;animation:fadeInUp 1.5s ease-in-out}.steps-section h2{font-size:30px;margin-bottom:25px;font-weight:700;letter-spacing:1px;text-transform:uppercase}.step{background:#fff3;padding:15px 20px;margin-bottom:15px;border-radius:8px;font-size:18px;font-weight:500;text-align:left;display:flex;align-items:center}.step span{display:inline-block;width:40px;height:40px;background:#fff;color:#506690;font-weight:700;text-align:center;line-height:40px;border-radius:50%;margin-right:15px}.steps-section .cta-btn{background:#fc0;color:#161c2d;font-weight:700}.steps-section .cta-btn:hover{background:#e6b800}@keyframes fadeInUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}.header{background:#0d1b2a;padding:15px 0;box-shadow:0 2px 5px #0000001a}.nav{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;padding:0 20px}.logo h2{font-size:24px;color:#fff;font-weight:700;letter-spacing:1px;transition:.3s}.logo a{text-decoration:none}.logo h2:hover{color:#E8F9FF}.nav_menu{display:flex}.nav_menu_list{display:flex;gap:20px;list-style:none}.nav_menu_item{position:relative}.nav_menu_link{text-decoration:none;color:#fff;font-size:16px;font-weight:600;padding:8px 12px;transition:.3s}.nav_menu_link:hover{color:#E8F9FF}@media screen and (max-width: 767px){.grid-item-2{display:none}.logo{display:none}.nav_menu{display:flex;align-items:center;text-align:center;margin:0 auto}.nav_menu_list{gap:10px;margin-top:10px}.nav_menu_link{padding:10px;width:100%;border-radius:5px}.nav_menu_link:hover{background:#ffffff4d}}@media screen and (min-width: 1040px){.container{width:1040px;margin:0 auto}}
</style>
<body>
    <div class="hero">
        <h1>🚀 How XpenSync Works</h1>
        <p>Take control of your finances with XpenSync! Easily track expenses, set budgets, and gain valuable insights to stay on top of your spending.</p>
    </div>

    <section class="steps-section">
        <h2>Steps to Use XpenSync</h2>
        <div class="step"><span>1</span> Create an account and set up your profile.</div>
        <div class="step"><span>2</span> Add your daily expenses and categorize them.</div>
        <div class="step"><span>3</span> Set monthly budgets to control spending.</div>
        <div class="step"><span>4</span> Track your financial insights with detailed reports.</div>
        <div class="step"><span>5</span> Get alerts when you're close to your budget limit.</div>
        <a href="includes/signup.php" class="cta-btn">Try XpenSync Today!</a>
    </section>

    <?php include "includes/footer.php"; ?>
</body>
</html>
