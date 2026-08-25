-- Este primer trigger básicamente gestiona la tabla del historial de contraseñas agregando nuevas contraseñas cada que hay un update en users

DELIMITER $$
CREATE TRIGGER TRG_UpdateUser
BEFORE UPDATE ON Users
FOR EACH ROW
BEGIN
    -- UpdateInfo_Date en Users se actualiza con la fecha y hora actual
    SET NEW.UpdateInfo_Date = CURRENT_TIMESTAMP();
    
    -- Si User_CurrentPassword en Users cambia, entonces insertar la contraseña antigua en Passwords
    IF OLD.User_CurrentPassword != NEW.User_CurrentPassword THEN
        INSERT INTO Passwords (
            ID_User,
            User_Password
        ) VALUES (
            OLD.ID_User,
            OLD.User_CurrentPassword
        );
    END IF;
END $$
DELIMITER ;
;

-- Cuando se cambie el estatus del curso también cambiará la fecha de la última vez que se actualizó

DELIMITER $$
CREATE TRIGGER TRG_UpdateCourse
BEFORE UPDATE ON Courses
FOR EACH ROW
BEGIN
	-- UpdateInfo_Date en Courses se actualiza con la fecha y hora actual
	SET NEW.UpdateInfo_Date = CURRENT_TIMESTAMP();
    
	-- Si la cantidad de niveles del curso es 0 entonces el estatus cambia a 1
    IF OLD.ID_Course = OLD.ID_Course AND NEW.Course_TotalLevels = 0 THEN
		SET NEW.Course_Status = 1; -- Acá no hago update directo para no mandar a llamar el trigger en bucle si es que es posible lograr eso
	END IF; -- (EDIT: Este último cambio de estado genera problemas al querer dar de baja un curso cuando no tiene niveles, le cambias el estado a 0 y regresa a 1 AAAAAA)
END; $$
DELIMITER ;
;

-- Cuando se haga un DELETE a una relación curso-categoría y esta sea la única registrada a un curso, el curso que quedó sin categorías cambia su estatus a 1 (existe pero sin publicar)

DELIMITER $$
CREATE TRIGGER TGR_Delete_Course_Category
AFTER DELETE ON Course_Category
FOR EACH ROW
BEGIN
    DECLARE CategoryCount INT;

    -- Verificar si el curso quedó sin categorías
    SELECT COUNT(*) INTO CategoryCount
    FROM Course_Category
    WHERE ID_Course = OLD.ID_Course;

    -- Si el curso quedó sin categorías, cambiar su estado a 1 "curso sin publicar"
    IF CategoryCount = 0 THEN
		CALL `SP_CourseManagement`(5, OLD.ID_Course, NULL, NULL, NULL, NULL); -- Cambio Estatus 1 "curso existe sin publicar"
    END IF;
END; $$
DELIMITER ;
;

DELIMITER $$
CREATE TRIGGER TGR_New_CourseEnrollment
AFTER INSERT ON User_LevelCourse
FOR EACH ROW
BEGIN
    -- Declarar variables para almacenar el ID del curso
    DECLARE pID_Course VARCHAR(36);

    -- Obtener el ID_Course correspondiente al nivel inscrito
    SELECT ID_Course
    INTO pID_Course
    FROM LevelCourse
    WHERE ID_Level = NEW.ID_Level;

    -- Verificar si el usuario ya está inscrito en el curso
    IF NOT EXISTS (
        SELECT 1
        FROM User_CourseEnrollments
        WHERE ID_User = NEW.ID_User AND ID_Course = pID_Course
    ) THEN
        -- Insertar la inscripción al curso (No pude llamar al Stored Procedure porque daba error AAAAAA)
        INSERT INTO User_CourseEnrollments (
            ID_User, ID_Course
        ) VALUES (
            NEW.ID_User, 
            pID_Course
        );
    END IF;
END$$
DELIMITER ;
;