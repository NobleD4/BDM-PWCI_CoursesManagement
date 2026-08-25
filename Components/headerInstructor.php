<header class="header">
    <nav class="navigation">
        <div class="dropdown">
            <a href="#" class="dropbtn">Categorías</a>
            <div class="dropdown-content">
                <a href="curso.html">Curso 1</a>
                <a href="curso2.html">Curso 2</a>
                <a href="curso3.html">Curso 3</a>
            </div>
        </div>
    </nav>
    <div class="user">
        <a href="perfilinstructor.php" class="user-dropdown-toggle">
            <img src="<?php echo isset($_SESSION['Profile_Picture']) ? 'data:image/jpeg;base64,' . base64_encode($_SESSION['Profile_Picture']) : 'https://i.pinimg.com/564x/cb/81/27/cb8127cba8860d645bbe0cfb07ef0759.jpg'; ?>"
            alt="Foto del usuario"
            id="profilePicture">
        </a>
        <div class="user-dropdown-content">
            <a href="perfilinstructor.php">Mi Perfil</a>
            <a href="index.php">Cerrar Sesión</a>
        </div>
    </div>
    <div class="auth-buttons">
    </div>
        <div class="topnav">
            <input type="text" placeholder="Buscar...">
        </div>
</header>