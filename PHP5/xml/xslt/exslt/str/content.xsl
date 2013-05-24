<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
    xmlns:str="http://exslt.org/strings"
    extension-element-prefixes="str"
    xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>
    <xsl:output  method="xml" encoding="WINDOWS-1251" indent="yes"/>

    <xsl:variable name='padding' select='str:padding(52,".")'/>

    <xsl:template match="//глава">
	<xsl:variable name='chapter'>
	    Глава<xsl:value-of select='position()'/>
	    <xsl:text> </xsl:text><xsl:value-of select='.'/>
	</xsl:variable>
	<xsl:value-of select='str:align(@страница,str:align($chapter,$padding),"right")'/>
    </xsl:template>

</xsl:stylesheet>
