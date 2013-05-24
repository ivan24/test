<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version = '1.0'
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <!-- Обработка припева с Рефреном -->
    <xsl:template match='Припев[../Рефрен]'>
      <div class='refrain'>
	<xsl:apply-templates select="строка" />
	<xsl:apply-templates select="строка[1]" />
	<xsl:apply-templates select="строка[1]" />
      </div>
    </xsl:template>

    <!-- Обработка обычного припева -->
    <xsl:template match='Припев'>
      <div class='refrain'>
	<xsl:apply-templates select="строка" />
      </div>
    </xsl:template>

</xsl:stylesheet>
