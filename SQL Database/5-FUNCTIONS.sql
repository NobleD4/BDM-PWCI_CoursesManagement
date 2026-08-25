DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Course_TotalLevels`(pID_Course VARCHAR(36)) RETURNS tinyint
    DETERMINISTIC
BEGIN
    DECLARE Total_Levels TINYINT;
    -- Sumamos los precios de todos los niveles asociados al curso especificado
    SELECT COUNT(ID_Level) INTO Total_Levels -- Si la suma da nulo en caso de no haber niveles, lo convierte en 0
    FROM LevelCourse
    WHERE ID_Course = pID_Course;
    
    RETURN Total_Levels;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_CourseAverageRating`(
    pID_Course VARCHAR(36)
) RETURNS decimal(2,1)
    DETERMINISTIC
BEGIN
    DECLARE averageRating DECIMAL(2,1);

    -- Calcular el promedio de UserRating para el curso dado
    SELECT AVG(UserRating)
    INTO averageRating
    FROM User_CourseEnrollments
    WHERE ID_Course = pID_Course
      AND UserRating IS NOT NULL; -- Excluir calificaciones de usuarios que aún no califican

    -- Si no hay calificaciones, retornar 0
    IF averageRating IS NULL THEN
        SET averageRating = 0;
    END IF;

    RETURN averageRating;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_CourseProgress`(
    pID_User INT UNSIGNED,
    pID_Course VARCHAR(36)
) RETURNS int
    DETERMINISTIC
BEGIN
    DECLARE completedLevels INT UNSIGNED DEFAULT 0;
    DECLARE totalLevels INT UNSIGNED DEFAULT 0;
    DECLARE courseProgress TINYINT UNSIGNED DEFAULT 0;

    -- Obtener el número de niveles completados por el usuario en el curso usando la función FUNC_UserLevelsCompleted
    SET completedLevels = FUNC_UserLevelsCompleted(pID_User, pID_Course);

    -- Obtener el total de niveles del curso usando la función FUNC_Course_TotalLevels
    SET totalLevels = FUNC_Course_TotalLevels(pID_Course);

    -- Calcular el porcentaje de progreso si el curso tiene niveles
    IF totalLevels > 0 THEN
        SET courseProgress = TRUNCATE((completedLevels / totalLevels) * 100, 0);
    ELSE
        SET courseProgress = 0; -- Si el curso no tiene niveles, el progreso es 0
    END IF;

    RETURN courseProgress;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_CourseSearch`(pSearchWords TEXT) RETURNS text CHARSET utf8mb4
    DETERMINISTIC
BEGIN
    DECLARE SearchPattern TEXT;
    
    -- Patrón de búsqueda parcial
    SET SearchPattern = CONCAT('%', pSearchWords, '%');
    
    RETURN SearchPattern;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_CourseTotal_Votes`(
	pID_Course VARCHAR(36)
) RETURNS int unsigned
    DETERMINISTIC
BEGIN
	DECLARE totalVotes INT UNSIGNED DEFAULT 0;
    
    -- Obtener el número total de votos de un curso
	SELECT COUNT(UserRating)
    INTO totalVotes
    FROM User_CourseEnrollments
	WHERE UserRating IS NOT NULL
    AND ID_Course = pID_Course;
    
    RETURN totalVotes;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_FullCourse_MostBoughtLevel`(
    pID_Course VARCHAR(36)
) RETURNS varchar(36) CHARSET utf8mb4
    DETERMINISTIC
