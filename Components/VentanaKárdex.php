<div id="window9" class="window">
    <table id="kardexTable">
        <thead>
            <tr>
                <th>ID de curso</th>
                <th>Nombre del curso</th>
                <th>Fecha inicio</th>
                <th>Progreso</th>
                <th>Fecha fin</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            <!-- Filas dinámicas se cargarán aquí desde la base de datos -->
            
        </tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const kardexTable = document.getElementById("kardexTable").querySelector("tbody");

        // Función para cargar kárdex desde la base de datos
        async function loadKardex() {
            try {
                const response = await fetch("./Controllers/get_kárdex.php");
                const KARDEX = await response.json();

                kardexTable.innerHTML = ""; // Limpia la tabla

                KARDEX.forEach(kardex => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${kardex.ID_Course}</td>
                        <td>${kardex.Course_Name}</td>
                        <td>${kardex.Beginning_Date}</td>
                        <td>${kardex.CourseProgress}</td>
                        <td>${kardex.Completion_Date}</td>
                        <td>${kardex.Course_Status}</td>
                        `;
                        kardexTable.appendChild(row);
                    });
                } catch (error) {
                    console.error("Error al cargar el kárdex:", error);
                }
            }
            // Cargar kárdex al iniciar
            loadKardex();
        });
    </script>
</div>