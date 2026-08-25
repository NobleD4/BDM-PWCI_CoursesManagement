<div id="window4" class="window">
    <div class="containercategorianueva">
        <form id="ID_FORM_NEW_CATEGORY" action="./Controllers/crear_categoría.php" method="POST">
            <!-- Formulario para añadir una nueva categoría -->
            <input type="text" id="newOptioncreada" name="NAME_INPUT_NEW_CATEGORY" placeholder="Nombre de la categoría">
            <br>
            <textarea id="newDescription" name="NAME_TEXTARE_NEW_CATEGORY_DESCRIPTION"
            placeholder="Descripción de la categoría"></textarea>
            <button type="submit" id="submitBtncat">Agregar</button>
        </form>
    </div>
    
    <!-- Tabla para mostrar las categorías existentes -->
    <div class="table-container">
        <table id="categoryTable" border="1">
            <thead>
                <tr>
                    <th>ID de categoría</th>
                    <th>Usuario creador</th>
                    <th>Fecha de creación</th>
                    <th>Usuario actualización</th>
                    <th>Última actualización</th>
                    <th>Nombre de categoría</th>
                    <th>Descripción de categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Filas dinámicas se cargarán aquí desde la base de datos -->
            </tbody>
        </table>
    </div>

    <div id="editModal" style="display: none;">
        <form id="editForm" action="./Controllers/edit_categoría.php" method="POST">
            <input type="hidden" name="NAME_INPUT_EDIT_CATEGORY" id="editCategoryId">
            <label for="editCategoryName">Nombre de categoría:</label>
            <input type="text" name="NAME_INPUT_EDIT_CATEGORY_NAME" id="editCategoryName" required>
            <br>
            <label for="editCategoryDescription">Descripción de categoría:</label>
            <textarea name="NAME_INPUT_EDIT_CATEGORY_DESCRIPTION" id="editCategoryDescription" required></textarea>
            <br>
            <button type="submit">Guardar cambios</button>
            <button type="button" id="cancelEditBtn">Cancelar</button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
    // const submitBtn = document.getElementById("submitBtncat");
    const categoryTable = document.getElementById("categoryTable").querySelector("tbody");

    // Función para cargar categorías desde la base de datos
    async function loadCategories() {
        try {
            const response = await fetch("./Controllers/get_categoría.php"); // Archivo PHP para obtener las categorías
            const categories = await response.json();

            categoryTable.innerHTML = ""; // Limpia la tabla

            categories.forEach(category => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <tr>
                        <td>${category.ID_Category}</td>
                        <td>${category.Register_User}</td>
                        <td>${category.Register_Date}</td>
                        <td>${category.UpdateInfo_User}</td>
                        <td>${category.UpdateInfo_Date}</td>
                        <td>${category.Category_Name}</td>
                        <td>${category.Category_Description}</td>
                        <td>
                            <form id="ID_FORM_NEW_CATEGORY" action="./Controllers/edit_categoría.php" method="POST">
                                <button type="button" class="editBtn" data-id="${category.ID_Category}" 
                                    data-name="${category.Category_Name}" 
                                    data-description="${category.Category_Description}">
                                    Editar
                                </button>
                            </form>
                            <br>
                            <form id="ID_FORM_NEW_CATE" action="./Controllers/delete_categoría.php" method="POST">
                                <input type="hidden" id="hiddenInput" name="NAME_INPUT_DELETE_CATEGORY" value="${category.ID_Category}">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    `;
                    categoryTable.appendChild(row);
                });
            } catch (error) {
                console.error("Error al cargar las categorías:", error);
            }
        }
        // Cargar categorías al iniciar
        loadCategories();
    });

    document.addEventListener("DOMContentLoaded", () => {
        const categoryTable = document.getElementById("categoryTable").querySelector("tbody");
        const editModal = document.getElementById("editModal");
        const editForm = document.getElementById("editForm");
        const editCategoryId = document.getElementById("editCategoryId");
        const editCategoryName = document.getElementById("editCategoryName");
        const editCategoryDescription = document.getElementById("editCategoryDescription");
        const cancelEditBtn = document.getElementById("cancelEditBtn");

        // Mostrar modal al hacer clic en "Editar"
        categoryTable.addEventListener("click", (e) => {
            if (e.target.classList.contains("editBtn")) {
                const categoryId = e.target.getAttribute("data-id");
                const categoryName = e.target.getAttribute("data-name");
                const categoryDescription = e.target.getAttribute("data-description");

                // Llenar el formulario de edición
                editCategoryId.value = categoryId;
                editCategoryName.value = categoryName;
                editCategoryDescription.value = categoryDescription;

                // Mostrar el modal
                editModal.style.display = "block";
            }
        });

        // Ocultar modal al hacer clic en "Cancelar"
        cancelEditBtn.addEventListener("click", () => {
            editModal.style.display = "none";
        });
    });
    
    </script>

</div>