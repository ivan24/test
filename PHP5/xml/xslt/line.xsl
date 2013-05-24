<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <xsl:template match='строка|Рефрен'>
	<div class='line'><xsl:value-of select='.'/></div>
    </xsl:template>

</xsl:stylesheet>
