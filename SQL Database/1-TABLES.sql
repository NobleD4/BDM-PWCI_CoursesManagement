CREATE DATABASE IF NOT EXISTS DB_Prueba;
USE DB_Prueba;

CREATE TABLE Users (
    ID_User						INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    User_Status					BIT DEFAULT 1 NOT NULL,
    User_Role					TINYINT DEFAULT 1 NOT NULL,			-- 1 Estudiante, 2 Instructor, 3 Administrador
    Register_Date				DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
	UpdateInfo_Date				DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    Profile_Picture				MEDIUMBLOB,
    User_Birthdate				DATE NOT NULL,
    User_Gender					TINYINT UNSIGNED DEFAULT 0 NOT NULL, -- 0 Indefinido, 1 Femenino, 2 Masculino
    User_Name					VARCHAR(64) NOT NULL,
    User_LastName				VARCHAR(64) NOT NULL,
    User_SecondLastName			VARCHAR(64),
    User_email					VARCHAR(64),
    User_CurrentPassword		VARBINARY(255) NOT NULL,
    User_PasswordAttempts		TINYINT UNSIGNED DEFAULT 0 NOT NULL
);

CREATE TABLE Passwords (
	ID_Password 				VARCHAR(36) NOT NULL DEFAULT(UUID()) PRIMARY KEY,
	ID_User 					INT UNSIGNED NOT NULL,
	Register_Date 				DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	User_Password 				VARBINARY(255) NOT NULL,
    
    FOREIGN KEY (ID_User) REFERENCES Users(ID_User)
);

CREATE TABLE Category (
	ID_Category					VARCHAR(36) NOT NULL DEFAULT(UPPER(REPLACE(UUID(), '-', '0'))) PRIMARY KEY,
	ID_RegisterUser				INT UNSIGNED NOT NULL,
	ID_UpdateInfoUser			INT UNSIGNED NOT NULL,
	Register_Date				DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    UpdateInfo_Date				DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    Category_Name				VARCHAR(64) NOT NULL,
    Category_Description		TINYTEXT DEFAULT NULL,
    
	FOREIGN KEY (ID_RegisterUser) REFERENCES Users(ID_User),
	FOREIGN KEY (ID_UpdateInfoUser) REFERENCES Users(ID_User)
);

CREATE TABLE Courses (
	ID_Course					VARCHAR(36) NOT NULL DEFAULT(REPLACE(UPPER(UUID()), '-', 'c')) PRIMARY KEY,
    ID_User						INT UNSIGNED NOT NULL,					-- Creador del curso
    Course_Status				BIT(2) DEFAULT 1 NOT NULL,				-- 0 Se dio de baja lógica, 1 Curso existe, 2 Curso publicado (No se puede publicar el curso sin niveles o cuando los niveles no tienen mínimo un video)
    Register_Date				DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    UpdateInfo_Date				DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
	Course_Picture				MEDIUMBLOB,
	Course_Name					VARCHAR(64) NOT NULL,
	Course_Description			TEXT NOT NULL,
    -- Course_TotalLevels			TINYINT UNSIGNED DEFAULT 0 NOT NULL,	-- Se puede agregar mientras creas el curso o se obtiene sumando la cantidad de registros de LevelCourse
    -- Total_Votes					INT UNSIGNED DEFAULT 0 NOT NULL,		-- Se calcula con base al total de registros no nulos de la columna UserRating de User_CourseEnrollments
    -- Avarage_Rating				DECIMAL(2, 1) DEFAULT 0 NOT NULL,		-- Se calcula con base al promedio de todos los ratings del curso de User_CourseEnrollments
	-- FullCourse_Price			DECIMAL(9, 2) DEFAULT 0 NOT NULL,		-- Es la suma del precio de todos los niveles de LevelCourse
	-- FullCourse_TimesBought		INT UNSIGNED DEFAULT 0 NOT NULL,		-- Si un usuario en User_LevelCourse tiene todos los Level_Status != 0, se suma +1 al contador de esta columna
    
    FOREIGN KEY (ID_User) REFERENCES Users(ID_User)
);

CREATE TABLE Course_Category (
    ID_Course 					VARCHAR(36) NOT NULL,
    ID_Category 				VARCHAR(36) NOT NULL,
    Register_Date				DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    
    PRIMARY KEY (ID_Course, ID_Category), -- Para evitar poner la misma categoría 2 veces en un mismo curso
    FOREIGN KEY (ID_Course) REFERENCES Courses(ID_Course) ON DELETE CASCADE,
    FOREIGN KEY (ID_Category) REFERENCES Category(ID_Category) ON DELETE CASCADE
);

CREATE TABLE LevelCourse (
	ID_Level					VARCHAR(36) NOT NULL DEFAULT(REPLACE(UUID(), '-', 'L')) PRIMARY KEY,
	ID_Course					VARCHAR(36) NOT NULL,
    Level_Status				BIT DEFAULT 0 NOT NULL, -- 0 Sin publicar, 1 Publicado
    Level_Name					VARCHAR(64) NOT NULL,
	Level_Price					DECIMAL(9, 2) NOT NULL,
    -- Level_TimesBought			INT UNSIGNED DEFAULT 0 NOT NULL,
    
    FOREIGN KEY (ID_Course) REFERENCES Courses(ID_Course)
    ON DELETE CASCADE
);

