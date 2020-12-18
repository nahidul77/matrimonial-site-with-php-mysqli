<div class="notification-box" >
    <div class="msg-sidebar notifications msg-noti" >
        <div class="topnav-dropdown-header">
            <span>Messages</span>
        </div>
        <div class="drop-scroll msg-list-scroll" id="msg_list">
            <ul class="list-box" id="message">
                <?php
                $mn = $server->message_notification();
                if ($mn->num_rows > 0) {
                    while ($row = $mn->fetch_assoc()) {
                        ?>
                        <li>
                            <a href="chat.php?message_to=<?php echo $row['notification_from'] ?>">
                                <div class="list-item">
                                    <div class="list-left">
                                        <span class="avatar">
                                            <img src="<?php echo $server->clientIamge_byID($row['notification_from']) ?>"  />
                                        </span>
                                    </div>
                                    <div class="list-body">
                                        <span class="message-author"><?php echo $server->clientName_byID($row['notification_from']) ?></span>
                                        <div class="clearfix"></div>
                                        <span class="message-content"><?php echo $row['notification_about'] ?></span>
                                        <small><?php echo $row['notification_time'] ?></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php 
                    }
                }
                ?>

            </ul>
        </div>

    </div>
</div>