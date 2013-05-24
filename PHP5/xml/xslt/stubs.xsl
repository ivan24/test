<?xml version='1.0' encoding='WINDOWS-1251'?>
<!-- XSLT-файл заглушек используемых шаблонов -->
<xsl:stylesheet version='1.0'
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <!-- Шаблоны 1-го уровня -->
    <xsl:template name='song' match='Песня'>
	<div class='stub'>
	    Содержание песни "<xsl:value-of select='./@название'/>"
	</div>
    </xsl:template>

    <!-- Шаблоны 2-го уровня -->
    <xsl:template match='Куплет'>
	<div class='stub'>Содержание куплета</div>
    </xsl:template>

    <xsl:template match='Припев'>
	<div class='stub'>Содержание припева</div>
    </xsl:template>

    <xsl:template name='final'>
	<div class='stub'>Содержание окончания</div>
    </xsl:template>

    <!-- Шаблоны 3-го уровня -->
    <xsl:template match='строка'>
	<div class='stub'>Содержание строки</div>
    </xsl:template>

    <xsl:template match='Рефрен'>
	<div class='stub'>Содержание Рефрена</div>
    </xsl:template>

</xsl:stylesheet>