BEGIN
    DECLARE MostBoughtLevel VARCHAR(36);

    -- Obtener el ID del nivel más comprado dentro del curso especificado
    SELECT L.ID_Level
    INTO MostBoughtLevel
    FROM User_LevelCourse U
    JOIN LevelCourse L ON U.ID_Level = L.ID_Level
    WHERE L.ID_Course = pID_Course
    GROUP BY L.ID_Level
    ORDER BY COUNT(U.ID_User) DESC, L.ID_Level ASC
    LIMIT 1;

    RETURN MostBoughtLevel;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_FullCourse_OneLevelBought`(
    pID_Course VARCHAR(36)
) RETURNS int unsigned
    DETERMINISTIC
BEGIN
    DECLARE UsersCount INT UNSIGNED;

    -- Contar los usuarios que han comprado al menos un nivel del curso
    SELECT COUNT(DISTINCT U.ID_User)
    INTO UsersCount
    FROM User_LevelCourse U
    LEFT JOIN LevelCourse L ON U.ID_Level = L.ID_Level
    WHERE L.ID_Course = pID_Course;

    RETURN COALESCE(UsersCount, 0);
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_FullCourse_Price`(pID_Course VARCHAR(36)) RETURNS decimal(9,2)
    DETERMINISTIC
BEGIN
    DECLARE Total_Price DECIMAL(9, 2);
    -- Sumamos los precios de todos los niveles asociados al curso especificado
    SELECT COALESCE(SUM(Level_Price), 0) INTO Total_Price -- Si la suma da nulo en caso de no haber niveles lo convierte en 0
    FROM LevelCourse
    WHERE ID_Course = pID_Course;
    
    RETURN Total_Price;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_FullCourse_Revenue_PayMethod`(
    pID_Course VARCHAR(36),
    pPay_Method TINYINT UNSIGNED
) RETURNS decimal(9,2)
    DETERMINISTIC
BEGIN
    DECLARE Total_Revenue DECIMAL(9, 2);

    -- Calcular las ganancias del curso para un método de pago específico
    SELECT COALESCE(SUM(L.Level_Price), 0)
    INTO Total_Revenue
    FROM User_LevelCourse U
    JOIN LevelCourse L ON U.ID_Level = L.ID_Level
    WHERE L.ID_Course = pID_Course
      AND U.Pay_Method = pPay_Method;

    RETURN Total_Revenue;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_FullCourse_TimesBought`(
    pID_Course VARCHAR(36)
) RETURNS int unsigned
    DETERMINISTIC
BEGIN
    DECLARE totalLevels INT UNSIGNED;
    DECLARE TimesBought INT UNSIGNED;

    -- Obtener el total de niveles del curso usando la función FUNC_Course_TotalLevels
    SET totalLevels = FUNC_Course_TotalLevels(pID_Course);

    -- Contar los usuarios que han comprado todos los niveles del curso
		SELECT COUNT(DISTINCT ID_User)
		INTO TimesBought
		FROM User_LevelCourse U
		LEFT JOIN LevelCourse L ON U.ID_Level = L.ID_Level
		WHERE L.ID_Course = pID_Course
		GROUP BY U.ID_User
		HAVING COUNT(U.ID_Level) = totalLevels;

    RETURN COALESCE(TimesBought, 0);
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_FullCourse_TotalRevenue`(
    pID_Course VARCHAR(36)
) RETURNS decimal(9,2)
    DETERMINISTIC
BEGIN
    DECLARE Total_Revenue DECIMAL(9, 2);

    -- Calcular las ganancias totales del curso
    SELECT COALESCE(SUM(L.Level_Price), 0)
    INTO Total_Revenue
    FROM User_LevelCourse U
    JOIN LevelCourse L ON U.ID_Level = L.ID_Level
    WHERE L.ID_Course = pID_Course;

    RETURN Total_Revenue;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_InstructorTotalRevenue`(pID_User INT UNSIGNED) RETURNS decimal(9,2)
    DETERMINISTIC
