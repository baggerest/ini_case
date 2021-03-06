<?php
if(strpos($_SERVER['HTTP_USER_AGENT'],"Chrome")=="") die("Not Chrome Google Browser System.");

$main_folder = "";
switch ($_ENV['COMPUTERNAME']) {
    case 'DESKTOP-6OVHJN1':
        $main_folder = "C:/my/rathena_20180819/conf/";
        break;
    case 'ZOKU':
        $main_folder = "D:/rathena_20180819/conf/";
        break;
    default:
        $main_folder = "";
        break;
}

if(!is_dir($main_folder)) die("&Prime;$main_folder&Prime; does not exist.");

$read_conf_list = array(
    0 => "battle_athena.conf",
    1 => "char_athena.conf",
    2 => "inter_athena.conf",
    3 => "log_athena.conf",
    4 => "login_athena.conf",
    5 => "map_athena.conf",
    6 => "packet_athena.conf",
    7 => "script_athena.conf",
    8 => "battle/battle.conf",
    9 => "battle/battleground.conf",
    10 => "battle/client.conf",
    11 => "battle/drops.conf",
    12 => "battle/exp.conf",
    13 => "battle/feature.conf",
    14 => "battle/gm.conf",
    15 => "battle/guild.conf",
    16 => "battle/homunc.conf",
    17 => "battle/items.conf",
    18 => "battle/misc.conf",
    19 => "battle/monster.conf",
    20 => "battle/party.conf",
    21 => "battle/pet.conf",
    22 => "battle/player.conf",
    23 => "battle/skill.conf",
    24 => "battle/status.conf",
);

$save_txt = array(
    0 => "import/battle_conf.txt",
    1 => "import/char_conf.txt",
    2 => "import/inter_conf.txt",
    3 => "import/log_conf.txt",
    4 => "import/login_conf.txt",
    5 => "import/map_conf.txt",
    6 => "import/packet_conf.txt",
    7 => "import/script_conf.txt",
);

$save_txt_ = array(
    $read_conf_list[0] => $save_txt[0],
    $read_conf_list[1] => $save_txt[1],
    $read_conf_list[2] => $save_txt[2],
    $read_conf_list[3] => $save_txt[3],
    $read_conf_list[4] => $save_txt[4],
    $read_conf_list[5] => $save_txt[5],
    $read_conf_list[6] => $save_txt[6],
    $read_conf_list[7] => $save_txt[7],
    $read_conf_list[8] => $save_txt[0],
    $read_conf_list[9] => $save_txt[0],
    $read_conf_list[10] => $save_txt[0],
    $read_conf_list[11] => $save_txt[0],
    $read_conf_list[12] => $save_txt[0],
    $read_conf_list[13] => $save_txt[0],
    $read_conf_list[14] => $save_txt[0],
    $read_conf_list[15] => $save_txt[0],
    $read_conf_list[16] => $save_txt[0],
    $read_conf_list[17] => $save_txt[0],
    $read_conf_list[18] => $save_txt[0],
    $read_conf_list[19] => $save_txt[0],
    $read_conf_list[20] => $save_txt[0],
    $read_conf_list[21] => $save_txt[0],
    $read_conf_list[22] => $save_txt[0],
    $read_conf_list[23] => $save_txt[0],
    $read_conf_list[24] => $save_txt[0],
);

$remove_file = array(
    0 => "atcommand_athena.conf",
    1 => "channels.conf",
    2 => "groups.conf",
    3 => "inter_server.conf",
    4 => "maps_athena.conf",
    5 => "subnet_athena.conf",
);

$td_height_px = 27;
$symbol = "&prime;";
$dsymbol = "&Prime;";
$conf_set = 'darkgray';
$show_set_font_color = '#ffffff';
$show_set_border_color = 'darkgreen';
$th_font_size = 20;
$th_font_color = '#000000';
$th_back_color = '#BDB885';
$version = "v1.0 by baggerest © 2017.6";