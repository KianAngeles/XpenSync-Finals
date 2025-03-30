
<style>
a{text-decoration:none}.header{width:100%;background-color:#506690;padding:15px 20px;box-shadow:0 4px 10px #0000001a;display:flex;justify-content:space-between;align-items:center}.nav{display:flex;align-items:center}.logo h2{color:#fff;font-size:24px;margin:0}.nav_menu{display:flex}.nav_menu_list{display:flex;gap:20px;list-style:none;margin:0;padding:0}.nav_menu_link{color:#fff;font-size:18px;text-decoration:none;transition:.3s}.nav_menu_link:hover{color:#FFD700}.title{color:#fff;font-size:24px;font-weight:700}@media screen and (min-width: 390px) and (max-width: 1024px){.title-desktop{display:none}.nav_menu{display:flex;flex-direction:column;position:fixed;top:0;left:-100%;width:75%;height:100vh;background-color:#2c3e50;padding-top:80px;transition:left .4s ease-in-out;box-shadow:4px 0 10px #0003;z-index:1100}.nav_menu.active{left:0}.nav_menu_list{flex-direction:column;text-align:center;gap:25px}.nav_menu_item{padding:10px 0}.nav_menu_link{font-size:20px;font-weight:700;color:#fff;transition:.3s}.nav_menu_link:hover{color:#FFD700}.hamburger{display:block;width:35px;height:30px;position:absolute;left:20px;cursor:pointer;z-index:1200}.hamburger div{width:100%;height:4px;background-color:#fff;position:absolute;transition:all .3s ease-in-out}.hamburger div:nth-child(1){top:0}.hamburger div:nth-child(2){top:12px}.hamburger div:nth-child(3){top:24px}.hamburger.open div:nth-child(1){transform:translateY(12px) rotate(45deg)}.hamburger.open div:nth-child(2){opacity:0}.hamburger.open div:nth-child(3){transform:translateY(-12px) rotate(-45deg)}.overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:#00000080;z-index:1000;display:none}.overlay.active{display:block}body.menu-open{overflow:hidden}.mobile-title{position:absolute;right:20px;font-size:22px;color:#fff;font-weight:700;display:block}}.hamburger{display:none}.mobile-title{display:none}@media screen and (min-width: 390px) and (max-width: 1024px){.title-desktop{display:none}.hamburger{display:block}.mobile-title{display:block}}.title-desktop{color:#fff;font-size:24px;font-weight:700;position:absolute;right:20px}
</style>

<body>
    <!-- ==== HEADER ==== -->
    <header class="header">
      <!-- ==== NAVBAR ==== -->
      <nav class="nav">
        <!-- Hamburger Icon on the Left -->
        <div class="hamburger" onclick="toggleMenu()">
          <div></div>
          <div></div>
          <div></div>
        </div>

        <!-- XpenSync Title on the Right -->
        <div class="mobile-title">XpenSync</div>

        <!-- Full Navbar -->
        <div class="nav_menu" id="nav_menu">
          <ul class="nav_menu_list">
            <li class="nav_menu_item">
              <a href="index.php" class="nav_menu_link">HOME</a>
            </li>
            <li class="nav_menu_item">
              <a href="about.php" class="nav_menu_link">ABOUT</a>
            </li>
            <li class="nav_menu_item">
              <a href="Service.php" class="nav_menu_link">SERVICE</a>
            </li>
            <li class="nav_menu_item">
              <a href="contact.php" class="nav_menu_link">CONTACT</a>
            </li>
          </ul>
        </div>

        <div class="title-desktop">XyperSync</div>
      </nav>
    </header>

    <!-- Overlay to prevent clicks on background -->
    <div class="overlay" id="overlay"></div>

    <script>
      function toggleMenu() {
        let menu = document.getElementById("nav_menu");
        let hamburger = document.querySelector(".hamburger");
        let overlay = document.getElementById("overlay");
        let body = document.body;

        menu.classList.toggle("active");
        hamburger.classList.toggle("open");
        overlay.classList.toggle("active");
        body.classList.toggle("menu-open"); 

        // Close menu when clicking the overlay
        overlay.onclick = function () {
          menu.classList.remove("active");
          hamburger.classList.remove("open");
          overlay.classList.remove("active");
          body.classList.remove("menu-open");
        };
      }
    </script>
</body>