BEGIN
    DECLARE totalRevenue DECIMAL(9, 2);

    -- Calcular las ganancias totales de todos los cursos del instructor
    SELECT COALESCE(SUM(Total_Revenue), 0)
    INTO totalRevenue
    FROM VIEW_GeneralRevenues
    WHERE ID_Course IN (
        SELECT ID_Course
        FROM Courses
        WHERE ID_User = pID_User AND Course_Status = 2 -- Solo los que tienen el estatus de publicado
    );

    RETURN totalRevenue;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Level_TimesBought`(
    pID_Level VARCHAR(36)
) RETURNS int unsigned
    DETERMINISTIC
BEGIN
	DECLARE LevelTimesBought INT UNSIGNED;
    
    SELECT COUNT(ID_Level)
    INTO LevelTimesBought
    FROM User_LevelCourse
    WHERE ID_Level = pID_Level;
    
    RETURN LevelTimesBought;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_PercentCompletedCourses`(pID_User INT UNSIGNED) RETURNS tinyint unsigned
    DETERMINISTIC
BEGIN
    DECLARE totalCourses INT;
    DECLARE completedCourses INT;
    DECLARE percentCourses DECIMAL(5, 2);
    
    -- Total de cursos inscritos
    SET totalCourses = FUNC_TotalEnrolledCourses(pID_User);
    
    -- Total de cursos completados
    SET completedCourses = FUNC_UserCoursesCompleted(pID_User);

    -- Calcular porcentaje si hay cursos inscritos
    IF totalCourses > 0 THEN
        SET percentCourses = TRUNCATE((completedCourses / totalCourses) * 100, 0);
    ELSE
        SET percentCourses = 0;
    END IF;

    RETURN percentCourses;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_TotalEnrolledCourses`(pID_User INT UNSIGNED) RETURNS int unsigned
    DETERMINISTIC
BEGIN
    DECLARE totalCourses INT;
    
    SELECT COUNT(ID_Course) 
    INTO totalCourses
    FROM User_CourseEnrollments
    WHERE ID_User = pID_User;

    RETURN totalCourses;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_TotalOfferedCourses`(pID_User INT UNSIGNED) RETURNS int unsigned
    DETERMINISTIC
BEGIN
    DECLARE totalCourses INT UNSIGNED;

    -- Cantidad de cursos ofrecidos por el instructor
    SELECT COUNT(ID_Course)
    INTO totalCourses
    FROM Courses
    WHERE ID_User = pID_User AND Course_Status = 2; -- Solo los que tienen el estatus de publicado

    RETURN totalCourses;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_UserCoursesCompleted`(pID_User INT UNSIGNED) RETURNS int unsigned
    DETERMINISTIC
BEGIN
	DECLARE completedCourses INT UNSIGNED;
    
		SELECT COUNT(ID_Course)
		INTO completedCourses
		FROM User_CourseEnrollments
		WHERE ID_User = pID_User AND Course_Status = 3;
        
	RETURN completedCourses;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_UserLevelsCompleted`(
	pID_User INT UNSIGNED,
    pID_Course VARCHAR(36)
) RETURNS int unsigned
    DETERMINISTIC
BEGIN
	DECLARE completedLevels INT UNSIGNED DEFAULT 0;
    
    -- Obtener el número de niveles completados por el usuario en el curso
    SELECT COUNT(U.Completion_Date)
    INTO completedLevels
    FROM User_LevelCourse U
    LEFT JOIN LevelCourse L ON U.ID_Level = L.ID_Level
    WHERE U.Completion_Date IS NOT NULL
      AND U.ID_User = pID_User
      AND L.ID_Course = pID_Course;
      
	RETURN completedLevels;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_VerifyChange_Course_Status`(pID_Course VARCHAR(36)) RETURNS tinyint(1)
    DETERMINISTIC
BEGIN
    DECLARE all_levels_active BOOLEAN;
    DECLARE has_category BOOLEAN;

    -- Verificar si todos los niveles están activos
    SELECT CASE
        WHEN COUNT(ID_Level) = 0 THEN TRUE  -- No hay niveles pendientes (todos activos)
        ELSE FALSE
    END INTO all_levels_active
    FROM LevelCourse
    WHERE ID_Course = pID_Course AND Level_Status = 0; -- Buscar niveles no activos

    -- Verificar si pertenece a al menos una categoría
    SELECT CASE
        WHEN COUNT(ID_Course) > 0 THEN TRUE
        ELSE FALSE
    END INTO has_category
    FROM Course_Category
    WHERE ID_Course = pID_Course;

    -- Retornar verdadero si ambas condiciones se cumplen
    RETURN all_levels_active AND has_category;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_VerifyChange_Level_Status`(
    pID_Level VARCHAR(36)
) RETURNS tinyint
    DETERMINISTIC
