DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CategoryManagement`(
	IN pSP_Action			TINYINT
    
    ,IN pID_Category	VARCHAR(36)
	,IN pID_User		INT UNSIGNED
    ,IN pCategory_Name	VARCHAR(64)
    ,IN pCategory_Description	TINYTEXT
)
BEGIN
	IF pSP_Action = -1 THEN -- SELECCIONAR LA VISTA PARA ADMINS DE CATEGORÍAS
		SELECT
			ID_Category,
			Register_User,
			Register_Date,
			UpdateInfo_User,
			UpdateInfo_Date,
			Category_Name,
			Category_Description
		FROM VIEW_Categories_Admin;

	ELSEIF pSP_Action = 0 THEN -- SELECCIONAR TODAS LAS CATEGORÍAS
		SELECT
			ID_Category,
            ID_RegisterUser,
            ID_UpdateInfoUser,
            Register_Date,
            UpdateInfo_Date,
            Category_Name,
            Category_Description
        FROM Category;

	ELSEIF pSP_Action = 1 THEN -- SELECCIONAR CATEGORÍA POR ID
		SELECT
			ID_Category,
            ID_RegisterUser,
            ID_UpdateInfoUser,
            Register_Date,
            UpdateInfo_Date,
            Category_Name,
            Category_Description
        FROM Category WHERE ID_Category = pID_Category;
        
    ELSEIF pSP_Action = 2 THEN -- REGISTRAR CATEGORÍA
		INSERT INTO Category (
			ID_RegisterUser,
			ID_UpdateInfoUser,
            Category_Name,
            Category_Description
            )
		VALUES (
			pID_User,
			pID_User,
			pCategory_Name,
            pCategory_Description
			);
            
	ELSEIF pSP_Action = 3 THEN -- ACTUALIZAR CATEGORÍA
		UPDATE Category
        SET 
			UpdateInfo_Date			= CURRENT_TIMESTAMP(),
            ID_UpdateInfoUser		= pID_User,
            Category_Name			= pCategory_Name,
            Category_Description	= pCategory_Description
		WHERE ID_Category = pID_Category;
	
    ELSEIF pSP_Action = 4 THEN -- ELIMINAR CATEGORÍA
		DELETE FROM Category
		WHERE ID_Category = pID_Category;
	END IF;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Course_CategoryManagement`(
	IN pSP_Action			TINYINT,
    
    IN pID_Course			VARCHAR(36),
    IN pID_Category			VARCHAR(36)
)
BEGIN
	IF pSP_Action = 0 THEN -- SELECCIONAR TODA LA TABLA
		SELECT ID_Course, ID_Category, Register_Date FROM Course_Category;
    
    ELSEIF pSP_Action = 1 THEN -- SELECCIONAR POR ID CURSO (VER CATEGORÍAS DE UN CURSO)
		SELECT ID_Course, Category_Name, ID_Category, Register_Date
        FROM VIEW_Course_Category_Extended WHERE ID_Course = pID_Course;
    
    ELSEIF pSP_Action = 2 THEN -- SELECCIONAR POR ID CATEGORÍA (VER CURSOS DE UNA CATEGORÍA)
		SELECT ID_Course, ID_Category, Register_Date
        FROM Course_Category WHERE ID_Category = pID_Category;
        
    ELSEIF pSP_Action = 3 THEN -- SELECCIONAR POR ID CURSO Y POR ID CURSO CATEGORÍA (VER UN RENGLÓN EN ESPECÍFICO)
		SELECT ID_Course, ID_Category, Register_Date
        FROM Course_Category WHERE ID_Course = pID_Course AND ID_Category = pID_Category;
    
    ELSEIF pSP_Action = 4 THEN	-- REGISTRAR
		INSERT INTO Course_Category (ID_Course, ID_Category) VALUES (pID_Course, pID_Category);
	
    ELSEIF pSP_Action = 5 THEN	-- ELIMINAR COMPLETAMENTE
		DELETE FROM Course_Category
		WHERE ID_Course = pID_Course AND ID_Category = pID_Category;
	END IF;
