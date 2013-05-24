<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
    xmlns:exsl="http://exslt.org/common"
    extension-element-prefixes="exsl"
    xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>
   <xsl:output  method="html" encoding="WINDOWS-1251" indent="yes"/>
    <xsl:variable name="tree"><a><b><c><d/></c></b></a></xsl:variable>
     <xsl:template match="/">
       <out>
	 <xsl:value-of select="count(exsl:node-set($tree)//*)"/>
      </out>
    </xsl:template>
</xsl:stylesheet>
