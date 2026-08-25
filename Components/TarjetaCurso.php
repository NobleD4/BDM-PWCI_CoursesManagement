<div class="responsive">
    <div class="gallery">
        <a href="curso.php?ID_Course=<?= $course['ID_Course']; ?>">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($course['Course_Picture']); ?>" alt="Portada del curso">
            <div class="desc">
                <input type="hidden" id="hiddenInput" name="NAME_INPUT_" value="IDCurso">
                <p><b>Nombre: </b><?php echo ($course['Course_Name']); ?></p>
                <p><b>Niveles: </b><?php echo ($course['Course_TotalLevels']); ?></p>
                <p><b>Precio: </b><?php echo ($course['FullCourse_Price']); ?></p>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="fa fa-star <?= $i <= ($course['AverageRating']) ? 'checked' : ''; ?>"></span>
                <?php endfor; ?>
                <p><b>Calificación: </b><?php echo ($course['AverageRating']); ?></p>
                <p><b>Creado por: </b><?php echo ($course['Creator_Name']); ?></p>
            </div>
        </a>
    </div>
</div>