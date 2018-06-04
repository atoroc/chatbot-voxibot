<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<!--

  Nihao XSLT
  
  Nihao: Norbert's HAwhaw Objects for the Iphone
  
  Copyright (C) 2008 Norbert Huffschmid
  $Date: 2008/07/27 18:24:23 $

  This XSLT file enables XSLT-capable web browsers to display
  HAWHAW XML files without a HAWHAW proxy involved. For more
  information about HAWHAW XML please refer to:
  http://www.hawhaw.de/faq.htm

  This XSLT file is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This XSLT file is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  http://www.gnu.org/copyleft/gpl.html

-->
	<!--

definition of global variables -->
	<!--

deck attribute: color -->
	<xsl:variable name="deckwidetextcolor">
		<xsl:choose>
			<xsl:when test="/hawhaw/deck/@color">
				<xsl:value-of select="/hawhaw/deck/@color"/>
			</xsl:when>
			<xsl:otherwise>#000000</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<!--

deck attribute: font size -->
	<xsl:variable name="size">
		<xsl:choose>
			<xsl:when test="/hawhaw/deck/@size">
				<xsl:value-of select="/hawhaw/deck/@size"/>
			</xsl:when>
		</xsl:choose>
	</xsl:variable>
	<!--

deck attribute: font face -->
	<xsl:variable name="face">
		<xsl:choose>
			<xsl:when test="/hawhaw/deck/@face">
				<xsl:value-of select="/hawhaw/deck/@face"/>
			</xsl:when>
			<xsl:when test="/hawhaw/deck/@css" />
			<xsl:otherwise>Arial,Times</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<!-- 

deck attribute link color -->
	<xsl:variable name="link_color">
		<xsl:choose>
			<xsl:when test="/hawhaw/deck/@link_color">
				<xsl:value-of select="/hawhaw/deck/@link_color"/>
			</xsl:when>
			<xsl:when test="/hawhaw/deck/@css" />
			<xsl:otherwise>#004411</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<!-- 

deck attribute vlink color -->
	<xsl:variable name="vlink_color">
		<xsl:choose>
			<xsl:when test="/hawhaw/deck/@vlink_color">
				<xsl:value-of select="/hawhaw/deck/@vlink_color"/>
			</xsl:when>
			<xsl:when test="/hawhaw/deck/@css" />
			<xsl:otherwise>#006633</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<!-- 

deck attribute skin -->
	<xsl:variable name="skin">
		<xsl:choose>
			<xsl:when test="/hawhaw/deck/@skin">
				<xsl:value-of select="/hawhaw/deck/@skin"/>
			</xsl:when>
			<xsl:otherwise>http://skin.hawhaw.de/skin.css</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<!-- 

HAWHAW XML element templates -->
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<!-- 

