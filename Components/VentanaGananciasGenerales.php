<div id="window5" class="window">
    <?php include './Components/DropDownGanancias.php';?>

    <table id="generalRevenues">
        <thead>
            <tr>
                <th>ID de Curso</th>
                <th>Nombre del Curso</th>
                <th>Estatus del Curso</th>
                <th>Cantidad de Estudiantes</th>
                <th>Nivel Promedio</th>
                <th>Ingresos Transferencia</th>
                <th>Ingresos Mastercard</th>
                <th>Ingresos PayPal</th>
                <th>Total Ingresos</th>
            </tr>
        </thead>
        <tbody>
            <!-- Filas dinámicas se cargarán aquí desde la base de datos -->

        </tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const generalRevenues = document.getElementById("generalRevenues").querySelector("tbody");

        // Función para cargar ingresos generales desde la base de datos
        async function loadRevenues() {
            try {
                const response = await fetch("./Controllers/get_GananciasGenerales.php");
                const REVENUES = await response.json();

                generalRevenues.innerHTML = ""; // Limpia la tabla

                REVENUES.forEach(Revenues => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${Revenues.ID_Course}</td>
                        <td>${Revenues.Course_Name}</td>
                        <td>${Revenues.Course_Status}</td>
                        <td>${Revenues.Total_Students}</td>
                        <td>${Revenues.Level_Name}</td>
                        <td>$ ${Revenues.Transfer_Revenue} MXN</td>
                        <td>$ ${Revenues.Mastercard_Revenue} MXN</td>
                        <td>$ ${Revenues.PayPal_Revenue} MXN</td>
                        <td>$ ${Revenues.Total_Revenue} MXN</td>
                        `;
                        generalRevenues.appendChild(row);
                    });
                } catch (error) {
                    console.error("Error al cargar las ganancias generales:", error);
                }
            }
            // Cargar ingresos generales al iniciar
            loadRevenues();
        });
    </script>
</div>