BEGIN
    DECLARE VerifyChange_Level_Status BOOLEAN DEFAULT TRUE;

    -- Verificar si existe al menos un video asociado al nivel
    IF NOT EXISTS (
        SELECT 1
        FROM LevelResources
        WHERE ID_Level = pID_Level
          AND Resource_Type = 1
    ) THEN
        -- Si no hay videos, no se puede publicar
        SET VerifyChange_Level_Status = FALSE;
    END IF;

    RETURN VerifyChange_Level_Status;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_VerifyEmail`(
    pUser_email VARCHAR(64),
    pUser_Role TINYINT,
    pID_User INT UNSIGNED
) RETURNS tinyint(1)
    DETERMINISTIC
BEGIN
    DECLARE emailIsUnique BOOLEAN;
    -- Verificar si el correo ya existe en la tabla Users para ese rol y es diferente del usuario actual
    IF (SELECT COUNT(User_email) FROM Users WHERE User_email = pUser_email AND User_Role = pUser_Role AND ID_User != pID_User) = 0 THEN
        SET emailIsUnique = TRUE;  -- La verificación regresa TRUE si no existe aún
    ELSE
        SET emailIsUnique = FALSE; -- La verificación regresa FALSE si ya existe
    END IF;

    RETURN emailIsUnique;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_VerifyPassword`(
    pID_User INT UNSIGNED,
	pUser_NewPassword VARCHAR(64)
) RETURNS tinyint(1)
    DETERMINISTIC
BEGIN
    DECLARE VerifyPassword BOOLEAN DEFAULT TRUE;
    DECLARE currentPassword VARBINARY(255);
    
    -- Obtener la contraseña actual del usuario
    SELECT User_CurrentPassword
    INTO currentPassword
		FROM Users
		WHERE ID_User = pID_User;
    
    -- Verificar si la contraseña nueva coincide con la actual
    IF AES_ENCRYPT(pUser_NewPassword, 'BDM') = currentPassword THEN
        -- La nueva contraseña es igual a la actual
        SET VerifyPassword = FALSE;
	-- Verificar si la contraseña nueva coincide con las anteriores 3
    ELSEIF EXISTS (
        SELECT 1
        FROM (
            SELECT User_Password
            FROM Passwords
            WHERE ID_User = pID_User
            ORDER BY Register_Date DESC
            LIMIT 3
        ) AS RecentPasswords
        WHERE RecentPasswords.User_Password = AES_ENCRYPT(pUser_NewPassword, 'BDM')
    ) THEN
		-- La nueva contraseña coincide con las anteriores 3
        SET VerifyPassword = FALSE;
    END IF;

    RETURN VerifyPassword;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_VerifyUser_AllLevelsCompleted`(
    pID_User INT UNSIGNED, 
    pID_Course VARCHAR(36)
) RETURNS tinyint(1)
    DETERMINISTIC
BEGIN
    DECLARE completedLevels INT UNSIGNED;
    DECLARE totalLevels TINYINT UNSIGNED;

    -- Obtener los niveles completados por el usuario
    SET completedLevels = FUNC_UserLevelsCompleted(pID_User, pID_Course);

    -- Obtener el total de niveles del curso
    SET totalLevels = FUNC_Course_TotalLevels(pID_Course);

    -- Retornar TRUE si los niveles completados son iguales al total
    RETURN completedLevels = totalLevels;
END$$
DELIMITER ;
;