CREATE TABLE LevelResources (
	ID_Resource					VARCHAR(36) NOT NULL DEFAULT(REPLACE(UUID(), '-', 'R')) PRIMARY KEY,
    ID_Level					VARCHAR(36) NOT NULL,
    Resource_Name				VARCHAR(64) NOT NULL,
    Resource_Type				TINYINT UNSIGNED NOT NULL,	-- TEXTO, ARCHIVO ADJUNTO, IMAGEN, ENLACE, VIDEO
    Resource_Path				TEXT NOT NULL, -- Almacena la ruta en el servidor Media/iduser/idcurso/idnivel/idrecurso.extensión
    
    FOREIGN KEY (ID_Level) REFERENCES LevelCourse(ID_Level)
	ON DELETE CASCADE
);

CREATE TABLE User_LevelCourse (
	ID_User                     INT UNSIGNED NOT NULL,
    ID_Level                    VARCHAR(36) NOT NULL,
	Level_Status				BIT(2) DEFAULT 1 NOT NULL,	-- 0 sin comprar, 1 sin comenzar, 2 comenzado, 3 terminado (Qué onda con mi yo del pasado, si no lo compras no existirá fila)
    Pay_Method					TINYINT UNSIGNED NOT NULL,	-- 0 Ninguno, 1 Transferencia, 2 Mastercard, 3 PayPal (Lo vuelvo a decir, si no lo compras no existirá fila)
    Beginning_Date              DATETIME,
    Completion_Date             DATETIME, 					-- Fecha en la que el estudiante completó el nivel (si aplica) (Cantidad de filas donde este campo no es null / Cantidad de niveles del curso = courseProgress (Y todo eso redondearlo para abajo o simplemente omitir decimales))
    
    PRIMARY KEY (ID_User, ID_Level),	-- Para que los usuarios no puedan comprar varias veces el mismo curso
    FOREIGN KEY (ID_User) REFERENCES Users(ID_User),
    FOREIGN KEY (ID_Level) REFERENCES LevelCourse(ID_Level)
    ON DELETE CASCADE
);

CREATE TABLE User_CourseEnrollments ( -- InscripciónCurso
	ID_User						INT UNSIGNED NOT NULL,
    ID_Course					VARCHAR(36) NOT NULL,
    Course_Status				BIT(2) DEFAULT 1 NOT NULL,	-- 0 Sin comprar, 1 Parcialmente comprado, 2 Completamente comprado y sin terminar, 3 Terminado (Lo mismo aquí con el estatus "sin comprar", AAAAAA)
	-- Progress                 TINYINT UNSIGNED DEFAULT 0 NOT NULL,	-- Porcentaje del progreso en el curso, ((niveles-completados/total-niveles) * 100)
    Beginning_Date				DATETIME,	-- Fecha en la que el estudiante comenzó su primer nivel
    Completion_Date				DATETIME,	-- Cuando el porcentaje sea igual a 100% se actualiza con el current_TimeStamp()
    UserRating					TINYINT UNSIGNED, -- No se podrá modificar hasta que el curso no se haya completado
    Rating_Date					DATETIME,
    
    PRIMARY KEY (ID_User, ID_Course), -- Llave compuesta para que los usuarios no puedan comprar varias veces el mismo curso
    FOREIGN KEY (ID_User) REFERENCES Users(ID_User),
    FOREIGN KEY (ID_Course) REFERENCES Courses(ID_Course)
    ON DELETE CASCADE
);

CREATE TABLE Course_Comments (
	ID_Comment					VARCHAR(36) NOT NULL DEFAULT(REPLACE(UUID(), '-', 'C')) PRIMARY KEY,
    ID_User						INT UNSIGNED NOT NULL,
    ID_Course					VARCHAR(36) NOT NULL,
    Register_Date				DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    Comment_Status				BIT DEFAULT 1 NOT NULL, -- 0 Borrado, 1 Activo
    Comment_Text				TEXT NOT NULL,
    
    FOREIGN KEY (ID_User) REFERENCES Users(ID_User),
    FOREIGN KEY (ID_Course) REFERENCES Courses(ID_Course)
);

CREATE TABLE DirectMessages (
	ID_Message					VARCHAR(36) NOT NULL DEFAULT(REPLACE(UUID(), '-', 'M')) PRIMARY KEY,
    Message_Status 				BIT DEFAULT 1 NOT NULL,
    Register_Date				DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    
    ID_Transmitter				INT UNSIGNED NOT NULL,
    ID_Receiver					INT UNSIGNED NOT NULL,
    
    Message 					TEXT NOT NULL,
    
    FOREIGN KEY (ID_Transmitter) REFERENCES Users(ID_User),
	FOREIGN KEY (ID_Receiver) REFERENCES Users(ID_User)
);