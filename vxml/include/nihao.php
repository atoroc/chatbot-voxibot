<?php

// nihao.php
// Copyright (C) 2008 Norbert Huffschmid
// Last modified: 15. August 2008
//
// Nihao: Norbert's HAWHAW objects for the iPhone
// HAWHAW: Html And Wml Hybrid Adapted Webserver
//
// This PHP library is a wrapper for hawhaw.inc and Nihao.
// It requires hawhaw.inc V5.21 or higher.
//
// For further information please visit:
// http://www.hawhaw.de/
// http://www.hawhaw.de/faq.htm#Nihao0

define("NIHAO_PHP_VERSION", "NIHAO.PHP V1.0");

//echo $_SERVER['HTTP_USER_AGENT'];

class NIHAO_deck extends HAW_deck
{
  function NIHAO_deck($title=HAW_NOTITLE, $alignment=HAW_ALIGN_LEFT, $output=HAW_OUTPUT_AUTOMATIC)
  {
    parent::HAW_deck($title, $alignment, $output);

    if ($this->desktopBrowser || $this->iPhoneAlike)
    {
      parent::use_simulator("css/layout.css");
      parent::set_css("css/layout.css");
      parent::use_link_brackets(false);
      parent::set_css_class("panel");
    
      // show page title in toolbar
      $title = new HAW_text($title);
      $title->set_css_class("toolbar");
      parent::add_text($title);
    }
    else if (strstr($_SERVER['HTTP_USER_AGENT'], "(Linux; U; Android"))
    {
      parent::use_simulator("css2/layout.css");
      parent::set_css("css2/layout.css");
      parent::use_link_brackets(false);
      parent::set_css_class("panel");
    
      // show page title in toolbar
      $title = new HAW_text($title);
      $title->set_css_class("toolbar");
      parent::add_text($title);
    }
    else if ($title != HAW_NOTITLE)
    {
      // show page title as heading
      $title = new HAW_text($title, HAW_TEXTFORMAT_BIG | HAW_TEXTFORMAT_BOLD);
      parent::add_text($title);
      
      $separator = new HAW_rule();
      parent::add_rule($separator);
    }
  }
  
  function create_page()
  {
    parent::create_page();
    
    if ($this->get_markup_language() == HAW_HTML)
      echo "<!-- created by " . NIHAO_PHP_VERSION . " -->";
  }
    
  function set_panel($flag)
  {
    if ($flag == true)
      parent::set_css_class("panel");
    else
      parent::set_css_class("");
  }
};


class NIHAO_text extends HAW_text
{
  function NIHAO_text($text, $attrib=HAW_TEXTFORMAT_NORMAL)
  {
    parent::HAW_text($text, $attrib);
    parent::set_css_class("panel");
  }
};


class NIHAO_listGroup extends HAW_text
{
  function NIHAO_listGroup($text, $attrib=HAW_TEXTFORMAT_NORMAL)
  {
    parent::HAW_text($text, $attrib);
    parent::set_css_class("listGroup");
  }
  
  function create(&$deck)
  {
    if (!$deck->desktopBrowser && !$deck->iPhoneAlike)
      $this->attrib |= HAW_TEXTFORMAT_BOLD;
      
    parent::create($deck);
  }
};


class NIHAO_link extends HAW_link
{
  function NIHAO_link($label, $url, $title="")
  {
    parent::HAW_link($label, $url, $title);
    parent::set_css_class("iLink");
  }
};


class NIHAO_toolButton extends HAW_link
{
  function NIHAO_toolButton($label, $url, $title="")
  {
    parent::HAW_link($label, $url, $title);
    parent::set_css_class("toolButton");
  }
};


class NIHAO_backButton extends HAW_link
{
  function NIHAO_backButton($label, $url, $title="")
  {
    parent::HAW_link($label, $url, $title);
    parent::set_css_class("backButton");
  }
};


class NIHAO_leftButton extends HAW_link
{
  function NIHAO_leftButton($label, $url, $title="")
  {
    parent::HAW_link($label, $url, $title);
    parent::set_css_class("leftButton");
  }
};


class NIHAO_phone extends HAW_phone
{
  function NIHAO_phone($destination, $title="")
  {
    parent::HAW_phone($destination, $title);
    parent::set_css_class("callButton");
  }
};

?>