<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
    xmlns:exsl="http://exslt.org/common"
    extension-element-prefixes="exsl"
    xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <xsl:variable name="tree">
    <a><b><c><d/></c></b></a>
    </xsl:variable>

    <xsl:variable name="string" select="'fred'"/>
    <xsl:variable name="number" select="93.7"/>
    <xsl:variable name="boolean" select="true()"/>
    <xsl:variable name="node-set" select="//*"/>

    <xsl:template match="/">
      <out>:
	<xsl:value-of select="exsl:object-type($string)"/>;
	<xsl:value-of select="exsl:object-type($number)"/>;
	<xsl:value-of select="exsl:object-type($boolean)"/>;
	<xsl:value-of select="exsl:object-type($node-set)"/>;
	<xsl:value-of select="exsl:object-type($tree)"/>;
	<xsl:if test="function-available('saxon:expression')"
		xmlns:saxon="http://icl.com/saxon">
	    <xsl:value-of select="exsl:object-type(saxon:expression('item'))"/>
	</xsl:if>;
      </out>
    </xsl:template>
</xsl:stylesheet>
