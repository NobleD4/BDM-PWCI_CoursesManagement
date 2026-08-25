CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_adminusers` AS
    SELECT 
        `db_prueba`.`users`.`ID_User` AS `ID_User`,
        `db_prueba`.`users`.`User_Status` AS `User_Status`,
        `db_prueba`.`users`.`User_Role` AS `User_Role`,
        `db_prueba`.`users`.`Register_Date` AS `Register_Date`,
        `db_prueba`.`users`.`UpdateInfo_Date` AS `UpdateInfo_Date`,
        `db_prueba`.`users`.`Profile_Picture` AS `Profile_Picture`,
        `db_prueba`.`users`.`User_Birthdate` AS `User_Birthdate`,
        `db_prueba`.`users`.`User_Gender` AS `User_Gender`,
        `db_prueba`.`users`.`User_Name` AS `User_Name`,
        `db_prueba`.`users`.`User_LastName` AS `User_LastName`,
        `db_prueba`.`users`.`User_SecondLastName` AS `User_SecondLastName`,
        `db_prueba`.`users`.`User_email` AS `User_email`,
        `db_prueba`.`users`.`User_PasswordAttempts` AS `User_PasswordAttempts`
    FROM
        `db_prueba`.`users`
    WHERE
        (`db_prueba`.`users`.`User_Role` = 3);

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_categories_admin` AS
    SELECT 
        `c`.`ID_Category` AS `ID_Category`,
        CONCAT(`u1`.`User_Name`,
                ' ',
                `u1`.`User_LastName`,
                ' ',
                `u1`.`User_SecondLastName`) AS `Register_User`,
        `c`.`Register_Date` AS `Register_Date`,
        CONCAT(`u2`.`User_Name`,
                ' ',
                `u2`.`User_LastName`,
                ' ',
                `u2`.`User_SecondLastName`) AS `UpdateInfo_User`,
        `c`.`UpdateInfo_Date` AS `UpdateInfo_Date`,
        `c`.`Category_Name` AS `Category_Name`,
        `c`.`Category_Description` AS `Category_Description`
    FROM
        ((`db_prueba`.`category` `c`
        LEFT JOIN `db_prueba`.`users` `u1` ON ((`c`.`ID_RegisterUser` = `u1`.`ID_User`)))
        LEFT JOIN `db_prueba`.`users` `u2` ON ((`c`.`ID_UpdateInfoUser` = `u2`.`ID_User`)))
    ORDER BY `c`.`UpdateInfo_Date`;

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_course_category_extended` AS
    SELECT 
        `cc`.`ID_Course` AS `ID_Course`,
        `c`.`Category_Name` AS `Category_Name`,
        `cc`.`ID_Category` AS `ID_Category`,
        `cc`.`Register_Date` AS `Register_Date`
    FROM
        (`db_prueba`.`course_category` `cc`
        JOIN `db_prueba`.`category` `c` ON ((`cc`.`ID_Category` = `c`.`ID_Category`)));

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_coursecomments` AS
    SELECT 
        `cc`.`ID_Comment` AS `ID_Comment`,
        `cc`.`ID_User` AS `ID_User`,
        `u`.`Profile_Picture` AS `Profile_Picture`,
        CONCAT(`u`.`User_Name`,
                ' ',
                `u`.`User_LastName`,
                IFNULL(CONCAT(' ', `u`.`User_SecondLastName`),
                        '')) AS `Full_User_Name`,
        `cc`.`ID_Course` AS `ID_Course`,
        `cc`.`Register_Date` AS `Register_Date`,
        `uce`.`UserRating` AS `UserRating`,
        `cc`.`Comment_Status` AS `Comment_Status`,
        `cc`.`Comment_Text` AS `Comment_Text`
    FROM
        ((`db_prueba`.`course_comments` `cc`
        JOIN `db_prueba`.`users` `u` ON ((`cc`.`ID_User` = `u`.`ID_User`)))
        JOIN `db_prueba`.`user_courseenrollments` `uce` ON (((`cc`.`ID_User` = `uce`.`ID_User`)
            AND (`cc`.`ID_Course` = `uce`.`ID_Course`))));

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_courserevenues` AS
    SELECT 
        `ulc`.`ID_User` AS `ID_User`,
        CONCAT(`u`.`User_Name`,
                ' ',
                `u`.`User_LastName`,
                ' ',
                `u`.`User_SecondLastName`) AS `Full_Name`,
        `ulc`.`ID_Level` AS `ID_Level`,
        `lc`.`ID_Course` AS `ID_Course`,
        `lc`.`Level_Name` AS `Level_Name`,
        `ulc`.`Beginning_Date` AS `Beginning_Date`,
        `lc`.`Level_Price` AS `Level_Price`,
        (CASE
            WHEN (`ulc`.`Pay_Method` = 1) THEN 'Transferencia'
            WHEN (`ulc`.`Pay_Method` = 2) THEN 'Mastercard'
            WHEN (`ulc`.`Pay_Method` = 3) THEN 'PayPal'
            ELSE 'Desconocido'
        END) AS `Pay_Method`
    FROM
        ((`db_prueba`.`user_levelcourse` `ulc`
        LEFT JOIN `db_prueba`.`levelcourse` `lc` ON ((`ulc`.`ID_Level` = `lc`.`ID_Level`)))
        LEFT JOIN `db_prueba`.`users` `u` ON ((`ulc`.`ID_User` = `u`.`ID_User`)));

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_fullcourse_data` AS
    SELECT 
        `c`.`ID_Course` AS `ID_Course`,
        `c`.`ID_User` AS `ID_User`,
        CONCAT(`u`.`User_Name`,
                ' ',
                `u`.`User_LastName`,
                ' ',
                `u`.`User_SecondLastName`) AS `Creator_Name`,
        `c`.`Course_Status` AS `Number_Status`,
        (CASE
            WHEN (`c`.`Course_Status` = 2) THEN 'ACTIVADO'
            ELSE 'DESACTIVADO'
        END) AS `Course_Status`,
        `c`.`Register_Date` AS `Register_Date`,
        `c`.`UpdateInfo_Date` AS `UpdateInfo_Date`,
        `c`.`Course_Picture` AS `Course_Picture`,
        `c`.`Course_Name` AS `Course_Name`,
        `c`.`Course_Description` AS `Course_Description`,
        FUNC_COURSE_TOTALLEVELS(`l`.`ID_Course`) AS `Course_TotalLevels`,
        FUNC_COURSETOTAL_VOTES(`l`.`ID_Course`) AS `Total_Votes`,
        FUNC_COURSEAVERAGERATING(`l`.`ID_Course`) AS `AverageRating`,
        (CASE
            WHEN (FUNC_FULLCOURSE_PRICE(`l`.`ID_Course`) = 0) THEN 'GRATIS'
            ELSE CONCAT('$ ',
                    CONVERT( FUNC_FULLCOURSE_PRICE(`l`.`ID_Course`) USING UTF8MB4),
                    ' MXN')
        END) AS `FullCourse_Price`,
        FUNC_FULLCOURSE_ONELEVELBOUGHT(`l`.`ID_Course`) AS `FullCourse_OneLevelBought`,
        FUNC_FULLCOURSE_TIMESBOUGHT(`l`.`ID_Course`) AS `FullCourse_TimesBought`
    FROM
        ((`db_prueba`.`courses` `c`
        LEFT JOIN `db_prueba`.`levelcourse` `l` ON ((`c`.`ID_Course` = `l`.`ID_Course`)))
        LEFT JOIN `db_prueba`.`users` `u` ON ((`c`.`ID_User` = `u`.`ID_User`)))
    GROUP BY `c`.`ID_Course` , `c`.`Course_Name` , `u`.`User_Name` , `u`.`User_LastName` , `u`.`User_SecondLastName`;

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_fullcourseenrollments_data` AS
    SELECT 
        `enrollments`.`ID_User` AS `Enrolled_UserID`,
        `db_prueba`.`courses`.`ID_Course` AS `ID_Course`,
        `db_prueba`.`courses`.`ID_User` AS `ID_User`,
        CONCAT(`db_prueba`.`users`.`User_Name`,
                ' ',
                `db_prueba`.`users`.`User_LastName`,
                ' ',
                `db_prueba`.`users`.`User_SecondLastName`) AS `Creator_Name`,
        `db_prueba`.`courses`.`Course_Status` AS `Number_Status`,
        (CASE
            WHEN (`db_prueba`.`courses`.`Course_Status` = 2) THEN 'ACTIVADO'
            ELSE 'DESACTIVADO'
        END) AS `Course_Status`,
        `db_prueba`.`courses`.`Register_Date` AS `Register_Date`,
        `db_prueba`.`courses`.`UpdateInfo_Date` AS `UpdateInfo_Date`,
        `db_prueba`.`courses`.`Course_Picture` AS `Course_Picture`,
        `db_prueba`.`courses`.`Course_Name` AS `Course_Name`,
        `db_prueba`.`courses`.`Course_Description` AS `Course_Description`,
        FUNC_COURSE_TOTALLEVELS(`db_prueba`.`courses`.`ID_Course`) AS `Course_TotalLevels`,
        FUNC_COURSETOTAL_VOTES(`db_prueba`.`courses`.`ID_Course`) AS `Total_Votes`,
        FUNC_COURSEAVERAGERATING(`db_prueba`.`courses`.`ID_Course`) AS `AverageRating`,
        (CASE
            WHEN (FUNC_FULLCOURSE_PRICE(`db_prueba`.`courses`.`ID_Course`) = 0) THEN 'GRATIS'
            ELSE CONCAT('$ ',
                    CONVERT( FUNC_FULLCOURSE_PRICE(`db_prueba`.`courses`.`ID_Course`) USING UTF8MB4),
                    ' MXN')
        END) AS `FullCourse_Price`,
        FUNC_FULLCOURSE_TIMESBOUGHT(`db_prueba`.`courses`.`ID_Course`) AS `FullCourse_TimesBought`,
        `enrollments`.`Course_Status` AS `Enrollment_Status`,
        `enrollments`.`Beginning_Date` AS `Beginning_Date`,
        `enrollments`.`Completion_Date` AS `Completion_Date`,
        `enrollments`.`UserRating` AS `UserRating`,
        `enrollments`.`Rating_Date` AS `Rating_Date`
    FROM
        ((`db_prueba`.`user_courseenrollments` `enrollments`
        JOIN `db_prueba`.`courses` ON ((`enrollments`.`ID_Course` = `db_prueba`.`courses`.`ID_Course`)))
        JOIN `db_prueba`.`users` ON ((`db_prueba`.`courses`.`ID_User` = `db_prueba`.`users`.`ID_User`)));

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_generalrevenues` AS
    SELECT 
        `c`.`ID_Course` AS `ID_Course`,
        `c`.`ID_User` AS `ID_User`,
        `c`.`Course_Status` AS `Number_Status`,
        (CASE
            WHEN (`c`.`Course_Status` = 2) THEN 'ACTIVADO'
            ELSE 'DESACTIVADO'
        END) AS `Course_Status`,
        `c`.`Course_Name` AS `Course_Name`,
        `c`.`Register_Date` AS `Register_Date`,
        `c`.`UpdateInfo_Date` AS `UpdateInfo_Date`,
        FUNC_FULLCOURSE_MOSTBOUGHTLEVEL(`c`.`ID_Course`) AS `MostBought_Level`,
        `lc`.`Level_Name` AS `Level_Name`,
        FUNC_FULLCOURSE_ONELEVELBOUGHT(`c`.`ID_Course`) AS `Total_Students`,
        FUNC_FULLCOURSE_REVENUE_PAYMETHOD(`c`.`ID_Course`, 1) AS `Transfer_Revenue`,
        FUNC_FULLCOURSE_REVENUE_PAYMETHOD(`c`.`ID_Course`, 2) AS `Mastercard_Revenue`,
        FUNC_FULLCOURSE_REVENUE_PAYMETHOD(`c`.`ID_Course`, 3) AS `PayPal_Revenue`,
        FUNC_FULLCOURSE_TOTALREVENUE(`c`.`ID_Course`) AS `Total_Revenue`
    FROM
        (`db_prueba`.`courses` `c`
        LEFT JOIN `db_prueba`.`levelcourse` `lc` ON ((`lc`.`ID_Level` = FUNC_FULLCOURSE_MOSTBOUGHTLEVEL(`c`.`ID_Course`))));

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_instructorreport` AS
    SELECT 
        `db_prueba`.`users`.`ID_User` AS `ID_User`,
        CONCAT(`db_prueba`.`users`.`User_Name`,
                ' ',
                `db_prueba`.`users`.`User_LastName`,
                ' ',
                `db_prueba`.`users`.`User_SecondLastName`) AS `Full_Name`,
        `db_prueba`.`users`.`Register_Date` AS `Register_Date`,
        FUNC_TOTALOFFEREDCOURSES(`db_prueba`.`users`.`ID_User`) AS `TotalOfferedCourses`,
        FUNC_INSTRUCTORTOTALREVENUE(`db_prueba`.`users`.`ID_User`) AS `InstructorTotalRevenue`
    FROM
        `db_prueba`.`users`
    WHERE
        (`db_prueba`.`users`.`User_Role` = 2);

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_instructorreport` AS
    SELECT 
        `db_prueba`.`users`.`ID_User` AS `ID_User`,
        CONCAT(`db_prueba`.`users`.`User_Name`,
                ' ',
                `db_prueba`.`users`.`User_LastName`,
                ' ',
                `db_prueba`.`users`.`User_SecondLastName`) AS `Full_Name`,
        `db_prueba`.`users`.`Register_Date` AS `Register_Date`,
        FUNC_TOTALOFFEREDCOURSES(`db_prueba`.`users`.`ID_User`) AS `TotalOfferedCourses`,
        FUNC_INSTRUCTORTOTALREVENUE(`db_prueba`.`users`.`ID_User`) AS `InstructorTotalRevenue`
    FROM
        `db_prueba`.`users`
    WHERE
        (`db_prueba`.`users`.`User_Role` = 2);

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`view_studentusers` AS
    SELECT 
        `db_prueba`.`users`.`ID_User` AS `ID_User`,
        `db_prueba`.`users`.`User_Status` AS `User_Status`,
        `db_prueba`.`users`.`User_Role` AS `User_Role`,
        `db_prueba`.`users`.`Register_Date` AS `Register_Date`,
        `db_prueba`.`users`.`UpdateInfo_Date` AS `UpdateInfo_Date`,
        `db_prueba`.`users`.`Profile_Picture` AS `Profile_Picture`,
        `db_prueba`.`users`.`User_Birthdate` AS `User_Birthdate`,
        `db_prueba`.`users`.`User_Gender` AS `User_Gender`,
        `db_prueba`.`users`.`User_Name` AS `User_Name`,
        `db_prueba`.`users`.`User_LastName` AS `User_LastName`,
        `db_prueba`.`users`.`User_SecondLastName` AS `User_SecondLastName`,
        `db_prueba`.`users`.`User_email` AS `User_email`,
        `db_prueba`.`users`.`User_PasswordAttempts` AS `User_PasswordAttempts`
    FROM
        `db_prueba`.`users`
    WHERE
        (`db_prueba`.`users`.`User_Role` = 1);

CREATE
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `db_prueba`.`VIEW_PreviewRecentChat` AS
SELECT
    GREATEST(DM.ID_Transmitter, DM.ID_Receiver) AS ID_UserA,
    MAX(UA.Profile_Picture),
    MAX(CONCAT(
        UA.User_Name, ' ',
        UA.User_LastName, ' ', COALESCE(UA.User_SecondLastName, '')
        )) AS UserA_FullName,
    LEAST(DM.ID_Transmitter, DM.ID_Receiver) AS ID_UserB,
    MAX(UB.Profile_Picture), MAX(CONCAT(
        UB.User_Name, ' ',
        UB.User_LastName, ' ',
        COALESCE(UB.User_SecondLastName, '')
        )) AS UserB_FullName,
    MAX(DM.Register_Date) AS LastDate
FROM
    DirectMessages DM
JOIN Users UA ON UA.ID_User = GREATEST(DM.ID_Transmitter, DM.ID_Receiver)
JOIN Users UB ON UB.ID_User = LEAST(DM.ID_Transmitter, DM.ID_Receiver)
GROUP BY
    ID_UserA, ID_UserB;