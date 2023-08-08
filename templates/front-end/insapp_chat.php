 
<?php 
$user_id = get_current_user_id(); 
$conver_id = $_POST['conversation_id'];    
          
$results = insapp_select_all_conversation($user_id);
$last = insapp_select_last_conversation($user_id);
$last_conversation = $last[0]->id;
$sender_last = $last[0]->sender_id;
$receiver_last = $last[0]->receiver_id;
if(  $user_id == $sender_last){
    $user_last_2 = $receiver_last;
}else{
    $user_last_2 = $sender_last;
}
function fandatestime($daten){
    $date=date_create($daten);
    return date_format($date,"d M Y , H:i");
   }
   function fandtime($daten){
    $date=date_create($daten);
    return date_format($date,"H:i");
   }

?>
 
 
                            <input type="hidden" class="insapp_chat_receiver" value="<?php _e($user_last_2) ?>">
                           <input type="hidden" class="insapp_chat_sender" value="<?php _e($user_id) ?>">

                     
                        <?php 
                        $list_messages = insapp_get_all_message_($conver_id);
                        // var_dump($list_messages);
                        foreach ($list_messages as $list_message ) {
                           
                            $sender_id = $list_message->sender_id;
                            $receiver_id = $list_message->receiver_id;
                            $message = $list_message->smsmessage;
                            $date_ = $list_message->timestamp;
                            $date_time = fandatestime($date_) ; 
                            $time = fandtime($date_); 
                           
                            if($user_id == $sender_id ){  
 
                                $user_info2 = get_userdata($sender_id); 
                                $name2 = $user_info2->display_name;   
                                $profile_photo_url = get_user_meta($sender_id, 'wp_user_avatar', true);
    
                                if ($profile_photo_url) {
                                $user_img2 = $profile_photo_url;
                                } else {
                                 $user_img2 =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                                }
                             ?>
                                

                                <div class="d-flex justify-content-end mb-4">      
                                    <div class="d-flex ">
                                        
                                        <div class=" me-3 text-end">
                                            <small> <?php _e($time) ?></small>
                                            <div class="d-flex">
                                                <div class="me-2 mt-2">
                                                    
                                                    
                                                </div>
                                                
                                                <div class="card mt-2 rounded-top-md-end-0 bg-primary text-white ">
                                                    
                                                    <div class="card-body text-start p-2">
                                                        <p class="mb-0">
                                                        <?php _e($message) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- <img src="<?php //echo $user_img2 ?>" alt="Image"
                                            class="rounded-circle avatar-md"> -->
                                    </div>
                                </div>

                            <?php
                                
                            }else{
                               
                                $user_info2 = get_userdata($sender_id); 
                                $name2 = $user_info2->display_name;   
                                $profile_photo_url = get_user_meta($sender_id, 'wp_user_avatar', true);

                                if ($profile_photo_url) {
                                $user_img2 = $profile_photo_url;
                                } else {
                                $user_img2 =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                                }

                            ?>

                                <div class="d-flex  mb-4">
                                    <!-- <img src="<?php // echo $user_img2 ?>" alt="Image"
                                        class="rounded-circle avatar-md user-avatar"> -->
                                    
                                    <div class=" ms-3">
                                        <small><span class="username"><?php _e($name2) ?></span> , <?php _e($time) ?></small>
                                        <div class="d-flex">
                                            <div class="card mt-2 rounded-top-md-left-0 border">
                                                <div class="card-body p-2">
                                                    <p class="mb-0 text-dark">
                                                        <?php  _e($message) ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="ms-2 mt-2">
                                                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            <?php }
                         

                        ?>
                            
                            
                           
                        <?php } ?>
                        </div>
 