<deck> -->
	<xsl:template match="deck">
		<html>
			<xsl:if test="@language">
				<xsl:attribute name="language"><xsl:value-of select="@language"/></xsl:attribute>
			</xsl:if>
			<head>
				<meta name="GENERATOR" content="Nihao XSLT (C) Norbert Huffschmid"/>
				<meta name="viewport" content="width=device-width" />
				<xsl:if test="@redirection">
					<meta http-equiv="refresh">
						<xsl:attribute name="content"><xsl:value-of select="@redirection"/>;</xsl:attribute>
					</meta>
				</xsl:if>
				<title>
					<xsl:value-of select="@title"/>
				</title>
				<link rel="stylesheet" type="text/css">
					<xsl:attribute name="href"><xsl:value-of select="$skin"/></xsl:attribute>
				</link>
				<xsl:if test="@css">
					<link rel="stylesheet" type="text/css">
						<xsl:attribute name="href"><xsl:value-of select="@css"/></xsl:attribute>
					</link>
				</xsl:if>
				<style type="text/css">
					<xsl:comment>
						body {
								font-family: <xsl:value-of select="$face"/>;
								font-size: <xsl:value-of select="$size"/>;
								color:<xsl:value-of select="$deckwidetextcolor"/>;
								background-color:<xsl:value-of select="@bgcolor"/>;
								background-image:url(<xsl:value-of select="@background"/>);
						}
						a:link { color: <xsl:value-of select="$link_color"/>; }
						a:visited { color: <xsl:value-of select="$vlink_color"/>; }
					</xsl:comment>
				</style>
			</head>
			<body>
				<div id="canvas">
					<xsl:attribute name="style">
						<xsl:choose>
							<xsl:when test="@align">
								text-align: <xsl:value-of select="@align"/>;
							</xsl:when>
							<xsl:otherwise>
								text-align: left;
							</xsl:otherwise>
						</xsl:choose>
					</xsl:attribute>
					<!--xsl:attribute name="style">
						text-align: <xsl:value-of select="@align"/>;
					</xsl:attribute-->
					<xsl:attribute name="class">
						<xsl:value-of select="@css_class" />
					</xsl:attribute>
					<span id="hawcsshook1"></span>
					<xsl:apply-templates/>
				</div>
				
				<!-- This let's IceWeasel hang! WHY??? -->
				<!--script language="JavaScript">
				var useragent = navigator.userAgent;
				if ((useragent.indexOf('iPod') &gt; -1) ||
					(useragent.indexOf('iPhone') &gt; -1)) {
 					document.writeln('For iPod or iPhone');
				}
				else {
					document.writeln('For desktop browser');
				}
				</script-->
				
				<a href="http://www.hawhaw.de/info/xsltinfo.php" target="_blank" style="display: none;">
					<font size="-1">Powered by HAWHAW (C)</font>
				</a>
			</body>
		</html>
	</xsl:template>
	<!-- 

<text> -->
	<xsl:template match="text">
		<!-- text attribute: bold -->
		<xsl:variable name="format_bold">
			<xsl:choose>
				<xsl:when test="@bold = 'yes'">font-weight:bold;</xsl:when>
			</xsl:choose>
		</xsl:variable>
		<!-- text attribute: italic -->
		<xsl:variable name="format_italic">
			<xsl:choose>
				<xsl:when test="@italic = 'yes'">font-style:italic;</xsl:when>
			</xsl:choose>
		</xsl:variable>
		<!-- text attribute: underline -->
		<xsl:variable name="format_underline">
			<xsl:choose>
				<xsl:when test="@underline = 'yes'">text-decoration:underline;</xsl:when>
			</xsl:choose>
		</xsl:variable>
		<!-- text attribute: big -->
		<xsl:variable name="format_big">
			<xsl:choose>
				<xsl:when test="@big = 'yes'">font-size:larger;</xsl:when>
			</xsl:choose>
		</xsl:variable>
		<!-- text attribute: small -->
		<xsl:variable name="format_small">
			<xsl:choose>
				<xsl:when test="@small = 'yes'">font-size:smaller;</xsl:when>
			</xsl:choose>
		</xsl:variable>
		<!-- text attribute: color -->
		<xsl:variable name="format_color">
			<xsl:choose>
				<xsl:when test="@color">color:<xsl:value-of select="@color"/>;</xsl:when>
				<xsl:otherwise>
					<xsl:if test="@boxed = 'yes'">
            color:#FFFFFF;
          </xsl:if>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		<!-- text attribute: boxcolor -->
		<xsl:variable name="format_boxcolor">
			<xsl:choose>
				<xsl:when test="@boxcolor">
					<xsl:value-of select="@boxcolor"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="$deckwidetextcolor"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		<!-- text attribute: boxed -->
		<xsl:variable name="format_boxed">
			<xsl:choose>
				<xsl:when test="@boxed = 'yes'">background-color:<xsl:value-of select="$format_boxcolor"/>;</xsl:when>
			</xsl:choose>
		</xsl:variable>
		<!-- put out formatted text -->
		<span>
			<xsl:attribute name="style"><xsl:value-of select="concat($format_bold,$format_italic,$format_underline,
                                     $format_big,$format_small,
                                     $format_color,$format_boxed)"/>
			</xsl:attribute>
			<xsl:attribute name="class">
				<xsl:value-of select="@css_class" />
			</xsl:attribute>
			<xsl:apply-templates/>
			<!-- add line breaks -->
			<xsl:choose>
				<xsl:when test="@br">
					<xsl:call-template name="br_loop">
						<xsl:with-param name="counter" select="@br"/>
					</xsl:call-template>
				</xsl:when>
				<xsl:otherwise>
					<xsl:call-template name="br_loop">
						<xsl:with-param name="counter" select="1"/>
					</xsl:call-template>
				</xsl:otherwise>
			</xsl:choose>
		</span>
	</xsl:template>
	<!-- 

