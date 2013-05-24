<?xml version='1.0' encoding='...'?>
<xsl:stylesheet version = '1.0'
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'
     ...
     >
    <!-- Определение формата вывода -->
    <xsl:output  method="..." encoding="..." indent="..."/>
    <xsl:strip-space elements="..."/>
    <xsl:preserve-space elements="..."/>
    <xsl:decimal-format name="..."/>

    <!-- Загрузка внещних стилей -->
    <xsl:include href="..."/>
    <xsl:import href="..."/>

    <!-- Определение перемнных и параметров -->
    <xsl:param name='...'>...</xsl:param>
    <xsl:variable name="...">...</xsl:variable>

    <!-- Описание шаблонов -->
    <xsl:template match='/'>  <!-- 1-й шаблон-->
	<!-- Описание действий-->
	<xsl:apply-templates select="..."/>
	<!-- Описание действий-->
	<xsl:apply-templates select="..."/>
	 ...
    </xsl:template>

    <xsl:template match='...'><!-- 2-й шаблон-->
	<!-- Описание действий-->
	 ...
    </xsl:template>

    <xsl:template name="..."> <!-- 3-й шаблон-->
	<!-- Описание действий-->
	 ...
    </xsl:template>

    <!-- ... -->  <!-- 4-й шаблон-->

</xsl:stylesheet>
