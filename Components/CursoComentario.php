<div class="carousel-item active">
    <div class="testimonial">
        <div class="testimonial-header">
            <img src="<?php echo isset($comment['Profile_Picture']) ? 'data:image/jpeg;base64,' . base64_encode($comment['Profile_Picture']) : 'https://i.pinimg.com/564x/cb/81/27/cb8127cba8860d645bbe0cfb07ef0759.jpg'; ?>"
            alt="Foto del usuario"
            id="profilePicture"
            class="avatar">
            <div>
                <h3><?php echo ($comment['Full_User_Name']); ?></h3>
                <span><?php echo ($comment['Register_Date']); ?></span>
            </div>

        </div>

        <p><?php echo ($comment['Comment_Text']); ?></p>
        
        <div class="rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="fa fa-star <?= $i <= ($comment['UserRating']) ? 'checked' : ''; ?>"></span>
            <?php endfor; ?>
        </div>
    </div>
</div>