<a> -->
	<xsl:template match="a">
		<!-- create link -->
		<span>
			<xsl:if test="@css_class">
				<xsl:attribute name="class">
					<xsl:value-of select="@css_class" />
				</xsl:attribute>
			</xsl:if>
			<a>
				<xsl:attribute name="href"><xsl:value-of select="@href"/></xsl:attribute>
				<xsl:if test="@title">
					<xsl:attribute name="title">
						<xsl:value-of select="@title"/>
					</xsl:attribute>
				</xsl:if>
				<xsl:apply-templates/>
			</a>
			<!-- add line breaks -->
			<xsl:choose>
				<xsl:when test="@br">
					<xsl:call-template name="br_loop">
						<xsl:with-param name="counter" select="@br"/>
					</xsl:call-template>
				</xsl:when>
				<xsl:otherwise>
					<xsl:call-template name="br_loop">
						<xsl:with-param name="counter" select="1"/>
					</xsl:call-template>
				</xsl:otherwise>
			</xsl:choose>
		</span>
	</xsl:template>
	<!-- 

<linkset> -->
	<xsl:template match="linkset">
		<div id="hawlinkset">
			<xsl:apply-templates/>
		</div>
	</xsl:template>
	<!-- 

<img> -->
	<xsl:template match="img">
		<img style="vertical-align:middle; border-style:none">
			<xsl:if test="@html">
				<xsl:attribute name="src"><xsl:value-of select="@html"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="@src">
				<xsl:attribute name="src"><xsl:value-of select="@src"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="@alt">
				<xsl:attribute name="alt"><xsl:value-of select="@alt"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="@html_width">
				<xsl:attribute name="width"><xsl:value-of select="@html_width"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="@html_height">
				<xsl:attribute name="height"><xsl:value-of select="@html_height"/></xsl:attribute>
			</xsl:if>
		</img>
		<!-- add line breaks -->
		<xsl:choose>
			<xsl:when test="@br">
				<xsl:call-template name="br_loop">
					<xsl:with-param name="counter" select="@br"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="br_loop">
					<xsl:with-param name="counter" select="0"/>
				</xsl:call-template>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<!-- 

<hr> -->
	<xsl:template match="hr">
		<xsl:copy-of select="."/>
	</xsl:template>
	<!-- 

<phone> -->
	<xsl:template match="phone">
		<span>
			<xsl:attribute name="class">
				<xsl:value-of select="@css_class" />
			</xsl:attribute>
			<a>
				<xsl:attribute name="href">phoneto:<xsl:apply-templates/></xsl:attribute>
				<xsl:if test="@title">
					<xsl:attribute name="title">
						<xsl:value-of select="@title"/>
					</xsl:attribute>
				</xsl:if>
				<span class="hawphonelabel">
					<xsl:apply-templates/>
				</span>
			</a>
			<!-- add line breaks -->
			<xsl:choose>
				<xsl:when test="@br">
					<xsl:call-template name="br_loop">
						<xsl:with-param name="counter" select="@br"/>
					</xsl:call-template>
				</xsl:when>
				<xsl:otherwise>
					<xsl:call-template name="br_loop">
						<xsl:with-param name="counter" select="0"/>
					</xsl:call-template>
				</xsl:otherwise>
			</xsl:choose>
		</span>
	</xsl:template>
	<!-- 

<form> -->
	<xsl:template match="form">
		<form method="get">
			<xsl:attribute name="action"><xsl:value-of select="@action"/></xsl:attribute>
			<xsl:apply-templates/>
		</form>
	</xsl:template>
	<!-- 

