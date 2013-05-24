<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
     xmlns:php="http://php.net/xsl"
     xsl:extension-element-prefixes="php"
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <xsl:template match='строка|Рефрен'>
	<xsl:copy-of select="php:function('Line',.)"/>
	<div class='processtime'>
	    <xsl:value-of select="php:function('processTime')"/>
	</div>
    </xsl:template>

</xsl:stylesheet>