END$$
DELIMITER ;
;

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Course_Comments`(
	IN pSP_Action			TINYINT,
    
    IN pID_Comment			VARCHAR(36),
    IN pID_User				INT UNSIGNED,
    IN pID_Course			VARCHAR(36),
    IN pComment_Text		TEXT
)
BEGIN
	IF pSP_Action = 0 THEN -- SELECCIONAR TODA LA TABLA
		SELECT ID_Comment, ID_User, ID_Course, Register_Date, Comment_Status, Comment_Text
        FROM Course_Comments;
    
    ELSEIF pSP_Action = 1 THEN -- SELECCIONAR POR ID_User (Todos los comentarios de un usuario)
		SELECT ID_Comment, ID_User, ID_Course, Register_Date, Comment_Status, Comment_Text
        FROM Course_Comments
        WHERE ID_User = pID_User;
        
    ELSEIF pSP_Action = 2 THEN -- SELECCIONAR POR ID_Course (Todos los comentarios de un curso)
		SELECT ID_Comment, ID_User, Profile_Picture, ID_Course, Full_User_Name, Register_Date, UserRating, Comment_Text
        FROM VIEW_CourseComments
        WHERE ID_Course = pID_Course;
        
	ELSEIF pSP_Action = 3 THEN -- SELECCIONAR POR ID_Comment (Comentario específico)
		SELECT ID_Comment, ID_User, Profile_Picture, ID_Course, Full_User_Name, Register_Date, UserRating, Comment_Text
        FROM VIEW_CourseComments
        WHERE ID_Comment = pID_Comment;
    
    ELSEIF pSP_Action = 4 THEN -- REGISTRAR
		INSERT INTO Course_Comments (ID_User, ID_Course, Comment_Text)
        VALUES (pID_User, pID_Course, pComment_Text);
        
	ELSEIF pSP_Action = 5 THEN -- EDITAR
		UPDATE Course_Comments
			SET
				Comment_Text	= pComment_Text
			WHERE ID_Comment = pID_Comment;
    
	ELSEIF pSP_Action = 6 THEN -- BAJA LÓGICA
		UPDATE Course_Comments
			SET
				Comment_Status	= 0
			WHERE ID_Comment = pID_Comment;
            
	ELSEIF pSP_Action = 7 THEN -- ALTA LÓGICA
		UPDATE Course_Comments
			SET
				Comment_Status	= 1
			WHERE ID_Comment = pID_Comment;
            
	ELSEIF pSP_Action = 8 THEN -- ELIMINAR COMPLETAMENTE
		DELETE FROM Course_Comments
			WHERE ID_Comment = pID_Comment;
	END IF;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CourseManagement`(
	IN pSP_Action			TINYINT,
    
	IN pID_Course			VARCHAR(36),
    IN PID_User				INT UNSIGNED,
    IN pCourse_Picture		MEDIUMBLOB,
    IN pCourse_Name			VARCHAR(64),
    IN pCourse_Description	TEXT
)
BEGIN
	IF pSP_Action = -7 THEN -- SELECCIONAR REPORTE INDIVIDUAL DE UN CURSO
		SELECT
			Full_Name,
			Level_Name,
			Beginning_Date,
			Level_Price,
			Pay_Method
		FROM VIEW_CourseRevenues
		WHERE ID_Course = pID_Course;
	
    ELSEIF pSP_Action = -6 THEN -- SELECCIONAR REPORTE DE VENTAS GENERALES DE UN INSTRUCTOR EN ESPECÍFICO
		SELECT
			ID_Course,
			Course_Status,
			Course_Name,
			Total_Students,
			Level_Name,
			Transfer_Revenue,
			Mastercard_Revenue,
			PayPal_Revenue,
			Total_Revenue
		FROM VIEW_GeneralRevenues
		WHERE ID_User = pID_User;
	
	ELSEIF pSP_Action = -5 THEN -- SELECCIONAR TARJETAS DE CURSO ACTIVO POR MÁS RECIENTES
		SELECT
			ID_Course,
			Register_Date,
            UpdateInfo_Date,
			Course_Picture,
			Course_Name,
            Creator_Name,
			Course_Description,
			Course_TotalLevels,
			Total_Votes,
            AverageRating,
			FullCourse_Price,
            FullCourse_OneLevelBought,
			FullCourse_TimesBought
		FROM VIEW_FullCourse_Data
		WHERE Number_Status = 2
        ORDER BY Register_Date DESC;
        
	ELSEIF pSP_Action = -4 THEN -- SELECCIONAR TARJETAS DE CURSO ACTIVO POR MEJOR CALIFICADOS
		SELECT
			ID_Course,
			Register_Date,
            UpdateInfo_Date,
			Course_Picture,
			Course_Name,
            Creator_Name,
			Course_Description,
			Course_TotalLevels,
			Total_Votes,
            AverageRating,
			FullCourse_Price,
            FullCourse_OneLevelBought,
			FullCourse_TimesBought
		FROM VIEW_FullCourse_Data
		WHERE Number_Status = 2
        ORDER BY AverageRating DESC;

	ELSEIF pSP_Action = -3 THEN -- SELECCIONAR TARJETAS DE CURSO ACTIVO POR MÁS VENDIDOS
		SELECT
			ID_Course,
			Register_Date,
            UpdateInfo_Date,
			Course_Picture,
			Course_Name,
            Creator_Name,
			Course_Description,
			Course_TotalLevels,
			Total_Votes,
            AverageRating,
			FullCourse_Price,
            FullCourse_OneLevelBought,
			FullCourse_TimesBought
		FROM VIEW_FullCourse_Data
		WHERE Number_Status = 2
        ORDER BY FullCourse_OneLevelBought DESC;
        
	ELSEIF pSP_Action = -2 THEN -- SELECCIONAR TARJETAS DE CURSO POR CREADOR DE CURSO
		SELECT
			ID_Course,
			Register_Date,
            UpdateInfo_Date,
			Course_Picture,
			Course_Name,
            Creator_Name,
			Course_Description,
			Course_TotalLevels,
			Total_Votes,
            AverageRating,
			FullCourse_Price,
            FullCourse_OneLevelBought,
			FullCourse_TimesBought
		FROM VIEW_FullCourse_Data
		WHERE ID_User = pID_User AND Number_Status != 0;
    
	ELSEIF pSP_Action = -1 THEN -- SELECCIONAR DATOS DENTRO DE LA PÁGINA DE CURSOS
		SELECT
			ID_Course,
            ID_User,
            Course_Status,
			Register_Date,
            UpdateInfo_Date,
			Course_Picture,
			Course_Name,
            Creator_Name,
			Course_Description,
			Course_TotalLevels,
			Total_Votes,
            AverageRating,
			FullCourse_Price,
			FullCourse_TimesBought
		FROM VIEW_FullCourse_Data
		WHERE ID_Course = pID_Course;

	ELSEIF pSP_Action = 0 THEN -- SELECCIONAR TODOS LOS CURSOS ACTIVOS
		SELECT
			ID_Course
			,ID_User
			,Course_Status	
			,Register_Date	
			,UpdateInfo_Date	
			,Course_Picture	
			,Course_Name	
			,Course_Description
		FROM Courses WHERE Course_Status = 1;
    
    ELSEIF pSP_Action = 1 THEN -- SELECCIONAR CURSO ACTIVO POR ID
		SELECT
			ID_Course
			,ID_User
			,Course_Status	
			,Register_Date	
			,UpdateInfo_Date	
			,Course_Picture	
			,Course_Name	
			,Course_Description
		FROM Courses WHERE ID_Course = pID_Course AND Course_Status = 1;
    
	ELSEIF pSP_Action = 2 THEN -- REGISTRAR
		INSERT INTO Courses (
			ID_User,
			Course_Picture,
            Course_Name,
            Course_Description
            )
        VALUES (
			pID_User,
            pCourse_Picture,
            pCourse_Name,
            pCourse_Description
			);
            
	ELSEIF pSP_Action = 3 THEN -- ACTUALIZAR INFO DE CURSO
		UPDATE Courses
        SET
            Course_Picture			= pCourse_Picture,
            Course_Name				= pCourse_Name,
            Course_Description		= pCourse_Description
		WHERE ID_Course = pID_Course;
        
	ELSEIF pSP_Action = 4 THEN -- BAJA LÓGICA
        UPDATE Courses
        SET Course_Status = 0
        WHERE ID_Course = pID_Course;

	ELSEIF pSP_Action = 5 THEN -- CURSO EXISTE
        UPDATE Courses
        SET Course_Status = 1
        WHERE ID_Course = pID_Course;

	ELSEIF pSP_Action = 6 THEN -- ALTA LÓGICA
        IF FUNC_VerifyChange_Course_Status(pID_Course) THEN
			UPDATE Courses
			SET Course_Status = 2
			WHERE ID_Course = pID_Course;
        END IF;

	ELSEIF pSP_Action = 7 THEN -- ELIMINAR COMPLETAMENTE
		DELETE FROM Courses
		WHERE ID_Course = pID_Course;
    END IF;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_DirectMessages`(
	IN pSP_Action		TINYINT,
    
    IN pID_Message		VARCHAR(36),
    IN pID_Transmitter	INT UNSIGNED,
    IN pID_Receiver		INT UNSIGNED,
    
    IN pMessage 		TEXT
)
BEGIN
	IF pSP_Action = -1 THEN -- SELECCIONAR TODA LA TABLA
		SELECT ID_Message, Message_Status, Register_Date, ID_Transmitter, ID_Receiver, Message
        FROM DirectMessages;
    
    ELSEIF pSP_Action = 0 THEN -- SELECCIONA UN CHAT
		SELECT ID_Message, Message_Status, Register_Date, ID_Transmitter, ID_Receiver, Message
        FROM DirectMessages
        WHERE ID_Transmitter = pID_Transmitter
        AND ID_Receiver = pID_Receiver;
	
    ELSEIF pSP_Action = 1 THEN -- SELECCIONA UN MENSAJE EN ESPECÍFICO
		SELECT ID_Message, Message_Status, Register_Date, ID_Transmitter, ID_Receiver, Message
        FROM DirectMessages
        WHERE ID_Message = pID_Message;
        
	ELSEIF pSP_Action = 2 THEN -- REGISTRAR NUEVO MENSAJE
		INSERT INTO DirectMessages (ID_Transmitter, ID_Receiver, Message)
        VALUES (pID_Transmitter, pID_Receiver, pMessage);
        
	ELSEIF pSP_Action = 3 THEN -- BAJA LÓGICA
		UPDATE DirectMessages
			SET
				Message_Status	= 0
			WHERE ID_Message = pID_Message;
        
	ELSEIF pSP_Action = 4 THEN -- ALTA LÓGICA
		UPDATE DirectMessages
			SET
				Message_Status	= 1
			WHERE ID_Message = pID_Message;
        
	ELSEIF pSP_Action = 5 THEN -- ELIMINAR COMPLETAMENTE
		DELETE FROM DirectMessages
			WHERE ID_Message = pID_Message;
    END IF;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LevelCourseManagement`(
	IN pSP_Action			TINYINT,
    
    IN pID_Level			VARCHAR(36),
    IN pID_Course			VARCHAR(36),
    IN pLevel_Name			VARCHAR(64),
    IN pLevel_Price			DECIMAL(9, 2)
)
BEGIN
	IF pSP_Action = 0 THEN -- SELECCIONA TODOS LOS NIVELES
		SELECT ID_Level, ID_Course, Level_Status, Level_Name, Level_Price, Level_TimesBought
        FROM VIEW_LevelCourse_FullData;
        
	ELSEIF pSP_Action = 1 THEN -- SELECCIONA NIVEL EN ESPECÍFICO
		SELECT ID_Level, ID_Course, Level_Status, Level_Name, Level_Price, Level_TimesBought
        FROM VIEW_LevelCourse_FullData WHERE ID_Level = pID_Level;
    
    ELSEIF pSP_Action = 2 THEN -- SELECCIONA TODOS LOS NIVELES DE UN CURSO EN ESPECÍFICO
		SELECT ID_Level, ID_Course, Level_Status, Level_Name, Level_Price, Level_TimesBought
        FROM VIEW_LevelCourse_FullData WHERE ID_Course = pID_Course;
	
    ELSEIF pSP_Action = 3 THEN -- REGISTRAR NIVEL
        INSERT INTO LevelCourse (ID_Course, Level_Name, Level_Price)
		VALUES (pID_Course, pLevel_Name, pLevel_Price);
        
	ELSEIF pSP_Action = 4 THEN -- ACTUALIZAR NIVEL
		UPDATE LevelCourse
        SET
            Level_Name			= pLevel_Name,
            Level_Price			= pLevel_Price
		WHERE ID_Level = pID_Level;
	
    ELSEIF pSP_Action = 5 THEN -- ESTATUS "SIN PUBLICAR"
		UPDATE LevelCourse
        SET
            Level_Status		= 0
		WHERE ID_Level = pID_Level;
        
	ELSEIF pSP_Action = 6 THEN -- ESTATUS "PUBLICADO"
		IF FUNC_VerifyChange_Level_Status(pID_Level) THEN
			UPDATE LevelCourse
			SET Level_Status	= 1
			WHERE ID_Level = pID_Level;
		END IF;
    
	ELSEIF pSP_Action = 7 THEN -- ELIMINAR NIVEL
		DELETE FROM LevelCourse
		WHERE ID_Level = pID_Level;
        
	ELSEIF pSP_Action = 8 THEN -- ELIMINAR TODOS LOS NIVELES DEL CURSO
		DELETE FROM LevelCourse
		WHERE ID_Course = pID_Course;
    END IF;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LevelResourcesManagement`(
	IN pSP_Action			TINYINT,
    
    IN pID_Course			VARCHAR(36),
    IN pID_Level			VARCHAR(36),
    IN pID_Resource			VARCHAR(36),
    IN pResource_Name		TEXT,
    IN pResource_Type		TINYINT UNSIGNED,
    IN pResource_Path		TEXT
)
BEGIN
	IF pSP_Action = 0 THEN -- SELECCIONA TODOS LOS RECURSOS
    SELECT ID_Resource, ID_Level, Resource_Name, Resource_Type, Resource_Path FROM LevelResources;
    
    ELSEIF pSP_Action = 1 THEN -- SELECCIONA RECURSO EN ESPECÍFICO
	SELECT ID_Resource, ID_Level, Resource_Name, Resource_Type, Resource_Path FROM LevelResources
    WHERE ID_Resource = pID_Resource;
    
    ELSEIF pSP_Action = 2 THEN -- SELECCIONA TODOS LOS RECURSOS DE UN NIVEL EN ESPECÍFICO
    SELECT ID_Resource, ID_Level, Resource_Name, Resource_Type, Resource_Path FROM LevelResources
    WHERE ID_Level = pID_Level;
    
    ELSEIF pSP_Action = 3 THEN -- SELECCIONA TODOS LOS RECURSOS DE UN CURSO
    SELECT C.ID_Course, L.ID_Level, L.ID_Resource, L.Resource_Name, L.Resource_Type, L.Resource_Path
    FROM LevelResources L
	LEFT JOIN LevelCourse C ON L.ID_Level = C.ID_Level
    WHERE C.ID_Course = pID_Course;
    
    ELSEIF pSP_Action = 4 THEN -- REGISTRAR UN RECURSO
    INSERT INTO LevelResources (ID_Level, Resource_Name, Resource_Type, Resource_Path)
    VALUES (pID_Level, pResource_Name, pResource_Type, pResource_Path);
    
    ELSEIF pSP_Action = 5 THEN -- ACTUALIZAR UN RECURSO
    UPDATE LevelCourse
        SET
            Resource_Name		= pResource_Name,
            Resource_Type		= pResource_Type,
            Resource_Path		= pResource_Path
		WHERE ID_Resource = pID_Resource;
    
    ELSEIF pSP_Action = 6 THEN -- ELIMINAR UN RECURSO EN ESPECÍFICO
    DELETE FROM LevelResources
	WHERE ID_Resource = pID_Resource;
    
    ELSEIF pSP_Action = 7 THEN -- ELIMINAR TODOS LOS RECURSOS DE UN NIVEL EN ESPECÍFICO
    DELETE FROM LevelResources
	WHERE ID_Level = pID_Level;
    
    ELSEIF pSP_Action = 8 THEN -- ELIMINA TODOS LOS RECURSOS DE UN CURSO COMPLETO
    DELETE FROM LevelResources
	WHERE ID_Level IN (
		SELECT ID_Level
		FROM LevelCourse
		WHERE ID_Course = pID_Course
	);
    
    END IF;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_CourseEnrollmentsManagement`(
	IN pSP_Action				TINYINT,
    
    IN pID_User					INT UNSIGNED,
    IN pID_Course				VARCHAR(36),
    IN pUserRating				TINYINT UNSIGNED
)
BEGIN
	IF pSP_Action = -1 THEN -- SELECCIONAR KÁRDEX DEL ALUMNO
		SELECT ID_Course, Course_Name, Beginning_Date, CourseProgress, Completion_Date, Course_Status
        FROM VIEW_Kardex
        WHERE ID_User = pID_User;
    
	ELSEIF pSP_Action = 0 THEN -- SELECCIONAR TODA LA TABLA
		SELECT ID_User, ID_Course, Course_Status, Beginning_Date, Completion_Date, UserRating, Rating_Date
        FROM User_CourseEnrollments;
	
    ELSEIF pSP_Action = 1 THEN -- SELECCIONAR POR ID_User (VER CURSOS INSCRITOS DE UN USUARIO)
		SELECT
			Enrolled_UserID,
			ID_Course,
			Register_Date,
            UpdateInfo_Date,
			Course_Picture,
			Course_Name,
            Creator_Name,
			Course_Description,
			Course_TotalLevels,
			Total_Votes,
            AverageRating,
			FullCourse_Price,
			FullCourse_TimesBought
        FROM VIEW_FullCourseEnrollments_Data
        WHERE Enrolled_UserID = pID_User;
    
    ELSEIF pSP_Action = 2 THEN -- SELECCIONAR POR ID_Course (VER USUARIOS INSCRITOS A UN CURSO)
		SELECT ID_User, ID_Course, Course_Status, Beginning_Date, Completion_Date, UserRating, Rating_Date
        FROM User_CourseEnrollments
        WHERE ID_Course = pID_Course;
        
    ELSEIF pSP_Action = 3 THEN -- SELECCIONAR POR ID_User Y POR ID_Course (VER UN RENGLÓN EN ESPECÍFICO)
		SELECT ID_User, ID_Course, Course_Status, Beginning_Date, Completion_Date, UserRating, Rating_Date
        FROM User_CourseEnrollments
        WHERE ID_User = pID_User AND ID_Course = pID_Course;
        
    ELSEIF pSP_Action = 4 THEN	-- REGISTRAR
		INSERT INTO User_CourseEnrollments (ID_User, ID_Course)
        VALUES (pID_User, pID_Course);
    
	ELSEIF pSP_Action = 5 THEN	-- EMPEZAR CURSO (Cuando comienza su primer nivel)
		UPDATE User_CourseEnrollments
		SET
			Beginning_Date		= CURRENT_TIMESTAMP()
		WHERE ID_User = pID_User AND ID_Course = pID_Course;
        
	ELSEIF pSP_Action = 6 THEN	-- CURSO COMPLETAMENTE COMPRADO (Cuando el usuario compra todos los niveles)
		UPDATE User_CourseEnrollments
		SET
			Course_Status		= 2 -- 2, Completamente comprado y sin terminar
		WHERE ID_User = pID_User AND ID_Course = pID_Course;
     
	ELSEIF pSP_Action = 7 THEN	-- COMPLETAR CURSO
		UPDATE User_CourseEnrollments
		SET
			Course_Status		= 3, -- 3 Curso Terminado (¿cómo vas a completar un curso si no lo has terminado de comprar?)
			Completion_Date		= CURRENT_TIMESTAMP()
		WHERE ID_User = pID_User AND ID_Course = pID_Course;
		
	ELSEIF pSP_Action = 8 THEN	-- CALIFICAR CURSO
		UPDATE User_CourseEnrollments
        SET
			Rating_Date = CURRENT_TIMESTAMP(),
			UserRating = pUserRating
            WHERE ID_User = pID_User AND ID_Course = pID_Course;
    
	ELSEIF pSP_Action = 9 THEN	-- ELIMINAR COMPLETAMENTE
		DELETE FROM User_CourseEnrollments
		WHERE ID_User = pID_User AND ID_Course = pID_Course;
    
    END IF;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_LevelCourseManagement`(
	pSP_Action					TINYINT,

	pID_User                    INT UNSIGNED,
    pID_Level                   VARCHAR(36),
    pPay_Method					TINYINT UNSIGNED	-- 1 Transferencia, 2 Mastercard, 3 PayPal
)
BEGIN
	IF pSP_Action = 0 THEN -- SELECCIONAR TODA LA TABLA
		SELECT ID_User, ID_Level, Level_Status, Pay_Method, Beginning_Date, Completion_Date
        FROM User_LevelCourse;
        
    ELSEIF pSP_Action = 1 THEN -- SELECCIONAR POR ID_User (VER NIVELES DE UN USUARIO)
		SELECT ID_User, ID_Level, Level_Status, Pay_Method, Beginning_Date, Completion_Date
        FROM User_LevelCourse WHERE ID_User = pID_User;
        
    ELSEIF pSP_Action = 2 THEN -- SELECCIONAR POR ID_Level (VER USUARIOS DE UN NIVEL)
		SELECT ID_User, ID_Level, Level_Status, Pay_Method, Beginning_Date, Completion_Date
        FROM User_LevelCourse WHERE ID_Level = pID_Level;
    
    ELSEIF pSP_Action = 3 THEN -- SELECCIONAR POR ID_User Y POR ID_Level (VER UN RENGLÓN EN ESPECÍFICO)
		SELECT ID_User, ID_Level, Level_Status, Pay_Method, Beginning_Date, Completion_Date
        FROM User_LevelCourse WHERE ID_User = pID_User AND ID_Level = pID_Level;
        
	ELSEIF pSP_Action = 4 THEN	-- REGISTRAR
    INSERT INTO User_LevelCourse (ID_User, ID_Level, Pay_Method)
    VALUES (pID_User, pID_Level, pPay_Method);
    
    ELSEIF pSP_Action = 5 THEN	-- EMPEZAR NIVEL
    UPDATE User_LevelCourse
		SET
			Beginning_Date		= CURRENT_TIMESTAMP(),
            Level_Status		= 2
		WHERE ID_User = pID_User AND ID_Level = pID_Level;
        
        -- Verificar si es el primer nivel que comienza
		IF NOT EXISTS (
			SELECT 1
			FROM User_CourseEnrollments
			WHERE ID_User = pID_User AND Beginning_Date IS NOT NULL
		) THEN
			UPDATE User_CourseEnrollments
			SET Beginning_Date = CURRENT_TIMESTAMP()
			WHERE ID_User = pID_User AND ID_Course = (
				SELECT ID_Course
				FROM LevelCourse
				WHERE ID_Level = pID_Level
			);
        END IF;
    
    ELSEIF pSP_Action = 6 THEN	-- COMPLETAR NIVEL
		UPDATE User_LevelCourse
		SET
			Completion_Date = CURRENT_TIMESTAMP(),
			Level_Status = 3
		WHERE ID_User = pID_User AND ID_Level = pID_Level;

		-- Verificar si el usuario ha completado todos los niveles del curso
		IF FUNC_VerifyUser_AllLevelsCompleted(pID_User, (
			SELECT ID_Course
			FROM LevelCourse
			WHERE ID_Level = pID_Level
		)) THEN
			UPDATE User_CourseEnrollments
			SET Completion_Date = CURRENT_TIMESTAMP()
			WHERE ID_User = pID_User AND ID_Course = (
				SELECT ID_Course
				FROM LevelCourse
				WHERE ID_Level = pID_Level
			);
		END IF;

    ELSEIF pSP_Action = 7 THEN	-- ELIMINAR COMPLETAMENTE
    DELETE FROM User_LevelCourse
    WHERE ID_User = pID_User AND ID_Level = pID_Level; 
    
    END IF;
END$$
DELIMITER ;
;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UserManagement`(
	IN pSP_Action				TINYINT

	,IN pID_User				INT
    ,IN pUser_Role				TINYINT UNSIGNED
    ,IN pProfile_Picture		MEDIUMBLOB
	,IN pUser_Birthdate			DATE
	,IN pUser_Gender			TINYINT UNSIGNED
	,IN pUser_Name				VARCHAR(64)
	,IN pUser_LastName			VARCHAR(64)
	,IN pUser_SecondLastName	VARCHAR(64)
	,IN pUser_email				VARCHAR(64)
	,IN pUser_CurrentPassword	VARCHAR(32)
    
    ,IN pUser_NewPassword		VARCHAR(32)
    
    ,OUT pResultCode 			INT -- Código de resultado del procedure
)
Action_Exit:BEGIN
	DECLARE passwordHistoryCheck	BOOLEAN DEFAULT TRUE;
	DECLARE emailIsUnique			BOOLEAN DEFAULT TRUE;
	DECLARE SuccessfulLogin			BOOLEAN DEFAULT TRUE;
    SET pResultCode = 0;			-- 0, Procedure exitoso
	
	IF pSP_Action = -3 THEN -- SELECCIONAR REPORTE DE INSTRUCTOR
		SELECT
			ID_User,
			Full_Name,
			Register_Date,
            TotalOfferedCourses,
            InstructorTotalRevenue
		FROM VIEW_InstructorReport;
    
    ELSEIF pSP_Action = -2 THEN -- SELECCIONAR REPORTE DE ESTUDIANTES
		SELECT
			ID_User,
			Full_Name,
			Register_Date,
			TotalEnrolledCourses,
			PercentCompletedCourses
		FROM VIEW_StudentReport;
    
    ELSEIF pSP_Action = -1 THEN -- SELECCIONAR TODOS LOS USUARIOS
		SELECT ID_User,
			User_Status,
			User_Role,
			Register_Date,
			UpdateInfo_Date,
			Profile_Picture,
			User_Birthdate,
			User_Gender,
			User_Name,
			User_LastName,
			User_SecondLastName,
			User_email,
			User_PasswordAttempts
		FROM users;
    
    ELSEIF pSP_Action = 0 THEN -- SELECT PARA LOGIN 0
		IF (SELECT COUNT(ID_User) FROM Users WHERE ID_User = pID_User
				AND User_Status = 1
				AND User_CurrentPassword = AES_ENCRYPT(pUser_CurrentPassword, 'BDM')) != 1 THEN
			SET SuccessfulLogin = FALSE;
            SET pResultCode = 2; -- Código 2 indica credenciales inválidas
            SET pSP_Action = -10; -- Acción que no existe para que la 2 no se quede en bucle
		LEAVE Action_Exit;
        END IF;
        
		SELECT ID_User,
			User_Status,
			User_Role,
			Register_Date,
			UpdateInfo_Date,
			Profile_Picture,
			User_Birthdate,
			User_Gender,
			User_Name,
			User_LastName,
			User_SecondLastName,
			User_email,
			User_PasswordAttempts
		FROM users WHERE ID_User = pID_User
				AND User_Status = 1
				AND User_CurrentPassword = AES_ENCRYPT(pUser_CurrentPassword, 'BDM');

	ELSEIF pSP_Action = 1 THEN -- SELECT PARA LOGIN 1
		IF (SELECT COUNT(User_email) FROM Users WHERE User_email = pUser_email
				AND User_Status = 1
                AND User_Role = pUser_Role
				AND User_CurrentPassword = AES_ENCRYPT(pUser_CurrentPassword, 'BDM')) != 1 THEN
			SET SuccessfulLogin = FALSE;
            SET pResultCode = 2; -- Código 2 indica credenciales inválidas
            SET pSP_Action = -10; -- Acción que no existe para que la 2 no se quede en bucle
		LEAVE Action_Exit;
        END IF;
        
		SELECT ID_User,
			User_Status,
			User_Role,
			Register_Date,
			UpdateInfo_Date,
			Profile_Picture,
			User_Birthdate,
			User_Gender,
			User_Name,
			User_LastName,
			User_SecondLastName,
			User_email,
			User_PasswordAttempts
		FROM users WHERE User_email = pUser_email
				AND User_Status = 1
                AND User_Role = pUser_Role
				AND User_CurrentPassword = AES_ENCRYPT(pUser_CurrentPassword, 'BDM');
    
	ELSEIF pSP_Action = 2 THEN -- REGISTRAR
    -- Verificar si el correo se puede usar para ese rol
		SET emailIsUnique = FUNC_VerifyEmail(pUser_email, pUser_Role, 0);
		-- Si la función devuelve FALSE, el correo ya ha sido utilizado para ese rol
        IF emailIsUnique = FALSE THEN
            SET pResultCode = 1; -- Código 1 indica que el correo no se puede usar
            SET pSP_Action = -10; -- Acción que no existe para que la 2 no se quede en bucle
		LEAVE Action_Exit;
        END IF;
    
		INSERT INTO Users (
			User_Role,
            Profile_Picture,
            User_Birthdate,
            User_Gender,
            User_Name,
            User_LastName,
            User_SecondLastName,
            User_email,
            User_CurrentPassword
            )
		VALUES (
			pUser_Role,
            pProfile_Picture,
            pUser_Birthdate,
            pUser_Gender,
            pUser_Name,
            pUser_LastName,
            pUser_SecondLastName,
            pUser_email,
            AES_ENCRYPT(pUser_CurrentPassword, 'BDM')
            );
        
	ELSEIF pSP_Action = 3 THEN -- ACTUALIZAR INFO DE USUARIO    
    -- Verificar si el correo se puede usar para ese rol
		SET emailIsUnique = FUNC_VerifyEmail(pUser_email, pUser_Role, pID_User);
		-- Si la función devuelve FALSE, el correo ya ha sido utilizado para ese rol
        IF emailIsUnique = FALSE THEN
            SET pResultCode = 1; -- Código 1 indica que el correo no se puede usar
            SET pSP_Action = -10; -- Acción que no existe para que la 2 no se quede en bucle
		LEAVE Action_Exit;
        END IF;
    
        UPDATE Users
        SET 
            Profile_Picture			= pProfile_Picture,
            User_Birthdate 			= pUser_Birthdate,
            User_Gender 			= pUser_Gender,
            User_Name 				= pUser_Name,
            User_LastName 			= pUser_LastName,
            User_SecondLastName		= pUser_SecondLastName,
            User_email 				= pUser_email
        WHERE ID_User = pID_User
			AND User_Status = 1;
            
	ELSEIF pSP_Action = 4 THEN -- ACTUALIZAR CONTRASEÑA
		-- Verificar si la nueva contraseña es igual a la actual o si ya fue usada en el historial
		SET passwordHistoryCheck = FUNC_VerifyPassword(pID_User, pUser_NewPassword);
        -- Si la función devuelve FALSE, la contraseña ya ha sido utilizada
        IF passwordHistoryCheck = FALSE THEN
            SET pResultCode = 3; -- Código 3 indica que la contraseña es repetida
            SET pSP_Action = -10;
		LEAVE Action_Exit;
        END IF;
		
        -- Si todo fue válido, actualizar la nueva contraseña siempre y cuando el usuario haya colocado correctamente la contraseña actual
        UPDATE Users
        SET User_CurrentPassword = AES_ENCRYPT(pUser_NewPassword, 'BDM')
        WHERE ID_User = pID_User
            AND User_CurrentPassword = AES_ENCRYPT(pUser_CurrentPassword, 'BDM')
            AND User_Status = 1;
        
	ELSEIF pSP_Action = 5 THEN -- BAJA LÓGICA
        UPDATE Users
        SET User_Status = 0
        WHERE ID_User = pID_User
			AND User_Status = 1;
	
    ELSEIF pSP_Action = 6 THEN -- ALTA LÓGICA
        UPDATE Users
        SET User_Status = 1
        WHERE ID_User = pID_User
			AND User_Status = 0;
    
	ELSEIF pSP_Action = 7 THEN -- ELIMINAR COMPLETAMENTE
        DELETE FROM Users
        WHERE ID_User = pID_User;
        
	END IF;
END$$
DELIMITER ;
;