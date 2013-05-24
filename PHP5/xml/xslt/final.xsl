<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <xsl:template name='final'>
	<xsl:choose>
	    <xsl:when test="@id=1">
		<!-- 6-ть раз повторить Припев -->
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
	    </xsl:when>
	    <xsl:when test="@id=2">
		<!-- 14-ть раз повторить Припев -->
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
		<xsl:apply-templates select="Припев"/>
	    </xsl:when>
	</xsl:choose>
    </xsl:template>

</xsl:stylesheet>
