<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
     xmlns:exsl="http://exslt.org/common"
     extension-element-prefixes="exsl"
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <xsl:output  method="html" encoding="WINDOWS-1251" indent="yes"/>
<xsl:template match="/">
  <html>
    <head><title>Frame example</title></head>
    <frameset cols="20%, 80%">
      <frame src="toc.html"/>
      <exsl:document href="toc.html" encoding="WINDOWS-1251">
	<html>
	  <head><title>Содержание</title></head>
	  <body>
	     <xsl:apply-templates mode="toc" select="//Содержание"/>
	  </body>
	</html>
      </exsl:document>
      <frame src="body.html"/>
      <exsl:document href="body.html" encoding="WINDOWS-1251">
	<html>
	  <head><title>Страница</title></head>
	  <body>
	     <xsl:apply-templates select="//Страница"/>
	  </body>
	</html>
      </exsl:document>
    </frameset>
  </html>
</xsl:template>
</xsl:stylesheet>

