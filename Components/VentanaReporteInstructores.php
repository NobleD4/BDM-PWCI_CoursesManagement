<div id="window3" class="window">
    <table id="InstructorReport">
        <thead>
            <tr>
                <th>ID de Usuario</th>
                <th>Nombre completo</th>
                <th>Fecha de registro</th>
                <th>Cursos ofrecidos</th>
                <th>Total Ingresos</th>
            </tr>
        </thead>
        <tbody>
            <!-- Filas dinámicas se cargarán aquí desde la base de datos -->

        </tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const InstructorReport = document.getElementById("InstructorReport").querySelector("tbody");

        // Función para cargar reporte de instructores desde la base de datos
        async function loadInstructorReport() {
            try {
                const response = await fetch("./Controllers/get_ReporteInstructores.php");
                const INSTRUCTORS = await response.json();

                InstructorReport.innerHTML = ""; // Limpia la tabla

                INSTRUCTORS.forEach(Instructors => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${Instructors.ID_User}</td>
                        <td>${Instructors.Full_Name}</td>
                        <td>${Instructors.Register_Date}</td>
                        <td>${Instructors.TotalOfferedCourses}</td>
                        <td>$ ${Instructors.InstructorTotalRevenue} MXN</td>
                        `;
                        InstructorReport.appendChild(row);
                    });
                } catch (error) {
                    console.error("Error al cargar el reporte de instructores:", error);
                }
            }
            // Cargar reporte de instructores al iniciar
            loadInstructorReport();
        });
    </script>
</div>