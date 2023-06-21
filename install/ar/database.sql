
CREATE TABLE `members` (
  `uid` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `cant` varchar(255) NOT NULL,
  `lastlogin` varchar(255) NOT NULL,
  `signt` text NOT NULL,
  `totla_ps` int(11) NOT NULL,
  `sig_data` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usertitle` int(11) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `total_posts` int(11) NOT NULL,
  `out` int(11) NOT NULL,
  `retitle` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `moder_title` varchar(255) NOT NULL,
  `moder_gid` int(11) NOT NULL,
  `your_style` int(11) NOT NULL,
  `option_getpm` int(11) NOT NULL,
  `option_getgm` int(11) NOT NULL,
  `option_online` int(11) NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `members`
-- 

-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_announcements`
-- 

CREATE TABLE `phpforyou_announcements` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `u_id` int(11) NOT NULL,
  `in` varchar(50) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `views` int(11) default NULL,
  `u_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_announcements`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_attachments`
-- 

CREATE TABLE `phpforyou_attachments` (
  `aid` int(11) NOT NULL auto_increment,
  `a_uid` int(11) NOT NULL,
  `a_name` varchar(255) NOT NULL,
  `a_type` varchar(255) NOT NULL,
  `a_size` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  PRIMARY KEY  (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_attachments`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_contact`
-- 

CREATE TABLE `phpforyou_contact` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `msg` text NOT NULL,
  `data` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_contact`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_friends`
-- 

CREATE TABLE `phpforyou_friends` (
  `id` int(11) NOT NULL auto_increment,
  `friend_uid` varchar(255) NOT NULL,
  `friend_active` varchar(255) NOT NULL,
  `friend_name` varchar(255) NOT NULL,
  `friend_id` varchar(255) NOT NULL,
  `friend_date` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_friends`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_groups`
-- 

CREATE TABLE `phpforyou_groups` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `style` varchar(900) NOT NULL,
  `name` varchar(255) NOT NULL,
  `out` int(11) NOT NULL,
  `add_topic` int(11) NOT NULL,
  `add_post` int(11) NOT NULL,
  `edit_topic` int(11) NOT NULL,
  `edit_post` int(11) NOT NULL,
  `delete_topic` int(11) NOT NULL,
  `delete_post` int(11) NOT NULL,
  `send_pm` int(11) NOT NULL,
  `attach_up` int(11) NOT NULL,
  `view_forums` int(11) NOT NULL,
  `view_topics` int(11) NOT NULL,
  `attach_down` int(11) NOT NULL,
  `mod_edit` int(11) NOT NULL,
  `mod_delete` int(11) NOT NULL,
  `mod_move` int(11) NOT NULL,
  `mod_sticky` int(11) NOT NULL,
  `view_online` int(11) NOT NULL,
  `view_memberlist` int(11) NOT NULL,
  `show_in_online` int(11) NOT NULL,
  `mod_close` int(11) NOT NULL,
  `rename` int(11) NOT NULL,
  `search` int(11) NOT NULL default '1',
  `script` int(11) NOT NULL,
  `is_mod` int(11) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `view_profile` int(11) NOT NULL default '1',
  `view_userip` int(11) NOT NULL default '0',
  `rigester` int(11) NOT NULL default '1',
  `admin_title` int(11) NOT NULL,
  `admin_tools` int(11) NOT NULL,
  `admin_members` int(11) NOT NULL,
  `admin_hacks` int(11) NOT NULL,
  `admin_icons` int(11) NOT NULL,
  `admin_smiles` int(11) NOT NULL,
  `admin_styles` int(11) NOT NULL,
  `admin_sections` int(11) NOT NULL,
  `admin_setting` int(11) NOT NULL,
  `admin_filem` int(11) NOT NULL,
  `admin_theards` int(11) NOT NULL,
  `admin_groups` int(11) NOT NULL,
  `admin_portal` int(11) NOT NULL,
  `admin_inputs` int(11) NOT NULL,
  `admin_langs` int(11) NOT NULL,
  `view_portal` int(11) NOT NULL,
  `view_selftopics` int(11) NOT NULL,
  `admin_pages` int(11) NOT NULL,
  `admin_ancs` int(11) NOT NULL,
  `mod_merge` int(11) NOT NULL,
  `mod_recy` int(11) NOT NULL,
  `view_getpage` int(11) NOT NULL,
  `theards_rating` int(11) NOT NULL,
  `tell_freind` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `show_in_online` (`show_in_online`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_groups`
-- 

INSERT INTO `phpforyou_groups` VALUES (1, 'الزوار', '<span color=\"#000\">{name}</span>', 'زائر', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 1);
INSERT INTO `phpforyou_groups` VALUES (2, 'الأعضاء', '<span style=\"color:#0000ff\">{name}</span>', 'عضو', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1);
INSERT INTO `phpforyou_groups` VALUES (3, 'الإداريين', '<span style=\"color:#f00;background:#fff;\">{name}</span>', 'المدير العام', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `phpforyou_groups` VALUES (4, 'المراقبين', '<span style=\"color:green;\">{name}</span>', 'المراقب العام', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `phpforyou_groups` VALUES (5, 'المشرفين', '<span style=\"color:#c00; background:#fff;\">{name}</span>', 'مشرف', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1);
INSERT INTO `phpforyou_groups` VALUES (6, 'المحظورين', '<span style=\"color:#000;text-decoration:line-through;\">{name}</span>', 'محظور', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `phpforyou_groups` VALUES (7, 'بإنتظار التفعيل', '<span style=\"color:#ccc\">{name}</span>', 'بإنتظار التفعيل', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_hacks`
-- 

CREATE TABLE `phpforyou_hacks` (
  `block_id` int(11) NOT NULL auto_increment,
  `block_title` varchar(255) NOT NULL,
  `block_code` text NOT NULL,
  `hack_option` text NOT NULL,
  `filedir` varchar(255) NOT NULL,
  `is_actived` int(11) NOT NULL,
  `hack_other` varchar(2500) NOT NULL,
  `hack_ver` varchar(250) NOT NULL,
  `hack_url` varchar(250) NOT NULL,
  PRIMARY KEY  (`block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_hacks`
-- 


-- --------------------------------------------------------


-- 
-- بنية الجدول `phpforyou_icons`
-- 

CREATE TABLE `phpforyou_icons` (
  `icon_id` int(11) NOT NULL auto_increment,
  `icon_title` varchar(255) NOT NULL,
  `icon_url` varchar(255) NOT NULL,
  PRIMARY KEY  (`icon_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_icons`
-- 

INSERT INTO `phpforyou_icons` VALUES (1, 'bell', 'images/icons/bell.gif');
INSERT INTO `phpforyou_icons` VALUES (2, 'video', 'images/icons/video.gif');
INSERT INTO `phpforyou_icons` VALUES (3, 'info', 'images/icons/exclamation.gif');
INSERT INTO `phpforyou_icons` VALUES (4, 'star', 'images/icons/star.gif');
INSERT INTO `phpforyou_icons` VALUES (5, 'wink', 'images/icons/wink.gif');
INSERT INTO `phpforyou_icons` VALUES (6, 'heart', 'images/icons/heart.gif');
INSERT INTO `phpforyou_icons` VALUES (7, 'lightning', 'images/icons/lightning.gif');
INSERT INTO `phpforyou_icons` VALUES (8 'thumbsdown', 'images/icons/thumbsdown.gif');
INSERT INTO `phpforyou_icons` VALUES (9 'biggrin', 'images/icons/biggrin.gif');
INSERT INTO `phpforyou_icons` VALUES (10 'sad', 'images/icons/sad.gif');

-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_infosite`
-- 

CREATE TABLE `phpforyou_infosite` (
  `title` varchar(255) NOT NULL,
  `meta` varchar(255) NOT NULL,
  `close_do` int(11) NOT NULL,
  `close_msg` varchar(255) NOT NULL,
  `style_id` int(11) NOT NULL,
  `sig_html` int(11) NOT NULL,
  `sig_pass` int(11) NOT NULL,
  `post_html` int(11) NOT NULL,
  `post_usicon` varchar(255) NOT NULL,
  `user_pm` int(11) NOT NULL,
  `register` int(11) NOT NULL,
  `page_forum` int(11) NOT NULL,
  `sig_title` int(11) NOT NULL,
  `post_fast` int(11) NOT NULL,
  `cat_usicon` varchar(255) NOT NULL,
  `replace_words` text NOT NULL,
  `wavatar` int(11) NOT NULL,
  `havatar` int(11) NOT NULL,
  `wicon` int(11) NOT NULL,
  `hicon` int(11) NOT NULL,
  `topics_sort` varchar(255) NOT NULL,
  `types` text NOT NULL,
  `attach_size` int(11) NOT NULL,
  `attach_do` int(11) NOT NULL,
  `admin_msg` text NOT NULL,
  `avatar_up_size` int(11) NOT NULL,
  `delete_avatar` int(11) NOT NULL,
  `page_posts` int(11) NOT NULL,
  `page_online` int(11) NOT NULL,
  `page_members` int(11) NOT NULL,
  `page_attachments` int(11) NOT NULL,
  `pblocks_order` varchar(255) NOT NULL,
  `register_group` int(11) NOT NULL,
  `actived_group` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active_do` int(11) NOT NULL default '1',
  `language` int(11) NOT NULL,
  `signup_data` varchar(255) NOT NULL,
  `datatype` varchar(255) NOT NULL,
  `timetype` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_infosite`
-- 

INSERT INTO `phpforyou_infosite` VALUES ('Easy Forum', 'Easy Forum', 1, 'Text',1, 1, 5, 1, 'images/default_post.gif', 1, 1, 4, 0, 1, 'images/default_icon.png', 'xss\r|root', 135, 125, 65, 56, 'DESC', 'png|psd|zip|jpeg|gif', 1024000, 1, 'Admin Content', 2147483647, 1, 5, 10, 2, 10, 'DESC', 2, 2, 'http://localhost', 'php4u@hotmail.com', 0, 1, 'M Y', 'm-d-Y', 'h:i A');

-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_inputs`
-- 

CREATE TABLE `phpforyou_inputs` (
  `input_id` int(11) NOT NULL auto_increment,
  `input_type` varchar(255) NOT NULL,
  `input_value` text NOT NULL,
  `input_strings` text NOT NULL,
  `input_name` varchar(255) NOT NULL,
  `input_order` int(11) NOT NULL default '0',
  `input_view` int(11) NOT NULL,
  `input_exists` int(11) NOT NULL,
  `input_edit` int(11) NOT NULL default '0',
  PRIMARY KEY  (`input_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_inputs`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_languages`
-- 

CREATE TABLE `phpforyou_languages` (
  `lang_id` int(11) NOT NULL auto_increment,
  `lang_name` varchar(255) NOT NULL,
  `lang_folder` varchar(255) NOT NULL,
  PRIMARY KEY  (`lang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_languages`
-- 

INSERT INTO `phpforyou_languages` VALUES (1, 'Arabic', 'ar');
INSERT INTO `phpforyou_languages` VALUES (2, 'English', 'eng');

-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_moderators`
-- 


CREATE TABLE `phpforyou_moderators` (
  `id` int(11) NOT NULL auto_increment,
  `section_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `edit` int(11) NOT NULL,
  `delete` int(11) NOT NULL,
  `move` int(11) NOT NULL,
  `sticky` int(11) NOT NULL,
  `merge` int(11) NOT NULL,
  `close` int(11) NOT NULL,
  `recy` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_moderators`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_moderlogs`
-- 

CREATE TABLE `phpforyou_moderlogs` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `theard_id` int(11) NOT NULL,
  `do` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_moderlogs`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_names`
-- 

CREATE TABLE `phpforyou_names` (
  `name_id` int(11) NOT NULL auto_increment,
  `user_title` varchar(255) NOT NULL,
  `user_star` varchar(255) NOT NULL,
  `user_post` int(11) NOT NULL,
  PRIMARY KEY  (`name_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_names`
-- 

INSERT INTO `phpforyou_names` VALUES (1, 'عضو جديد', 'images/stars/1Star.gif', 10);
INSERT INTO `phpforyou_names` VALUES (2, 'المدير العام', 'images/stars/7Star.gif', 0);

-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_online`
-- 

CREATE TABLE `phpforyou_online` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `where` varchar(255) NOT NULL,
  `lastmove_time` varchar(255) NOT NULL,
  `f_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_online`
-
-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_pages`
-- 

CREATE TABLE `phpforyou_pages` (
  `page_id` int(11) NOT NULL auto_increment,
  `page_name` varchar(255) NOT NULL,
  `page_views` int(11) NOT NULL,
  `page_text` text NOT NULL,
  `page_active` int(11) NOT NULL,
  `page_time` int(11) NOT NULL,
  `page_date` varchar(255) NOT NULL,
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_pages`
-- 

INSERT INTO `phpforyou_pages` VALUES (1, 'الإحصائيات', 0, '<div class=\"text\">عدد المواضيع الكلي : <?php print TotalTopics(); ?></div>\r\n<div class=\"text\">عدد المشاركات الكلي : <?php print TotalPosts(); ?></div>\r\n<div class=\"text\">عدد الأعضاء الكلي : <?php print TotalUsers(); ?></div>\r\n<div class=\"text\">اخر عضو مسجل : <?php print LastUser(); ?></div>\r\n<div class=\"text\">الأعضاء المتواجدون : <?php print \r\n$eaf->online->OnlineUsers(); ?></div>\r\n<div class=\"text\">الزوار المتواجدون : <?php print $eaf->online->OnlineGuest(); ?></div>\r\n<br />\r\n<?php $LIGQUERYS = $eaf->db->query(\"select * from `members` where `totla_ps` != 0 order by `totla_ps` desc limit 10\"); ?>\r\n<table style=\"width:50%; margin-left:auto; margin-right:auto;\">\r\n<tr>\r\n<td class=\"Tabletitle\" colspan=\"2\">أفضل عضو من حيث المواضيع</td>\r\n</tr>\r\n<tr>\r\n<td class=\"tool\">إسم المستخدم</td>\r\n<td class=\"tool\">عدد المواضيع</td>\r\n</tr>\r\n<?php while($LIGQUERYROWS = $eaf->db->_object($LIGQUERYS)): ?>\r\n<tr>\r\n<td><a href=\"?action=profile=<?php print $LIGQUERYROWS->uid; ?>\"><?php print $LIGQUERYROWS->username; ?></a></td>\r\n<td><?php print $LIGQUERYROWS->totla_ps; ?></td>\r\n</tr>\r\n<? endwhile; ?>\r\n</table>\r\n<br />\r\n<?php $LIXGQUERYS = $eaf->db->query(\"select * from `members` where `total_posts` != 0 order by `total_posts` desc limit 10\"); ?>\r\n<table style=\"width:50%; margin-left:auto; margin-right:auto;\">\r\n<tr>\r\n<td class=\"Tabletitle\" colspan=\"2\">أفضل عضو من حيث المشاركات</td>\r\n</tr>\r\n<tr>\r\n<td class=\"tool\">إسم إسم المستخدم</td>\r\n<td class=\"tool\">عدد المشاركات</td>\r\n</tr>\r\n<?php while($LIXGQUERYROWS = $eaf->db->_object($LIXGQUERYS)): ?>\r\n<tr>\r\n<td><a href=\"?action=profile=<?php print $LIXGQUERYROWS->uid; ?>\"><?php print $LIXGQUERYROWS->username; ?></a></td>\r\n<td><?php print $LIXGQUERYROWS->total_posts; ?></td>\r\n</tr>\r\n<? endwhile; ?>\r\n</table>\r\n', 0, 1316963786, '09-25-2011 , 10:16 AM');

-- --------------------------------------------------------


CREATE TABLE `phpforyou_pblocks` (
  `block_id` int(11) NOT NULL auto_increment,
  `block_title` varchar(255) NOT NULL,
  `block_content` text NOT NULL,
  `block_active` varchar(255) NOT NULL,
  `block_sort` int(11) NOT NULL default '0',
  `block_where` varchar(255) NOT NULL,
  PRIMARY KEY  (`block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_pblocks`
-- 

INSERT INTO `phpforyou_pblocks` VALUES (1, 'أقسام الموقع', '<?php print ForumsMenu(); ?>', 'yes', 1, '1');
INSERT INTO `phpforyou_pblocks` VALUES (2, 'الساعة', '<center>\r\n<object type={ReplaceArowa}application/x-shockwave-flash{ReplaceArowa}\r\n data={ReplaceArowa}http://edmullen.net/flash/relog.swf{ReplaceArowa}\r\n width={ReplaceArowa}200{ReplaceArowa} height={ReplaceArowa}200{ReplaceArowa}>\r\n<param name={ReplaceArowa}movie{ReplaceArowa} value={ReplaceArowa}http://edmullen.net/flash/relog.swf{ReplaceArowa}>\r\n<param name={ReplaceArowa}WMode{ReplaceArowa} value={ReplaceArowa}Transparent{ReplaceArowa}>\r\n</object>\r\n</center>', 'yes', 2, '1');
INSERT INTO `phpforyou_pblocks` VALUES (3, 'المتواجدون الان', 'الأعضاء : \r\n<?php print $eaf->online->OnlineUsers(); ?> , الزوار : \r\n<?php print $eaf->online->OnlineGuest(); ?> ', 'yes', 1, '2');
INSERT INTO `phpforyou_pblocks` VALUES (4, 'الأحصائيات', 'المواضيع : <?php print TotalTopics(); ?>\r\n,\r\nالمشاركات  : <?php print TotalPosts(); ?>\r\n,\r\nالأعضاء  : <?php print TotalUsers(); ?>', 'yes', 2, '2');
INSERT INTO `phpforyou_pblocks` VALUES (5, 'أفضل أعضاء', '<?php\r\nfunction GetTopUser($By){\r\n\r\n	global $eaf;\r\n	\r\n	$Query = $eaf->db->query({ReplaceArowa}select username,uid from members order by $By desc limit 1{ReplaceArowa});\r\n	\r\n	$Rows  = $eaf->db->_object($Query);\r\n	\r\n	return {ReplaceArowa}<a href=\\{ReplaceArowa}?profile&uid=$Rows->uid\\{ReplaceArowa}>$Rows->username</a>{ReplaceArowa};	\r\n}\r\n?>\r\n<p>أفضل كاتب للمواضيع : <?php print \r\nGetTopUser({ReplaceArowa}totla_ps{ReplaceArowa}); ?></p>\r\n<p>افضل كاتب للمشاركات : <?php print GetTopUser({ReplaceArowa}total_posts{ReplaceArowa}); ?></p>', 'yes', 3, '2');
INSERT INTO `phpforyou_pblocks` VALUES (6, 'جديد المواضيع', '<?php\r\n$GetLastTopicsMenu = $eaf->db->query({ReplaceArowa}select * from {ReplaceArowa} . tablenamestart({ReplaceArowa}topics{ReplaceArowa}) . {ReplaceArowa} order by tid desc limit 20{ReplaceArowa});\r\n	print {ReplaceArowa}\\n<ol>\\n{ReplaceArowa};\r\n	while($RowsGetLastTopicsMenu = $eaf->db->_object($GetLastTopicsMenu)) : \r\n	\r\n		print {ReplaceArowa}\\n<li><a href=\\{ReplaceArowa}?showtheard&tid=$RowsGetLastTopicsMenu->tid\\{ReplaceArowa} title=\\{ReplaceArowa}{ReplaceArowa}.substr(strip_tags(GetBbCode($RowsGetLastTopicsMenu->text)),0,250).{ReplaceArowa}\\{ReplaceArowa}>$RowsGetLastTopicsMenu->title</a></li>\\n{ReplaceArowa};\r\n\r\n	endwhile;\r\n	print {ReplaceArowa}\\n </ol>\\n{ReplaceArowa};\r\n?>', 'yes', 1, '3');


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_pm`
-- 

CREATE TABLE `phpforyou_pm` (
  `sid` int(11) NOT NULL auto_increment,
  `stitle` varchar(255) NOT NULL,
  `sdata` varchar(255) NOT NULL,
  `sfrom` varchar(255) NOT NULL,
  `sact` varchar(255) NOT NULL,
  `smsg` text NOT NULL,
  `s_uid` int(11) NOT NULL,
  `s_fname` varchar(255) NOT NULL,
  `admin_view` int(11) NOT NULL default '0',
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_pm`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_posts`
-- 

CREATE TABLE `phpforyou_posts` (
  `pid` int(11) NOT NULL auto_increment,
  `t_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,

  `u_id` int(11) NOT NULL,
  `ptitle` varchar(255) NOT NULL,
  `pdata` varchar(255) NOT NULL,
  `pusername` varchar(255) NOT NULL,
  `ptext` text NOT NULL,
  `picon` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_posts`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_reputation`
-- 

CREATE TABLE `phpforyou_reputation` (
  `reputation_id` int(11) NOT NULL auto_increment,
  `reputation_userid` int(11) NOT NULL,
  `reputation_way` text NOT NULL,
  `reputation_data` varchar(255) NOT NULL,
  `reputation_time` int(11) NOT NULL,
  `reputation_by` int(11) NOT NULL,
  `reputation_tid` int(11) NOT NULL,
  `reputation_pid` int(11) NOT NULL,
  PRIMARY KEY  (`reputation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_reputation`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_sections`
-- 


CREATE TABLE `phpforyou_sections` (
  `fid` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `more` varchar(9000) NOT NULL,
  `open` int(11) NOT NULL,
  `total_topics` int(11) NOT NULL,
  `total_replays` int(11) NOT NULL,
  `last_topic` text NOT NULL,
  `sort` int(11) NOT NULL,
  `catimg` varchar(255) NOT NULL,
  `last_postid` int(11) NOT NULL,
  `last_postuser` varchar(255) NOT NULL,
  `last_postuid` int(11) NOT NULL,
  `guset_show` int(11) NOT NULL,
  `user_show` int(11) NOT NULL,
  `rule` text NOT NULL,
  `mods_show` int(11) NOT NULL,
  `out_show` int(11) NOT NULL,
  `morder_show` int(11) NOT NULL,
  `last_postdate` varchar(255) NOT NULL,
  `last_posticon` varchar(255) NOT NULL,
  `view_self` int(11) NOT NULL,
  `order` int(11) NOT NULL default '0',
  `act_show` int(11) NOT NULL,
  PRIMARY KEY  (`fid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_sections`
-- 

INSERT INTO `phpforyou_sections` VALUES (1, 'تصنيف', 'وصف التصنيف', 1, 0, 0, '', 0, '', 0, '', 0, 0, 0, '', 0, 0, 0, '', '', 0 , 1, 1);
INSERT INTO `phpforyou_sections` VALUES (2, 'منتدى', 'وصف المنتدى', 1, 0, 0, '', 1, 'images/default_icon.png', 0, '', 0, 0, 0, '<span style=\"font-weight:bold;color:#f10b00;\">لاشئ</span><br />\r\n', 0, 0, 0, '', '', 1 , 1 , 1);

-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_smiles`
-- 

CREATE TABLE `phpforyou_smiles` (
  `smile_id` int(11) NOT NULL auto_increment,
  `smile_title` varchar(255) NOT NULL,
  `smile_replace` varchar(255) NOT NULL,
  PRIMARY KEY  (`smile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_smiles`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_styles`
-- 

CREATE TABLE `phpforyou_styles` (
  `style_id` int(11) NOT NULL auto_increment,
  `style_name` varchar(255) NOT NULL,
  `style_folder` varchar(255) NOT NULL,
  `style_select` int(11) NOT NULL,
  PRIMARY KEY  (`style_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_styles`
-- 

INSERT INTO `phpforyou_styles` VALUES (1, 'default arabic', 'default_arabic', 1);
INSERT INTO `phpforyou_styles` VALUES (2, 'default english', 'default_english', 1);

-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_topics`
-- 

CREATE TABLE `phpforyou_topics` (
  `tid` int(11) NOT NULL auto_increment,
  `f_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `data` varchar(255) NOT NULL,
  `views` int(11) NOT NULL,
  `text` text NOT NULL,
  `txts` int(11) NOT NULL,
  `icon_id` varchar(255) NOT NULL,
  `close` int(11) NOT NULL,
  `stayed` int(11) NOT NULL,
  `lastpage` int(11) NOT NULL,
  `wtime` int(11) NOT NULL,
  `lastpostid` int(11) NOT NULL,
  `lastpost_title` varchar(255) NOT NULL,
  `lastpost_icon` varchar(255) NOT NULL,
  `lastpost_user` varchar(255) NOT NULL,
  `lastpost_time` int(11) NOT NULL,
  `deleted` int(11) NOT NULL default '0',
  `rating` int(11) NOT NULL,
  PRIMARY KEY  (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_topics`
-- 

INSERT INTO `phpforyou_topics` VALUES (1, 2, 1, 'admin', 'new topic', '08-30-2011 , 12:42 PM', 1, '[align=center][h1]hallo[/h1][/align]', 0, 'images/default_post.gif', 0, 0, 0, 1314693732, 0, '', '', '', 0, 0, 0);

-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_trating`
-- 

CREATE TABLE `phpforyou_trating` (
  `id` int(11) NOT NULL auto_increment,
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_trating`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_vistorsmsgs`
-- 

CREATE TABLE `phpforyou_vistorsmsgs` (
  `msg_id` int(11) NOT NULL auto_increment,
  `msg_u_id` int(11) NOT NULL,
  `msg_by` int(11) NOT NULL default '1',
  `msg_data` varchar(255) NOT NULL,
  `msg_text` text NOT NULL,
  `msg_ip` varchar(255) NOT NULL,
  `msg_time` int(11) NOT NULL,
  PRIMARY KEY  (`msg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_vistorsmsgs`
-- 


-- --------------------------------------------------------

-- 
-- بنية الجدول `phpforyou_warnings`
-- 

CREATE TABLE `phpforyou_warnings` (
  `warning_id` int(11) NOT NULL auto_increment,
  `warning_userid` int(11) NOT NULL,
  `warning_by` int(11) NOT NULL,
  `warning_more` text NOT NULL,
  `warning_data` varchar(255) NOT NULL,
  `warning_time` int(11) NOT NULL,
  `theardid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  PRIMARY KEY  (`warning_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- إرجاع أو إستيراد بيانات الجدول `phpforyou_warnings`
-- 

