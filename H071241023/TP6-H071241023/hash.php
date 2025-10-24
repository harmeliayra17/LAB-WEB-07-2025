<?php
echo 'admin: ', password_hash('admin123', PASSWORD_DEFAULT), '<br>';
echo 'manager1: ', password_hash('manager123', PASSWORD_DEFAULT), '<br>';
echo 'manager2: ', password_hash('manager456', PASSWORD_DEFAULT), '<br>';
echo 'manager3: ', password_hash('manager789', PASSWORD_DEFAULT), '<br>';
echo 'member1: ', password_hash('member123', PASSWORD_DEFAULT), '<br>';
echo 'member2: ', password_hash('member456', PASSWORD_DEFAULT), '<br>';
echo 'member3: ', password_hash('member789', PASSWORD_DEFAULT), '<br>';
?>