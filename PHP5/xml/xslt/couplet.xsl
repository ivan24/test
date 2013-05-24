<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <!-- Обработка куплета с Рефреном -->
    <xsl:template match='Куплет[../Рефрен]'>
      <div class='couplet'>
	<xsl:for-each select ="./куплет">
	    <xsl:apply-templates select="строка" />
	    <xsl:apply-templates select="../../Рефрен[1]" />
	<xsl:if test="position()!=last()"><br/></xsl:if>
	</xsl:for-each>
      </div>
    </xsl:template>

    <!-- Обработка обычного куплета -->
    <xsl:template match='Куплет'>
      <div class='couplet'>
	<xsl:apply-templates select="строка" />
      </div>
    </xsl:template>

</xsl:stylesheet>
