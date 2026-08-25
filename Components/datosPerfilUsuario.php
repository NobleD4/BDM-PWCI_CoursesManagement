<form id="ID_FORM_UPDATE_USER" action="./Controllers/actualizar_usuario.php" method="POST" enctype="multipart/form-data">
    <div class="user">
        <a href="#" id="profilePictureLink">
        <img src="<?php echo isset($_SESSION['Profile_Picture']) ? 'data:image/jpeg;base64,' . base64_encode($_SESSION['Profile_Picture']) : 'https://i.pinimg.com/564x/cb/81/27/cb8127cba8860d645bbe0cfb07ef0759.jpg'; ?>"
        alt="Foto del usuario"
        id="profilePicture">
        <input type="file" id="fileInput" name="profilePicture" style="display: none;" accept="image/*">
        </a>
    </div>
    <button id="openFileDialog">Cambiar Foto</button>
    <label for="name">Nombre:</label>
    <input type="text" id="ID_INPUT_NAME" name="name" required value="<?php echo isset($_SESSION['User_Name']) ? $_SESSION['User_Name'] : ''; ?>">

    <label for="name">Apellido paterno:</label>
    <input type="text" id="ID_INPUT_LASTNAME" name="lastname" required value="<?php echo isset($_SESSION['User_LastName']) ? $_SESSION['User_LastName'] : ''; ?>">

    <label for="name">Apellido materno:</label>
    <input type="text" id="ID_INPUT_SECONDLASTNAME" name="secondlastname" required value="<?php echo isset($_SESSION['User_SecondLastName']) ? $_SESSION['User_SecondLastName'] : ''; ?>">

    <label for="birthdate">Fecha de Nacimiento:</label>
    <input type="date" id="ID_INPUT_BIRTHDATE" name="fechanac" required value="<?php echo isset($_SESSION['User_Birthdate']) ? $_SESSION['User_Birthdate'] : ''; ?>">

    <label for="email">Correo Electrónico:</label>
    <input type="email" id="ID_INPUT_EMAIL" name="email" required value="<?php echo isset($_SESSION['User_email']) ? $_SESSION['User_email'] : ''; ?>">

    <button type="submit">Guardar</button>
</form>