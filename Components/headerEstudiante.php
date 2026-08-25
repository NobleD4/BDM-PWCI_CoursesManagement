<header class="header">
    <nav class="navigation">
        <div class="dropdown">
            <a href="#" class="dropbtn">Categorías</a>
            <div class="dropdown-content">
                <a href="curso.html">HTML</a>
                <a href="curso2.html">CSS</a>
                <a href="curso3.html">PHP</a>
            </div>
        </div>
    </nav>
    <div class="shoppingcart">
        <a href="carrito.html">
        <img src="https://img.icons8.com/?size=100&id=59997&format=png&color=FFFFFF" alt="Carrito">
    </a>
    </div>
    <div class="user">
        <a href="./perfil.php" class="user-dropdown-toggle">
            <img src="<?php echo isset($_SESSION['Profile_Picture']) ? 'data:image/jpeg;base64,' . base64_encode($_SESSION['Profile_Picture']) : 'https://i.pinimg.com/564x/cb/81/27/cb8127cba8860d645bbe0cfb07ef0759.jpg'; ?>"
            alt="Foto del usuario"
            id="profilePicture">
        </a>
        <div class="user-dropdown-content">
            <a href="./perfil.php">Mi Perfil</a>
            <a href="./index.php">Cerrar Sesión</a>
        </div>
    </div>
    <div class="auth-buttons">
    </div>
    <div class="topnav">
        <input type="text" placeholder="Buscar...">
    </div>
</header>