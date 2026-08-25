<?php
  include './DB_Config.php';

  $id_user = $_SESSION['ID_User'];

  $sql = "CALL SP_CourseManagement(
  -2,      -- IN pSP_Action
      
  NULL,   -- IN pID_Course
  ?,      -- IN PID_User
  NULL,   -- IN pCourse_Picture
  NULL,   -- IN pCourse_Name
  NULL    -- IN pCourse_Description
  )";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_user);
  $stmt->execute();
  $result2 = $stmt->get_result();
?>

<div class="dropdownganancias">
    <label for="dropbtnganancias">Escoja un curso</label>
    <select class="dropbtnganancias" onchange="openWindow('window9', this.value)">
        <option value="" disabled selected>Seleccione un curso</option>
        <?php
            while ($course = $result2->fetch_assoc()) {
        ?>
        <option value="<?php echo ($course['ID_Course']);?>"><?php echo ($course['Course_Name']);?></option>
        <?php
            }
        ?>
    </select>
</div>