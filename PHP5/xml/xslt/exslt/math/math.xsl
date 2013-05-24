<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
    xmlns:xsl='http://www.w3.org/1999/XSL/Transform'
    xmlns:math="http://exslt.org/math"
    xsl:extension-element-prefixes="math"
    >

    <xsl:output  method="xml" encoding="WINDOWS-1251" indent="yes"/>

    <xsl:template match="values">
       <result>
	  <xsl:text>
	      Максимум: </xsl:text>
	  <xsl:value-of select="math:max(value)" />
	  <xsl:text>
	      Минимум: </xsl:text>
	  <xsl:value-of select="math:min(value)" />
	  <xsl:text>
	      2**10=</xsl:text>
	  <xsl:value-of select="math:power(2,10)" />
	  <xsl:text>
</xsl:text>
       </result>
    </xsl:template>

</xsl:stylesheet>

