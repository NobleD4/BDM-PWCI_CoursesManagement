<?php
    include './DB_Config.php';

    $id_level = $level['ID_Level'];
    $sql = "CALL SP_LevelResourcesManagement(
        2,       -- pSP_Action
        
        NULL,    -- pID_Course
        ?,       -- pID_Level
        NULL,    -- pID_Resource
        NULL,    -- pResource_Name
        NULL,    -- pResource_Type
        NULL     -- pResource_Path
    );";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_level);
    $stmt->execute();
    $resources = $stmt->get_result();
?>

<?php
    include './DB_Config.php';

    $id_user = $_SESSION['ID_User'];
    $id_level = $level['ID_Level'];
    $sql = "CALL SP_User_LevelCourseManagement(
        3,      -- pSP_Action

        ?,      -- pID_User
        ?,      -- pID_Level
        NULL    -- pPay_Method
    );";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_user, $id_level);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
?>

<div class="wrapper">
    <div class="level-title" onclick="toggleLevelContent(this)">
        <span><?php echo ($level['Level_Name']); ?> <?php echo ($level['Level_Price']); ?></span>
        
        <?php if (!$row && !$is_creator) { ?>
            <form action="./Controllers/comprar_nivel.php" method="POST">
                <input type="hidden" name="NAME_INPUT_ID_COURSE" value="<?= $course['ID_Course']; ?>">
                <input type="hidden" name="action" id="action-input" value="4">
                <input type="hidden" name="NAME_INPUT_PAY_METHOD" id="pay_method" value="1">
                <input type="hidden" name="NAME_INPUT_ID_USER" value="<?php echo $_SESSION['ID_User']; ?>">
                <input type="hidden" name="NAME_INPUT_ID_LEVEL" value="<?php echo $id_level; ?>">
                
                <button type="submit" onclick="setPayMethod(1)">Comprar con Transferencia</button>
                <button type="submit" onclick="setPayMethod(2)">Comprar con Mastercard</button>
                <button type="submit" onclick="setPayMethod(3)">Comprar con PayPal</button>
            </form>

            <script>
                function setPayMethod(actionValue) {
                document.getElementById('pay_method').value = actionValue;
            }
            </script>
        <?php } ?>
        
        <?php if ($row && $row['Level_Status'] == 1) { ?>
            <form action="./Controllers/comprar_nivel.php" method="POST">
                <input type="hidden" name="NAME_INPUT_ID_COURSE" value="<?= $course['ID_Course']; ?>">
                <input type="hidden" name="action" id="action-input" value="5">
                <input type="hidden" name="NAME_INPUT_ID_USER" value="<?php echo $_SESSION['ID_User']; ?>">
                <input type="hidden" name="NAME_INPUT_ID_LEVEL" value="<?php echo $id_level; ?>">
                <button type="submit">Empezar nivel</button>
            </form>
        <?php } ?>

        <span>+</span>
    </div>
    <?php if (($row && ($row['Level_Status'] == 2 || $row['Level_Status'] == 3)) || $is_creator) { ?>
        <div class="level-content">
            <?php if ($is_creator) { ?>
                <span>Estatus del Nivel: <?php echo ($level['Level_Status']) ?></span>
                <br>

                <?php
                    if ($level['Level_Status'] === 'DESACTIVADO') {
                ?>
                <!-- Botón Activar Nivel -->
                <form action="./Controllers/activar_nivel.php" method="POST">
                    <input type="hidden" name="ID_Level" value="<?php echo $id_level; ?>">
                    <input type="hidden" name="NAME_INPUT_ID_COURSE" value="<?= $course['ID_Course']; ?>">
                    <button>Activar Nivel</button>
                </form>
                <?php
                    } else {
                ?>
                <!-- Botón Desactivar Nivel -->
                <form action="./Controllers/desactivar_nivel.php" method="POST">
                    <input type="hidden" name="ID_Level" value="<?php echo $id_level; ?>">
                    <input type="hidden" name="NAME_INPUT_ID_COURSE" value="<?= $course['ID_Course']; ?>">
                    <button>Desactivar Nivel</button>
                </form>
                <?php
                    }
                ?>

                <form action="./Controllers/eliminar_nivel.php" method="POST">
                    <input type="hidden" name="ID_Level" value="<?php echo $id_level; ?>">
                    <input type="hidden" name="NAME_INPUT_ID_COURSE" value="<?= $course['ID_Course']; ?>">
                    <button>Eliminar Nivel Completamente</button>
                </form>
            <?php } ?>

            <p>RECURSOS:</p>
            <?php foreach ($resources as $resource): ?>
                <div class="resource-item">
                    <?php
                        $resource_path = htmlspecialchars($resource['Resource_Path']);
                        $resource_name = htmlspecialchars($resource['Resource_Name']);
                        switch ($resource['Resource_Type']) {
                            case 1: // Video
                                echo "<video width='60%' controls>
                                        <source src='./Controllers/$resource_path' type='video/mp4'>
                                        Tu navegador no soporta el video.
                                    </video>";
                            break;

                            case 2: // Imagen
                                echo "<img src='./Controllers/$resource_path' alt='$resource_name' width='60%'>";
                            break;

                            case 3: // Enlace
                                echo "<a href='./Controllers/$resource_path' target='_blank'>$resource_name</a>";
                            break;

                            case 4: // Archivo adjunto
                                echo "<p>$resource_name</p>
                                <a href='./Controllers/$resource_path' download>Descargar</a>";
                            break;
                        }
                    ?>
                </div>
            <?php endforeach; ?>
            <div class="buttons">
                <?php if ($is_creator) { ?>
                    <form action="./Controllers/subir_video.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="ID_Level" value="<?php echo $id_level; ?>">
                        <input type="hidden" name="NAME_INPUT_ID_COURSE" value="<?= $course['ID_Course']; ?>">
                        <input type="file" name="resource_file" required>
                        <select name="resource_type" required>
                            <option value="1">Video</option>
                            <option value="2">Imagen</option>
                            <option value="3">Enlace</option>
                            <option value="4">Archivo Adjunto</option>
                        </select>
                        <button type="submit">Añadir recurso</button>
                    </form>
                <?php } ?>
                <?php if ($_SESSION['User_Role'] == 1) { ?>
                    <form action="./Controllers/comprar_nivel.php" method="POST">
                        <input type="hidden" name="NAME_INPUT_ID_COURSE" value="<?= $course['ID_Course']; ?>">
                        <input type="hidden" name="action" id="action-input" value="6">
                        <input type="hidden" name="NAME_INPUT_ID_USER" value="<?php echo $_SESSION['ID_User']; ?>">
                        <input type="hidden" name="NAME_INPUT_ID_LEVEL" value="<?php echo $id_level; ?>">
                        <button type="submit">Completar Nivel</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<!-- Initialize the JS-SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=ASYpbAYOyr-wsuCiNIcgFtZ4_HYzzIxRISWRWGOHCkuwX2NRTQ8bGI7hR7hiDEsweqns-aL5KK1MUxVt&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
data-sdk-integration-source="developer-studio"></script>