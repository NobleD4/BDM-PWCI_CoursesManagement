<div id="window5" class="window">
    <table id="StudentReport">
        <thead>
            <tr>
                <th>ID de Usuario</th>
                <th>Nombre completo</th>
                <th>Fecha de registro</th>
                <th>Cursos Inscritos</th>
                <th>% Cursos terminados</th>
            </tr>
        </thead>
        <tbody>
            <!-- Filas dinámicas se cargarán aquí desde la base de datos -->

        </tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const StudentReport = document.getElementById("StudentReport").querySelector("tbody");

        // Función para cargar reporte de estudiantes desde la base de datos
        async function loadStudentReport() {
            try {
                const response = await fetch("./Controllers/get_ReporteEstudiantes.php");
                const STUDENTS = await response.json();

                StudentReport.innerHTML = ""; // Limpia la tabla

                STUDENTS.forEach(Students => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${Students.ID_User}</td>
                        <td>${Students.Full_Name}</td>
                        <td>${Students.Register_Date}</td>
                        <td>${Students.TotalEnrolledCourses}</td>
                        <td>${Students.PercentCompletedCourses}</td>
                        `;
                        StudentReport.appendChild(row);
                    });
                } catch (error) {
                    console.error("Error al cargar el reporte de estudiantes:", error);
                }
            }
            // Cargar reporte de estudiantes al iniciar
            loadStudentReport();
        });
    </script>
</div>