<input> -->
	<xsl:template match="input">
		<xsl:value-of select="@label"/>
		<xsl:text> </xsl:text>
		<input class="hawinputtext">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>
			<xsl:attribute name="value"><xsl:value-of select="@value"/></xsl:attribute>
			<xsl:attribute name="size"><xsl:value-of select="@size"/></xsl:attribute>
			<xsl:attribute name="maxlength"><xsl:value-of select="@maxlength"/></xsl:attribute>
			<xsl:attribute name="type"><xsl:value-of select="@type"/></xsl:attribute>
		</input>
		<!-- add line breaks -->
		<xsl:choose>
			<xsl:when test="@br">
				<xsl:call-template name="br_loop">
					<xsl:with-param name="counter" select="@br"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="br_loop">
					<xsl:with-param name="counter" select="1"/>
				</xsl:call-template>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<!-- 

<select> -->
	<xsl:template match="select">
		<select size="1">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>
			<xsl:for-each select="option">
				<option>
					<xsl:attribute name="value"><xsl:value-of select="@value"/></xsl:attribute>
					<!-- select first option, if no other option is selected explicitely -->
					<xsl:if test="@selected = 'yes' or ((position() = 1) and not(..//option[@selected = 'yes']))">
						<xsl:attribute name="selected">selected</xsl:attribute>
					</xsl:if>
					<xsl:value-of select="@label"/>
					<br/>
				</option>
			</xsl:for-each>
		</select>
	</xsl:template>
	<!-- 

<radio> -->
	<xsl:template match="radio">
		<xsl:for-each select="button">
			<input type="radio">
				<xsl:attribute name="name"><xsl:value-of select="../@name"/></xsl:attribute>
				<xsl:attribute name="value"><xsl:value-of select="@value"/></xsl:attribute>
				<xsl:if test="@checked = 'yes'">
					<xsl:attribute name="checked">checked</xsl:attribute>
				</xsl:if>
			</input>
			<xsl:value-of select="@label"/>
			<br/>
		</xsl:for-each>
	</xsl:template>
	<!-- 

<checkbox> -->
	<xsl:template match="checkbox">
		<input type="checkbox">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>
			<xsl:attribute name="value"><xsl:value-of select="@value"/></xsl:attribute>
			<xsl:if test="@checked = 'yes'">
				<xsl:attribute name="checked">checked</xsl:attribute>
			</xsl:if>
		</input>
		<xsl:value-of select="@label"/>
		<br/>
	</xsl:template>
	<!-- 

<hidden> -->
	<xsl:template match="hidden">
		<input type="hidden">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>
			<xsl:attribute name="value"><xsl:value-of select="@value"/></xsl:attribute>
		</input>
	</xsl:template>
	<!-- 

<submit> -->
	<xsl:template match="submit">
		<input type="submit" id="hawinputsubmit">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>
			<xsl:attribute name="value"><xsl:value-of select="@label"/></xsl:attribute>
		</input>
		<br/>
	</xsl:template>
	<!-- 

<table> -->
	<xsl:template match="table">
		<table border="1">
			<xsl:apply-templates/>
		</table>
	</xsl:template>
	<!-- 

<tr> -->
	<xsl:template match="tr">
		<tr>
			<xsl:apply-templates/>
		</tr>
	</xsl:template>
	<!-- 

<td> -->
	<xsl:template match="td">
		<td>
			<xsl:apply-templates/>
		</td>
	</xsl:template>
	<!-- 

VoiceXML DUMMY TEMPLATES -->
	<xsl:template match="voice_text">
		<xsl:comment>
      voice_text: <xsl:value-of select="."/>
		</xsl:comment>
	</xsl:template>
	<xsl:template match="voice_help">
		<xsl:comment>
      voice_help: <xsl:value-of select="."/>
		</xsl:comment>
	</xsl:template>
	<xsl:template match="voice_nomatch">
		<xsl:comment>
      voice_nomatch: <xsl:value-of select="."/>
		</xsl:comment>
	</xsl:template>
	<xsl:template match="voice_noinput">
		<xsl:comment>
      voice_noinput: <xsl:value-of select="."/>
		</xsl:comment>
	</xsl:template>
	<!-- 

HELP TEMPLATES -->
	<xsl:template name="br_loop">
		<xsl:param name="counter"/>
		<xsl:choose>
			<xsl:when test="$counter &gt; 0">
				<br/>
				<xsl:call-template name="br_loop">
					<xsl:with-param name="counter" select="$counter - 1"/>
				</xsl:call-template>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
