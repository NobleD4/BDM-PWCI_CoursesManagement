<div id="window9" class="window">
    <?php include './Components/DropDownGanancias.php';?>

    <table>
        <thead>
            <tr>
                <th>Nombre del Estudiante</th>
                <th>Nivel</th>
                <th>Fecha de Inscripción</th>
                <th>Precio pagado</th>
                <th>Método de pago</th>
            </tr>
        </thead>
        <tbody>
            <!-- Filas dinámicas se cargarán aquí desde la base de datos -->

        </tbody>
    </table>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const courseRevenuesTable = document.querySelector("#window9 tbody");

            // Función para cargar datos del curso seleccionado
            async function loadCourseRevenues(courseId) {
                if (!courseId) return;

                try {
                    const response = await fetch(`./Controllers/get_GananciasCurso.php?ID_Course=${courseId}`);
                    const REVENUES = await response.json();

                    courseRevenuesTable.innerHTML = ""; // Limpia la tabla

                    REVENUES.forEach(revenue => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${revenue.Full_Name}</td>
                            <td>${revenue.Level_Name}</td>
                            <td>${revenue.Beginning_Date}</td>
                            <td>${revenue.Level_Price}</td>
                            <td>${revenue.Pay_Method}</td>
                        `;
                        courseRevenuesTable.appendChild(row);
                    });
                } catch (error) {
                    console.error("Error al cargar las ganancias del curso:", error);
                }
            }
            
            // Exportar la función globalmente
            window.loadCourseRevenues = loadCourseRevenues;
        });
    </script>
</div>